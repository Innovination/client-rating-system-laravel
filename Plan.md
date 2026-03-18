# Plan.md

## Project
Client Reputation & Dispute Sharing Portal for Agencies

## Goal
Build a Laravel-based, community-driven portal where verified agencies can report client disputes, rate clients, and share feedback so other agencies can make better engagement decisions.

## Phase 1 Scope (MVP)

### In Scope
- Agency registration with email verification
- Authentication (login/logout)
- Agency profile create/edit/view
- Client listing, creation, search by name
- Dispute reporting with category/tagging and supporting notes
- Client rating (1–5) and feedback submission
- Public client profile with aggregate rating and report list
- Basic admin panel for moderation and user suspension

### Out of Scope (Phase 1)
- File uploads/evidence attachments
- Advanced trust scores/fraud detection
- External verification integrations (KYC/CRM)
- Real-time chat/messaging
- Multi-language support
- Mobile apps

## Assumptions
- Laravel app is the primary backend and server-rendered UI or blade-driven admin can be used for MVP speed.
- One agency account can submit multiple reports/ratings.
- Public users can view only limited client data + reporting agency contact details as specified.
- Admin moderation is manual (no AI moderation in Phase 1).

## Functional Requirements Mapping

### 1. User Registration & Authentication
- Use Laravel auth + email verification (`MustVerifyEmail`).
- Registration fields: agency name, email, password, phone, company name, website (optional).
- User status: `active`, `suspended`.

Acceptance:
- Unverified users cannot submit disputes/ratings.
- Suspended users cannot log in or submit content.

### 2. Agency Profile Management
- Editable profile: legal/business name, contact person, phone, email, website, address, company info.
- Public visibility: contact details available for other agencies.

Acceptance:
- Agency can view and update their profile.
- Profile validations enforced via Form Requests.

### 3. Client Listing & Search
- Add client by name with optional identifiers (e.g., website, location, notes).
- Search by client name (partial match).
- Paginated list views only.

Acceptance:
- Search returns relevant client records with rating summary.
- Client detail page shows associated disputes + feedback.

### 4. Dispute Reporting
- Submit dispute linked to a client and reporting agency.
- Required fields: client, project category, dispute type, issue description.
- Optional: supporting notes.

Acceptance:
- Dispute is visible on client profile after submission.
- Admin can remove inappropriate disputes.

### 5. Ratings & Feedback
- Agency can rate client (1–5) and leave written feedback.
- Aggregate rating calculated per client.
- Restriction: one active rating per agency per client (update allowed).

Acceptance:
- Aggregate rating updates after create/update/delete moderation.
- Feedback list is visible publicly for each client.

### 6. Public Client Profile
- Show client name, overall rating, dispute/feedback entries, reporting agency contact details.
- No sensitive private data (internal notes, admin fields) exposed.

Acceptance:
- Anonymous visitor can view public client profile.
- Data shown matches moderation state.

### 7. Moderation & Admin Panel
- Admin authentication and role-based access.
- Admin actions:
  - Approve/review/remove disputes and feedback
  - Suspend/unsuspend agencies
  - Manage dispute categories

Acceptance:
- Non-admin users cannot access admin routes.
- Moderation actions are auditable (basic action logs).

## Non-Functional Requirements
- Security: CSRF protection, validation, output escaping, authorization policies.
- Performance: indexed search fields, eager loading to avoid N+1, pagination everywhere.
- Reliability: soft deletes where appropriate for recoverability.
- Observability: middleware-based request logging for admin-sensitive actions.
- UX: simple responsive layouts and clear empty/loading/error states.

## Proposed Data Model (Phase 1)

### Core Tables
- `users`
  - id, name, email, password, role (`agency`/`admin`), status (`active`/`suspended`), email_verified_at, timestamps
- `agency_profiles`
  - id, user_id, company_name, contact_person, phone, website, address, city, country, company_info, timestamps
- `clients`
  - id, name, website (nullable), location (nullable), created_by (user_id), timestamps, softDeletes
- `dispute_categories`
  - id, name, slug, is_active, timestamps
- `disputes`
  - id, client_id, agency_user_id, dispute_category_id, project_type, dispute_type, issue_description, supporting_notes (nullable), status (`visible`/`hidden`), moderated_by (nullable), moderated_at (nullable), timestamps, softDeletes
