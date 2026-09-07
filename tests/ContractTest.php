<?php

declare(strict_types=1);
namespace Kumwe\Approval\Tests;

use DateTimeImmutable;
use InvalidArgumentException;
use Kumwe\Access\AuthorizationGateway;
use Kumwe\Access\MembershipDirectory;
use Kumwe\Access\ResourceSiteOwnershipWriter;
use Kumwe\Approval\ApprovalBinding;
use Kumwe\Approval\ApprovalDenied;
use Kumwe\Approval\ApprovalQueryRepository;
use Kumwe\Approval\ApprovalQueryService;
use Kumwe\Approval\ApprovalRepository;
use Kumwe\Approval\ApprovalRequest;
use Kumwe\Approval\ApprovalRule;
use Kumwe\Approval\ApprovalService;
use Kumwe\Approval\ApprovalStatus;
use Kumwe\Approval\ApprovalVoteView;
use Kumwe\Approval\ConfigProvider;
use Kumwe\Approval\StepUpProofConsumer;
use Kumwe\Audit\Application\AuditRecorder;
use Kumwe\Transaction\Contract\TransactionManager;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;

final class ContractTest extends TestCase
{
    private const UUID = '0191574f-f0b8-7bf3-a9aa-91c6b8244e12';

    #[DataProvider('bindingMutations')]
    public function testEveryBindingFieldChangesDigest(int $field, mixed $replacement): void
    {
        $args = ['maker', 'record.update', 'record', 'one', 1, 'site', 'org', 'workspace', str_repeat('a',64), str_repeat('b',64)];
        $original = new ApprovalBinding(...$args); $args[$field] = $replacement;
        self::assertNotSame($original->digest(), (new ApprovalBinding(...$args))->digest());
    }
    public static function bindingMutations(): array
    {
        return [[0,'checker'],[1,'record.delete'],[2,'article'],[3,'two'],[4,2],[5,'other'],[6,'other'],[7,null],[8,str_repeat('c',64)],[9,str_repeat('c',64)]];
    }

    #[DataProvider('invalidBindings')]
    public function testBindingRejectsInvalidState(int $field, mixed $replacement): void
    {
        $args = ['maker', 'record.update', 'record', 'one', 1, 'site', 'org', 'workspace', str_repeat('a',64), str_repeat('b',64)];
        $args[$field] = $replacement; $this->expectException(InvalidArgumentException::class); new ApprovalBinding(...$args);
    }
    public static function invalidBindings(): array
    {
        return [[0,''],[1,'INVALID'],[2,' bad'],[3,"id\n"],[4,0],[5,''],[6,null],[7,'UPPER'],[8,'abc'],[9,str_repeat('A',64)]];
    }

    #[DataProvider('invalidRules')]
    public function testInvalidRulesFailBeforeAnyAuthorityLookup(int $field, mixed $replacement): void
    {
        $args = [self::UUID,'review','record.check',2,true,1,null]; $args[$field] = $replacement;
        $this->expectException(InvalidArgumentException::class); new ApprovalRule(...$args);
    }
    public static function invalidRules(): array { return [[0,'not-uuid'],[1,'bad code'],[2,'UPPER'],[3,0],[3,33],[5,0],[6,'not-uuid']]; }

    public function testViewDecisionIsClosedAndDenialDoesNotEnumerate(): void
    {
        self::assertSame('The requested approval operation is not permitted.', (new ApprovalDenied())->getMessage());
        $this->expectException(InvalidArgumentException::class);
        new ApprovalVoteView(self::UUID, 'checker', 'unknown', null, new DateTimeImmutable());
    }

    public function testRealLaminasResolvesExactlyTwoSharedServicesFromExplicitPorts(): void
    {
        $config = (new ConfigProvider())(); $services = [];
        foreach ([ApprovalRepository::class, StepUpProofConsumer::class, MembershipDirectory::class,
            TransactionManager::class, AuthorizationGateway::class, ResourceSiteOwnershipWriter::class,
            AuditRecorder::class, ClockInterface::class, ApprovalQueryRepository::class] as $port) {
            $services[$port] = $this->createStub($port);
        }
        $services[UuidFactoryInterface::class] = new UuidFactory();
        $container = new ServiceManager($config['dependencies'] + ['services' => $services]);
        foreach ([ApprovalService::class, ApprovalQueryService::class] as $service) {
            self::assertInstanceOf($service, $container->get($service));
            self::assertSame($container->get($service), $container->get($service));
        }
        self::assertCount(2, $config['dependencies']['factories']);
        self::assertFalse((new ServiceManager($config['dependencies']))->has(AuthorizationGateway::class));
    }

