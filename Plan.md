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

## 4. Advanced Features (Future Scope / Phase 2+)

### 4.1 Agency Verification System
- Verified badges for trusted agencies.
- Manual and/or document-backed verification workflow.
- Verification state tracked in agency profile and surfaced in public views.

### 4.2 Dispute Evidence Upload
- Secure evidence uploads (contracts, invoices, screenshots).
- File type/size validation and malware scanning integration point.
- Access control for sensitive evidence (role and policy guarded).

### 4.3 Client Identity Disambiguation
- Duplicate detection heuristics for similar client names/identifiers.
- Admin-supported merge flow for duplicate client profiles.
- Audit trail for merge actions.

### 4.4 Reputation Scoring Algorithm
- Weighted score model combining:
  - Number of reviews
  - Credibility/verification level of reporting agencies
  - Recency of feedback/disputes
- Keep raw average rating visible alongside weighted score for transparency.

### 4.5 Dispute Resolution Workflow
- Allow agency and client-side response threads per dispute.
- Status lifecycle support: `open`, `resolved`, `disputed`.
- Timeline view for dispute progression.

### 4.6 Privacy & Visibility Controls
- Optional agency anonymization for public dispute entries.
- Visibility tiers for sensitive reports (public/agency-only/admin-only).
- Policy-driven masking of contact details based on visibility.

### 4.7 Notifications System
- Trigger alerts for:
  - New reviews on followed clients
  - Responses to disputes
  - Platform updates/moderation outcomes
- Deliver via email first; in-app notifications can follow.

### 4.8 API Access
- Authenticated API for third-party integrations.
- Scoped tokens/permissions for agency tools integration.
- Rate limiting, API audit logs, and versioned endpoints.

### 4.9 Mobile Application
- Cross-platform mobile app (e.g., React Native or Flutter).
- Core flows: search client, post dispute, post feedback, receive alerts.
- Role-based access parity with web features.

### 4.10 Community Features
- Agency discussion threads/forums.
- Upvote/downvote feedback usefulness.
- Commenting on reports with moderation controls.

## 5. Roles & Responsibilities

### Platform Owner
- Define platform policies and moderation rules.
- Manage admin operations and moderation quality.
- Ensure legal, compliance, and ethical governance.

### Agencies (Users)
- Submit accurate and truthful dispute/feedback data.
- Use the platform responsibly and follow policy.
- Engage constructively with other agencies/community.

## 6. Key Workflows

### 6.1 Posting a Dispute
1. Agency logs in.
2. Agency searches for an existing client or adds a new client.
3. Agency submits dispute details.
4. System publishes entry (subject to moderation policy/configuration).

### 6.2 Checking a Client
1. Agency searches by client name.
2. Agency reviews rating, disputes, and feedback.
3. Agency contacts the reporting agency if needed.

## 7. Acceptance Criteria
- Agencies can register and log in successfully.
- Users can add and search clients.
- Disputes and feedback can be submitted and displayed.
- Ratings are calculated and visible.
- Admin can moderate content effectively.
- Platform maintains basic performance and usability standards.

## Definition of Done (Phase 1)
- All in-scope modules implemented with named routes, authorization, validation, and pagination.
- Admin moderation and suspension flows operational.
- Automated tests for critical user/admin journeys are green.
- Public client profile safely exposes only approved fields.
