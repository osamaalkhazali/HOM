# HOM Platform Overview

House of Management (HOM) delivers a multi-tenant recruitment and consulting portal that connects internal administrators, client organizations, and job seekers. The platform combines consulting service presentation with a complete hiring pipeline and secure collaboration between HOM staff and client HR teams.

---

## Site Experience

### Public Website

-   Highlights HOM consulting services, core sectors, and differentiators.
-   Promotes featured insights, testimonials, and partner logos when provided.
-   Directs prospective talent to the job board and directs potential clients to contact HOM.

### Job Board

-   Public catalog of active job postings with search and filtering.
-   Job seekers can review role details, required documents, and apply online.
-   Application submission triggers confirmation emails and in-app notifications.

### Admin Portal

-   Bootstrap-driven admin center reachable at `/admin/login`.
-   Authentication is guard-specific for Super Admin, Admin, and Client HR roles.
-   Global navigation adapts to the signed-in role, reducing clutter and preventing accidental access.

---

## Core Roles and Responsibilities

### Super Admin (HOM Leadership)

-   Manage all clients, admins, and client HR accounts without restriction.
-   Create, update, or archive job postings for any client.
-   Manage employee records and their accompanying documents across every client.
-   Control global settings, including notification templates and site-wide messaging.
-   Activate or deactivate any admin account (`is_active` flag enforcement).
-   View full analytics dashboards spanning all clients, departments, and hiring funnels.
-   Receive every critical notification, including hires, document submissions, and role escalations.

### Admin (HOM Operations)

-   Oversee daily recruitment operations across all clients.
-   Maintain job postings, applications, employee records, and associated documents for every client.
-   Update application statuses, request documents, and finalize hires.
-   Manage standard admin accounts (excluding Super Admin records) and Client HR access.
-   Monitor client-level performance via dashboards and summary widgets.

### Client Owner (Client Leadership)

-   Optional role representing decision makers at client organizations.
-   Gains high-level visibility into their company’s openings, applications, and hires.
-   Approves additional Client HR users or requests role changes via HOM admins.
-   Cannot edit jobs or applications directly; designed for oversight and approvals.

### Client HR (Client Talent Partner)

-   Authentication uses the admin portal with scoped permissions.
-   Dashboard, analytics, and counts are limited to their assigned client.
-   Access read-only job listings for their organization, including drafts and archived roles for reference.
-   Manage applications tied to their client’s jobs:
    -   Update application statuses (shortlisted, interview scheduled, documents requested, hired, rejected, etc.).
    -   Add document requests, monitor submissions, and track candidate history.
    -   Convert hired applicants into employees automatically through the workflow.
-   Review and update employee profiles belonging to their client, including placement notes.
-   Receive real-time notifications and emails when:
    -   A job seeker applies to their client’s posting.
    -   An application reaches the `hired` status.
    -   Documents are submitted or requested updates are overdue.
-   Cannot:
    -   Create or modify job postings.
    -   Manage admin or Client HR accounts.
    -   Change system-wide settings.
    -   Access data belonging to other clients.
-   Super Admin and Admin roles share the same employee and document management capabilities but operate across all clients instead of a single tenant.

### Job Seeker (Talent)

-   Creates a profile, uploads resumes, and manages applications.
-   Receives emails when status updates occur or documents are requested.
-   Can withdraw applications or update documents before final decisions.

---

## Client Journey

1. **Engagement**: HOM leadership onboards a new client, creating an organization record and assigning dedicated Client HR contacts.
2. **Configuration**: Super Admin or Admin teams configure job categories, subcategories, and any custom requirements.
3. **Job Intake**: HOM Admin drafts job postings based on client requirements and publishes them to the job board.
4. **Recruitment**: Client HR collaborates with HOM Admins to review applicants, update statuses, and manage interviews.
5. **Hiring**: When an applicant is marked `hired`, the system creates an employee record and informs all stakeholders.
6. **Post-Hire Follow-Up**: Client HR can track employee details, onboarding notes, and future placement opportunities directly within the employee directory.

---

## Notification Ecosystem

-   **Application Submitted**: Sent to HOM Admins and relevant Client HR users.
-   **Status Updated**: Applicant receives updates for each transition; Client HR receives updates for their client.
-   **Documents Requested**: Applicant receives a request email; Client HR monitors outstanding items in the portal.
-   **Application Hired**: Applicant, assigned Client HR, and HOM Admin all receive notifications.
-   All notifications appear in the portal’s bell icon with read/unread tracking and digests.

---

## Security and Compliance

-   Admin accounts must verify their email before accessing the portal.
-   The `is_active` flag provides emergency suspension without deleting records.
-   Super Admin accounts are locked from modification by lower roles.
-   Client HR permissions are enforced both in UI and backend policies to maintain tenant isolation.
-   Sensitive information (documents, resumes, employee records) resides in protected storage with access logging through Laravel events.

---

## Future Enhancements (Roadmap)

-   Client-facing analytics exports for quarterly reviews.
-   Interview scheduling integrations with calendar providers.
-   Expanded document workflow with expiration reminders and compliance checklists.
-   White-label branding per client for the job board and candidate communications.

---

## Contact

For questions about the site experience, role definitions, or onboarding new clients, reach out to the HOM leadership or operations team through the internal communication channels.
