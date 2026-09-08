---
schema: "kumwe-migration-handoff/v2"
artifact_kind: "framework_php"
migration_id: "KUMWE-MIG-2026-023"
change_set: "KUMWE-CS-2026-023"
state: "draft_pr_open"
source:
  app:
    repository: "https://github.com/kumwe/app"
    baseline_commit: "24ecf956423c18933e824b43cea1bfb9127a79a9"
    examined_paths:
      - "src/BusinessSecurity/Application/Approval/ApprovalStatus.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRequestView.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalService.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalBinding.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRule.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalQueryService.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalQueryRepository.php"
      - "src/BusinessSecurity/Application/Approval/StepUpProofConsumer.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRepository.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalVoteView.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalDenied.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRequest.php"
    old_namespace_roots:
      - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\"
    capability_index_sha256: null
  semantic_inputs: []
  examined_dependencies:
    - "kumwe/access-context"
    - "kumwe/access-control"
    - "kumwe/audit"
    - "kumwe/transaction 0.1.2 at 56c8eb14a70bd3f1ed7eaeae7196a07d6627bf03"
  active_related_pull_requests:
    - "https://github.com/kumwe/access-control/pull/6"
    - "https://github.com/kumwe/audit/pull/5"
target:
  repository: "https://github.com/kumwe/approval"
  artifact_identity: "kumwe/approval"
  canonical_namespace_or_abi: "Kumwe\\Approval"
  branch: codex/integration-readiness-20260908
  pull_request: "https://github.com/kumwe/approval/pull/4"
ownership:
  responsibility: "Portable maker-checker bindings, approval state transitions, request/query values and transaction-bounded services through explicit host ports."
  non_responsibilities:
    - "Credential and step-up authentication"
    - "Protected-action execution"
    - "Database repositories, locking, trusted context construction, notifications and delivery"
  allowed_dependency_ceiling:
    - "kumwe/access-context"
    - "kumwe/access-control"
    - "kumwe/audit"
    - "kumwe/transaction"
  implementation_owner: "kumwe/approval"
  next_consumer: "kumwe/app"
  public_manifests:
    -
      path: "resources/public-api/v1.json"
      sha256: "5985b2105f0ecafd9804084a894309175236e8f182c4ad47c892c97dbe72c48d"
    -
      path: "resources/capabilities/v1.json"
      sha256: "355b1a9fc67458ba5fbc2758d06415a72dbaf19bc50b7bdee09fca5812de4109"
    -
      path: "resources/service-map/v1.json"
      sha256: "da068d341df795d85028636ad16414a7086de63f9ece5e3551ed39a6907fdc25"
  intentionally_excluded:
    - "MembershipDirectory belongs to Access"
    - "App persistence, authorization authority, protected workflows and integration tests"
