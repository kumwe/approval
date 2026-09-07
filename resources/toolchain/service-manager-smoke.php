<?php

declare(strict_types=1);

use Kumwe\Access\AuthorizationGateway;
use Kumwe\Approval\ApprovalQueryService;
use Kumwe\Approval\ApprovalService;
use Kumwe\Approval\ConfigProvider;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\ServiceManager;

require $argv[1] ?? dirname(__DIR__, 2) . '/vendor/autoload.php';
$configuration = (new ConfigProvider())()['dependencies'];
$host = require __DIR__ . '/smoke-ports.php';
$container = new ServiceManager($configuration + ['services' => $host]);
foreach ([ApprovalService::class, ApprovalQueryService::class] as $service) {
    $instance = $container->get($service);
    if (!$instance instanceof $service || $container->get($service) !== $instance) {
        throw new RuntimeException('Exported service or shared lifetime is broken.');
    }
    try {
        (new ServiceManager($configuration))->get($service);
        throw new RuntimeException('Host dependencies must be explicit.');
    } catch (ServiceNotFoundException) {
    }
}
if ((new ServiceManager($configuration))->has(AuthorizationGateway::class)) {
    throw new RuntimeException('Package installed unauthorized host authority.');
}
echo "Two shared Approval services resolved in real Laminas; missing host ports fail closed.\n";
