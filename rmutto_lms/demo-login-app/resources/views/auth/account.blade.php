<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | IL2 RMUTTO</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v={{ time() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <style>
        body {
            background-color: #f1f4f9;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
        }

        /* Standardized Header UI */
        .top-header {
            background: #f1f4f9;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-inner-pill {
            max-width: 1440px;
            width: 100%;
            background: #fff;
            height: 64px;
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-logo img {
            height: 38px;
            width: auto;
            display: block;
        }

        .category-select-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            border: 1px solid #e2e8f0;
        }

        .search-bar-pill {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border-radius: 30px;
            padding: 0 20px;
            height: 44px;
            width: 320px;
            gap: 12px;
        }

        .search-bar-pill input {
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            font-size: 14px;
            color: #475569;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .h-icon-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            position: relative;
        }

        .h-icon-btn svg {
            width: 22px;
            height: 22px;
            stroke-width: 1.5;
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #f97316;
            color: #fff;
            font-size: 10px;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 700;
            border: 2px solid #fff;
        }

        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 16px 6px 6px;
            border-radius: 40px;
            background: #f8fafc;
            text-decoration: none;
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
        }

        .profile-avatar-head {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #94a3b8;
        }

        /* Account Layout */
        .account-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 20px 20px 80px;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 30px;
        }

        .sidebar {
            background: #fff;
            border-radius: 24px;
            padding: 24px 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            height: fit-content;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            border-radius: 14px;
            text-decoration: none;
            color: #64748b;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .nav-item.active {
            background: #f1f5f9;
            color: #3b82f6;
            font-weight: 700;
        }

        .nav-item img {
            width: 22px;
            height: 22px;
            opacity: 0.7;
        }

        .nav-item.active img {
            opacity: 1;
        }

        /* Main Content */
        .content-header {
            margin-bottom: 24px;
        }

        .content-title {
            font-size: 20px;
            font-weight: 800;
            color: #1a202c;
        }

        .account-card {
            background: #fff;
            border-radius: 24px;
            padding: 60px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            min-height: 600px;
        }

        /* Avatar Section */
        .avatar-section {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 50px;
        }

        .avatar-main {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #94a3b8;
        }

        .edit-btn {
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            background: #003a70;
            color: #fff;
            border: none;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 40px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 700;
            color: #1a202c;
        }

        .form-group label span {
            color: #ef4444;
            margin-left: 2px;
        }

        .form-group input, .form-group select {
            height: 52px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 14px;
            color: #4a5568;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #3b82f6;
        }

        .btn-navy {
            height: 52px;
            background: #003a70;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0 24px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-update {
            margin-top: 50px;
            height: 52px;
            width: 220px;
            background: #003a70;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-update:hover {
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: #d8d8d8;
            padding: 80px 40px;
            border-top: 1px solid #f1f5f9;
        }

        .footer-inner {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 100px;
        }

        .footer-logo-section {
            flex: 1;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }

        .logo-circle img {
            width: 70px;
        }

        .footer-tagline {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
        }

        .footer-links-container {
            display: flex;
            justify-content: flex-start;
            gap: 80px;
        }

        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .footer-col a {
            font-size: 14px;
            color: #475569;
            text-decoration: none;
        }

        .footer-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 24px;
        }

        .footer-lang {
            padding: 10px 24px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            color: #64748b;
            min-width: 140px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='3'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .social-icons {
            display: flex;
            gap: 16px;
        }

        .social-icons a img {
            width: 24px;
            height: 24px;
        }

        .app-badges {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .app-badges img {
            height: 38px;
        }

        @media (max-width: 1024px) {
            .account-container { grid-template-columns: 1fr; }
            .header-inner-pill { max-width: 95%; }
            .footer-inner { flex-direction: column; gap: 40px; }
            .footer-links-container { justify-content: flex-start; gap: 40px; }
            .footer-right { align-items: flex-start; }
            .form-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .top-header { padding: 12px 24px; position: fixed; width: 100%; top: 0; left: 0; right: 0; box-sizing: border-box; }
            .header-inner-pill { height: auto; padding: 12px 20px; border-radius: 20px; flex-direction: column; gap: 10px; width: 100%; max-width: 100%; }
            .search-bar-pill { width: 100%; }
            .category-select-pill, .h-icon-btn:not(:last-child) { display: none; }
            .header-right { width: 100%; justify-content: center; }
            
            .account-container { padding: 120px 24px 40px; }
            .account-card { padding: 30px 24px; }
            .footer { padding: 40px 24px; }
            .footer-inner { gap: 30px; }
            .footer-links-container { flex-direction: column; gap: 20px; }
        }

        @media (max-width: 480px) {
            .content-title { font-size: 18px; }
            .btn-update { width: 100%; }
            .avatar-section { margin-bottom: 30px; }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="shared-shell">
        @include('partials.sidebar', ['activePage' => 'account'])
    </div>
    <main class="account-content">
        <div class="content-header">
            <h1 class="content-title">My Account</h1>
        </div>

        <div class="account-card">
            <div class="avatar-section">
                <div class="avatar-main"></div>
                <button class="edit-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </button>
            </div>

            <form action="#">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name<span>*</span></label>
                        <input type="text" value="Student">
                    </div>
                    <div class="form-group">
                        <label>Username<span>*</span></label>
                        <input type="text" value="@Student2">
                    </div>

                    <div class="form-group">
                        <label>Current Password<span>*</span></label>
                        <input type="password" value="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢">
                    </div>
                    <div class="form-group" style="padding-bottom: 2px;">
                        <a href="{{ route('password.change') }}" class="btn-navy" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">Change</a>
                    </div>

                    <div class="form-group">
                        <label>Old Password<span>*</span></label>
                        <input type="password" placeholder="Enter old password">
                    </div>
                    <div class="form-group">
                        <label>New Password<span>*</span></label>
                        <input type="password" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label>Email<span>*</span></label>
                        <input type="email" value="123@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Date of birth<span>*</span></label>
                        <input type="text" value="Teacher">
                    </div>

                    <div class="form-group">
                        <label>Phone No<span>*</span></label>
                        <input type="tel" value="000-0000 0000">
                    </div>
                    <div class="form-group">
                        <label>Country<span>*</span></label>
                        <select>
                            <option>Malaysia</option>
                            <option>Thailand</option>
                            <option>Singapore</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex;">
                    <button type="submit" class="btn-update">Update</button>
                </div>
            </form>
        </div>
    </main>
</div>

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-logo-section">
            <div class="logo-circle">
                <img src="{{ asset('images/icons/logo.svg') }}" alt="Logo">
            </div>
            <p class="footer-tagline">Learn anytime and anywhere<br>from IL2 career skills</p>
        </div>

        <div class="footer-links-container">
            <div class="footer-col">
                <a href="#">Teach on IL2</a>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Help and Support</a>
            </div>
            <div class="footer-col">
                <a href="#">Terms</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Cookies Policy</a>
                <a href="#">Career</a>
            </div>
        </div>

        <div class="footer-right">
            <select class="footer-lang">
                <option>English</option>
                <option>Thai</option>
            </select>
            
            <div class="social-icons">
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" alt="Instagram"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg" alt="Twitter"></a>
            </div>

            <div class="app-badges">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store">
            </div>
        </div>
    </div>
</footer>

</body>
</html>

