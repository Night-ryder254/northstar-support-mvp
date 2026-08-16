# Project Board — Northstar Sprint

| Task ID | Description | Owner | Priority | Status | Definition of Done | Effort | Branch |
|---|---|---|---|---|---|---|---|
| TASK-01 | Orders table migration | Nigel Matekwa (Night-ryder254) | High | Done | Migration creates orders table, runs without error | 1h | feature/db-orders-migration |
| TASK-02 | Returns table migration |  Nigel Matekwa (Night-ryder254) | High | Done | Migration creates returns table, runs without error | 1h | feature/db-returns-migration |
| TASK-03 | Seed fictional order/return data |  Nigel Matekwa (Night-ryder254) | High | Done | 10+ orders + returns seeded, verified via db:seed | 2h | feature/db-seeder |
| TASK-04 | OrderLookupService | Nigel Matekwa (Night-ryder254) | High | Done | Returns order for valid number, null for unknown | 2h | feature/business-logic-services |
| TASK-05 | ReturnService |  Nigel Matekwa (Night-ryder254) | High | Done | Returns status or "not requested" default | 2h | feature/business-logic-services |
| TASK-06 | Order API endpoint |  Nigel Matekwa (Night-ryder254) | High | Done | 200/404/422 correctly returned | 3h | feature/order-api-endpoint |
| TASK-07 | Return API endpoint |  Nigel Matekwa (Night-ryder254) | High | Done | 200/404/422 correctly returned | 3h | feature/return-api-endpoint |
| TASK-08 | Dashboard UI (v1) | Nigel Matekwa (Night-ryder254) | High | Done | Order + return lookup working, no reload | 4h | feature/dashboard-ui |
| TASK-09 | Feature test suite (orders/returns) |  Nigel Matekwa (Night-ryder254) | High | Done | 10 scenarios passing via artisan test | 3h | (root commit) |
| TASK-11 | .env.example |  Nigel Matekwa (Night-ryder254) | Medium | Done | Teammate can configure local env from file | 1h | (root commit) |
| TASK-13 | README |  Nigel Matekwa (Night-ryder254) | Medium | Done | Setup, architecture, API, testing documented | 3h | (root commit) |
| TASK-16 | Products table migration |  Nigel Matekwa (Night-ryder254) | High | Done | products table created, runs without error | 1h | (root commit) |
| TASK-17 | Product model + stock seeder |  Nigel Matekwa (Night-ryder254) | High | Done | 10+ variants seeded incl. out-of-stock | 2h | (root commit) |
| TASK-18 | StockAvailabilityService |  Nigel Matekwa (Night-ryder254) | High | Done | Returns variants for SKU or null | 2h | (root commit) |
| TASK-19 | Stock API endpoint |  Nigel Matekwa (Night-ryder254) | High | Done | 200/404/422 correctly returned | 3h | (root commit) |
| TASK-20 | Stock + FAQ UI sections | sherilkerubo | High | Done | Customers can check stock and browse FAQs, no reload | 4h | feature/stock-ui, feature/faq-ui |
| TASK-21 | Stock feature tests |  Nigel Matekwa (Night-ryder254) | High | Done | Valid/unknown/malformed SKU scenarios pass | 2h | (root commit) |
| TASK-22 | FAQ migration | Thando | High | Done | faqs table created, runs without error | 1h | feature/faq-api |
| TASK-22a | FAQ model + factory | Thando | High | Done | Faq model with active/category/search scopes | 1h | feature/faq-api |
| TASK-22b | FAQ service | Thando | High | Done | Returns filtered/searchable FAQ list | 2h | feature/faq-api |
| TASK-22c | FAQ API endpoints | Thando | High | Done | GET /api/faqs and /api/faqs/{id} working | 2h | feature/faq-api |
| TASK-22d | FAQ seeder | Thando | Medium | Done | 10 FAQs across 4 categories seeded | 1h | feature/faq-api |
| TASK-22e | FAQ feature tests | Thando | Medium | Done | FAQ API test suite passing | 2h | feature/faq-api |
| TASK-23 | Exclude env variants from git |  Nigel Matekwa (Night-ryder254) | Medium | Done | .env.render and variants gitignored | 1h | (root commit) |
| TASK-24 | Dockerfile for Render deploy |  Nigel Matekwa (Night-ryder254) | High | Done | App builds and runs on Render via Docker | 4h | (root commit) |

**Rule check:** every task is ≤4 hours; none exceeds the limit.
