# Northstar Support Deflection MVP

A lightweight, self-service web dashboard that lets Northstar Retail Co.
customers instantly check **order status**, **return/refund status**,
**stock availability**, and browse a **searchable FAQ library** — without
opening a support ticket.

Built as a 5-day sprint MVP by a 4–5 person development pod, following a
structured Agile process with a Team Charter, task-tracked Project Board,
and a full commit/branch audit trail.

**🔗 Live demo:** https://northstar-support-mvp-3uy0.onrender.com

---

## Table of Contents
- [What this MVP does](#what-this-mvp-does)
- [Live Demo](#live-demo)
- [Tech Stack](#tech-stack)
- [Architecture Overview](#architecture-overview)
- [Project Structure](#project-structure)
- [Setup & Installation (local)](#setup--installation-local)
- [Environment Configuration](#environment-configuration)
- [Database](#database)
- [Running the App Locally](#running-the-app-locally)
- [Try It — Sample Data](#try-it--sample-data)
- [API Reference](#api-reference)
- [Testing](#testing)
- [Deployment](#deployment)
- [Git Workflow & Commit Conventions](#git-workflow--commit-conventions)
- [Task-to-Code Mapping](#task-to-code-mapping)
- [Audit Trail](#audit-trail)
- [Known Limitations](#known-limitations)
- [Team](#team)
- [Documentation Index](#documentation-index)

---

## What this MVP does

Customers can:
1. **Check order status** — enter an order number and instantly see whether
   it's processing, packed, shipped, delivered, or cancelled, plus an
   estimated delivery date.
2. **Check return & refund status** — enter an order number to see the
   current return status and refund status, or view general return
   instructions.
3. **Check stock availability** — enter a SKU and see every size/color
   variant, current stock quantity, or restock date if unavailable.
4. **Browse FAQs** — search and filter a self-service help library by
   category (delivery, returns, refunds, orders) without contacting
   support at all.

All four flows run through a validated JSON API backed by a real
database — no hardcoded or mocked responses.

## Live Demo

**https://northstar-support-mvp-3uy0.onrender.com**

No login required. Try the sample data below directly on the live site.

## Tech Stack

| Layer | Technology | Why |
|---|---|---|
| Frontend | Blade, Tailwind CSS, vanilla JS (`fetch`) | Fast to build, responsive by default, no build-pipeline dependency |
| Backend | PHP 8.2+ / Laravel 11–12 | Built-in migrations avoid manual database table creation; strong validation and ORM out of the box |
| Database | MySQL 8+ (local/production) / SQLite (public demo only) | Matches assignment spec; Eloquent uses parameter binding, protecting against SQL injection |
| Version Control | Git + GitHub | Branch-per-task workflow for a full auditable history |
| Hosting (demo) | Render (Docker) | Free public hosting for live, no-login demo access |
| Project Management | GitHub Projects / Trello board | Task tracking with owners, priorities, and Definitions of Done |

## Architecture Overview

Customer (Browser)
|
Frontend — Blade views + Tailwind + fetch()
|
Laravel Routes → Controllers (thin: validate + delegate only)
|
Service Layer — OrderLookupService, ReturnService, StockAvailabilityService, FaqService
|
Eloquent Models — Order, ReturnRequest, Product, Faq
|
Database (orders, returns, products, faqs tables — built via migrations)
|
JSON Response → rendered back into the dashboard


Controllers stay intentionally thin. All business logic lives in
`app/Services/`, which keeps the code testable and reusable independent of
the HTTP layer.

## Project Structure

northstar-support-mvp/
├── app/
│ ├── Http/Controllers/Api/
│ │ ├── OrderController.php
│ │ ├── ReturnController.php
│ │ ├── StockController.php
│ │ └── FaqController.php
│ ├── Services/
│ │ ├── OrderLookupService.php
│ │ ├── ReturnService.php
│ │ ├── StockAvailabilityService.php
│ │ └── FaqService.php
│ └── Models/
│ ├── Order.php
│ ├── ReturnRequest.php
│ ├── Product.php
│ └── Faq.php
├── database/
│ ├── migrations/
│ │ ├── ..._create_orders_table.php
│ │ ├── ..._create_returns_table.php
│ │ ├── ..._create_products_table.php
│ │ └── ..._create_faqs_table.php
│ └── seeders/
│ ├── SupportDataSeeder.php
│ ├── ProductStockSeeder.php
│ └── FaqSeeder.php
├── resources/views/dashboard/
│ └── index.blade.php
├── routes/
│ ├── api.php
│ └── web.php
├── tests/Feature/
│ ├── SupportApiTest.php
│ └── StockApiTest.php
├── Dockerfile (Render deployment only)
├── .env.example
├── .gitignore
└── README.md


## Setup & Installation (local)

```bash
git clone https://github.com/<your-username>/northstar-support-mvp.git
cd northstar-support-mvp
composer install
cp .env.example .env
php artisan key:generate
```

Requires: PHP 8.2+, Composer 2.x, MySQL 8+ (XAMPP works fine locally).

## Environment Configuration

Edit `.env` and make sure these lines are **uncommented** (no leading `#`)
and set correctly:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=northstar_support
DB_USERNAME=root
DB_PASSWORD=


> Also ensure `APP_NAME` is quoted if it contains a space, e.g.
> `APP_NAME="North Star Support"` — an unquoted value with whitespace
> causes `The environment file is invalid!` errors on any artisan command.

## Database

Create the database (no manual phpMyAdmin table creation required —
Laravel migrations build the schema):

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS northstar_support;"
php artisan migrate
```

Load fictional demo data:

```bash
php artisan db:seed --class=Database\\Seeders\\SupportDataSeeder
php artisan db:seed --class=Database\\Seeders\\ProductStockSeeder
php artisan db:seed --class=Database\\Seeders\\FaqSeeder
```

**Schema summary**

- `orders`: `id`, `order_number` (unique), `customer_name`, `status`, `estimated_delivery`, timestamps.
- `returns`: `id`, `order_number`, `return_status`, `refund_status`, `return_reason`, timestamps.
- `products`: `id`, `sku`, `product_name`, `size`, `color`, `stock_quantity`, `restock_date`, timestamps.
- `faqs`: `id`, `question`, `answer`, `category`, `active`, timestamps.

## Running the App Locally

```bash
php artisan serve
```
Visit **http://127.0.0.1:8000**

## Try It — Sample Data

| Order Number | Order Status | Return Status | Notes |
|---|---|---|---|
| ORD1001 | processing | — | no return requested |
| ORD1004 | delivered | requested / pending | wrong size |
| ORD1005 | cancelled | rejected / not_applicable | cancelled before shipping |
| ORD1007 | delivered | received / processed | damaged in transit |
| ORD1010 | delivered | in_transit / pending | changed mind |
| ORD1011 | delivered | — | no return row at all (tests default path) |
| ORD9999 | *(doesn't exist)* | — | tests 404 handling |
| abc123 | *(invalid format)* | — | tests 422 validation |

| SKU | Product | Notes |
|---|---|---|
| SKU1001 | Northstar Classic Tee | 4 sizes, mix of in/out of stock |
| SKU1002 | Northstar Running Shoes | 3 sizes, mix of in/out of stock |
| SKU1004 | Northstar Water Bottle | fully out of stock, has restock date |

FAQs are searchable by keyword and filterable by category (`delivery`, `returns`, `refunds`, `orders`) directly on the dashboard.

## API Reference

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api/orders/{order_number}` | Order status + delivery estimate |
| GET | `/api/returns/{order_number}` | Return + refund status |
| GET | `/api/returns-instructions` | Static return instructions |
| GET | `/api/stock/{sku}` | Stock levels across all size/color variants |
| GET | `/api/faqs?category=&search=` | List FAQs, optionally filtered |
| GET | `/api/faqs/{id}` | Single FAQ by id |

Full request/response contracts: see `docs/api-documentation.md` (added separately).

## Testing

```bash
php artisan test
```

Covers 16 scenarios across all four features — valid/invalid lookups,
empty input, malformed formats, default-value paths, and frontend/API
integration. Current result: **16 passed, 33 assertions**.

## Deployment

The live demo is deployed on **Render** using a `Dockerfile` (Render has
no native PHP runtime picker, only Docker or Node auto-detection).

Key points:
- The Docker build installs PHP 8.2, Composer, and `pdo_sqlite`.
- `.env` is generated at build time from the committed `.env.example`
  (the real `.env` is gitignored and never enters the container).
- DB settings are rewritten to SQLite **inside the container only** —
  `.env.example` itself stays MySQL-configured for local/production use.
- Migrations and all three seeders run automatically on every deploy.

See `docs/go-live-readiness.md` for the full production-readiness
checklist, including what changes would be needed for a real MySQL-backed
production deployment.

## Git Workflow & Commit Conventions

- Branch naming: `feature/<description>`, `fix/<description>`, `docs/<description>`
- Commit format: `<type>: <what changed> - <why it matters>`
  - Example: `feat: create order lookup API - enables automated order tracking`
- Forbidden commit messages: `wip`, `updates`, `changes`, `final`, `stuff`, `fixes`
- Every task's branch and commit reference its Task ID from the Project Board.

Full rules: see `docs/team-charter.md` (added separately).

## Task-to-Code Mapping

| Task ID | File(s) | Owner |
|---|---|---|
| TASK-01 | `database/migrations/..._create_orders_table.php` | Nigel (Database) |
| TASK-02 | `database/migrations/..._create_returns_table.php` | Nigel (Database) |
| TASK-03 | `database/seeders/SupportDataSeeder.php` | Nigel (Database) |
| TASK-04 | `app/Services/OrderLookupService.php` | Nigel (Backend) |
| TASK-05 | `app/Services/ReturnService.php` | Nigel (Backend) |
| TASK-06 | `app/Http/Controllers/Api/OrderController.php` | Nigel (Backend) |
| TASK-07 | `app/Http/Controllers/Api/ReturnController.php` | Nigel (Backend) |
| TASK-08 | `resources/views/dashboard/index.blade.php` (v1) | Sheryl (Frontend) |
| TASK-09 | `tests/Feature/SupportApiTest.php` | Nigel (Testing/QA) |
| TASK-16 | `database/migrations/..._create_products_table.php` | Nigel (Database) |
| TASK-17 | `app/Models/Product.php`, `database/seeders/ProductStockSeeder.php` | Nigel (Database) |
| TASK-18 | `app/Services/StockAvailabilityService.php` | Nigel (Backend) |
| TASK-19 | `app/Http/Controllers/Api/StockController.php` | Nigel (Backend) |
| TASK-20 | `resources/views/dashboard/index.blade.php` (stock section) | Sheryl (Frontend) |
| TASK-21 | `tests/Feature/StockApiTest.php` | Nigel (Testing/QA) |
| TASK-22 | `app/Models/Faq.php`, `Services/FaqService.php`, `Controllers/Api/FaqController.php`, `seeders/FaqSeeder.php`, dashboard redesign | Thando |
| TASK-24 | `Dockerfile` | Nigel (DevOps) |


## Known Limitations

- No customer authentication — order number/SKU alone grants lookup access.
- `returns.order_number` and `products.sku` are soft references, not
  formal foreign keys (deliberate simplification for the 5-day timeline).
- Public demo uses SQLite due to Render's free-tier constraints; local
  and intended production setup are MySQL, unchanged.

Full detail: see `docs/go-live-readiness.md`.

## Team

| Member | Role |
|---|---|
| Sheryl | Coordination + Frontend |
| Nigel | Backend/API |
| Nigel | Database |
| Nigel/Thando | Testing/QA + Documentation |
| Nigel | Integration/DevOps/QA |
| Thando | FAQ self-service feature |
