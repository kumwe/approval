<?php

declare(strict_types=1);

namespace Kumwe\Approval\Container;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Kumwe\Approval\ApprovalQueryService;
use Kumwe\Approval\ApprovalQueryRepository;
use Kumwe\Access\AuthorizationGateway;
use Kumwe\Access\MembershipDirectory;
use Psr\Clock\ClockInterface;

/** Explicit host-port construction; no defaults or ambient state. @since 0.1.0 */
final class ApprovalQueryServiceFactory
{
    /**
     * Resolve required host-owned bindings.
     * @param ContainerInterface $container Host composition boundary.
     * @return ApprovalQueryService Shared stateless service.
     * @throws InvalidArgumentException On a wrong-type binding.
     * @since 0.1.0
     */
    public function __invoke(ContainerInterface $container): ApprovalQueryService
    {
        $repository = $container->get(ApprovalQueryRepository::class);
        if (!$repository instanceof ApprovalQueryRepository) {
            throw new InvalidArgumentException("Host binding ApprovalQueryRepository has the wrong type.");
        }
        $authorization = $container->get(AuthorizationGateway::class);
        if (!$authorization instanceof AuthorizationGateway) {
            throw new InvalidArgumentException("Host binding AuthorizationGateway has the wrong type.");
        }
        $memberships = $container->get(MembershipDirectory::class);
        if (!$memberships instanceof MembershipDirectory) {
            throw new InvalidArgumentException("Host binding MembershipDirectory has the wrong type.");
        }
        $clock = $container->get(ClockInterface::class);
        if (!$clock instanceof ClockInterface) {
            throw new InvalidArgumentException("Host binding ClockInterface has the wrong type.");
        }
        return new ApprovalQueryService($repository, $authorization, $memberships, $clock);
    }
}
