# kumwe/approval

Portable maker-checker requests and state transitions under `Kumwe\Approval`.
An approval binds actor, action, resource identity/version, scope, authority, payload
and exclusive expiry. Register ConfigProvider dependencies in a host Laminas
ServiceManager and supply every port in resources/service-map/v1.json.

Run composer install, composer check and composer examples with PHP 8.5.
Published stable dependencies supply the required APIs. Publication requires the complete
package gate and exact dependency tag/source/dist identity checks. Independent verification
and App adoption are separate stages; independent attestation is required before App adoption under the v2 handoff.
See docs/public-api.md and docs/architecture.md.
