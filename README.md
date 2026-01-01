# Fansclub Esport Platform

A digital platform for an e-sports fan club that manages paid membership applications, QR-based membership verification,
and content management for news and merchandise. The system is designed with a clear separation between public pages,
member-only features, and a secured admin dashboard.

---

## Project Summary

This project is an end-to-end membership management system for an e-sports fan club. It covers public content delivery,
structured member onboarding with payment proof validation, QR-based identity verification, and an isolated admin panel
with immutable audit logs.

The repository serves as an engineering case study and production-grade Laravel application, not as an academic or
peer-reviewed research paper.

---

## Key Features

* **Public**

    * Dynamic landing page driven by the `settings` table
    * News listing and detail pages
    * Merchandise catalog with external shop links

* **Member**

    * Membership application with payment proof upload
    * Automated email notification for pending applications
    * Magic link for password setup and reset
    * Approved-only profile access
    * Profile updates with photo upload
    * QR-based membership verification accessible by anyone

* **Admin**

    * Dedicated authentication guard (`admin`)
    * Dashboard with basic metrics
    * Review workflow to approve or reject applicants
    * Automated approval/rejection emails with magic links
    * CRUD modules for news and merchandise
    * Fan club settings management (logo, banner, branding)
    * Immutable admin activity logs

---

## Tech Stack

* **Backend**: PHP 8.2+ / Laravel 12
* **Database**: MySQL 8.0 / MariaDB
* **Frontend**: Blade templates + Vite (Node.js & npm)
* **DevOps**: Docker Compose, Makefile
* **Tooling**: Composer, PHPUnit/Pest, Laravel Pint, phpMyAdmin
* **Libraries**: `endroid/qr-code` for QR code generation

---

## Local Setup

### Prerequisites

* PHP 8.2 with standard Laravel extensions (BCMath, Ctype, Fileinfo, Mbstring, OpenSSL, PDO, Tokenizer, XML)
* Composer 2.x
* Node.js & npm (Node v24.9.0, npm v11.6.0)
* Docker & Docker Compose
* MySQL/MariaDB (or containerized via Docker)
* Local SMTP service (e.g., Mailhog) or valid SMTP credentials

---

## Installation

### Quick Installation (Docker + Makefile)

Before running the command below, ensure the `.env` file is prepared and properly configured.

```bash
make copy
make install
```

---

### Manual Setup (Step-by-Step)

#### 1. Clone the Repository

Fetch the source code first.

```bash
git clone git@github.com:zygmacore/e-sport.git
cd e-sport
```

---

#### 2. Prepare Environment Configuration

Prepare the environment file before starting any services so Docker containers can read the correct configuration.

```bash
cp .env.example .env
```

Edit the `.env` file according to your local setup:

```env
APP_NAME="Fansclub Esport"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.your_host.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Fansclub Esport"
```

---

#### 3. Start Docker Containers

Start all required services (Laravel, MySQL, etc.).

```bash
docker compose up -d
```

Verify that all containers are running correctly:

```bash
docker compose ps
```

---

#### 4. Enter the Laravel Container

All following commands should be executed inside the Laravel container.

```bash
docker exec -it laravel_app bash
```

---

#### 5. Install Backend & Frontend Dependencies

Install project dependencies after the container is running.

```bash
composer install
npm install
```

Generate the application key:

```bash
php artisan key:generate
```

---

#### 6. Database Migration & Seeding

Prepare the database schema and seed initial data.

```bash
php artisan migrate
php artisan db:seed --class=SettingsSeeder
```

---

#### 7. Build Frontend Assets

For development:

```bash
npm run dev
```

For a production build:

```bash
npm run build
```

---

#### 8. Run the Application Server

Expose the application so it can be accessed from the host machine.

```bash
php artisan serve --host=0.0.0.0
```

The application will be available at:

```
http://localhost:8000
```

---

#### 9. Create Admin User (Manual)

Create an admin account manually using Tinker.

```bash
php artisan tinker

\App\Models\User::updateOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'Admin Demo',
        'password' => bcrypt('secret'),
        'role' => 'admin',
        'status' => 'active',
    ]
);
```

Admin login:

```
/admin/login
Email: admin@example.com
Password: secret
```

## Additional Commands

**Restart containers**

```bash
docker compose down && docker compose up -d
```

**Access MySQL container**

```bash
docker exec -it mysql_laravel mysql -u root -p
```

---

## Project Structure Overview

* `app/Http/Controllers/Frontend/*` – public and member-facing flows, authentication, QR verification.
* `app/Http/Controllers/Admin/*` – dashboard, application review, news, merchandise, settings, and activity logs.
* `app/Mail/*` – mailables for pending, approved, rejected, and password reset notifications.
* `app/Helpers/AdminLogger.php` – immutable audit logging utility.
* `app/Models/*` – core database models (`User`, `MemberProfile`, `MembershipHistory`, `News`, `Merchandise`, `Setting`,
  `AdminActivityLog`).
* `resources/views/frontend` & `resources/views/admin` – Blade templates separated by domain.
* `resources/views/emails` – email templates.
* `database/migrations` & `database/factories` – schema definitions and factories.
* `routes/web.php` – unified routing for public, member, and admin namespaces.

---

## Documentation

* [Technical Whitepaper](https://zenodo.org/records/18073923)

---

## Notes

This repository documents a real-world engineering project and system design case study. It is intended as a reproducible and auditable reference for Laravel-based application development, not as an academic publication.

## License

This project is licensed under the MIT License. See the [LICENCE](https://github.com/ZygmaCore/e-sport/blob/main/LICENSE) file for full details.
