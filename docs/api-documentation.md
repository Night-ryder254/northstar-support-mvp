# API Documentation

## GET /api/orders/{order_number}
200 with order data · 404 unknown · 422 malformed format (must match ORD\d{4,}).

## GET /api/returns/{order_number}
200 with return+refund data (defaults if no return row) · 404 unknown order · 422 malformed.

## GET /api/returns-instructions
200, static step list, no parameters.

## GET /api/stock/{sku}
200 with all size/color variants and stock levels · 404 unknown SKU · 422 malformed (must match SKU\d{4,}).

## GET /api/faqs?category=&search=
200, filterable list of active FAQs.

## GET /api/faqs/{id}
200 for valid id · 404 unknown · 422 malformed id.
