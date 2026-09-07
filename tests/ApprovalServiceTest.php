<?php

declare(strict_types=1);
namespace Kumwe\Approval\Tests;

use DateInterval;
use DateTimeImmutable;
use Kumwe\Access\AuthorizationGateway;
use Kumwe\Access\MembershipDirectory;
use Kumwe\Access\ResourceSiteOwnershipWriter;
use Kumwe\Approval\ApprovalBinding;
use Kumwe\Approval\ApprovalDenied;
use Kumwe\Approval\ApprovalRepository;
use Kumwe\Approval\ApprovalRequest;
use Kumwe\Approval\ApprovalRule;
use Kumwe\Approval\ApprovalService;
use Kumwe\Approval\ApprovalStatus;
use Kumwe\Approval\StepUpProofConsumer;
use Kumwe\Audit\Application\AuditRecorder;
use Kumwe\Context\Contract\Principal;
use Kumwe\Context\Value\AuthenticationStrength;
use Kumwe\Context\Value\ExecutionContext;
use Kumwe\Context\Value\MembershipContext;
use Kumwe\Context\Value\SiteContext;
use Kumwe\Context\Value\StepUpProof;
use Kumwe\Transaction\Contract\TransactionManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Ramsey\Uuid\UuidFactory;

final class ApprovalServiceTest extends TestCase
{
    private const REQUEST = '0191574f-f0b8-7bf3-a9aa-91c6b8244e12';
    private const RULE = '0191574f-f0b8-7bf3-a9aa-91c6b8244e13';
    private ApprovalRepository $repository;
    private StepUpProofConsumer $proofs;
    private MembershipDirectory $memberships;
    private AuditRecorder $audit;
    private ResourceSiteOwnershipWriter $ownership;
    private AuthorizationGateway $authorization;
    private DateTimeImmutable $now;
    private bool $inTransaction = false;
    private ApprovalService $service;

    protected function setUp(): void
    {
        $this->now = new DateTimeImmutable('2026-09-07T10:00:00Z');
        $this->repository = $this->createMock(ApprovalRepository::class);
        $this->proofs = $this->createMock(StepUpProofConsumer::class);
        $this->memberships = $this->createMock(MembershipDirectory::class);
        $this->audit = $this->createMock(AuditRecorder::class);
        $this->ownership = $this->createMock(ResourceSiteOwnershipWriter::class);
        $this->authorization = $this->createMock(AuthorizationGateway::class);
        $transactions = $this->createStub(TransactionManager::class);
        $transactions->method('transactional')->willReturnCallback(function (callable $operation): mixed {
            self::assertFalse($this->inTransaction);
            $this->inTransaction = true;
            try { return $operation(); } finally { $this->inTransaction = false; }
        });
        $clock = $this->createStub(ClockInterface::class);
        $clock->method('now')->willReturn($this->now);
        $this->service = new ApprovalService($this->repository, $this->proofs, $this->memberships,
            $transactions, $this->authorization, $this->ownership, $this->audit, $clock, new UuidFactory());
    }

    private function context(string $actor = 'maker', bool $proof = true, string $site = 'default',
        ?MembershipContext $membership = null): ExecutionContext
    {
        $authority = new \stdClass();
        $principal = $this->createStub(Principal::class);
        $principal->method('subject')->willReturn($actor);
        $principal->method('securityEpoch')->willReturn(1);
        $principal->method('hasProvenance')->willReturnCallback(static fn (object $p): bool => $p === $authority);
        $principal->method('authorityFingerprint')->willReturn(hash('sha256', $actor));
        $principal->method('authorizationFingerprint')->willReturn(hash('sha256', $actor));
        $scope = SiteContext::fromString($site);
        $stepUp = $proof ? new StepUpProof($actor, 'session-1', $scope, $membership?->organization(),
            'totp', $this->now->modify('-1 minute'), $this->now->modify('+4 minutes'), str_repeat('N', 32),
            purpose: 'business.record.update') : null;
        return ExecutionContext::issueHuman($authority, $principal, $scope,
            $proof ? AuthenticationStrength::MultiFactor : AuthenticationStrength::Password,
            'approval-test', membership: $membership, sessionId: $proof ? 'session-1' : null, stepUpProof: $stepUp);
    }

    private function binding(?ExecutionContext $context = null, int $version = 7, string $payload = 'a'): ApprovalBinding
    {
        return ApprovalBinding::fromContext($context ?? $this->context(), 'business.record.update', 'record',
            'record-1', $version, str_repeat($payload, 64));
    }

    private function rule(int $quorum = 2, int $version = 1): ApprovalRule
    {
        return new ApprovalRule(self::RULE, 'review', 'vendor.invoice.check', $quorum, true, $version, null);
    }

    private function request(ApprovalStatus $status = ApprovalStatus::Pending,
        ?ApprovalBinding $binding = null, ?DateTimeImmutable $expiry = null): ApprovalRequest
    {
        return new ApprovalRequest(self::REQUEST, self::RULE, 1, 'vendor.invoice.check', null, true,
            $binding ?? $this->binding(), 2, $status, $expiry ?? $this->now->modify('+1 hour'), 3);
    }