framework_php:
  composer_package: "kumwe/approval"
  canonical_namespace: "Kumwe\\Approval"
  public_api_manifest: "resources/public-api/v1.json"
  capability_manifest: "resources/capabilities/v1.json"
  service_map: "resources/service-map/v1.json"
  extracted_symbols:
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalBinding"
      new_fqcn: "Kumwe\\Approval\\ApprovalBinding"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalBinding.php"
      target_path: "src/ApprovalBinding.php"
      kind: "class"
      public_methods:
        - "__construct"
        - "action"
        - "contextFingerprint"
        - "digest"
        - "fromContext"
        - "organization"
        - "payloadDigest"
        - "requesterId"
        - "resourceId"
        - "resourceType"
        - "resourceVersion"
        - "siteIdentifier"
        - "workspace"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalDenied"
      new_fqcn: "Kumwe\\Approval\\ApprovalDenied"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalDenied.php"
      target_path: "src/ApprovalDenied.php"
      kind: "class"
      public_methods:
        - "__construct"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalQueryRepository"
      new_fqcn: "Kumwe\\Approval\\ApprovalQueryRepository"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalQueryRepository.php"
      target_path: "src/ApprovalQueryRepository.php"
      kind: "interface"
      public_methods:
        - "findVisible"
        - "visible"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalQueryService"
      new_fqcn: "Kumwe\\Approval\\ApprovalQueryService"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalQueryService.php"
      target_path: "src/ApprovalQueryService.php"
      kind: "class"
      public_methods:
        - "__construct"
        - "detail"
        - "inbox"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRepository"
      new_fqcn: "Kumwe\\Approval\\ApprovalRepository"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalRepository.php"
      target_path: "src/ApprovalRepository.php"
      kind: "interface"
      public_methods:
        - "approvalCount"
        - "approverEligible"
        - "insert"
        - "lock"
        - "requesterEligible"
        - "rule"
        - "transition"
        - "vote"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRequest"
      new_fqcn: "Kumwe\\Approval\\ApprovalRequest"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalRequest.php"
      target_path: "src/ApprovalRequest.php"
      kind: "class"
      public_methods:
        - "__construct"
      public_properties:
        - "approvalAction"
        - "approverRoleId"
        - "binding"
        - "distinctActors"
        - "expiresAt"
        - "id"
        - "quorum"
        - "ruleId"
        - "ruleVersion"
        - "status"
        - "version"
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRequestView"
      new_fqcn: "Kumwe\\Approval\\ApprovalRequestView"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalRequestView.php"
      target_path: "src/ApprovalRequestView.php"
      kind: "class"
      public_methods:
        - "__construct"
      public_properties:
        - "action"
        - "approvalAction"
        - "approvalCount"
        - "approverRoleId"
        - "bindingDigest"
        - "canApprove"
        - "canCancel"
        - "canRevoke"
        - "createdAt"
        - "distinctActors"
        - "expiresAt"
        - "id"
        - "organizationIdentifier"
        - "payloadDigest"
        - "requesterId"
        - "requiredQuorum"
        - "resourceId"
        - "resourceType"
        - "resourceVersion"
        - "ruleCode"
        - "ruleVersion"
        - "siteIdentifier"
        - "status"
        - "version"
        - "votes"
        - "workspaceIdentifier"
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRule"
      new_fqcn: "Kumwe\\Approval\\ApprovalRule"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalRule.php"
      target_path: "src/ApprovalRule.php"
      kind: "class"
      public_methods:
        - "__construct"
      public_properties:
        - "approvalAction"
        - "approverRoleId"
        - "code"
        - "distinctActors"
        - "id"
        - "quorum"
        - "version"
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalService"
      new_fqcn: "Kumwe\\Approval\\ApprovalService"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalService.php"
      target_path: "src/ApprovalService.php"
      kind: "class"
      public_methods:
        - "__construct"
        - "approve"
        - "cancel"
        - "consume"
        - "expire"
        - "reject"
        - "request"
        - "revoke"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalStatus"
      new_fqcn: "Kumwe\\Approval\\ApprovalStatus"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalStatus.php"
      target_path: "src/ApprovalStatus.php"
      kind: "enum"
      public_methods: []
      public_properties: []
      public_constants:
        - "Approved"
        - "Cancelled"
        - "Consumed"
        - "Expired"
        - "Pending"
        - "Rejected"
        - "Revoked"
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalVoteView"
      new_fqcn: "Kumwe\\Approval\\ApprovalVoteView"
      source_path: "src/BusinessSecurity/Application/Approval/ApprovalVoteView.php"
      target_path: "src/ApprovalVoteView.php"
      kind: "class"
      public_methods:
        - "__construct"
      public_properties:
        - "approverId"
        - "decidedAt"
        - "decision"
        - "id"
        - "reason"
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
    -
      old_fqcn: "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\StepUpProofConsumer"
      new_fqcn: "Kumwe\\Approval\\StepUpProofConsumer"
      source_path: "src/BusinessSecurity/Application/Approval/StepUpProofConsumer.php"
      target_path: "src/StepUpProofConsumer.php"
      kind: "interface"
      public_methods:
        - "consume"
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: "Documented scalar/value projections; native object serialization is not a durable wire or authority contract."
      compatibility: "Existing names/signatures retained; malformed projection and note inputs are now refused."
  consumers:
    app_code:
      - "src/Administrator/Http/Handler/AdministratorAccessControlHandler.php"
      - "src/Administrator/Http/Handler/AdministratorBusinessSecurityHandler.php"
      - "src/BusinessRecord/Application/BusinessRecordCustomActionGuard.php"
      - "src/BusinessRecord/Application/BusinessRecordService.php"
      - "src/BusinessSecurity/Application/Administration/BusinessSecurityAdministrationService.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalBinding.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalDenied.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalQueryRepository.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalQueryService.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRepository.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRequest.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRequestView.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalRule.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalService.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalStatus.php"
      - "src/BusinessSecurity/Application/Approval/ApprovalVoteView.php"
      - "src/BusinessSecurity/Application/Approval/StepUpProofConsumer.php"
      - "src/BusinessSecurity/Infrastructure/Persistence/DoctrineApprovalQueryRepository.php"
      - "src/BusinessSecurity/Infrastructure/Persistence/DoctrineApprovalRepository.php"
      - "src/BusinessSecurity/Infrastructure/Persistence/DoctrineStepUpProofConsumer.php"
      - "src/BusinessSurface/Application/BusinessApprovalSurfaceService.php"
      - "src/Delivery/Console/Command/BusinessConsoleFailureMapper.php"
      - "src/Delivery/Console/Command/BusinessRecordConsolePresenter.php"
      - "src/Delivery/Http/Api/Business/BusinessApprovalApiHandler.php"
      - "src/Delivery/Http/Api/Business/BusinessApprovalApiPresenter.php"
      - "src/Delivery/Http/Api/Business/BusinessRecordApiResponder.php"
      - "src/Infrastructure/Mcp/McpToolErrorVocabulary.php"
      - "src/Kernel/ContainerFactory.php"
      - "src/Portal/Http/Handler/PortalApprovalHandler.php"
    configuration_and_di: []
    reflection_and_string_references:
      - "Recompute against current App before adoption; see docs/consumer-inventory.json"
    fixtures_and_examples:
      - "examples/typed-consumer.php"
    external: []
  dependency_injection:
    mode: "config-provider"
    provider: "Kumwe\\Approval\\ConfigProvider"
    factories:
      - "Kumwe\\Approval\\Container\\ApprovalServiceFactory"
      - "Kumwe\\Approval\\Container\\ApprovalQueryServiceFactory"
    aliases: []
    service_lifetimes:
      - "Kumwe\\Approval\\ApprovalService: shared; all operation context is explicit"
      - "Kumwe\\Approval\\ApprovalQueryService: shared; all operation context is explicit"
    configuration_keys: []
    provider_absence_reason: null
