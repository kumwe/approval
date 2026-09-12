# Core contract

Approval owns portable maker-checker bindings, state transitions, request/query values and transaction-bound
services. Core authenticates actors, issues trusted context, verifies step-up, builds current authority, authorizes
and executes the protected action, and supplies database, locking, replay, audit, notification and delivery adapters.

## Composition and lifetime

Core registers the `dependencies` returned by `Kumwe\Approval\ConfigProvider` in its composition root.
ApprovalService and ApprovalQueryService are shared stateless services. Each operation receives explicit context;
no actor, scope or authority is cached. The [integration guide](integration.md) lists all ten exact host bindings,
including repositories, membership/authorization, ownership, transactions, audit, clock and UUID generation.
Factories fail on wrong types; no default persistence, credential or authorization adapter exists.

## Transaction and authority boundary

Repository mutations, rule locks, ownership writes, proof consumption and audit append participate in the same
transaction. Exceptions roll back every effect. Core invokes approval `consume` immediately before the protected
mutation in the same outer transaction. Consuming an approval does not execute or authorize that action by itself.

The repository locks the active rule/eligibility state, counts distinct actors, rejects duplicate votes atomically,
and compare-and-sets expected request state/version. The package compares rule identity/version, checker capability,
quorum, distinctness and role. A changed rule or stale authority fails closed. Only the maker consumes an unchanged
binding. Expiry is exclusive, lifetime is at most seven days, and terminal requests cannot be replayed.

Query adapters enforce exact actor/scope visibility, live eligibility, deterministic newest-first ordering and
bounded results. Stale membership or absent permissions returns no items. Presentation snapshots never establish
authority. [Architecture](architecture.md) and [public API](public-api.md) define all transitions and signatures.

## Compatibility and test ownership

Runtime uses exact Context, Access Control, Audit and Transaction 0.1.2, plus PSR Clock/Container and Ramsey UUID.
Core selects compatible exact versions together and commits its lockfile. The [release record](release-record.md),
[source map](source-map.json) and [consumer inventory](consumer-inventory.json) preserve exact source baselines.
Reconcile those mappings against current Core code before replacing imports or duplicate implementation tests.

The package owns binding fields, separation checks, policy freshness, replay-port calls, expiry/state transitions,
query boundaries and factory wiring. Core retains actual database races, competing-approver contention, audit rollback,
step-up authority, ownership writes and protected-action integrations. Archive smoke sentinels are test-only bindings
outside production source and must never be installed as host implementations.

Independent release verification binds selected source, archives and dependencies. Hosted package CI and a local
clean consumer do not prove Core integration. Rollback restores Core's previously validated dependency/composition
tuple with its persisted approval compatibility checks.
