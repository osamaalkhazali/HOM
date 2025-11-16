HOM Platform
==========

Modern multi-client recruitment and consulting portal for **House of Management (HOM)**. The platform delivers a unified experience for super administrators, in-house admins, client HR teams, and job seekers. Recent work focused on multi-client isolation, richer admin tooling, secure authentication, and a streamlined Client HR workflow.

---

## Table of Contents

- [Key Capabilities](#key-capabilities)
- [Role Overview](#role-overview)
- [Application Workflows](#application-workflows)
- [Getting Started](#getting-started)
- [Environment Configuration](#environment-configuration)
- [Running the Stack](#running-the-stack)
- [Seeded Accounts](#seeded-accounts)
- [Client HR Experience](#client-hr-experience)
- [Administration Notes](#administration-notes)
- [Troubleshooting](#troubleshooting)

---

## Key Capabilities

- **Multi-Client Architecture** – Jobs, applications, employees, and notifications stay isolated per client.
- **Role-Based Administration** – Three guard-driven roles (Super Admin, Admin, Client HR) with tailored permissions and dashboards.
- **Admin Authentication Suite**
    - Custom Bootstrap login theme with password visibility toggles
    - Password reset flow dedicated to admins (separate broker, branded emails)
    - Email verification enforced for every admin account
    - Profile editor with phone support; email changes trigger re-verification and auto logout
- **Notification System**
    - Application status changes fire database + mail notifications
    - Client HR is notified when an applicant is hired for their client
- **Application Lifecycle Enhancements**
    - Document request builder with dynamic rows
    - Automatic employee record creation when status becomes `hired`
    - Status change safety prompts for `hired` and `rejected`
- **Data Visibility Improvements**
    - Distinct employee counts in sidebar
    - Client-filtered dashboards for Client HR users
    - Horizontal scrolling tables where needed (employees, clients)
- **Security Controls**
    - `is_active` flag for admins; inactive accounts are blocked even if email is verified
    - Super admin accounts are protected from edit/delete/status changes by other admins

---

## Role Overview

| Capability | Super Admin | Admin | Client HR |
|-----------|-------------|-------|-----------|
| Access all clients & data | ✅ | ✅ | ❌ (own client only) |
| Manage admins | ✅ | ✅ | ❌ |
| Create / edit / delete jobs | ✅ | ✅ | ❌ (read-only) |
| View applications | ✅ | ✅ | ✅ (filtered) |
| Change application status | ✅ | ✅ | ✅ (own client) |
| Receive hire notifications | ✅ | ✅ | ✅ (if tied to client) |
| View employee directory | ✅ | ✅ | ✅ (filtered) |
| Edit platform settings | ✅ | ❌ | ❌ |
| Access analytics dashboard | ✅ | ✅ | ✅ (client scope) |

---

## Application Workflows

### Hiring Flow
1. Admin updates application status in `Admin ▸ Applications`.
2. Status change confirmation prevents accidental `hired` / `rejected` transitions.
3. When status becomes `hired`:
     - Employee record is generated automatically (if missing).
     - Candidate receives email + in-app notification.
     - Matching Client HR user receives the same notification + email.

### Document Requests
- Add requested documents directly from the application edit view.
- `Documents Requested` status is applied automatically when new requests are added.
- Document upload / status progression is reflected in the timeline.

---

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer 2+
- Node.js 18+
- MySQL 8+ (or compatible)
- SMTP credentials for outbound email

### Installation
```bash
git clone https://github.com/osamaalkhazali/HOM.git
cd HOM

composer install
npm install

copy .env.example .env
php artisan key:generate
```

Run migrations with sample data:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

Compile assets (choose one):

```bash
npm run dev
npm run build
```

Start the application:

```bash
php artisan serve
```

Default URL: `http://hom.test` (adjust if your `.env` differs).

---

## Environment Configuration

Minimal settings to update in `.env`:

```env
APP_NAME="HOM"
APP_URL=http://hom.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hom
DB_USERNAME=hom_user
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=no-reply@hom.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@hom.com
MAIL_FROM_NAME="HOM"
```

> Admin email verification and password resets depend on working SMTP credentials.

---

## Running the Stack

| Task | Command |
|------|---------|
| Serve backend | `php artisan serve` |
| Watch assets | `npm run dev` |
| Run tests | `php artisan test` |
| Clear caches | `php artisan optimize:clear` |
| Reset database | `php artisan migrate:fresh --seed` |

---

## Seeded Accounts

After `migrate:fresh --seed` the following accounts are available:

| Role | Email | Password | Notes |
|------|-------|----------|-------|
| Super Admin | `admin@jobportal.com` | `password123` | Full system access |
| Super Admin | `hr@hom-intl.com` | `password` | Legacy seeded admin |
| Admin | `admin@hom-intl.com` | `password` | General administrator |
| Client HR (Bromine Jo) | `hr@bromineje.com` | `password` | Filtered to Bromine Jo data |
| Client HR (TechVision) | `hr@techvision.com` | `password` | Filtered to TechVision data |
| Job Seeker samples | `*.example.com` | `password` | See seeder output |

All seeded admin accounts are active and email-verified.

---

## Client HR Experience

Client HR users log in through the admin portal but see a scoped experience:

- Dashboard metrics and charts limited to their assigned client.
- Read-only access to their organization's job postings (no create/edit/delete).
- Full application workflow control for their client’s jobs, including status changes and document requests.
- Employee directory filtered to hires belonging to their client.
- Real-time notifications + emails when applicants move to `hired`.
- Navigation stripped of super admin features; restricted routes return 403.

> Client HR cannot manage admins, clients, or global settings. Contact an Admin if scope changes are required.

---

## Administration Notes

- Email verification is required. Profile email changes clear the verification timestamp, dispatch a new email, and log the admin out until confirmed.
- `is_active` toggle is exposed in admin management. Inactive admins cannot authenticate even if verified.
- Super admin records cannot be edited, deactivated, or deleted by other admins.
- Use the notification bell in the admin navbar to access unread items. "Mark all as read" and "View all" links are available.
- Document requests are allowed only in `shortlisted`, `documents_requested`, and `documents_submitted` statuses; the UI explains restrictions when disabled.

---

## Troubleshooting

| Issue | Resolution |
|-------|------------|
| Email reset/verification not received | Confirm SMTP settings, check mail logs, and ensure the queue worker (if used) is running. |
| Admin login blocked | Verify `admins.is_active = 1` and `email_verified_at` is populated. Use `php artisan tinker` to inspect. |
| "Route page not found" for admin features | Clear cached routes: `php artisan route:clear`. |
| Missing uploads or broken images | Ensure `storage:link` has been executed and the web server has write access to `storage/app/public`. |
| Seed data absent | Run `php artisan migrate:fresh --seed` to rebuild the sample dataset. |

---

Need additional help? Open an issue in the repository or contact the HOM engineering team.
