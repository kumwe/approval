<?php

declare(strict_types=1);
namespace Kumwe\Approval\Tests;

use DateTimeImmutable;
use Kumwe\Access\AuthorizationDecision;
use Kumwe\Access\AuthorizationGateway;
use Kumwe\Access\MembershipDirectory;
use Kumwe\Approval\ApprovalQueryRepository;
use Kumwe\Approval\ApprovalQueryService;
use Kumwe\Context\Contract\Principal;
use Kumwe\Context\Value\AuthenticationStrength;
use Kumwe\Context\Value\ExecutionContext;
use Kumwe\Context\Value\MembershipContext;
use Kumwe\Context\Value\OrganizationContext;
use Kumwe\Context\Value\SiteContext;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;

final class ApprovalQueryServiceTest extends TestCase
{
    private const UUID = '0191574f-f0b8-7bf3-a9aa-91c6b8244e12';
    private function context(bool $membership = false): ExecutionContext
    {
        $principal = $this->createStub(Principal::class);
        $principal->method('subject')->willReturn('maker');
        $principal->method('securityEpoch')->willReturn(1);
        $principal->method('hasProvenance')->willReturn(true);
        $principal->method('authorityFingerprint')->willReturn(str_repeat('a', 64));
        $principal->method('authorizationFingerprint')->willReturn(str_repeat('a', 64));
        return ExecutionContext::issueHuman(new \stdClass(), $principal, SiteContext::default(),
            AuthenticationStrength::Password, 'query-test', membership: $membership
            ? new MembershipContext(self::UUID, OrganizationContext::fromString('org'), null, 1, 1) : null);
    }

    #[DataProvider('visibilityModes')]
    public function testIndependentVisibilityFlagsAndLimitReachRepository(bool $own, bool $eligible, bool $managed): void
    {
        $context = $this->context(); $now = new DateTimeImmutable('2026-09-07T10:00:00Z');
        $authorization = $this->createMock(AuthorizationGateway::class);
        $authorization->expects(self::exactly(3))->method('decide')->willReturnOnConsecutiveCalls(
            $own ? new AuthorizationDecision(\Kumwe\Access\DecisionState::Allow, 'test', 'allow') : new AuthorizationDecision(\Kumwe\Access\DecisionState::Deny, 'test', 'forbidden'),
            $eligible ? new AuthorizationDecision(\Kumwe\Access\DecisionState::Allow, 'test', 'allow') : new AuthorizationDecision(\Kumwe\Access\DecisionState::Deny, 'test', 'forbidden'),
            $managed ? new AuthorizationDecision(\Kumwe\Access\DecisionState::Allow, 'test', 'allow') : new AuthorizationDecision(\Kumwe\Access\DecisionState::Deny, 'test', 'forbidden'),
        );
        $repository = $this->createMock(ApprovalQueryRepository::class);
        $repository->expects($own || $eligible || $managed ? self::once() : self::never())->method('visible')
            ->with($context, $own, $eligible, $managed, $now, 17)->willReturn([]);
        $clock = $this->createStub(ClockInterface::class); $clock->method('now')->willReturn($now);
        $service = new ApprovalQueryService($repository, $authorization,
            $this->createStub(MembershipDirectory::class), $clock);
        self::assertSame([], $service->inbox($context, 17));
    }
    public static function visibilityModes(): array
    {
        return [[true,false,false],[false,true,false],[false,false,true],[true,true,true],[false,false,false]];
    }

    #[DataProvider('invalidLimits')]
    public function testInvalidLimitsDoNotQueryPersistence(int $limit): void
    {
        $repository = $this->createMock(ApprovalQueryRepository::class);
        $repository->expects(self::never())->method('visible');
        $service = new ApprovalQueryService($repository, $this->createStub(AuthorizationGateway::class),
            $this->createStub(MembershipDirectory::class), $this->createStub(ClockInterface::class));
        $this->expectException(\InvalidArgumentException::class); $service->inbox($this->context(), $limit);
    }
    public static function invalidLimits(): array { return [[0],[101]]; }

    public function testStaleMembershipIsNonEnumeratingAndDoesNotQuery(): void
    {
        $context = $this->context(true);
        $memberships = $this->createMock(MembershipDirectory::class);
        $memberships->expects(self::exactly(2))->method('current')->with('maker', $context->site(),
            $context->membership(), false)->willReturn(false);
        $repository = $this->createMock(ApprovalQueryRepository::class);
        $repository->expects(self::never())->method('visible');
        $repository->expects(self::never())->method('findVisible');
        $authorization = $this->createMock(AuthorizationGateway::class);
        $authorization->expects(self::never())->method('decide');
        $service = new ApprovalQueryService($repository, $authorization, $memberships, $this->createStub(ClockInterface::class));
        self::assertSame([], $service->inbox($context));
        self::assertNull($service->detail($context, self::UUID));
    }

    public function testMalformedDetailDoesNotTouchPersistenceOrMembership(): void
    {
        $repository = $this->createMock(ApprovalQueryRepository::class);
        $repository->expects(self::never())->method('findVisible');
        $service = new ApprovalQueryService($repository, $this->createStub(AuthorizationGateway::class),
            $this->createStub(MembershipDirectory::class), $this->createStub(ClockInterface::class));
        self::assertNull($service->detail($this->context(), 'not-a-uuid'));
    }
}
