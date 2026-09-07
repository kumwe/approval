<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__) . '/vendor/autoload.php';
$binding = new Kumwe\Approval\ApprovalBinding('maker', 'record.update', 'record', 'record-1', 7,
    'site', null, null, str_repeat('a', 64), hash('sha256', '{"approved":true}'));
if (strlen($binding->digest()) !== 64 || $binding->resourceVersion() !== 7) {
    throw new RuntimeException('Approval binding example failed.');
}
echo "Exact resource version and payload are bound to the requester.\n";
