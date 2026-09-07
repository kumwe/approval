<?php

declare(strict_types=1);

// Explicit host-port sentinels used only by the archive construction smoke.
// Every behavior invocation fails: these are never production service bindings.
return [
    \Kumwe\Approval\ApprovalRepository::class => new class implements \Kumwe\Approval\ApprovalRepository {
        public function rule(Kumwe\Approval\ApprovalBinding $binding, bool $lock = false): ?Kumwe\Approval\ApprovalRule
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function requesterEligible(Kumwe\Approval\ApprovalRule $rule, Kumwe\Context\Value\ExecutionContext $context): bool
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function approverEligible(Kumwe\Approval\ApprovalRequest $request, Kumwe\Context\Value\ExecutionContext $context): bool
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function insert(string $id, Kumwe\Approval\ApprovalRule $rule, Kumwe\Approval\ApprovalBinding $binding, DateTimeImmutable $expiresAt, DateTimeImmutable $createdAt): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function lock(string $id): ?Kumwe\Approval\ApprovalRequest
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function vote(string $id, string $requestId, string $approverId, string $decision, ?string $reason, string $contextFingerprint, ?string $stepUpProofId, DateTimeImmutable $at): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function approvalCount(string $requestId): int
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function transition(string $requestId, Kumwe\Approval\ApprovalStatus $from, Kumwe\Approval\ApprovalStatus $to, int $expectedVersion, DateTimeImmutable $at): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Approval\ApprovalQueryRepository::class => new class implements \Kumwe\Approval\ApprovalQueryRepository {
        public function visible(Kumwe\Context\Value\ExecutionContext $context, bool $includeOwn, bool $includeEligible, bool $includeManaged, DateTimeImmutable $at, int $limit): array
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function findVisible(Kumwe\Context\Value\ExecutionContext $context, string $requestId, bool $includeOwn, bool $includeEligible, bool $includeManaged, DateTimeImmutable $at): ?Kumwe\Approval\ApprovalRequestView
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Approval\StepUpProofConsumer::class => new class implements \Kumwe\Approval\StepUpProofConsumer {
        public function consume(Kumwe\Context\Value\StepUpProof $proof, Kumwe\Context\Value\ExecutionContext $context, string $purpose, DateTimeImmutable $at): string
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Access\MembershipDirectory::class => new class implements \Kumwe\Access\MembershipDirectory {
        public function resolve(string $subjectId, Kumwe\Context\Value\SiteContext $site, string $organizationIdentifier, ?string $workspaceIdentifier = NULL, bool $lock = false): ?Kumwe\Context\Value\MembershipContext
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function current(string $subjectId, Kumwe\Context\Value\SiteContext $site, Kumwe\Context\Value\MembershipContext $membership, bool $lock = false): bool
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function selections(string $subjectId, Kumwe\Context\Value\SiteContext $site): array
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Transaction\Contract\TransactionManager::class => new class implements \Kumwe\Transaction\Contract\TransactionManager {
        public function transactional(callable $operation): mixed
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function afterCommit(callable $operation): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function afterRollback(callable $operation): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Access\AuthorizationGateway::class => new class implements \Kumwe\Access\AuthorizationGateway {
        public function decide(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Access\Capability $action, Kumwe\Access\AuthorizationResource $resource): Kumwe\Access\AuthorizationDecision
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function assertAllowed(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Access\Capability $action, Kumwe\Access\AuthorizationResource $resource): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function assertCanDelegate(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Access\Capability $action, Kumwe\Access\GrantScope $scope): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Access\ResourceSiteOwnershipWriter::class => new class implements \Kumwe\Access\ResourceSiteOwnershipWriter {
        public function record(Kumwe\Access\AuthorizationResource $resource, Kumwe\Context\Value\SiteContext $site): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function remove(Kumwe\Access\AuthorizationResource $resource, Kumwe\Context\Value\SiteContext $expectedSite): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
        public function reassign(Kumwe\Access\ResourceOwnership $owner, Kumwe\Access\OwnershipScope $expected): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Kumwe\Audit\Application\AuditRecorder::class => new class implements \Kumwe\Audit\Application\AuditRecorder {
        public function record(Kumwe\Audit\Domain\AuditEvent $event): void
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Psr\Clock\ClockInterface::class => new class implements \Psr\Clock\ClockInterface {
        public function now(): DateTimeImmutable
        {
            throw new \LogicException('Archive smoke host sentinel was invoked.');
        }
    },
    \Ramsey\Uuid\UuidFactoryInterface::class => new \Ramsey\Uuid\UuidFactory(),
];