    private function currentRule(): void
    {
        $this->repository->expects(self::once())->method('rule')->with(self::isInstanceOf(ApprovalBinding::class), true)
            ->willReturnCallback(function (): ApprovalRule { self::assertTrue($this->inTransaction); return $this->rule(); });
    }

    public function testRequestLocksRuleAndWritesOwnershipAndAuditInsideTransaction(): void
    {
        $context = $this->context(); $binding = $this->binding($context); $this->currentRule();
        $this->repository->method('requesterEligible')->willReturn(true);
        $this->repository->expects(self::once())->method('insert')->willReturnCallback(function (
            string $id, ApprovalRule $rule, ApprovalBinding $actual, DateTimeImmutable $expires,
        ) use ($binding): void { self::assertTrue($this->inTransaction); self::assertSame($binding, $actual);
            self::assertEquals($this->now->modify('+1 day'), $expires); });
        $this->ownership->expects(self::once())->method('record')->willReturnCallback(function (): void {
            self::assertTrue($this->inTransaction);
        });
        $this->audit->expects(self::once())->method('record')->willReturnCallback(function (): void {
            self::assertTrue($this->inTransaction);
        });
        self::assertNotNull($this->service->request($context, $binding));
    }

    public function testNoRuleHasNoWriteSideEffects(): void
    {
        $this->repository->expects(self::once())->method('rule')->with(self::anything(), true)->willReturn(null);
        $this->repository->expects(self::never())->method('insert'); $this->audit->expects(self::never())->method('record');
        self::assertNull($this->service->request($this->context(), $this->binding()));
    }

    #[DataProvider('invalidLifetimes')]
    public function testInvalidLifetimeRefusedBeforeInsert(string $interval): void
    {
        $this->currentRule(); $this->repository->method('requesterEligible')->willReturn(true);
        $this->repository->expects(self::never())->method('insert'); $this->expectException(\InvalidArgumentException::class);
        $this->service->request($this->context(), $this->binding(), new DateInterval($interval));
    }
    public static function invalidLifetimes(): array { return [['PT0S'], ['P8D']]; }

    #[DataProvider('quorumCounts')]
    public function testApprovePreservesFrozenCapabilityAndAdvancesOnlyAtQuorum(int $count, ApprovalStatus $status): void
    {
        $this->repository->method('lock')->willReturn($this->request());
        $this->repository->method('approverEligible')->willReturn(true); $this->currentRule();
        $this->proofs->expects(self::once())->method('consume')->willReturn(self::REQUEST);
        $this->repository->expects(self::once())->method('vote')->with(self::isString(), self::REQUEST,
            'checker', 'approve', 'Reviewed', self::isString(), self::REQUEST, $this->now);
        $this->repository->method('approvalCount')->willReturn($count);
        $this->repository->expects($status === ApprovalStatus::Approved ? self::once() : self::never())
            ->method('transition')->with(self::REQUEST, ApprovalStatus::Pending, $status, 3, $this->now);
        $checked = [];
        $this->authorization->method('assertAllowed')->willReturnCallback(static function ($context, $capability) use (&$checked): void {
            $checked[] = $capability->value();
        });
        self::assertSame($status, $this->service->approve($this->context('checker'), self::REQUEST, '  Reviewed  '));
        self::assertSame(['business.approval.approve', 'vendor.invoice.check'], $checked);
    }
    public static function quorumCounts(): array { return [[1, ApprovalStatus::Pending], [2, ApprovalStatus::Approved]]; }

    public function testRejectEndsPendingRequestImmediately(): void
    {
        $this->repository->method('lock')->willReturn($this->request());
        $this->repository->method('approverEligible')->willReturn(true); $this->currentRule();
        $this->proofs->method('consume')->willReturn(self::REQUEST);
        $this->repository->expects(self::never())->method('approvalCount');
        $this->repository->expects(self::once())->method('transition')->with(self::REQUEST, ApprovalStatus::Pending,
            ApprovalStatus::Rejected, 3, $this->now);
        self::assertSame(ApprovalStatus::Rejected, $this->service->reject($this->context('checker'), self::REQUEST));
    }

    #[DataProvider('deniedDecisions')]
    public function testInvalidDecisionDoesNotConsumeProofOrVote(string $failure): void
    {
        $context = $this->context($failure === 'maker' ? 'maker' : 'checker', $failure !== 'proof',
            $failure === 'site' ? 'other' : 'default');
        $this->repository->method('lock')->willReturn($failure === 'missing' ? null : $this->request(
            $failure === 'terminal' ? ApprovalStatus::Approved : ApprovalStatus::Pending,
            expiry: $failure === 'expired' ? $this->now : null));
        $this->repository->method('approverEligible')->willReturn($failure !== 'eligibility');
        $this->repository->method('rule')->willReturn($failure === 'policy' ? $this->rule(version: 2) : $this->rule());
        $this->proofs->expects(self::never())->method('consume'); $this->repository->expects(self::never())->method('vote');
        $this->expectException(ApprovalDenied::class);
        $this->service->approve($context, self::REQUEST, $failure === 'reason' ? ' ' : null);
    }
    public static function deniedDecisions(): array
    {
        return array_map(static fn (string $s): array => [$s], ['maker','missing','terminal','expired','eligibility','policy','proof','site','reason']);
    }

