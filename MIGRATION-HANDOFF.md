# Approval migration handoff

NRM-2026-024: phase 1 candidate implementation, not release-verified.
Initial implementation: merged PR #2 (successor to merged #1).
Namespace Kumwe\Approval; baseline and moved files in docs/source-map.json.

Twelve initial App types plus ConfigProvider and two explicit factories. MembershipDirectory
belongs to Access. Locked rule lookup, injected uuid4 identity, workspace-parent validation,
quorum upper bound, direct maker-checker/scope checks, cancellation expiry, live policy
freshness and Expired are intentional pre-release hardening.

App remains unchanged. After independent release verification, a separate
adoption replaces old imports and DI and removes implementation-owned ApprovalServiceTest
cases now owned here. Keep host database/concurrency, two-approver, step-up, authorization,
protected-action, audit rollback and delivery tests. Source changes require reconciliation.

The package now requires published Access Control 0.1.0 and Audit 0.1.0, with exact
stable direct Kumwe requirements. Publication verifies dependency release tags against
Composer source and dist identities; it does not require external attestations or
optional repository settings. The recorded 0.1.0 release awaits the human rebase merge
and successful default-branch publication. No App adoption is claimed.

Validation covers behavior/contract tests, max-level source PHPStan, explicit real
Laminas construction and a no-dev authoritative archive consumer. PR checks bind evidence
to the final head; independent upstream attestation remains outstanding.

Access Control v0.1.0 resolves to `54dbaa1dbffeb09ba390a5e75e8adc951c437a41`;
Audit v0.1.0 resolves to `be414ba7c3af218ee1744d1443ced2c7c630838f`.
Both normal publication runs succeeded on September 7, 2026. These observed dependency
identities are not a future Approval release SHA or an independent release attestation.
