# Project AGENTS.md

## Scope
These instructions apply to the `client-rating-system-laravel` repository.

## Source of Truth
- Product scope, MVP features, architecture direction, and delivery milestones are defined in [Plan.md](/Users/vidit/htdocs/client-rating-system-laravel/Plan.md).
- When implementing features for this project, align decisions with `Plan.md` unless the user explicitly overrides requirements.

## Development Guidelines
- Keep changes minimal, focused, and easy to review.
- Prefer Laravel conventions and maintainable patterns over custom abstractions.
- Use Form Requests for validation.
- Keep controllers thin; move business logic to services/actions.
- Use named routes and route model binding where practical.
- Avoid unbounded queries: use pagination for list endpoints.
- Prevent N+1 issues via eager loading.

## Safety
- Do not run destructive commands without explicit user approval.
- Do not revert unrelated local changes.

## Testing
- Add or update tests for behavior changes when code is modified.
- For Laravel tests in this repo, follow global Laravel guidance (factories, `DatabaseTransactions`, named routes, and database assertions).
- If tests are skipped, explicitly state what was skipped and why.

## Notes for Future Work
- Treat Phase 1 items in `Plan.md` as priority.
- Place non-MVP enhancements into a backlog and avoid expanding scope during implementation without user confirmation.
