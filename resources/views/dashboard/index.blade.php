<<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Northstar') }} — Support Center</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600|ibm-plex-mono:500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                            display: ['Space Grotesk', 'ui-sans-serif', 'system-ui'],
                            data: ['IBM Plex Mono', 'ui-monospace', 'monospace'],
                        },
                        colors: {
                            navy: { 950:'#0b1b2e', 900:'#102a45', 800:'#14304f', 700:'#1e3f63', 600:'#2c5480' },
                            slate: { 600:'#4a5b72', 400:'#8496ac', 200:'#d7dee7' },
                            mist: { 50:'#fafbfd', 100:'#f4f6fa', 200:'#e9edf3' },
                            signal: { 600:'#d94f1e', 500:'#f2662c', 400:'#f68a55', 100:'#fde7da' },
                            success: { 600:'#147a52', 100:'#dcf3e8' },
                            warning: { 600:'#a86a06', 100:'#fbecd0' },
                            danger: { 600:'#b83a30', 100:'#fbe3e1' },
                        },
                    },
                },
            };
        </script>
    @endif
</head>
<body class="bg-mist-100 font-sans text-navy-950 antialiased">

    <!-- Top bar -->
    <header class="border-b border-navy-950/5 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-navy-950 font-display text-sm font-bold text-white">N</span>
                <span class="font-display text-lg font-semibold tracking-tight">Northstar</span>
                <span class="ml-1 hidden rounded-full bg-mist-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 sm:inline">Support Center</span>
            </div>
            <nav class="hidden items-center gap-8 font-display text-sm font-medium text-slate-600 md:flex">
                <a href="#track" class="transition hover:text-navy-950">Track order</a>
                <a href="#stock" class="transition hover:text-navy-950">Stock</a>
                <a href="#returns" class="transition hover:text-navy-950">Returns &amp; refunds</a>
                <a href="#faqs" class="transition hover:text-navy-950">FAQs</a>
                <a href="#help" class="transition hover:text-navy-950">How it works</a>
            </nav>
            <a href="mailto:support@northstar.example"
               class="rounded-md border border-navy-950/10 px-4 py-2 font-display text-sm font-medium text-navy-950 transition hover:bg-mist-100">
                Contact support
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 pb-28 pt-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:pt-20">
            <div>
                <p class="font-display text-xs font-semibold uppercase tracking-[0.2em] text-signal-400">Self-service, no ticket needed</p>
                <h1 class="mt-4 font-display text-4xl font-semibold leading-[1.1] tracking-tight sm:text-5xl">
                    Know where it is.<br>Get it sorted.
                </h1>
                <p class="mt-5 max-w-md text-base leading-relaxed text-slate-200">
                    Look up any order, check stock on an item, see where a return and refund stand, or search our FAQs — all in one place, updated in real time.
                </p>
            </div>

            <!-- Signature motif: a checkpoint line, echoed later as the live order timeline -->
            <div class="hidden lg:block" aria-hidden="true">
                <svg viewBox="0 0 360 140" class="w-full">
                    <rect x="14" y="52" width="34" height="26" rx="4" fill="#1e3f63" />
                    <rect x="14" y="52" width="34" height="8" rx="2" fill="#f2662c" />
                    <line x1="60" y1="65" x2="300" y2="65" stroke="#2c5480" stroke-width="2" stroke-dasharray="2 8" stroke-linecap="round" />
                    <circle cx="60" cy="65" r="6" fill="#f2662c" />
                    <circle cx="150" cy="65" r="6" fill="#f2662c" />
                    <circle cx="230" cy="65" r="6" fill="#3a5c85" stroke="#8496ac" stroke-width="1.5" />
                    <circle cx="310" cy="65" r="6" fill="#14304f" stroke="#4a5b72" stroke-width="1.5" />
                    <rect x="296" y="38" width="34" height="26" rx="4" fill="none" stroke="#4a5b72" stroke-width="1.5" />
                </svg>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-transparent to-mist-100"></div>
    </section>

    <!-- Quick-action tile grid: every lookup gets equal weight -->
    <section class="relative mx-auto -mt-20 max-w-6xl px-6 pb-14">
        <div class="grid gap-6 lg:grid-cols-2">

            <!-- Track order -->
            <div id="track" class="rounded-2xl border border-navy-950/5 bg-white p-6 shadow-xl shadow-navy-950/10 sm:p-8">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-signal-100 text-signal-600">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
                    </span>
                    <h2 class="font-display text-lg font-semibold">Track your order</h2>
                </div>
                <p class="mt-2 text-sm text-slate-600">Enter the order number from your confirmation email.</p>

                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <input
                        type="text"
                        id="orderNumberInput"
                        placeholder="e.g. ORD1001"
                        class="w-full rounded-lg border border-slate-200 bg-mist-50 px-4 py-2.5 font-data text-sm tracking-wide text-navy-950 placeholder:text-slate-400 focus:border-navy-600 focus:outline-none focus:ring-2 focus:ring-navy-600/20"
                    >
                    <button id="lookupOrderBtn"
                        class="shrink-0 rounded-lg bg-signal-500 px-5 py-2.5 font-display text-sm font-semibold text-white transition hover:bg-signal-600 focus:outline-none focus:ring-2 focus:ring-signal-500/40">
                        Check status
                    </button>
                </div>

                <div id="orderResult" class="mt-5"></div>
            </div>

            <!-- Stock availability -->
            <div id="stock" class="rounded-2xl border border-navy-950/5 bg-white p-6 shadow-xl shadow-navy-950/10 sm:p-8">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-navy-950/5 text-navy-800">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                    </span>
                    <h2 class="font-display text-lg font-semibold">Stock availability</h2>
                </div>
                <p class="mt-2 text-sm text-slate-600">Check sizes, colors, and quantities for an item.</p>

                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <input
                        type="text"
                        id="skuInput"
                        placeholder="e.g. SKU1001"
                        class="w-full rounded-lg border border-slate-200 bg-mist-50 px-4 py-2.5 font-data text-sm tracking-wide text-navy-950 placeholder:text-slate-400 focus:border-navy-600 focus:outline-none focus:ring-2 focus:ring-navy-600/20"
                    >
                    <button id="lookupStockBtn"
                        class="shrink-0 rounded-lg border border-navy-950 px-5 py-2.5 font-display text-sm font-semibold text-navy-950 transition hover:bg-navy-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-navy-950/20">
                        Check stock
                    </button>
                </div>

                <div id="stockResult" class="mt-5"></div>
            </div>

            <!-- Returns & refunds -->
            <div id="returns" class="rounded-2xl border border-navy-950/5 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-signal-100 text-signal-600">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7v6h6"/><path d="M3 13a9 9 0 1 0 3-6.7L3 9"/></svg>
                    </span>
                    <h2 class="font-display text-lg font-semibold">Returns &amp; refunds</h2>
                </div>
                <p class="mt-2 text-sm text-slate-600">Check where a return and its refund currently stand.</p>

                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <input
                        type="text"
                        id="returnOrderNumberInput"
                        placeholder="e.g. ORD1004"
                        class="w-full rounded-lg border border-slate-200 bg-mist-50 px-4 py-2.5 font-data text-sm tracking-wide text-navy-950 placeholder:text-slate-400 focus:border-navy-600 focus:outline-none focus:ring-2 focus:ring-navy-600/20"
                    >
                    <button id="lookupReturnBtn"
                        class="shrink-0 rounded-lg border border-navy-950 px-5 py-2.5 font-display text-sm font-semibold text-navy-950 transition hover:bg-navy-950 hover:text-white focus:outline-none focus:ring-2 focus:ring-navy-950/20">
                        Check return
                    </button>
                </div>

                <div id="returnResult" class="mt-5"></div>
            </div>

            <div id="help" class="rounded-2xl border border-navy-950/5 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-navy-950/5 text-navy-800">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </span>
                    <h2 class="font-display text-lg font-semibold">How returns work</h2>
                </div>
                <p class="mt-2 text-sm text-slate-600">The steps for sending an item back, in order.</p>

                <button id="showInstructionsBtn"
                    class="mt-4 font-display text-sm font-semibold text-signal-600 transition hover:text-signal-500">
                    Show the steps →
                </button>

                <div id="instructionsResult" class="mt-4"></div>
            </div>

        </div>
    </section>

    <!-- FAQs -->
    <section id="faqs" class="mx-auto max-w-6xl px-6 pb-20">
        <div class="rounded-2xl border border-navy-950/5 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-signal-100 text-signal-600">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><path d="M12 17h.01"/></svg>
                </span>
                <h2 class="font-display text-lg font-semibold">Frequently asked questions</h2>
            </div>
            <p class="mt-2 text-sm text-slate-600">Search or browse by topic before reaching out.</p>

            <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                <input
                    type="text"
                    id="faqSearchInput"
                    placeholder="Search FAQs…"
                    class="w-full rounded-lg border border-slate-200 bg-mist-50 px-4 py-2.5 text-sm text-navy-950 placeholder:text-slate-400 focus:border-navy-600 focus:outline-none focus:ring-2 focus:ring-navy-600/20"
                >
                <button id="faqSearchBtn"
                    class="shrink-0 rounded-lg bg-signal-500 px-5 py-2.5 font-display text-sm font-semibold text-white transition hover:bg-signal-600 focus:outline-none focus:ring-2 focus:ring-signal-500/40">
                    Search
                </button>
            </div>

            <div id="faqCategoryPills" class="mt-4 flex flex-wrap gap-2"></div>

            <div id="faqResults" class="mt-6 divide-y divide-mist-200"></div>
        </div>
    </section>

    <footer class="border-t border-navy-950/5 bg-white py-8">
        <div class="mx-auto max-w-6xl px-6 text-sm text-slate-600">
            Can't find what you need? <a href="mailto:support@northstar.example" class="font-medium text-navy-950 underline underline-offset-2">Email support</a> and we'll get back to you within one business day.
        </div>
    </footer>

