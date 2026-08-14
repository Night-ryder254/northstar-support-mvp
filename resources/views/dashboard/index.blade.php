<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Northstar Support Deflection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Northstar Support Center</h1>
        <p class="text-muted">Check your order, returns, or stock availability instantly — no ticket needed.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Track Your Order</h5>
                    <div class="input-group mb-3">
                        <input type="text" id="orderNumberInput" class="form-control" placeholder="e.g. ORD1001">
                        <button class="btn btn-primary" id="lookupOrderBtn">Check Status</button>
                    </div>
                    <div id="orderResult"></div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Returns & Refunds</h5>
                    <div class="input-group mb-3">
                        <input type="text" id="returnOrderNumberInput" class="form-control" placeholder="e.g. ORD1004">
                        <button class="btn btn-outline-primary" id="lookupReturnBtn">Check Return Status</button>
                    </div>
                    <div id="returnResult"></div>
                    <button class="btn btn-link p-0 mt-2" id="showInstructionsBtn">How do I return an item?</button>
                    <div id="instructionsResult" class="mt-2"></div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Stock Availability</h5>
                    <div class="input-group mb-3">
                        <input type="text" id="skuInput" class="form-control" placeholder="e.g. SKU1001">
                        <button class="btn btn-outline-success" id="lookupStockBtn">Check Stock</button>
                    </div>
                    <div id="stockResult"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function alertHtml(type, message) {
    return <div class="alert alert-${type} mb-0">${message}</div>;
}

document.getElementById('lookupOrderBtn').addEventListener('click', async () => {
    const orderNumber = document.getElementById('orderNumberInput').value.trim();
    const resultDiv = document.getElementById('orderResult');
    if (!orderNumber) { resultDiv.innerHTML = alertHtml('warning', 'Please enter an order number.'); return; }
    resultDiv.innerHTML = '<div class="text-muted">Checking...</div>';
    try {
        const res = await fetch(/api/orders/${encodeURIComponent(orderNumber)});
        const body = await res.json();
        if (!body.success) { resultDiv.innerHTML = alertHtml('danger', body.error); return; }
        resultDiv.innerHTML = `
            <div class="alert alert-success mb-0">
                <strong>Order ${body.data.order_number}</strong><br>
                Status: <span class="text-capitalize">${body.data.status}</span><br>
                ${body.data.estimated_delivery ? 'Estimated delivery: ' + body.data.estimated_delivery : ''}
            </div>`;
    } catch (e) { resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.'); }
});

document.getElementById('lookupReturnBtn').addEventListener('click', async () => {
    const orderNumber = document.getElementById('returnOrderNumberInput').value.trim();
    const resultDiv = document.getElementById('returnResult');
    if (!orderNumber) { resultDiv.innerHTML = alertHtml('warning', 'Please enter an order number.'); return; }
    resultDiv.innerHTML = '<div class="text-muted">Checking...</div>';
    try {
        const res = await fetch(/api/returns/${encodeURIComponent(orderNumber)});
        const body = await res.json();
        if (!body.success) { resultDiv.innerHTML = alertHtml('danger', body.error); return; }
        resultDiv.innerHTML = `
            <div class="alert alert-info mb-0">
                Return status: <span class="text-capitalize">${body.data.return_status.replace('_',' ')}</span><br>
                Refund status: <span class="text-capitalize">${body.data.refund_status.replace('_',' ')}</span>
            </div>`;
    } catch (e) { resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.'); }
});

document.getElementById('showInstructionsBtn').addEventListener('click', async () => {
    const div = document.getElementById('instructionsResult');
    const res = await fetch('/api/returns-instructions');
    const body = await res.json();
    div.innerHTML = '<ol class="mb-0">' + body.data.steps.map(s => <li>${s}</li>).join('') + '</ol>';
});

document.getElementById('lookupStockBtn').addEventListener('click', async () => {
    const sku = document.getElementById('skuInput').value.trim();
    const resultDiv = document.getElementById('stockResult');
    if (!sku) { resultDiv.innerHTML = alertHtml('warning', 'Please enter a SKU.'); return; }
    resultDiv.innerHTML = '<div class="text-muted">Checking...</div>';
    try {
        const res = await fetch(/api/stock/${encodeURIComponent(sku)});
        const body = await res.json();
        if (!body.success) { resultDiv.innerHTML = alertHtml('danger', body.error); return; }
        const rows = body.data.variants.map(v => `
            <tr>
                <td>${v.size ?? '-'}</td>
                <td>${v.color ?? '-'}</td>
                <td>${v.in_stock ? '<span class="badge bg-success">In stock</span>' : '<span class="badge bg-secondary">Out of stock</span>'}</td>
                <td>${v.in_stock ? v.stock_quantity : (v.restock_date ? 'Restocking ' + v.restock_date : 'No restock date')}</td>
            </tr>`).join('');
        resultDiv.innerHTML = `
            <div class="mb-2"><strong>${body.data.product_name}</strong> (${body.data.sku})</div>
            <table class="table table-sm">
                <thead><tr><th>Size</th><th>Color</th><th>Status</th><th>Details</th></tr></thead>
                <tbody>${rows}</tbody>
            </table>`;
    } catch (e) { resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.'); }
});
</script>

</body>
</html>
