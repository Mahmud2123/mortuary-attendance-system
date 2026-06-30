# Online Mortuary Attendance Management System

A complete Laravel-based web application for digitising mortuary operations: body admission, cold storage chamber tracking, next-of-kin management, staff attendance, body release processing, dashboard analytics, and report generation.

## Tech Stack

- **Backend:** PHP 8.1+, Laravel 10.x
- **Database:** MySQL 8.0+ (or PostgreSQL 14+)
- **Frontend:** Bootstrap 5, Blade templates, Chart.js, DataTables
- **PDF:** barryvdh/laravel-dompdf

## Roles

| Role | Capabilities |
|---|---|
| **Admin** | Full CRUD on everything, staff management, audit logs, releases |
| **Attendant** | Admit bodies, manage chambers/kins, clock in/out |
| **Management** | Read-only dashboard, attendance reports, exports |

---

## 1. Installation (XAMPP / Local LAMP)

### Step 1 — Prerequisites
Install:
- [XAMPP](https://www.apachefriends.org/) (PHP 8.1+, MySQL)
- [Composer](https://getcomposer.org/)

Verify versions:
```bash
php -v
composer -v
```

### Step 2 — Place the Project
Copy the entire `mortuary` folder into your XAMPP `htdocs` directory:
```
C:\xampp\htdocs\mortuary       (Windows)
/Applications/XAMPP/htdocs/mortuary  (Mac)
/opt/lampp/htdocs/mortuary     (Linux)
```

### Step 3 — Install Dependencies
Open a terminal inside the project folder and run:
```bash
composer install
```

This downloads Laravel framework, Breeze, and laravel-dompdf — all listed in `composer.json`.

### Step 4 — Environment Setup
```bash
copy .env.example .env        # Windows
cp .env.example .env          # Mac/Linux

php artisan key:generate
```

Open `.env` and confirm your database credentials match your MySQL setup (defaults work for stock XAMPP):
```
DB_DATABASE=mortuary_ams
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5 — Create the Database
Open phpMyAdmin (`http://localhost/phpmyadmin`) and create a new database named:
```
mortuary_ams
```

### Step 6 — Run Migrations & Seed Data
```bash
php artisan migrate --seed
```

This creates all 8 tables and populates them with realistic test data (6 users, 5 chambers, 15 bodies, next-of-kin records, attendance logs, and 2 sample releases).

### Step 7 — Serve the App
**Option A (Artisan dev server — easiest):**
```bash
php artisan serve
```
Visit: `http://127.0.0.1:8000`

**Option B (Apache via XAMPP):**
Point your browser to `http://localhost/mortuary/public`

> If using Apache, make sure `mod_rewrite` is enabled (it is by default in XAMPP) so Laravel's pretty URLs work.

---

## 2. Demo Login Accounts

All seeded accounts use the password: **`password`**

| Role | Email | Staff ID |
|---|---|---|
| Admin | admin@mortuary.ng | ADMIN001 |
| Attendant | fatima@mortuary.ng | ATT001 |
| Attendant | ibrahim@mortuary.ng | ATT002 |
| Attendant | aisha@mortuary.ng | ATT003 |
| Management | mgmt@mortuary.ng | MGT001 |
| Management | ngozi@mortuary.ng | MGT002 |

---

## 3. Seeded Test Data

- **5 Chambers** (A–E) with varying capacities and statuses (available/full/maintenance)
- **6 Staff Users** across all 3 roles
- **15 Body Records** — 11 in storage, 2 admitted (unassigned), 2 already released
- **15 Next-of-Kin Records** linked to each body
- **7 Attendance Logs** (including one staff member currently clocked in)
- **2 Body Release Records** with certificates

---

## 4. Project Structure

```
mortuary/
├── app/
│   ├── Http/
│   │   ├── Controllers/      (8 controllers — Auth, Dashboard, Body, Chamber, Attendance, Release, Report, User, AuditLog)
│   │   └── Middleware/       (RoleMiddleware for RBAC)
│   └── Models/                (User, Body, Chamber, NextOfKin, AttendanceLog, BodyRelease, BodyChamberAssignment, AuditLog)
├── bootstrap/app.php          (Laravel 10 bootstrap + middleware registration)
├── database/
│   ├── migrations/             (4 migration files covering all 8 tables)
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── layouts/                (app.blade.php with sidebar, guest.blade.php for auth)
│   ├── auth/login.blade.php
│   ├── dashboard/index.blade.php
│   ├── bodies/                 (index, create, edit, show)
│   ├── chambers/                (index, create, edit, show)
│   ├── attendance/index.blade.php
│   ├── releases/                (index, create [3-step wizard], certificate, certificate-pdf)
│   ├── reports/                 (index + 4 PDF templates)
│   ├── users/                   (index, create, edit)
│   └── audit/index.blade.php
├── routes/web.php
├── public/css/app.css, public/js/app.js
├── composer.json
└── .env.example
```

---

## 5. Feature Walkthrough / Testing Guide

### A. Authentication
1. Visit the app — you're redirected to `/login`.
2. Log in as `admin@mortuary.ng` / `password`.
3. Try logging in with wrong credentials — confirm error message appears.

### B. Dashboard
- Confirm stat cards show correct counts (total bodies, in storage, admitted/released today, staff on duty).
- Confirm the 30-day admissions/releases line chart renders.
- Confirm the status distribution doughnut chart renders.
- Click a chamber box in the grid — should navigate to that chamber's detail page.

### C. Body Management
1. Go to **Bodies** → click **New Admission**.
2. Fill the form, optionally assign a chamber, submit.
3. Confirm a unique ref number like `MTR-2026-0016` was generated.
4. Confirm chamber occupancy incremented and status flips to "full" when capacity is reached.
5. Open a body's detail page → add a **Next of Kin** via the modal.
6. Edit the body record, change its status, save.
7. As Admin, delete a body record (soft delete) — confirm it's removed from the list.

### D. Chamber Management
1. Go to **Chambers** — confirm color coding (green=available, red=full, yellow=maintenance).
2. As Admin, create a new chamber.
3. Try deleting a chamber with bodies in it — confirm it's blocked.

### E. Attendance
1. Log in as `fatima@mortuary.ng`.
2. Go to **Attendance** → click **Clock In**. Confirm timestamp appears and button disables.
3. Click **Clock Out** → confirm duration is calculated automatically.
4. Log in as Admin/Management → confirm you can filter attendance by staff member and date range.

### F. Body Release (3-step wizard)
1. Go to **Releases** → **Process New Release**.
2. **Step 1:** select a body that has next-of-kin recorded.
3. **Step 2:** select the verified next of kin (radio button).
4. **Step 3:** check the confirmation box, submit.
5. Confirm: body status → `released`, chamber occupancy decremented, certificate generated.
6. View the certificate, then download it as a PDF.

### G. Reports
1. Go to **Reports**.
2. Generate an Admissions PDF report with a date filter — confirm it downloads.
3. Generate the same report as CSV — confirm it opens in Excel/Sheets correctly.
4. Repeat for Attendance, Chambers, and Releases reports.

### H. Role-Based Access
1. Log in as `mgmt@mortuary.ng` (Management).
2. Confirm there's no "New Admission" or "New Chamber" button (read-only).
3. Try directly visiting `/users` — confirm a 403 Forbidden error (Admin-only route).

### I. Audit Trail
1. Log in as Admin → go to **Audit Logs**.
2. Confirm create/update/delete actions on bodies, chambers, and users are all logged with before/after JSON snapshots.

---

## 6. Security Features Implemented

- **CSRF protection** on every form (`@csrf` directive)
- **Password hashing** via Laravel's `Hash::make()` / bcrypt
- **Role-based middleware** (`role:admin`) restricting sensitive routes
- **Mass-assignment protection** via `$fillable` on every model
- **SQL injection protection** via Eloquent ORM / query builder (no raw queries)
- **Soft deletes** on the `bodies` table for recoverability
- **Database transactions** wrapping multi-step operations (admission with chamber assignment, release processing)
- **Audit logging** of all create/update/delete actions with IP address and before/after state

---

## 7. Deployment Notes (Shared Hosting)

1. Upload all files **except** `public/` to a directory outside the public web root (e.g. `mortuary_app/`).
2. Upload the contents of `public/` to your `public_html/` (or equivalent) directory.
3. Edit `public/index.php` to point to the relocated `vendor/autoload.php` and `bootstrap/app.php` paths.
4. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
5. Run `php artisan config:cache` and `php artisan route:cache` for performance.
6. Ensure `storage/` and `bootstrap/cache/` are writable (`chmod -R 775`).

---

## 8. Troubleshooting

| Issue | Fix |
|---|---|
| "could not find driver" | Enable `pdo_mysql` in `php.ini` |
| 419 Page Expired on forms | Run `php artisan config:clear` and confirm cookies aren't blocked |
| Blank/white screen | Set `APP_DEBUG=true` temporarily and check `storage/logs/laravel.log` |
| Styles not loading | Confirm you're accessing via `/public` or that `php artisan serve` is used |
| Migration errors | Drop and recreate the database, then re-run `php artisan migrate --seed` |
