# Approval runtime and host integration

ApprovalService owns request, approve, reject, cancel, revoke, expire and consume.
Mutations, live membership checks and active-rule locking run through TransactionManager.
Host repository, ownership, replay-fence and audit adapters must share its transaction;
any exception rolls back all effects. rule(binding, true) holds active policy and
eligibility state locks. The package compares rule identity/version/checker capability/
quorum/distinctness/role before decisions and consumption. Changed policies fail closed.

The repository refuses duplicate actors atomically, counts distinct approving actors,
and compare-and-sets transitions against expected state and request version.
Only the maker consumes the unchanged binding. Pending requests accept votes and
cancellation. Pending/approved requests may be revoked or expire. Expiry is exclusive;
terminal requests cannot be replayed. Requests live no longer than seven days.

App authenticates actors, issues trusted ExecutionContext, verifies step-up, constructs
current authority, authorizes the protected action and executes it. Call consume in
the same outer transaction immediately before that mutation. Standalone consumption
does not execute a protected action. ClockInterface and UuidFactoryInterface are
explicit dependencies; uuid4 is the identity factory interface's supported API.

ApprovalQueryService bounds inbox limits to 1..100, asks three independent visibility
modes, and returns nothing for stale membership or absent permissions. Its port enforces
exact actor/scope and live eligibility, with newest-first deterministic order.
Services are stateless. Shared host ports must respect their process and transaction
lifecycles. No persistence, credential, HTTP, session or protected-action adapter moves.

Archive smoke sentinels are test-only explicit host bindings outside src. They throw
on behavior invocation and cannot be installed by ConfigProvider. Package tests exercise
runtime behavior separately through explicit host spies and hostile or changed inputs.
