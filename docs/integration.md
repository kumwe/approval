# Host integration contract

Register the `dependencies` array returned by `Kumwe\Approval\ConfigProvider`
with a Laminas ServiceManager. The provider registers two shared, stateless
services: `ApprovalService` and `ApprovalQueryService`. Each operation receives
its execution context explicitly. No actor, scope or authority is cached.

Supply these exact host bindings before resolving either service:

| Port | Host responsibility |
| --- | --- |
| `Kumwe\Approval\ApprovalRepository` | Lock rules, persist requests and votes, and compare-and-set transitions atomically. |
| `Kumwe\Approval\ApprovalQueryRepository` | Enforce actor/scope visibility and deterministic bounded inbox queries. |
| `Kumwe\Approval\StepUpProofConsumer` | Validate proof provenance and atomically consume a replay fence. |
| `Kumwe\Access\MembershipDirectory` | Resolve current membership and eligible authority. |
| `Kumwe\Access\AuthorizationGateway` | Evaluate current permissions for the supplied context. |
| `Kumwe\Access\ResourceSiteOwnershipWriter` | Record resource ownership within the mutation transaction. |
| `Kumwe\Transaction\Contract\TransactionManager` | Supply the shared transaction boundary. |
| `Kumwe\Audit\Application\AuditRecorder` | Append audit events atomically with the state change. |
| `Psr\Clock\ClockInterface` | Supply the current instant. |
| `Ramsey\Uuid\UuidFactoryInterface` | Generate request/vote identities through `uuid4()`. |

The query service needs only its query repository, authorization gateway,
membership directory and clock. Factories reject bindings of the wrong type.
There are no default persistence, credential, proof or authorization adapters.

Repository mutations, rule locks, ownership writes, proof consumption and audit
append must participate in the same transaction. Adapter exceptions must roll
back every effect. Call `consume` immediately before the protected mutation in
the same outer transaction; consuming an approval does not execute that action.
The host authenticates the actor, verifies step-up and authorizes the action.

The repository must count distinct actors, reject duplicate votes atomically,
and enforce the expected request version/state. A changed active rule or expired
proof fails closed. See [architecture](architecture.md) for the transition and
query contracts and [public API](public-api.md) for all exported types.

Pure library transitions, validation, factory wiring and hostile port behavior
are tested in this package. App adoption will add tests for the real database,
identity, transaction, audit, middleware and protected-action adapters. The
current source map and consumer inventory identify those future App edits.

This branch prepares release 0.1.1. Existing published exact dependency pins
remain coherent. The next dependency update must wait for compatible Access
Control and Audit successors, then update the complete dependency tuple and
rerun the isolated Composer consumer and full package gate before adoption.
