# Extraction readiness review

Reviewed against the v2 package brief and engineering/test ownership standard on September 7, 2026.

| Area | Verified implementation and next boundary |
| --- | --- |
| Portable ownership | 15 types; actor/action/resource/version/context-bound requests, maker-checker workflow, replay/transaction/membership ports and explicit DI. |
| This successor | Presentation snapshots now validate identity, scope parents, expiry, bounded quorum and unique votes. Invalid UTF-8/control-bearing notes fail before replay/persistence calls. |
| Dependency graph | The coherent published graph stays Context 0.1.0 + Access 0.1.0 + Audit 0.1.0 + Transaction 0.1.0. After Access and Audit successors are actually published and independently verified, advance all three pins together. Never guess their future tags. |

Published baseline: [0.1.0](https://github.com/kumwe/approval/releases/tag/v0.1.0). The current successor is [PR #4](https://github.com/kumwe/approval/pull/4), release record 0.1.1. Publication is observed; independent release verification and App integration are not claimed.

Library tests own behavior, value boundaries, deterministic errors, public API and provider/factory conformance. App keeps persistence, final authorization, trusted context construction, deployment, concurrency and composed integration tests. No App source or test is deleted in Phase 1.

After human review and publication, verify the final tagged source/artifact/manifests and a no-dev authoritative consumer. Reconcile current App changes against the recorded extraction baseline before replacing namespaces or deleting duplicate portable tests. Preserve historical release records and all genuine remaining adoption gates.

The reviewed API, capabilities, service map and complete v2 handoff pass the read-only
App package parser at commit `24ecf956423c18933e824b43cea1bfb9127a79a9`.
Package-owned manifest checks guard exported symbols, documentation and release identity.
The consumer check does not constitute independent verification of a future release.
