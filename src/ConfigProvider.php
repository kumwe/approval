<?php

declare(strict_types=1);

namespace Kumwe\Approval;

use Kumwe\Approval\Container\ApprovalServiceFactory;
use Kumwe\Approval\Container\ApprovalQueryServiceFactory;

/** Deterministic service wiring that grants no host authority. @since 0.1.0 */
final class ConfigProvider
{
    /**
     * Describe actual injected services only.
     * @return array{dependencies: array{factories: array<class-string, class-string>, shared: array<class-string, bool>}}
     * @since 0.1.0
     */
    public function __invoke(): array
    {
        return ['dependencies' => [
            'factories' => [
                ApprovalService::class => ApprovalServiceFactory::class,
                ApprovalQueryService::class => ApprovalQueryServiceFactory::class,
            ],
            'shared' => [ApprovalService::class => true, ApprovalQueryService::class => true],
        ]];
    }
}
