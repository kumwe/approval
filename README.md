# Kumwe Approval

[![Packagist version][version-badge]][package]
[![Approval CI][ci-badge]][ci]
[![PHP requirement][php-badge]][package]
[![License][license-badge]](LICENSE)

[version-badge]: https://img.shields.io/packagist/v/kumwe/approval
[package]: https://packagist.org/packages/kumwe/approval
[ci-badge]: https://github.com/kumwe/approval/actions/workflows/ci.yml/badge.svg?branch=main
[ci]: https://github.com/kumwe/approval/actions/workflows/ci.yml
[php-badge]: https://img.shields.io/packagist/dependency-v/kumwe/approval/php
[license-badge]: https://img.shields.io/packagist/l/kumwe/approval

Portable maker-checker requests and state transitions under `Kumwe\Approval`. An approval binds actor, action,
resource identity/version, scope, authority, payload and exclusive expiry. Core supplies trusted authority,
persistence and the actual protected action.

## Installation and use

Requires PHP 8.5 with mbstring. Install the published package with an exact pre-1.0 pin:

```sh
composer require kumwe/approval:0.1.2
```

```php
<?php

require 'vendor/autoload.php';

use Kumwe\Approval\ApprovalBinding;

$binding = new ApprovalBinding(
    'maker', 'record.update', 'record', 'record-1', 7,
    'site', null, null, str_repeat('a', 64), hash('sha256', '{"approved":true}'),
);
assert($binding->resourceVersion() === 7);
assert(strlen($binding->digest()) === 64);
```

This value describes a binding; the host must supply trusted actor, authority and scope facts. To run the workflow,
register ConfigProvider dependencies in the host composition root and supply every binding in the
[integration guide](docs/integration.md). The [typed example](examples/typed-consumer.php) verifies binding behavior.

## Core integration

ApprovalService and ApprovalQueryService are stateless. Core provides repositories, membership and authorization,
transaction-bound ownership/audit/replay operations, clock and UUID generation. The [Core contract](docs/core-contract.md)
defines authority, transaction, lifecycle and test ownership. Consuming an approval does not execute a protected action.

The exact Kumwe dependency tuple is Access Context, Access Control, Audit and Transaction 0.1.2, resolved from
Packagist. PSR Clock/Container and Ramsey UUID provide the remaining contracts. [Public API](docs/public-api.md),
[architecture](docs/architecture.md), [charter](CHARTER.md) and [release record](docs/release-record.md) describe the package.

## Development and releases

```sh
composer install
composer check
composer examples
```

CI checks behavior, hostile inputs, API/manifests, configured services and a no-dev authoritative archive consumer.
Published versions and CI status are linked above; Core validates its own retained integration suites.
The [release standard](docs/package-release-standard.md) distinguishes publication identity checks from independent
release evidence. Licensed under [Apache-2.0](LICENSE).
