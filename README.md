# kumwe/approval

Portable maker-checker requests and state transitions under `Kumwe\Approval`.
An approval binds actor, action, resource identity/version, scope, authority, payload
and exclusive expiry. Register ConfigProvider dependencies in a host Laminas
ServiceManager and supply every port in resources/service-map/v1.json.

Run composer install, composer check and composer examples with PHP 8.5.
Candidate branches provide APIs without immutable releases. Publication requires
exact stable Kumwe pins and independently verified releases. App adoption is separate.
See docs/public-api.md and docs/architecture.md.
