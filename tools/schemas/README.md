# Package manifest schemas

These authoritative v1 capability and service-map schema snapshots come from
kumwe/app commit 24ecf956423c18933e824b43cea1bfb9127a79a9, under
`docs/architecture/governance/schemas`. The package gate executes their complete
keyword subset locally, verifies exported symbols, document links and actual
provider mappings, and freezes the reviewed handoff manifest digests/headings.

The full handoff was separately accepted by the read-only App v2 package parser
at that baseline. App adoption repeats that consumer check against its current
schemas; package checks require no App checkout. Public API reflection remains
the source of truth for exact signatures and source ownership.
