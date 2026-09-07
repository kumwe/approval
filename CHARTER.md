# Approval package charter

Own generic approval binding/rule/request/status/view types, repository and query
ports, maker-checker separation and bounded approval services under Kumwe\Approval.

The host supplies trusted execution context, credentials and step-up authentication,
live membership and policy authority, persistence/locking, transaction connection,
audit durability, notifications and protected-action execution. A successful approval
is tied to the requester, exact action/resource/version/payload, current authority
fingerprint and expiry. It is never a transferable permission token.

The step-up consumer is an inward-facing replay-fence port; its concrete credential
and persistence implementation remains in the host. MembershipDirectory belongs to
Kumwe\Access and is not redefined here. Host-delivery code and ERP-specific workflows
are excluded. App adoption waits for all immutable dependency releases to be verified.
