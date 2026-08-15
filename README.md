# Northstar Support Deflection MVP

A lightweight, self-service web dashboard that lets Northstar Retail Co.
customers instantly check **order status** and **return/refund status**
without opening a support ticket — reducing repetitive manual ticket volume
for the customer support team.

Built as a 5-day sprint MVP by a 4–5 person development pod, following a
structured Agile process with a Team Charter, task-tracked Project Board,
and a full commit/branch audit trail.

---

## Table of Contents
- [What this MVP does](#what-this-mvp-does)
- [Tech Stack](#tech-stack)
- [Architecture Overview](#architecture-overview)
- [Project Structure](#project-structure)
- [Setup & Installation](#setup--installation)
- [Environment Configuration](#environment-configuration)
- [Database](#database)
- [Running the App](#running-the-app)
- [Try It — Sample Data](#try-it--sample-data)
- [API Reference](#api-reference)
- [Testing](#testing)
- [Git Workflow & Commit Conventions](#git-workflow--commit-conventions)
- [Task-to-Code Mapping](#task-to-code-mapping)
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
3. **Check stock availability** — enter an SKUnumber to see the
   current availability status of the item
   

all flows run through a validated JSON API backed by a real MySQL database
— no hardcoded or mocked responses.

## Tech Stack

| Layer | Technology | Why |
|---|---|---|
| Frontend | HTML, Bootstrap 5, vanilla JS (`fetch`) | Fast to build, responsive by default, no build-tooling overhead for a 5-day sprint |
| Backend | PHP 8.2+ / Laravel 11 | Built-in migrations avoid manual database table creation; strong validation and ORM out of the box |
| Database | MySQL 8+ | Matches assignment spec; Laravel's Eloquent ORM uses parameter binding, protecting against SQL injection |
| Version Control | Git + GitHub | Branch-per-task workflow for a full auditable history |
| Project Management | GitHub Projects / Trello board | Task tracking with owners, priorities, and Definitions of Done |

## Architecture Overview

Customer (Browser)
|
Frontend — Blade view + Bootstrap + fetch()
|
Laravel Routes → Controllers (thin: validate + delegate only)
|
Service Layer — OrderLookupService, ReturnService (business logic)
|
Eloquent Models — Order, ReturnRequest
|
MySQL Database (orders, returns,stock,faq tables — built via migrations)
|
JSON Response → rendered back into the dashboard


Controllers stay intentionally thin. All business logic lives in
`app/Services/`, which keeps the code testable and reusable independent of
the HTTP layer.

## Project Structure

northstar-support-mvp/ ├── app/ │ ├── Http/Controllers/Api/ │ │ ├── OrderController.php │ │ ├── ReturnController.php │ │ ├── StockController.php │ │ └── FaqController.php │ ├── Services/ │ │ ├── OrderLookupService.php │ │ ├── ReturnService.php │ │ └── FaqService.php │ └── Models/ │ ├── Order.php │ ├── ReturnRequest.php │ └── Faq.php ├── database/ │ ├── migrations/ │ │ ├── ..._create_orders_table.php │ │ ├── ..._create_returns_table.php │ │ ├── 2025_01_01_000003_create_products_table.php │ │ └── 2025_08_14_000001_create_faqs_table.php │ ├── factories/ │ │ └── FaqFactory.php │ └── seeders/ │ ├── SupportDataSeeder.php │ └── FaqSeeder.php ├── resources/views/dashboard/ │ └── index.blade.php ├── routes/ │ ├── api.php │ └── web.php ├── tests/Feature/ │ ├── SupportApiTest.php │ └── FaqTest.php ├── docs/ (added in a later step) ├── .env.example ├── .gitignore └── README.md
## Setup & Installation

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


> Also make sure `APP_NAME` is quoted if it contains a space, e.g.
> `APP_NAME="North Star Support"` — an unquoted value with whitespace will
> cause `The environment file is invalid!` errors on any artisan command.

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
```

**Schema summary**

`orders`: `id`, `order_number` (unique), `customer_name`, `status`
(processing / packed / shipped / delivered / cancelled),
`estimated_delivery`, timestamps.

`returns`: `id`, `order_number`, `return_status` (not_requested / requested
/ in_transit / received / rejected), `refund_status` (not_applicable /
pending / processed), `return_reason`, timestamps.
`faqs`: `id`, `question`, `answer`, `category `(returns / delivery / refunds / orders), active (boolean), timestamps.
`products`:`product_name`, `sku`, `variants array` of { size, color, in_stock, stock_quantity, restock_date }.

## Running the App

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

Stock: enter a SKU such as SKU1001 — see the stock seeder/factory for the full list of seeded SKUs once confirmed.

FAQs: 10 seeded via FaqSeeder, spread across four categories — delivery (3), returns (3), orders (3), refunds (1). Search by keyword (e.g. "refund", "cancel", "international") or filter by category in the dashboard.

## API Reference

### `GET /api/orders/{order_number}`
Returns order status and delivery estimate.
- `200` — order found, returns `{ success, data: { order_number, status, estimated_delivery } }`
- `404` — well-formed but unknown order number
- `422` — malformed order number (must match `ORD` + 4 or more digits)
- `500` — unexpected server/database error

### `GET /api/returns/{order_number}`
Returns return and refund status. If the order exists but has never had a
return requested, returns sane defaults (`not_requested` / `not_applicable`)
instead of a 404.

### `GET /api/returns-instructions`
Returns a static, ordered list of return steps. No parameters.

### `GET /api/stock/{sku}`

Returns stock variants for a SKU.

200 — returns { success, data: { product_name, sku, variants: [...] } }
404 — unknown SKU (assumed — confirm actual status code with StockController)

Full request/response examples: see `docs/api-documentation.md` (added
separately).

## Testing

```bash
php artisan test
```

Covers 10 required scenarios: valid/invalid order lookup, empty input,
malformed format, valid/invalid return lookup, no-return-row defaults,
instructions endpoint, frontend/API integration, and whitespace input
validation. All 10 currently pass (12/12 including default Laravel
examples, 24 assertions).

## Git Workflow & Commit Conventions

- Branch naming: `feature/<description>`, `fix/<description>`, `docs/<description>`
- Commit format: `<type>: <what changed> - <why it matters>`
  - Example: `feat: create order lookup API - enables automated order tracking`
- Forbidden commit messages: `wip`, `updates`, `changes`, `final`, `stuff`, `fixes`
- Every task's branch and commit reference its Task ID from the Project Board.

Full rules: see `docs/team-charter.md` (added separately).

## Task-to-Code Mapping

| Task ID | File(s) |
|---|---|---|
| TASK-01 | `database/migrations/..._create_orders_table.php` | 
| TASK-02 | `database/migrations/..._create_returns_table.php` |
| TASK-03 | `database/seeders/SupportDataSeeder.php` | 
| TASK-04 | `app/Services/OrderLookupService.php` | 
| TASK-05 | `app/Services/ReturnService.php` | 
| TASK-06 | `app/Http/Controllers/Api/OrderController.php` |
| TASK-07 | `app/Http/Controllers/Api/ReturnController.php` |
| TASK-08 | `resources/views/dashboard/index.blade.php` | 
| TASK-09 | `tests/Feature/SupportApiTest.php` |

## Known Limitations

- No customer authentication — order number alone grants lookup access.
- `returns.order_number` is a soft reference to `orders.order_number`, not
  a formal foreign key (deliberate simplification for the 5-day timeline).
- Stock availability (optional third category) was not built — priority
  was given to making order status and returns fully reliable first.
