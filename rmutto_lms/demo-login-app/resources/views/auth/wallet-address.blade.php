<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Address | IL2 RMUTTO</title>
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

        .shell {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 30px;
            max-width: 1450px;
            margin: 0 auto;
            padding: 100px 30px 40px;
            width: 100%;
        }

        .sidebar {
            background: #fff;
            border-radius: 24px;
            padding: 25px 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .nav-item {
            display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px;
            text-decoration: none; color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 4px; transition: 0.2s;
        }

        .nav-item:hover { background: #f1f5f9; color: #0f172a; }
        .nav-item.active { background: #f1f5f9; color: #003a70; font-weight: 700; }
        .nav-item img { width: 22px; height: 22px; opacity: 0.7; }
        .nav-item.active img { opacity: 1; }

        .content { display: flex; flex-direction: column; gap: 20px; }
        .page-title { font-size: 24px; font-weight: 800; color: #1e293b; }

        .wallet-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 24px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(0,0,0,0.03);
            padding: 24px;
        }

        .card h3 { font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 14px; }

        .field { margin-bottom: 14px; }
        .field label { display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 600; }
        .field input, .field select {
            width: 100%;
            height: 44px;
            border: 1px solid #dbe3ef;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
        }

        .field input:focus, .field select:focus { border-color: #003a70; }

        .btn-row { display: flex; gap: 10px; margin-top: 12px; }

        .btn-primary {
            border: none;
            background: #003a70;
            color: #fff;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-secondary {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .wallet-item {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .wallet-item h4 { font-size: 14px; color: #1e293b; margin-bottom: 4px; }
        .wallet-item p { font-size: 12px; color: #94a3b8; word-break: break-all; }

        @media (max-width: 1100px) {
            .shell { grid-template-columns: 1fr; }
            .wallet-grid { grid-template-columns: 1fr; }
            .sidebar { position: static; }
        }

        @media (max-width: 768px) {
            .shell { padding: 90px 16px 24px; }
            .header-pill { gap: 10px; flex-wrap: wrap; }
            .search-wrap { width: 100%; }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="shared-shell">
        @include('partials.sidebar', ['activePage' => 'wallet'])

        <main class="content">
            <h1 class="page-title">Wallet Address</h1>

            <div class="wallet-grid">
                <section class="card">
                    <h3>Add New Wallet</h3>

                    <div class="field">
                        <label>Wallet Name</label>
                        <input type="text" placeholder="My Main Wallet">
                    </div>

                    <div class="field">
                        <label>Network</label>
                        <select>
                            <option>Ethereum (ERC-20)</option>
                            <option>BNB Smart Chain (BEP-20)</option>
                            <option>Polygon</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Wallet Address</label>
                        <input type="text" placeholder="0x...">
                    </div>

                    <div class="btn-row">
                        <button class="btn-primary">Save Wallet</button>
                        <button class="btn-secondary">Clear</button>
                    </div>
                </section>

                <section class="card">
                    <h3>Saved Wallets</h3>

                    <div class="wallet-item">
                        <h4>Main Wallet (ERC-20)</h4>
                        <p>0x13d97c43f71e83f7a70a4dcad4e9a83bc94730f2</p>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
