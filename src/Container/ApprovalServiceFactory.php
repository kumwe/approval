<?php

declare(strict_types=1);

namespace Kumwe\Approval\Container;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Kumwe\Approval\ApprovalService;
use Kumwe\Approval\ApprovalRepository;
use Kumwe\Approval\StepUpProofConsumer;
use Kumwe\Access\MembershipDirectory;
use Kumwe\Transaction\Contract\TransactionManager;
use Kumwe\Access\AuthorizationGateway;
use Kumwe\Access\ResourceSiteOwnershipWriter;
use Kumwe\Audit\Application\AuditRecorder;
use Psr\Clock\ClockInterface;
use Ramsey\Uuid\UuidFactoryInterface;

/** Explicit host-port construction; no defaults or ambient state. @since 0.1.0 */
final class ApprovalServiceFactory
{
    /**
     * Resolve required host-owned bindings.
     * @param ContainerInterface $container Host composition boundary.
     * @return ApprovalService Shared stateless service.
     * @throws InvalidArgumentException On a wrong-type binding.
     * @since 0.1.0
     */
    public function __invoke(ContainerInterface $container): ApprovalService
    {
        $repository = $container->get(ApprovalRepository::class);
        if (!$repository instanceof ApprovalRepository) {
            throw new InvalidArgumentException("Host binding ApprovalRepository has the wrong type.");
        }
        $stepUp = $container->get(StepUpProofConsumer::class);
        if (!$stepUp instanceof StepUpProofConsumer) {
            throw new InvalidArgumentException("Host binding StepUpProofConsumer has the wrong type.");
        }
        $memberships = $container->get(MembershipDirectory::class);
        if (!$memberships instanceof MembershipDirectory) {
            throw new InvalidArgumentException("Host binding MembershipDirectory has the wrong type.");
        }
        $transactions = $container->get(TransactionManager::class);
        if (!$transactions instanceof TransactionManager) {
            throw new InvalidArgumentException("Host binding TransactionManager has the wrong type.");
        }
        $authorization = $container->get(AuthorizationGateway::class);
        if (!$authorization instanceof AuthorizationGateway) {
            throw new InvalidArgumentException("Host binding AuthorizationGateway has the wrong type.");
        }
        $ownership = $container->get(ResourceSiteOwnershipWriter::class);
        if (!$ownership instanceof ResourceSiteOwnershipWriter) {
            throw new InvalidArgumentException("Host binding ResourceSiteOwnershipWriter has the wrong type.");
        }
        $audit = $container->get(AuditRecorder::class);
        if (!$audit instanceof AuditRecorder) {
            throw new InvalidArgumentException("Host binding AuditRecorder has the wrong type.");
        }
        $clock = $container->get(ClockInterface::class);
        if (!$clock instanceof ClockInterface) {
            throw new InvalidArgumentException("Host binding ClockInterface has the wrong type.");
        }
        $identifiers = $container->get(UuidFactoryInterface::class);
        if (!$identifiers instanceof UuidFactoryInterface) {
            throw new InvalidArgumentException("Host binding UuidFactoryInterface has the wrong type.");
        }
        return new ApprovalService(
            $repository,
            $stepUp,
            $memberships,
            $transactions,
            $authorization,
            $ownership,
            $audit,
            $clock,
            $identifiers,
        );
    }
}
