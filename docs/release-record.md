---
schema: kumwe-package-release-record/v1
artifact_kind: "framework_php"
migration_id: "KUMWE-MIG-2026-023"
change_set: "KUMWE-CS-2026-023"
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
target:
  repository: "https://github.com/kumwe/approval"
  artifact_identity: "kumwe/approval"
  canonical_namespace_or_abi: "Kumwe\\Approval"
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
  version_policy: "SemVer; exact stable pre-1.0 pins and independent source/archive verification for Core consumers."
  expected_artifact_types:
    - "Composer ZIP"
    - "GitHub source archive"
  required_checks:
    - "composer check"
    - "release automation regressions"
    - "final Package gate"
  required_registry_or_installer: "Composer"
  required_external_attestation: true
consumer_contract:
  permitted_only_when:
    - "Final package gates pass"
    - "Selected release and exact dependencies are independently verified"
    - "App source drift is reconciled"
  consumer_repository: "kumwe/app"
  dependency_or_native_change: "Exact-pin compatible Approval, Context, Access Control, Audit and Transaction releases and regenerate Core composer.lock."
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
    - "Record verified source/artifact identity in external evidence and Core dependency records."
  verification_commands:
    - "composer check"
    - "Affected Core unit/integration suites and the complete host integration gate"
governance:
  completion_claim: false
decisions:
  - "Library owns portable behavior and conformance; App owns composed authority and integration."
  - "Malformed snapshots are refused at construction; projection flags never establish authority."
blockers: []
---

# Approval release record

## Package contract

Fifteen exported types own portable maker-checker bindings, transitions, query values, services and host ports.

## Public API and responsibility

[Public API](public-api.md), [architecture](architecture.md) and [Core contract](core-contract.md) define ownership.

## Dependencies and semantic inputs

Exact Context, Access Control, Audit and Transaction 0.1.2 dependencies supply the canonical contracts.
MembershipDirectory remains owned by Access Control. Clock, UUID and container collaborators are explicit.

## Consumer contract

[Source mappings](source-map.json) and [consumer inventory](consumer-inventory.json) retain exact baselines.
Core owns credentials, trusted contexts, protected actions, database repositories, replay fences and delivery.

## Test ownership

The package owns bindings, separation rules, freshness, replay-port calls, expiry/transitions, queries and DI.
Core retains actual database races, two-approver concurrency, audit rollback, step-up and protected-action tests.

## Consumer verification

Verify the selected exact release and dependency tuple independently. Run retained Core integration tests and
validate that repository, ownership, replay-fence and audit writes share the actual transaction.

## Compatibility and drift

Reconcile current Core code with source mappings before replacing imports or duplicate implementation tests.
Context is supplied per operation; neither approval consumption nor presentation flags establish action authority.

## Validation

Run `composer check`, examples and release automation regressions. CI proves the no-dev authoritative consumer
and actual Laminas service construction; external evidence records published source and archive identities.
