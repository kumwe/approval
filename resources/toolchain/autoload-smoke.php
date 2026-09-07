<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 2) . '/vendor/autoload.php';
$manifest = json_decode(file_get_contents(dirname(__DIR__) . '/public-api/v1.json'), true, 512, JSON_THROW_ON_ERROR);
foreach ($manifest['symbols'] as $name => $entry) {
    if (!class_exists($name) && !interface_exists($name) && !enum_exists($name)) {
        throw new RuntimeException('Missing exported symbol: ' . $name);
    }
}
echo count($manifest['symbols']) . " Approval public symbols loaded from Composer.\n";