    #[DataProvider('exportedServices')]
    public function testMissingHostBindingsFailClosed(string $service): void
    {
        $container = new ServiceManager((new ConfigProvider())()['dependencies']);
        $this->expectException(\Laminas\ServiceManager\Exception\ServiceNotFoundException::class);
        $container->get($service);
    }
    public static function exportedServices(): array { return [[ApprovalService::class],[ApprovalQueryService::class]]; }
    #[DataProvider('invalidProjectionFields')]
    public function testProjectionRejectsMalformedCountersAndEvidence(string $field, mixed $replacement): void
    {
        $args = [
            'id' => self::UUID, 'ruleCode' => 'review', 'ruleVersion' => 1,
            'approvalAction' => 'record.check', 'approverRoleId' => null, 'distinctActors' => true,
            'requesterId' => 'maker', 'action' => 'record.update', 'resourceType' => 'record',
            'resourceId' => 'record-1', 'resourceVersion' => 7, 'siteIdentifier' => 'site',
            'organizationIdentifier' => null, 'workspaceIdentifier' => null,
            'payloadDigest' => str_repeat('a', 64), 'bindingDigest' => str_repeat('b', 64),
            'requiredQuorum' => 2, 'approvalCount' => 1, 'status' => ApprovalStatus::Pending,
            'createdAt' => new DateTimeImmutable('2026-09-07T10:00:00Z'),
            'expiresAt' => new DateTimeImmutable('2026-09-08T10:00:00Z'),
            'version' => 1, 'canApprove' => true, 'canCancel' => false, 'canRevoke' => false, 'votes' => [],
        ];
        $valid = new \Kumwe\Approval\ApprovalRequestView(...$args);
        self::assertSame([], $valid->votes);
        self::assertFalse(property_exists($valid, 'contextFingerprint'));
        $args[$field] = $replacement;
        $this->expectException(InvalidArgumentException::class);
        new \Kumwe\Approval\ApprovalRequestView(...$args);
    }
    public static function invalidProjectionFields(): array
    {
        return [['ruleVersion', 0], ['requiredQuorum', 0], ['resourceVersion', 0],
            ['approvalCount', -1], ['approverRoleId', 'bad-role'], ['payloadDigest', 'bad'],
            ['bindingDigest', 'bad'], ['votes', [new \stdClass()]], ['id', 'bad-uuid'],
            ['ruleCode', 'bad code'], ['requesterId', ''], ['action', 'INVALID'], ['resourceType', 'INVALID'],
            ['resourceId', "bad\n"], ['siteIdentifier', ''], ['workspaceIdentifier', 'workspace'],
            ['organizationIdentifier', 'INVALID'], ['requiredQuorum', 33], ['approvalCount', 33],
            ['expiresAt', new DateTimeImmutable('2026-09-07T10:00:00Z')],
            ['votes', array_fill(0, 33, new ApprovalVoteView(self::UUID, 'checker', 'approve', null, new DateTimeImmutable()))],
            ['votes', array_fill(0, 2, new ApprovalVoteView(self::UUID, 'checker', 'approve', null, new DateTimeImmutable()))]];
    }

    #[DataProvider('invalidVoteFields')]
    public function testVoteProjectionRejectsMalformedIdentityAndNotes(int $field, mixed $replacement): void
    {
        $args = [self::UUID, 'checker', 'approve', 'Reviewed', new DateTimeImmutable('2026-09-07T10:00:00Z')];
        $args[$field] = $replacement;
        $this->expectException(InvalidArgumentException::class);
        new ApprovalVoteView(...$args);
    }

    public static function invalidVoteFields(): iterable
    {
        yield [0, 'bad-uuid'];
        yield [1, ''];
        yield [1, "checker\n"];
        foreach ([' ', "\xff", "truncated\xc3", "note\0hidden", str_repeat('é', 501)] as $reason) {
            yield [3, $reason];
        }
    }

}
