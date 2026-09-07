# Changelog

## 0.1.1

- Validate approval projections, vote identity/uniqueness, quorum bounds, scope parents and expiry. Reject invalid UTF-8 and control characters in notes before replay or persistence side effects. Preserve the solvable published dependency graph.
- Refresh extraction handoff and library-owned validation evidence; App adoption remains a separate task.

## 0.1.0

- Extract portable approval contracts, values and services from App.
- Complete explicit container wiring and package-owned behavior/boundary coverage.
- Use published Access Control 0.1.0 and Audit 0.1.0 with stable dependency resolution.
- Publish after the human rebase merge passes the complete package and dependency gates.