native_cpp: null
php_extension: null
tests:
  moved_or_added:
    - "tests/ApprovalServiceTest.php"
    - "tests/ApprovalQueryServiceTest.php"
    - "tests/ContractTest.php"
  remain_in_app_or_consumer:
    - "tests/Integration/BusinessSecurity/CompetingApproverContentionIntegrationTest.php"
    - "tests/Integration/BusinessSecurity/DoctrineApprovalQueryRepositoryIntegrationTest.php"
    - "tests/Unit/Administrator/Http/Handler/AdministratorAccessControlHandlerTest.php"
    - "tests/Unit/BusinessSecurity/Application/ApprovalServiceTest.php"
    - "tests/Unit/BusinessSecurity/Application/BusinessSecurityAdministrationServiceTest.php"
    - "tests/Unit/BusinessSecurity/Infrastructure/Persistence/DoctrineApprovalRepositoryTest.php"
    - "tests/Unit/BusinessSecurity/Infrastructure/Persistence/DoctrineStepUpProofConsumerTest.php"
    - "tests/Unit/BusinessSurface/Application/BusinessApprovalSurfaceServiceTest.php"
    - "tests/Unit/Delivery/Console/Command/BusinessRecordConsolePresenterTest.php"
    - "tests/Unit/Delivery/Http/Api/Business/BusinessApprovalApiPresenterTest.php"
    - "tests/Unit/Delivery/Http/Api/Business/BusinessRecordApiResponderTest.php"
  split_tests:
    - "Split library implementation assertions from host authority, transaction, DB and delivery assertions."
  prohibited_duplicates:
    - "Do not retain vendor-class implementation unit tests in App after verified adoption."
  corpora: []
