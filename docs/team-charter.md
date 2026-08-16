# Team Working Agreement — Northstar Sprint

## Team Roster
| Member | Role |
|---|---|
| Night-ryder254 (Nigel Matekwa) | Coordination + Backend/Database |
| sherilkerubo | Frontend/UI |
| Thando | FAQ feature (full-stack) |

## Communication Rules
- Primary channel: Whatsapp, Google Meet, response expected within 4 working hours.
- Decisions affecting scope or architecture are posted in-channel, not just discussed verbally.
- Daily async check-in: what was done, what's next, any blockers.

## Meeting / Check-in Expectations
- Day 1: Charter + Board workshop (mandatory, all members).
- Days 2–4: short daily standup (async or live).
- Day 4: mandatory checkpoint/audit review.
- Day 5: final demo rehearsal + submission review.

## Task Ownership
- Every board task has exactly one owner.
- Owner moves their own card and links their branch/commit.
- No task is picked up without being assigned on the board first.

## Deadlines
- Tasks are estimated at ≤4 hours each and expected to close within 1 working day of being picked up.
- Any task at risk of missing its estimate is flagged immediately, not silently carried over.

## Conflict Resolution
1. Direct resolution between the members involved.
2. If unresolved same-day, raised in the team channel for group input.
3. If still unresolved, escalated per the procedure below.

## Escalation Procedure
- Triggered by: missed deadlines without communication, zero visible activity for 2+ days, unresolved conflicts, or a blocker unsolved after one failed attempt.
- Step 1: raised in the team channel, tagging all members.
- Step 2: discussed at next standup; resolution owner + deadline assigned.
- Step 3: if unresolved, logged as a Day 4 checkpoint escalation item.

## Branch Naming Convention
`feature/<description>`, `fix/<description>`, `docs/<description>`, `test/<description>`.

## Commit Message Convention

<type>: <what changed> - <why it matters>

Allowed types: `feat`, `fix`, `docs`, `test`, `chore`, `style`.
Forbidden: `wip`, `updates`, `changes`, `final`, `stuff`, `fixes` with no context.

## Board Update Rules
- Board status updated the same day work is performed.
- Moving a card to Done requires a linked commit/PR and a passing test where applicable.

## Definition of Done (general)
1. The task's specific DoD is met.
2. Committed with a properly formatted message referencing the Task ID.
3. Does not break `php artisan test`.
4. Board card moved to Done same day.

## Signatures
| Member | Acknowledged |
|---|---|
| Nigel Matekwa (Night-ryder254) | Yes |
| sherilkerubo | Yes |
| Thando | Yes |