<script>
// ---- shared visual helpers -------------------------------------------------

function badgeToneClasses(rawStatus) {
    const status = (rawStatus || '').toLowerCase();
    // Matches the app's actual status vocabulary:
    // orders: processing / packed / shipped / delivered / cancelled
    // returns: not_requested / requested / in_transit / received / rejected
    // refunds: not_applicable / pending / processed
    const success = ['delivered', 'received', 'processed'];
    const warning = ['processing', 'packed', 'shipped', 'requested', 'in_transit', 'pending'];
    const danger = ['rejected', 'cancelled'];
    const neutral = ['not_requested', 'not_applicable'];

    if (neutral.includes(status)) return 'bg-mist-200 text-slate-500';
    if (success.includes(status)) return 'bg-success-100 text-success-600';
    if (danger.includes(status)) return 'bg-danger-100 text-danger-600';
    if (warning.includes(status)) return 'bg-warning-100 text-warning-600';
    return 'bg-mist-200 text-slate-600';
}

function badgeHtml(label, rawStatus) {
    const text = (rawStatus || '—').replace(/_/g, ' ');
    return `<span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold capitalize ${badgeToneClasses(rawStatus)}">
        ${label ? `<span class="font-display font-medium normal-case text-slate-500">${label}:</span>` : ''} ${text}
    </span>`;
}

