# Testing Documentation

Run via `php artisan test`. Current result: 16 passed, 33 assertions.

| Test ID | Scenario | Result |
|---|---|---|
| TEST-01 | Valid order lookup | PASS |
| TEST-02 | Unknown order lookup | PASS |
| TEST-03 | Empty order input | PASS |
| TEST-04 | Malformed order format | PASS |
| TEST-05 | Valid return lookup | PASS |
| TEST-06 | Unknown return lookup | PASS |
| TEST-07 | Order with no return row (defaults) | PASS |
| TEST-08 | Return instructions endpoint | PASS |
| TEST-09 | Dashboard page loads | PASS |
| TEST-10 | Whitespace order number | PASS |
| TEST-11 | Valid SKU lookup | PASS |
| TEST-12 | Unknown SKU | PASS |
| TEST-13 | Malformed SKU | PASS |
| TEST-14 | Out-of-stock variant + restock info | PASS |
| TEST-15/16 | FAQ API tests (Thando) | PASS |
