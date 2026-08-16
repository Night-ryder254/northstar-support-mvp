# Final Demonstration Script

1. Intro (30s) — support deflection MVP for Northstar, covering order status, returns/refunds, stock, and FAQs.
2. Order status happy path — ORD1001 -> processing.
3. Order status invalid — ORD9999 -> graceful error.
4. Returns — ORD1004 -> requested/pending; ORD1011 -> not_requested defaults.
5. Stock — SKU1001 -> variant table with in/out of stock.
6. FAQs — search "refund", filter by category.
7. Test suite — run `php artisan test` live, show 16/16 passing.
8. Audit trail — show `git shortlog -sn --all`, point out multi-author history.
9. Live demo — open the Render URL, repeat steps 2–6 live.
10. Wrap-up — reference Go-Live Readiness Note for next steps.