    #[DataProvider('consumeFailures')]
    public function testConsumptionRefusesChangedBindingPolicyExpiryAndReplay(string $failure): void
    {
        $this->repository->method('lock')->willReturn($this->request(
            $failure === 'replay' ? ApprovalStatus::Consumed : ApprovalStatus::Approved,
            expiry: $failure === 'expiry' ? $this->now : null));
        $this->repository->method('rule')->willReturn($failure === 'policy' ? $this->rule(version: 2) : $this->rule());
        $this->proofs->expects(self::never())->method('consume'); $this->repository->expects(self::never())->method('transition');
        $this->expectException(ApprovalDenied::class);
        $this->service->consume($this->context($failure === 'actor' ? 'stranger' : 'maker'), self::REQUEST,
            $this->binding(version: $failure === 'version' ? 8 : 7, payload: $failure === 'payload' ? 'b' : 'a'));
    }
    public static function consumeFailures(): array
    {
        return array_map(static fn (string $s): array => [$s], ['replay','expiry','policy','actor','version','payload']);
    }

    public function testConsumeTransitionsExactVersionAndAuditsInTransaction(): void
    {
        $this->repository->method('lock')->willReturn($this->request(ApprovalStatus::Approved)); $this->currentRule();
        $this->proofs->expects(self::once())->method('consume')->willReturn(self::REQUEST);
        $this->repository->expects(self::once())->method('transition')->with(self::REQUEST, ApprovalStatus::Approved,
            ApprovalStatus::Consumed, 3, $this->now);
        $this->audit->expects(self::once())->method('record')->willReturnCallback(function (): void { self::assertTrue($this->inTransaction); });
        $this->service->consume($this->context(), self::REQUEST, $this->binding());
    }

    public function testRequesterCancelsWithoutStepUp(): void
    {
        $context = $this->context(proof: false);
        $this->repository->method('lock')->willReturn($this->request(binding: $this->binding($context)));
        $this->proofs->expects(self::never())->method('consume');
        $this->repository->expects(self::once())->method('transition')->with(self::REQUEST, ApprovalStatus::Pending,
            ApprovalStatus::Cancelled, 3, $this->now); $this->service->cancel($context, self::REQUEST);
    }

    public function testExpiredRequestCannotBeCancelled(): void
    {
        $this->repository->method('lock')->willReturn($this->request(expiry: $this->now));
        $this->repository->expects(self::never())->method('transition');
        $this->expectException(ApprovalDenied::class); $this->service->cancel($this->context(), self::REQUEST);
    }

    #[DataProvider('expirableStates')]
    public function testExpiryIsExclusiveAndMaterializedForBothLiveStates(ApprovalStatus $state): void
    {
        $this->repository->method('lock')->willReturn($this->request($state, expiry: $this->now));
        $this->repository->expects(self::once())->method('transition')->with(self::REQUEST, $state,
            ApprovalStatus::Expired, 3, $this->now); $this->proofs->expects(self::never())->method('consume');
        $this->service->expire($this->context(), self::REQUEST);
    }
    public static function expirableStates(): array { return [[ApprovalStatus::Pending], [ApprovalStatus::Approved]]; }

    public function testEarlyExpiryRefused(): void
    {
        $this->repository->method('lock')->willReturn($this->request());
        $this->repository->expects(self::never())->method('transition');
        $this->expectException(ApprovalDenied::class); $this->service->expire($this->context(), self::REQUEST);
    }

    public function testManagerRevokesWithSingleUseProof(): void
    {
        $this->repository->method('lock')->willReturn($this->request(ApprovalStatus::Approved));
        $this->proofs->expects(self::once())->method('consume')->with(self::anything(), self::anything(),
            'business.approval.revoke', $this->now)->willReturn(self::REQUEST);
        $this->repository->expects(self::once())->method('transition')->with(self::REQUEST, ApprovalStatus::Approved,
            ApprovalStatus::Revoked, 3, $this->now); $this->service->revoke($this->context('manager'), self::REQUEST);
    }

    public function testAuditFailurePropagatesThroughTransaction(): void
    {
        $context = $this->context(proof: false);
        $this->repository->method('lock')->willReturn($this->request(binding: $this->binding($context)));
        $this->audit->method('record')->willThrowException(new \RuntimeException('audit unavailable'));
        try { $this->service->cancel($context, self::REQUEST); self::fail('Expected failure'); }
        catch (\RuntimeException $e) { self::assertSame('audit unavailable', $e->getMessage()); }
        self::assertFalse($this->inTransaction);
    }
}