documentation:
  charter: "CHARTER.md"
  readme: "README.md"
  public_api: "docs/public-api.md"
  architecture: "docs/architecture.md"
  integration_or_consumer: "docs/integration.md"
  examples:
    - "examples/typed-consumer.php"
  changelog_record: "CHANGELOG.md ## 0.1.2"
release_expectations:
  version_policy: "Exact stable pre-1.0 pins; preserve existing releases and independently verify the successor before App adoption."
  expected_artifact_types:
    - "Composer ZIP"
    - "GitHub source archive"
  required_checks:
    - "composer check"
    - "release automation regressions"
    - "final Package gate"
  required_registry_or_installer: "Composer"
  required_external_attestation: true
next_task:
  phase_name: "Human successor review, release verification and coordinated dependency admission before App adoption"
  permitted_only_when:
    - "Final package gates pass"
    - "Successor release and exact dependencies are independently verified"
    - "App source drift is reconciled"
  consumer_repository: "kumwe/app"
  dependency_or_native_change: "Transaction is pinned to published 0.1.2 at 56c8eb14a70bd3f1ed7eaeae7196a07d6627bf03. Keep the coherent Context/Access/Audit 0.1.0 tuple until compatible Access and Audit successors are published, then advance those exact pins together."
  namespace_or_api_replacements:
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalBinding => Kumwe\\Approval\\ApprovalBinding"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalDenied => Kumwe\\Approval\\ApprovalDenied"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalQueryRepository => Kumwe\\Approval\\ApprovalQueryRepository"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalQueryService => Kumwe\\Approval\\ApprovalQueryService"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRepository => Kumwe\\Approval\\ApprovalRepository"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRequest => Kumwe\\Approval\\ApprovalRequest"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRequestView => Kumwe\\Approval\\ApprovalRequestView"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalRule => Kumwe\\Approval\\ApprovalRule"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalService => Kumwe\\Approval\\ApprovalService"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalStatus => Kumwe\\Approval\\ApprovalStatus"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\ApprovalVoteView => Kumwe\\Approval\\ApprovalVoteView"
    - "Kumwe\\App\\BusinessSecurity\\Application\\Approval\\StepUpProofConsumer => Kumwe\\Approval\\StepUpProofConsumer"
  files_to_update:
    - "composer.json"
    - "composer.lock"
    - "Explicit App ConfigProvider and host-port bindings"
  files_to_remove:
    - "src/BusinessSecurity/Application/Approval/ApprovalStatus.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalRequestView.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalService.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalBinding.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalRule.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalQueryService.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalQueryRepository.php"
    - "src/BusinessSecurity/Application/Approval/StepUpProofConsumer.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalRepository.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalVoteView.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalDenied.php"
    - "src/BusinessSecurity/Application/Approval/ApprovalRequest.php"
  tests_to_remove:
    - "Only implementation-owned portions of App ApprovalServiceTest and value tests now proved in the library."
  tests_to_retain_or_add:
    - "tests/Integration/BusinessSecurity/CompetingApproverContentionIntegrationTest.php"
    - "tests/Integration/BusinessSecurity/DoctrineApprovalQueryRepositoryIntegrationTest.php"
    - "tests/Unit/Administrator/Http/Handler/AdministratorAccessControlHandlerTest.php"
    - "tests/Unit/BusinessSecurity/Application/ApprovalServiceTest.php"
    - "tests/Unit/BusinessSecurity/Application/BusinessSecurityAdministrationServiceTest.php"
    - "tests/Unit/BusinessSecurity/Infrastructure/Persistence/DoctrineApprovalRepositoryTest.php"
    - "tests/Unit/BusinessSecurity/Infrastructure/Persistence/DoctrineStepUpProofConsumerTest.php"
    - "tests/Unit/BusinessSurface/Application/BusinessApprovalSurfaceServiceTest.php"
    - "tests/Unit/Delivery/Console/Command/BusinessRecordConsolePresenterTest.php"
    - "tests/Unit/Delivery/Http/Api/Business/BusinessApprovalApiPresenterTest.php"
    - "tests/Unit/Delivery/Http/Api/Business/BusinessRecordApiResponderTest.php"
  di_or_provisioning_changes:
    - "Register Kumwe\\Approval\\ConfigProvider"
    - "Bind every host port in resources/service-map/v1.json; supply ClockInterface and UuidFactoryInterface explicitly"
  capability_index_changes:
    - "Record package ownership from verified release manifests."
  changelog_and_evidence_changes:
    - "Record verified source/artifact identity in the external attestation and App migration ledger."
  verification_commands:
    - "composer check"
    - "Affected App unit/integration suites and complete integration train gate"