function alertHtml(tone, message) {
    const tones = {
        warning: 'border-warning-100 bg-warning-100/60 text-warning-600',
        danger: 'border-danger-100 bg-danger-100/60 text-danger-600',
    };
    return `<div class="rounded-lg border px-4 py-3 text-sm font-medium ${tones[tone]}">${message}</div>`;
}

// Order-status checkpoint line — the same motif used decoratively in the hero,
// now doing real work as a progress indicator.
function timelineHtml(rawStatus) {
    const steps = ['processing', 'packed', 'shipped', 'delivered'];
    const status = (rawStatus || '').toLowerCase();

    if (status === 'cancelled') {
        return `<div class="mt-4 flex items-center gap-3 text-sm font-medium text-danger-600">
            <span class="h-2.5 w-2.5 rounded-full bg-danger-600"></span> Order cancelled
        </div>`;
    }

    const activeIndex = steps.indexOf(status);
    const currentIndex = activeIndex === -1 ? 0 : activeIndex;

    const dots = steps.map((step, i) => {
        const reached = i <= currentIndex;
        return `
            <div class="flex flex-1 flex-col items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full ${reached ? 'bg-signal-500' : 'bg-mist-200'}"></span>
                <span class="font-display text-[11px] font-medium capitalize ${reached ? 'text-navy-950' : 'text-slate-400'}">${step}</span>
            </div>`;
    }).join('<div class="mt-[5px] h-px flex-1 bg-mist-200"></div>');

    return `<div class="mt-5 flex items-start">${dots}</div>`;
}

function stockBadgeHtml(inStock) {
    return inStock
        ? `<span class="inline-flex items-center gap-1.5 rounded-full bg-success-100 px-3 py-1 text-xs font-semibold text-success-600">In stock</span>`
        : `<span class="inline-flex items-center gap-1.5 rounded-full bg-mist-200 px-3 py-1 text-xs font-semibold text-slate-500">Out of stock</span>`;
}

