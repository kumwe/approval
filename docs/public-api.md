# Public API

Request/vote projections validate identity grammar, organization/workspace parentage, positive ordered expiry and quorum/count bounds through 32. Vote lists contain at most 32 distinct vote and approver identities. Notes are nonblank UTF-8 with at most 500 characters; tabs and line breaks are allowed, other control characters are refused. The service validates notes before transaction and replay-consumption calls. Invalid projections throw InvalidArgumentException; invalid decision notes use the stable non-enumerating ApprovalDenied refusal.

The complete 15-type signature contract is resources/public-api/v1.json.
Constructors validate immutable values. ApprovalDenied uses one non-enumerating message.
Mutating services propagate host failures for transaction rollback. Each declaration
documents parameter/return meanings, exceptions and state. See architecture.md for
scope, expiry, concurrency and host obligations.

## Kumwe\Approval\ApprovalBinding

`class` in `src/ApprovalBinding.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"requesterId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"action","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceType","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"siteIdentifier","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"organization","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"workspace","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"contextFingerprint","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"payloadDigest","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":null}
- `action`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `contextFingerprint`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `digest`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `fromContext`: {"visibility":"public","static":true,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"action","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceType","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"payloadDigest","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"Kumwe\\Approval\\ApprovalBinding"}
- `organization`: {"visibility":"public","static":false,"parameters":[],"return":"?string"}
- `payloadDigest`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `requesterId`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `resourceId`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `resourceType`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `resourceVersion`: {"visibility":"public","static":false,"parameters":[],"return":"int"}
- `siteIdentifier`: {"visibility":"public","static":false,"parameters":[],"return":"string"}
- `workspace`: {"visibility":"public","static":false,"parameters":[],"return":"?string"}

## Kumwe\Approval\ApprovalDenied

`class` in `src/ApprovalDenied.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[],"return":null}

## Kumwe\Approval\ApprovalQueryRepository

`interface` in `src/ApprovalQueryRepository.php`.

- `findVisible`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"includeOwn","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"includeEligible","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"includeManaged","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"at","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":"?Kumwe\\Approval\\ApprovalRequestView"}
- `visible`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"includeOwn","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"includeEligible","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"includeManaged","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"at","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false},{"name":"limit","type":"int","optional":false,"variadic":false,"by_reference":false}],"return":"array"}

## Kumwe\Approval\ApprovalQueryService