concurrency:
  likely_conflict_files:
    - "App composer.json"
    - "App composer.lock"
    - "App provider list and approval host adapters"
  related_migrations:
    - "KUMWE-MIG-2026-004"
    - "KUMWE-MIG-2026-009"
    - "KUMWE-MIG-2026-021"
  ownership_conflicts: []
  integration_train: null
  resolution_rule: "semantic-preservation"
governance:
  roadmap_source_sha256: "a202155ef1a65f5ab293d4f8397ebf4ac430db7f1e877c776bbe7851e6fe18d8"
  roadmap_refs: []
  non_roadmap_refs:
    - "NRM-2026-024"
  completion_claim: false
decisions:
  - "No App edits, merges or releases in this task."
  - "Library owns portable behavior and conformance; App owns composed authority and integration."
  - "Malformed snapshots are refused at construction; projection flags never establish authority."
blockers:
  - "Independent successor and dependency release verification remains outstanding."
  - "Latest Context cannot be selected in Approval until compatible Access and Audit successors are actually published."
---

## Migration/implementation summary

The original 0.1.0 package is published. [PR #4](https://github.com/kumwe/approval/pull/4) is the boundary-validation successor; publication and independent release verification are separate observations.

## Public API and responsibility

Fifteen exported types own the portable maker-checker workflow. Protected-action execution, credentials, database repositories and transaction coupling remain App responsibilities. See docs/public-api.md and docs/architecture.md.

## Capability reuse/semantic input review

MembershipDirectory stays owned by Access. The service consumes Access, Audit, Transaction, Context, Clock and UUID contracts directly. It never copies their implementations.

## Consumer inventory

docs/source-map.json records the source baseline; docs/consumer-inventory.json lists current source/test/configuration users from that same baseline. Reconcile every changed App source before adoption.

## Test ownership

Package tests own binding fields, role/separation checks, policy freshness, replay-port calls, expiry/state transitions, query ports and DI. Keep actual DB races, two-approver concurrency, audit rollback, step-up authority and protected-action integration in App.

## Next-task execution notes

The selected production dependency tuple is:

- kumwe/access-context 0.1.2
- kumwe/access-control 0.1.2
- kumwe/audit 0.1.2
- kumwe/transaction 0.1.2

Published dependency identities and independent archive consumers must be verified before adoption.
The package gate enforces agreement between Composer constraints and the dependency evidence coordinates.

Require the complete package gate and independently verify the final release. The selected Context, Access and Audit 0.1.2 releases are the compatible published dependency graph. No App runtime switch occurs in this PR.

## Drift check

Reconcile mapped source and tests against the recorded App baseline and current App before any adoption.
Newer portable behavior must move upstream first; preserve App authority, persistence and integration tests.

## Validation recipe and observed local results

Run composer check and release automation regressions; prove the no-dev classmap-authoritative consumer and real Laminas service construction. Exact final tested heads, archive digests and external release observations are recorded outside the tested tree.

Transaction 0.1.2 is published at commit `56c8eb14a70bd3f1ed7eaeae7196a07d6627bf03`.
Its TransactionManager source is byte-identical to 0.1.0 and it has no Kumwe runtime
dependencies. The exact tag, Composer source and dist references were verified before
updating this package. This dependency update does not require an Access/Audit release.
