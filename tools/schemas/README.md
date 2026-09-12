# Package manifest schemas

These authoritative v1 capability and service-map schema snapshots come from
kumwe/app commit 24ecf956423c18933e824b43cea1bfb9127a79a9, under
`docs/architecture/governance/schemas`. The package gate executes their complete
keyword subset locally, verifies exported symbols, document links and actual
provider mappings, and checks the release record's manifest digests and headings.

The maintained `kumwe-package-release-record/v1` record is defined by the Extension SDK release verifier.
Core integration repeats consumer checks against its current schemas; package checks require no Core checkout.
Public API reflection remains the source of truth for exact signatures and source ownership.