`class` in `src/ApprovalQueryService.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"repository","type":"Kumwe\\Approval\\ApprovalQueryRepository","optional":false,"variadic":false,"by_reference":false},{"name":"authorization","type":"Kumwe\\Access\\AuthorizationGateway","optional":false,"variadic":false,"by_reference":false},{"name":"memberships","type":"Kumwe\\Access\\MembershipDirectory","optional":false,"variadic":false,"by_reference":false},{"name":"clock","type":"Psr\\Clock\\ClockInterface","optional":false,"variadic":false,"by_reference":false}],"return":null}
- `detail`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"?Kumwe\\Approval\\ApprovalRequestView"}
- `inbox`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"limit","type":"int","optional":true,"variadic":false,"by_reference":false}],"return":"array"}

## Kumwe\Approval\ApprovalRepository

`interface` in `src/ApprovalRepository.php`.

- `approvalCount`: {"visibility":"public","static":false,"parameters":[{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"int"}
- `approverEligible`: {"visibility":"public","static":false,"parameters":[{"name":"request","type":"Kumwe\\Approval\\ApprovalRequest","optional":false,"variadic":false,"by_reference":false},{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false}],"return":"bool"}
- `insert`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"rule","type":"Kumwe\\Approval\\ApprovalRule","optional":false,"variadic":false,"by_reference":false},{"name":"binding","type":"Kumwe\\Approval\\ApprovalBinding","optional":false,"variadic":false,"by_reference":false},{"name":"expiresAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false},{"name":"createdAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":"void"}
- `lock`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"?Kumwe\\Approval\\ApprovalRequest"}
- `requesterEligible`: {"visibility":"public","static":false,"parameters":[{"name":"rule","type":"Kumwe\\Approval\\ApprovalRule","optional":false,"variadic":false,"by_reference":false},{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false}],"return":"bool"}
- `rule`: {"visibility":"public","static":false,"parameters":[{"name":"binding","type":"Kumwe\\Approval\\ApprovalBinding","optional":false,"variadic":false,"by_reference":false},{"name":"lock","type":"bool","optional":true,"variadic":false,"by_reference":false}],"return":"?Kumwe\\Approval\\ApprovalRule"}
- `transition`: {"visibility":"public","static":false,"parameters":[{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"from","type":"Kumwe\\Approval\\ApprovalStatus","optional":false,"variadic":false,"by_reference":false},{"name":"to","type":"Kumwe\\Approval\\ApprovalStatus","optional":false,"variadic":false,"by_reference":false},{"name":"expectedVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"at","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":"void"}
- `vote`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"approverId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"decision","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"reason","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"contextFingerprint","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"stepUpProofId","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"at","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":"void"}

## Kumwe\Approval\ApprovalRequest

`class` in `src/ApprovalRequest.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"ruleId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"ruleVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"approvalAction","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"approverRoleId","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"distinctActors","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"binding","type":"Kumwe\\Approval\\ApprovalBinding","optional":false,"variadic":false,"by_reference":false},{"name":"quorum","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"status","type":"Kumwe\\Approval\\ApprovalStatus","optional":false,"variadic":false,"by_reference":false},{"name":"expiresAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false},{"name":"version","type":"int","optional":false,"variadic":false,"by_reference":false}],"return":null}

## Kumwe\Approval\ApprovalRequestView

`class` in `src/ApprovalRequestView.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"ruleCode","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"ruleVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"approvalAction","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"approverRoleId","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"distinctActors","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"requesterId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"action","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceType","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"resourceVersion","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"siteIdentifier","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"organizationIdentifier","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"workspaceIdentifier","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"payloadDigest","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"bindingDigest","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"requiredQuorum","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"approvalCount","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"status","type":"Kumwe\\Approval\\ApprovalStatus","optional":false,"variadic":false,"by_reference":false},{"name":"createdAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false},{"name":"expiresAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false},{"name":"version","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"canApprove","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"canCancel","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"canRevoke","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"votes","type":"array","optional":false,"variadic":false,"by_reference":false}],"return":null}

## Kumwe\Approval\ApprovalRule

`class` in `src/ApprovalRule.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"code","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"approvalAction","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"quorum","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"distinctActors","type":"bool","optional":false,"variadic":false,"by_reference":false},{"name":"version","type":"int","optional":false,"variadic":false,"by_reference":false},{"name":"approverRoleId","type":"?string","optional":false,"variadic":false,"by_reference":false}],"return":null}

## Kumwe\Approval\ApprovalService

`class` in `src/ApprovalService.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"repository","type":"Kumwe\\Approval\\ApprovalRepository","optional":false,"variadic":false,"by_reference":false},{"name":"stepUp","type":"Kumwe\\Approval\\StepUpProofConsumer","optional":false,"variadic":false,"by_reference":false},{"name":"memberships","type":"Kumwe\\Access\\MembershipDirectory","optional":false,"variadic":false,"by_reference":false},{"name":"transactions","type":"Kumwe\\Transaction\\Contract\\TransactionManager","optional":false,"variadic":false,"by_reference":false},{"name":"authorization","type":"Kumwe\\Access\\AuthorizationGateway","optional":false,"variadic":false,"by_reference":false},{"name":"ownership","type":"Kumwe\\Access\\ResourceSiteOwnershipWriter","optional":false,"variadic":false,"by_reference":false},{"name":"audit","type":"Kumwe\\Audit\\Application\\AuditRecorder","optional":false,"variadic":false,"by_reference":false},{"name":"clock","type":"Psr\\Clock\\ClockInterface","optional":false,"variadic":false,"by_reference":false},{"name":"identifiers","type":"Ramsey\\Uuid\\UuidFactoryInterface","optional":false,"variadic":false,"by_reference":false}],"return":null}
- `approve`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"reason","type":"?string","optional":true,"variadic":false,"by_reference":false}],"return":"Kumwe\\Approval\\ApprovalStatus"}
- `cancel`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"void"}
- `consume`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"binding","type":"Kumwe\\Approval\\ApprovalBinding","optional":false,"variadic":false,"by_reference":false}],"return":"void"}
- `expire`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"void"}
- `reject`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"reason","type":"?string","optional":true,"variadic":false,"by_reference":false}],"return":"Kumwe\\Approval\\ApprovalStatus"}
- `request`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"binding","type":"Kumwe\\Approval\\ApprovalBinding","optional":false,"variadic":false,"by_reference":false},{"name":"lifetime","type":"?DateInterval","optional":true,"variadic":false,"by_reference":false}],"return":"?string"}
- `revoke`: {"visibility":"public","static":false,"parameters":[{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"requestId","type":"string","optional":false,"variadic":false,"by_reference":false}],"return":"void"}

## Kumwe\Approval\ApprovalStatus

`enum` in `src/ApprovalStatus.php`.


## Kumwe\Approval\ApprovalVoteView

`class` in `src/ApprovalVoteView.php`.

- `__construct`: {"visibility":"public","static":false,"parameters":[{"name":"id","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"approverId","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"decision","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"reason","type":"?string","optional":false,"variadic":false,"by_reference":false},{"name":"decidedAt","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":null}

## Kumwe\Approval\ConfigProvider

`class` in `src/ConfigProvider.php`.

- `__invoke`: {"visibility":"public","static":false,"parameters":[],"return":"array"}

## Kumwe\Approval\Container\ApprovalQueryServiceFactory

`class` in `src/Container/ApprovalQueryServiceFactory.php`.

- `__invoke`: {"visibility":"public","static":false,"parameters":[{"name":"container","type":"Psr\\Container\\ContainerInterface","optional":false,"variadic":false,"by_reference":false}],"return":"Kumwe\\Approval\\ApprovalQueryService"}

## Kumwe\Approval\Container\ApprovalServiceFactory

`class` in `src/Container/ApprovalServiceFactory.php`.

- `__invoke`: {"visibility":"public","static":false,"parameters":[{"name":"container","type":"Psr\\Container\\ContainerInterface","optional":false,"variadic":false,"by_reference":false}],"return":"Kumwe\\Approval\\ApprovalService"}

## Kumwe\Approval\StepUpProofConsumer

`interface` in `src/StepUpProofConsumer.php`.

- `consume`: {"visibility":"public","static":false,"parameters":[{"name":"proof","type":"Kumwe\\Context\\Value\\StepUpProof","optional":false,"variadic":false,"by_reference":false},{"name":"context","type":"Kumwe\\Context\\Value\\ExecutionContext","optional":false,"variadic":false,"by_reference":false},{"name":"purpose","type":"string","optional":false,"variadic":false,"by_reference":false},{"name":"at","type":"DateTimeImmutable","optional":false,"variadic":false,"by_reference":false}],"return":"string"}
