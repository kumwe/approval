# Approval migration handoff

NRM-2026-024: phase 1 candidate implementation, not release-verified.
PR: https://github.com/kumwe/approval/pull/2 (successor to merged #1).
Namespace Kumwe\Approval; baseline and moved files in docs/source-map.json.

Twelve initial App types plus ConfigProvider and two explicit factories. MembershipDirectory
belongs to Access. Locked rule lookup, injected uuid4 identity, workspace-parent validation,
quorum upper bound, direct maker-checker/scope checks, cancellation expiry, live policy
freshness and Expired are intentional pre-release hardening.

App remains unchanged. After independent immutable release verification, a separate
adoption replaces old imports and DI and removes implementation-owned ApprovalServiceTest
cases now owned here. Keep host database/concurrency, two-approver, step-up, authorization,
protected-action, audit rollback and delivery tests. Source changes require reconciliation.

The merged Access main branch and Audit review branch and the transitive Canonical JSON API are candidate inputs,
not release evidence. Release admission rejects branch requirements and requires exact
stable pins and external attestations. No publication or App adoption is claimed.

Validation covers behavior/contract tests, max-level source PHPStan, explicit real
Laminas construction and a no-dev authoritative archive consumer. PR checks bind evidence
to the final head; independent upstream attestation remains outstanding.

Access resolves as `dev-main` after PR #4 merged and its review branch was deleted. Reviewed main commit `54dbaa1dbffeb09ba390a5e75e8adc951c437a41` preserves the tested Access source, Composer metadata, runtime resources and tests; only release automation and documentation differ.
