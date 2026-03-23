<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | IL2 RMUTTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v={{ time() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .avatar-head { width: 32px; height: 32px; border-radius: 50%; background: #94a3b8; }

        /* â”€â”€â”€ LAYOUT â”€â”€â”€ */
        .shell {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 25px;
            max-width: 1450px;
            margin: 0 auto;
            padding: 90px 30px 50px;
            flex: 1;
            width: 100%;
        }

        /* â”€â”€â”€ SIDEBAR â”€â”€â”€ */
        .sidebar {
            background: #fff;
            border-radius: 20px;
            padding: 20px 10px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            position: sticky;
            top: 80px;
            align-self: start;
        }
        .nav-item {
            display: flex; align-items: center; gap: 14px; padding: 12px 18px;
            border-radius: 12px; text-decoration: none; color: #64748b;
            font-size: 14px; font-weight: 500; margin-bottom: 2px; transition: 0.2s;
        }
        .nav-item:hover { background: #f1f5f9; color: #0f172a; }
        .nav-item img { width: 22px; height: 22px; opacity: 0.7; }

        /* â”€â”€â”€ MAIN CONTENT â”€â”€â”€ */
        .content {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }
        .btn-clear {
            background: #003a70;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 30px;
        }

        /* â”€â”€â”€ CART ITEMS â”€â”€â”€ */
        .cart-list { display: flex; flex-direction: column; gap: 20px; }

        .cart-item-wrap {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Checkbox styling */
        .cart-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #fff;
        }
        .cart-checkbox.checked {
            background: #003a70;
            border-color: #003a70;
        }
        .cart-checkbox svg { color: #fff; display: none; }
        .cart-checkbox.checked svg { display: block; }

        .cart-item {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            gap: 20px;
            position: relative;
        }

        .item-thumb {
            width: 110px;
            height: 110px;
            background: #e2e8f0;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .item-info { flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .item-title { font-size: 15px; font-weight: 700; color: #1e293b; }
        .item-desc { font-size: 11px; color: #94a3b8; }
        
        .teacher-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 4px;
        }
        .teacher-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e2e8f0;
        }
        .teacher-name { font-size: 11px; color: #94a3b8; }

        .item-price {
            position: absolute;
            top: 24px;
            right: 24px;
            font-size: 15px;
            font-weight: 800;
            color: #003a70;
        }

        .item-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-save {
            background: #003a70;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-delete {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            padding: 7px 30px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        /* â”€â”€â”€ SUMMARY CARD â”€â”€â”€ */
        .summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
        }
        .summary-header {
            background: #f4f2f9; /* Light purple */
            padding: 20px 24px;
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }
        .summary-body {
            padding: 0 24px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            font-size: 14.5px;
            border-bottom: 1px solid #f1f5f9;
        }
        .summary-row:last-child { border-bottom: none; }
        .row-label { color: #475569; font-weight: 500; }
        .row-value { color: #003a70; font-weight: 800; }

        .summary-total {
            background: #f4f2f9;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label { font-size: 14.5px; font-weight: 700; color: #1e293b; }
        .total-value { font-size: 15px; font-weight: 800; color: #003a70; }

        .btn-checkout {
            background: #003a70;
            color: #fff;
            border: none;
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-checkout:hover { background: #002a55; }

    </style>
</head>
<body>
    @include('partials.header')

    <div class="shared-shell">
        @include('partials.sidebar', ['activePage' => 'payment'])

        <!-- Main Content -->
        <main class="content">
            <div class="content-header">
                <h2>Shopping Cart</h2>
                <button class="btn-clear">Clear All</button>
            </div>

            <div class="cart-grid">
                <!-- Cart Items List -->
                <div class="cart-list">
                    
                    <!-- Item 1 -->
                    <div class="cart-item-wrap">
                        <div class="cart-checkbox checked">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div class="cart-item">
                            <div class="item-thumb"></div>
                            <div class="item-info">
                                <div class="item-title">Veterinary Nursing Assistant Course</div>
                                <div class="item-desc">To ensure the content is up-to-date with technology or aligns with learning outcomes.</div>
                                <div class="teacher-info">
                                    <div class="teacher-avatar"></div>
                                    <span class="teacher-name">Created by Teacher</span>
                                </div>
                                <div class="item-actions">
                                    <button class="btn-save">Saved for later</button>
                                    <button class="btn-delete">Delete</button>
                                </div>
                            </div>
                            <div class="item-price">Free</div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <!-- <div class="cart-item-wrap">
                        <div class="cart-checkbox">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div class="cart-item">
                            <div class="item-thumb"></div>
                            <div class="item-info">
                                <div class="item-title">Guide 2 Maths</div>
                                <div class="item-desc">In other words the smallest 2-digits number is 10</div>
                                <div class="teacher-info">
                                    <div class="teacher-avatar"></div>
                                    <span class="teacher-name">Created by Teacher 1</span>
                                </div>
                                <div class="item-actions">
                                    <button class="btn-save">Saved for later</button>
                                    <button class="btn-delete">Delete</button>
                                </div>
                            </div>
                            <div class="item-price">$5.99</div>
                        </div>
                    </div> -->

                </div>

                <!-- Summary Panel -->
                <div class="summary-panel">
                    <div class="summary-card">
                        <div class="summary-header">Payment Summary</div>
                        <div class="summary-body">
                            <div class="summary-row">
                                <span class="row-label">Subtotal</span>
                                <span class="row-value">$0</span>
                            </div>
                            <div class="summary-row">
                                <span class="row-label">Taxes</span>
                                <span class="row-value">$0</span>
                            </div>
                        </div>
                        <div class="summary-total">
                            <span class="total-label">Total</span>
                            <span class="total-value">$0</span>
                        </div>
                    </div>
                    <button class="btn-checkout" onclick="window.location.href='{{ route('payment.method') }}'">Checkout</button>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