function variantRowHtml(variant) {
    const details = variant.in_stock
        ? `<span class="font-data text-navy-950">${variant.stock_quantity} available</span>`
        : (variant.restock_date
            ? `<span class="text-slate-500">Restocking <span class="font-data">${variant.restock_date}</span></span>`
            : `<span class="text-slate-400">No restock date</span>`);

    return `
        <tr class="border-t border-mist-200">
            <td class="py-2.5 pr-4 text-sm text-navy-950">${variant.size ?? '—'}</td>
            <td class="py-2.5 pr-4 text-sm text-navy-950">${variant.color ?? '—'}</td>
            <td class="py-2.5 pr-4">${stockBadgeHtml(variant.in_stock)}</td>
            <td class="py-2.5 text-sm">${details}</td>
        </tr>`;
}

// ---- order tracking ---------------------------------------------------------

document.getElementById('lookupOrderBtn').addEventListener('click', async () => {
    const orderNumber = document.getElementById('orderNumberInput').value.trim();
    const resultDiv = document.getElementById('orderResult');
    if (!orderNumber) {
        resultDiv.innerHTML = alertHtml('warning', 'Please enter an order number.');
        return;
    }
    resultDiv.innerHTML = '<div class="text-sm text-slate-500">Checking…</div>';
    try {
        const res = await fetch(`/api/orders/${encodeURIComponent(orderNumber)}`);
        const body = await res.json();
        if (!body.success) {
            resultDiv.innerHTML = alertHtml('danger', body.error);
            return;
        }
        resultDiv.innerHTML = `
            <div class="rounded-lg border border-mist-200 bg-mist-50 p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="font-data text-sm font-semibold text-navy-950">${body.data.order_number}</span>
                    ${badgeHtml('', body.data.status)}
                </div>
                ${timelineHtml(body.data.status)}
                ${body.data.estimated_delivery ? `<p class="mt-4 text-sm text-slate-600">Estimated delivery: <span class="font-data font-medium text-navy-950">${body.data.estimated_delivery}</span></p>` : ''}
            </div>`;
    } catch (e) {
        resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.');
    }
});

// ---- returns & refunds -------------------------------------------------------

document.getElementById('lookupReturnBtn').addEventListener('click', async () => {
    const orderNumber = document.getElementById('returnOrderNumberInput').value.trim();
    const resultDiv = document.getElementById('returnResult');
    if (!orderNumber) {
        resultDiv.innerHTML = alertHtml('warning', 'Please enter an order number.');
        return;
    }
    resultDiv.innerHTML = '<div class="text-sm text-slate-500">Checking…</div>';
    try {
        const res = await fetch(`/api/returns/${encodeURIComponent(orderNumber)}`);
        const body = await res.json();
        if (!body.success) {
            resultDiv.innerHTML = alertHtml('danger', body.error);
            return;
        }
        resultDiv.innerHTML = `
            <div class="rounded-lg border border-mist-200 bg-mist-50 p-4">
                <div class="flex flex-wrap gap-2">
                    ${badgeHtml('Return', body.data.return_status)}
                    ${badgeHtml('Refund', body.data.refund_status)}
                </div>
            </div>`;
    } catch (e) {
        resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.');
    }
});

// ---- stock availability -------------------------------------------------------

document.getElementById('lookupStockBtn').addEventListener('click', async () => {
    const sku = document.getElementById('skuInput').value.trim();
    const resultDiv = document.getElementById('stockResult');
    if (!sku) {
        resultDiv.innerHTML = alertHtml('warning', 'Please enter a SKU.');
        return;
    }
    resultDiv.innerHTML = '<div class="text-sm text-slate-500">Checking…</div>';
    try {
        const res = await fetch(`/api/stock/${encodeURIComponent(sku)}`);
        const body = await res.json();
        if (!body.success) {
            resultDiv.innerHTML = alertHtml('danger', body.error);
            return;
        }
        const rows = body.data.variants.map(variantRowHtml).join('');
        resultDiv.innerHTML = `
            <div class="rounded-lg border border-mist-200 bg-mist-50 p-4">
                <div class="mb-1 flex flex-wrap items-baseline gap-2">
                    <span class="font-display text-sm font-semibold text-navy-950">${body.data.product_name}</span>
                    <span class="font-data text-xs text-slate-500">${body.data.sku}</span>
                </div>
                <table class="mt-2 w-full border-collapse text-left">
                    <thead>
                        <tr>
                            <th class="pb-2 pr-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Size</th>
                            <th class="pb-2 pr-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Color</th>
                            <th class="pb-2 pr-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="pb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Details</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>`;
    } catch (e) {
        resultDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.');
    }
});

