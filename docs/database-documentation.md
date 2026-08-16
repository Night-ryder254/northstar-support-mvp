# Database Documentation

## orders
id, order_number (unique), customer_name, status (processing/packed/shipped/delivered/cancelled), estimated_delivery, timestamps.

## returns
id, order_number, return_status (not_requested/requested/in_transit/received/rejected), refund_status (not_applicable/pending/processed), return_reason, timestamps.

## products
id, sku, product_name, size, color, stock_quantity, restock_date, timestamps.

## faqs
id, question, answer, category, active, timestamps.

## Seed data
- 11 fictional orders (ORD1001–ORD1011), all 5 statuses represented.
- 4 return records covering all status combinations; ORD1011 deliberately has none (tests default path).
- 11 product variants across 6 SKUs, including fully out-of-stock items.
- 10 FAQs across 4 categories (delivery, returns, refunds, orders).

All data is fictional, used only for demo/testing.
