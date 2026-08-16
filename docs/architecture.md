# Architecture — Northstar Support Deflection MVP

## Flow

Customer (Browser)
|
Frontend — Blade + Tailwind + fetch()
|
Laravel Routes -> Controllers (validate + delegate only)
|
Service Layer (OrderLookupService, ReturnService, StockAvailabilityService, FaqService)
|
Eloquent Models (Order, ReturnRequest, Product, Faq)
|
Database (MySQL locally/production, SQLite on the Render demo)
|
JSON response -> rendered in dashboard


## Why this structure
- Controllers stay thin — validation + delegation only.
- Business logic isolated in `app/Services/`, independently testable.
- Eloquent + parameter binding protects every query from SQL injection.

## Known trade-offs
- `returns.order_number` and `products.sku` are soft references, not formal foreign keys — deliberate simplification for the 5-day timeline.
- No authentication layer — order number/SKU alone grants lookup access, acceptable for an MVP proof of concept.