- `client_feedback`
  - id, client_id, agency_user_id, rating (1-5), feedback_text, status (`visible`/`hidden`), moderated_by (nullable), moderated_at (nullable), timestamps, softDeletes
- `admin_action_logs`
  - id, admin_user_id, action_type, target_type, target_id, metadata (json), timestamps

### Recommended Indexes
- `clients(name)`
- `disputes(client_id, status, created_at)`
- `client_feedback(client_id, status, created_at)`
- unique composite: `client_feedback(client_id, agency_user_id)`
- `users(role, status)`

## Application Architecture

### Layers
- Controllers: thin; delegate business logic.
- Form Requests: all validation.
- Services/Actions:
  - `ClientSearchService`
  - `DisputeSubmissionService`
  - `FeedbackService`
  - `ClientReputationService` (aggregate metrics)
  - `ModerationService`
- Policies/Gates:
  - Agency profile ownership
  - Dispute/feedback management
  - Admin-only moderation

### Routes (named)
- Auth + verification routes
- Agency routes (`auth`, `verified`):
  - profile edit/update
  - clients create/index/show/search
  - disputes store
  - feedback store/update
- Public routes:
  - clients index/search/show
- Admin routes (`auth`, `can:admin`):
  - moderation queue
  - disputes/feedback hide/restore/delete
  - users suspend/unsuspend
  - dispute categories CRUD

## Moderation Flow (MVP)
1. Agency submits dispute/feedback.
2. Content is visible by default (fast launch model) OR optionally flagged (config-driven).
3. Admin reviews reported content from moderation queue.
4. Admin can hide/remove and action is logged.

## Delivery Plan

### Sprint 1: Foundation (Week 1)
- Auth + email verification + roles/status
- Agency profile module
- DB migrations/models/factories for users/agencies/clients/categories
- Base policies and middleware

### Sprint 2: Core Reputation Features (Week 2)
- Client add/list/search/detail
- Dispute submission/listing
- Feedback + rating and aggregate computation
- Public client profile page

### Sprint 3: Admin & Hardening (Week 3)
- Admin panel and moderation actions
- User suspension flow
- Category management
- Audit logs + performance review (indexes, eager loading, pagination)
- UAT fixes and launch checklist

## Testing Strategy
- Feature tests for:
  - Auth, verification, suspension restrictions
  - Profile update validations
  - Client creation/search pagination
  - Dispute/feedback create + visibility
  - Aggregate rating correctness
  - Admin moderation and authorization boundaries
- Policy tests for admin/agency access control.
- Use factories and `DatabaseTransactions`.
- Persistence assertions with `assertDatabaseHas` / `assertDatabaseMissing`.

## Security & Compliance Checklist
- Enforce authorization on all write endpoints.
- Escape rendered feedback/dispute text to prevent XSS.
- Rate-limit submissions and search endpoints.
- Keep PII exposure minimal in public views.
- Log admin moderation activity.

## Risks & Mitigations
- Defamation/misuse risk:
  - Mitigation: clear terms, reporting mechanism, moderation controls, audit logs.
- Spam/low-quality submissions:
  - Mitigation: verified email, throttle limits, suspension tools.
- Data inconsistency in ratings:
  - Mitigation: unique rating constraint + transactional update path.
- Performance degradation on growth:
  - Mitigation: indexes, eager loading, pagination, cached aggregates (phase extension).

## Launch Checklist (MVP)
- Migrations and seeders deployed
- Admin user bootstrapped securely
- Email verification tested in production-like env
- Core feature tests passing
- Basic moderation SOP documented
- Backup and rollback plan defined

## Phase 2 Backlog (Post-MVP)
- Evidence attachments with secure storage
- Client verification badges
- Dispute resolution workflow/status tracking
- Notification system (email/in-app)
- Reputation scoring model and fraud signals
- API endpoints for integrations

## Definition of Done (Phase 1)
- All in-scope modules implemented with named routes, authorization, validation, and pagination.
- Admin moderation and suspension flows operational.
- Automated tests for critical user/admin journeys are green.
- Public client profile safely exposes only approved fields.