// ---- how returns work ---------------------------------------------------------

document.getElementById('showInstructionsBtn').addEventListener('click', async () => {
    const div = document.getElementById('instructionsResult');
    div.innerHTML = '<div class="text-sm text-slate-500">Loading…</div>';
    try {
        const res = await fetch('/api/returns-instructions');
        const body = await res.json();
        div.innerHTML = `<ol class="mt-2 space-y-3">${body.data.steps.map((step, i) => `
            <li class="flex gap-3">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-navy-950 font-data text-xs font-semibold text-white">${i + 1}</span>
                <span class="pt-0.5 text-sm text-navy-950">${step}</span>
            </li>`).join('')}</ol>`;
    } catch (e) {
        div.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.');
    }
});

// ---- FAQs ---------------------------------------------------------------------
// Wired to GET /api/faqs?category=&search=, response: { success, data: [{ id, question, answer, category }] }

const FAQ_CATEGORIES = ['returns', 'delivery', 'refunds', 'orders'];
let activeFaqCategory = '';

function renderFaqCategoryPills() {
    const pillsDiv = document.getElementById('faqCategoryPills');
    const categories = [{ key: '', label: 'All' }, ...FAQ_CATEGORIES.map(c => ({ key: c, label: c }))];
    pillsDiv.innerHTML = categories.map(cat => {
        const isActive = activeFaqCategory === cat.key;
        const tone = isActive ? 'bg-navy-950 text-white' : 'bg-mist-100 text-slate-600 hover:bg-mist-200';
        return `<button type="button" data-category="${cat.key}" class="rounded-full px-3 py-1.5 font-display text-xs font-semibold capitalize transition ${tone}">${cat.label}</button>`;
    }).join('');
}

function faqItemHtml(faq) {
    return `
        <div class="py-3">
            <button type="button" class="faq-toggle flex w-full items-center justify-between gap-4 text-left" data-target="faq-answer-${faq.id}">
                <span class="font-display text-sm font-semibold text-navy-950">${faq.question}</span>
                <svg class="faq-chevron h-4 w-4 shrink-0 text-slate-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div id="faq-answer-${faq.id}" class="mt-2 hidden text-sm leading-relaxed text-slate-600">
                ${faq.answer}
            </div>
        </div>`;
}

async function loadFaqs(searchTerm) {
    const resultsDiv = document.getElementById('faqResults');
    resultsDiv.innerHTML = '<div class="py-3 text-sm text-slate-500">Loading…</div>';
    try {
        const params = new URLSearchParams();
        if (searchTerm) params.set('search', searchTerm);
        if (activeFaqCategory) params.set('category', activeFaqCategory);
        const query = params.toString();

        const res = await fetch(`/api/faqs${query ? '?' + query : ''}`);
        const body = await res.json();
        if (!body.success) {
            resultsDiv.innerHTML = alertHtml('danger', body.error);
            return;
        }
        if (!body.data.length) {
            resultsDiv.innerHTML = '<div class="py-3 text-sm text-slate-500">No FAQs match your search.</div>';
            return;
        }
        resultsDiv.innerHTML = body.data.map(faqItemHtml).join('');
    } catch (e) {
        resultsDiv.innerHTML = alertHtml('danger', 'Could not reach the server. Please try again.');
    }
}

document.getElementById('faqCategoryPills').addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-category]');
    if (!btn) return;
    activeFaqCategory = btn.dataset.category;
    renderFaqCategoryPills();
    loadFaqs(document.getElementById('faqSearchInput').value.trim());
});

document.getElementById('faqResults').addEventListener('click', (e) => {
    const btn = e.target.closest('.faq-toggle');
    if (!btn) return;
    document.getElementById(btn.dataset.target).classList.toggle('hidden');
    btn.querySelector('.faq-chevron').classList.toggle('rotate-180');
});

document.getElementById('faqSearchBtn').addEventListener('click', () => {
    loadFaqs(document.getElementById('faqSearchInput').value.trim());
});
document.getElementById('faqSearchInput').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') loadFaqs(document.getElementById('faqSearchInput').value.trim());
});

// Initial load
renderFaqCategoryPills();
loadFaqs();
</script>

</body>
</html>
