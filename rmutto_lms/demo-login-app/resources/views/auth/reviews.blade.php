<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews | IL2 RMUTTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v={{ time() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        :root {
            --primary: #003a70;
            --orange: #f97316;
            --bg-gray: #f1f4f6;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --border: #e2e8f0;
            --blue-link: #2563eb;
        }

        body {
            background-color: var(--bg-gray);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        header { 
            background: #fff; 
            height: 74px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            position: fixed; 
            top: 0; left: 0; right: 0; 
            z-index: 1000; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.03); 
            padding: 0 30px;
        }
        .header-pill { width: 100%; max-width: 1440px; display: flex; align-items: center; justify-content: space-between; }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .logo img { height: 38px; }
        .search-wrap { position: relative; width: 280px; }
        .search-wrap input { width: 100%; height: 42px; background: #f1f5f9; border: none; border-radius: 25px; padding: 0 15px 0 40px; font-size: 13.5px; outline: none; }
        .search-wrap svg { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .header-right { display: flex; align-items: center; gap: 15px; }
        .h-icon-btn { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; position: relative; }
        .profile-pill { display: flex; align-items: center; gap: 10px; padding: 5px 15px 5px 5px; border-radius: 35px; background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; font-size: 13.5px; text-decoration: none; }
        .avatar-head { width: 32px; height: 32px; border-radius: 50%; background: #94a3b8; }

        .wrapper { display: grid; grid-template-columns: 240px 1fr; gap: 30px; max-width: 1440px; margin: 0 auto; padding: 100px 30px 40px; }
        .sidebar { background: #fff; border-radius: 24px; padding: 25px 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); position: sticky; top: 100px; height: fit-content; grid-row: 1/span 2; }
        .nav-link { display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; text-decoration: none; color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 4px; transition: 0.2s; }
        .nav-link:hover { background: #f8fafc; color: #0f172a; }
        .nav-link.active { background: #f8fafc; color: var(--primary); font-weight: 700; }
        .nav-link img { width: 22px; height: 22px; opacity: 0.7; }

        .main-card { background: #fff; border-radius: 30px; padding: 40px; box-shadow: 0 4px 25px rgba(0,0,0,0.02); }

        .course-hero { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 40px; }
        .hero-left .teacher-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
        .t-info { display: flex; align-items: center; gap: 12px; }
        .t-avatar { width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9 url('{{ asset('images/logo.png') }}') no-repeat center; background-size: contain; border: 1.5px solid #e2e8f0; }
        .t-content p { font-size: 11px; color: #94a3b8; margin: 0; }
        .t-content span { color: #2563eb; font-weight: 700; cursor: pointer; }
        .t-meta { display: flex; gap: 15px; margin-top: 4px; font-size: 11px; color: #94a3b8; }
        .hero-left-actions { display: flex; gap: 10px; }
        .btn-outline-sm { padding: 6px 20px; border: 1px solid #e2e8f0; border-radius: 20px; font-size: 11px; font-weight: 700; color: #64748b; text-decoration: none; }

        .title-price-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .title-price-row h1 { font-size: 32px; font-weight: 900; margin: 0; color: #0f172a; letter-spacing: -0.5px; }
        .price-text { font-size: 28px; font-weight: 900; color: #f97316; }

        .update-date { font-size: 11px; color: #94a3b8; margin-bottom: 20px; }
        .course-short-desc { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 25px; }
        .date-info { font-size: 12px; color: #64748b; margin-top: 15px; }
        .date-info span { color: #2563eb; font-weight: 700; margin-right: 15px; }
        .hero-btns { display: flex; gap: 12px; margin-top: 30px; }
        .btn-dark-blue { padding: 12px 30px; border-radius: 10px; font-size: 14px; font-weight: 700; color: #fff; background: #003a70; text-decoration: none; border: none; cursor: pointer; }

        .hero-right .video-preview { 
            width: 100%; 
            aspect-ratio: 1.6; 
            background: url('{{ asset('images/9. Animal care.jpg') }}') center/cover no-repeat; 
            border-radius: 20px; 
            position: relative; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
                border: 1px solid #94a3b8;
        }
        .play-btn { background: #e11d1d; border-radius: 50px; width: 72px; height: 36px; display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; box-shadow: 0 4px 15px rgba(225,29,29,0.4); transition: transform 0.2s ease; }
        .play-btn:hover { transform: scale(1.08); }

        .tab-strip { 
            display: flex; 
            justify-content: center; 
            gap: 60px; 
            border-bottom: 1px solid #f1f5f9; 
            margin-bottom: 50px; 
        }
        .tab-item { 
            padding: 15px 0; 
            font-size: 13px; 
            font-weight: 500; 
            color: #94a3b8; 
            border-bottom: 3px solid transparent; 
            cursor: pointer; 
            transition: 0.2s; 
        }
        .tab-item.active { 
            color: #1e293b; 
            border-bottom-color: #003a70; 
            font-weight: 600; 
            padding-left: 30px; 
            padding-right: 30px; 
        }

        /* REVIEWS CONTENT */
        .reviews-container { display: grid; grid-template-columns: 350px 1fr; gap: 50px; }
        
        .rev-left h2 { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 20px; }
        .rating-summary { margin-bottom: 30px; }
        .rating-big { display: flex; align-items: center; gap: 8px; font-size: 24px; font-weight: 800; color: #1e293b; }
        .rating-big span { color: #f97316; }
        .rating-count { font-size: 14px; color: #94a3b8; margin-top: 5px; }
        
        .rating-bars { margin-top: 25px; }
        .rb-row { display: flex; align-items: center; gap: 15px; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #1e293b; }
        .rb-label { width: 50px; white-space: nowrap; }
        .rb-bar-wrap { flex: 1; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .rb-bar-fill { height: 100%; background: #008080; border-radius: 10px; }
        .rb-percent { width: 40px; color: #1e293b; }

        .rev-right-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .rev-right-header p { font-size: 14px; color: #94a3b8; margin: 0; }
        
        .rev-list { display: grid; gap: 20px; }
        .rev-card { border: 1px solid #eef6ff; border-radius: 20px; padding: 30px; display: flex; gap: 25px; align-items: flex-start; }
        .rev-avatar { width: 55px; height: 55px; border-radius: 50%; background: #4477ce; flex-shrink: 0; }
        .rev-card-content { flex: 1; }
        .rev-header-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .rev-header-row span { font-size: 11px; font-weight: 700; color: #f97316; }
        .rev-header-row p { font-size: 11px; color: #94a3b8; margin: 0; }
        .rev-body-text { font-size: 13.5px; color: #475569; line-height: 1.6; margin: 0; }
        
        .view-more-rev { display: inline-block; font-size: 13.5px; font-weight: 800; color: var(--blue-link); text-decoration: underline; margin-top: 30px; cursor: pointer; }

        footer { grid-column: 1 / -1; border-radius: 26px; background: #fff; padding: 60px 40px; border-top: 1px solid #f1f5f9; display: flex; justify-content: center; width: 100%; margin-top: 40px; box-sizing: border-box; }
        .footer-inner { max-width: 1440px; width: 100%; display: grid; grid-template-columns: 1.2fr repeat(2, 1fr) 1.2fr; gap: 60px; }
        .f-brand .f-logo-circle { width: 70px; height: 70px; border-radius: 50%; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; margin-bottom: 30px; }
        .f-brand .f-logo-circle img { height: 45px; }
        .f-brand p { font-size: 13px; color: #64748b; line-height: 1.6; max-width: 250px; }
        .f-col h4 { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 25px; }
        .f-col ul { list-style: none; padding: 0; margin: 0; }
        .f-col li { margin-bottom: 18px; }
        .f-col a { font-size: 13.5px; color: #64748b; text-decoration: none; transition: 0.2s; }
        .f-col a:hover { color: #2563eb; text-decoration: underline; }
        .f-right-col { display: flex; flex-direction: column; align-items: flex-end; gap: 30px; }
        .lang-picker { padding: 10px 20px; border: 1px solid #cbd5e1; border-radius: 20px; font-size: 13px; color: #475569; background: #fff; outline: none; min-width: 120px; }
        .social-row { display: flex; gap: 15px; }
        .s-link { width: 34px; height: 34px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .s-link img { width: 18px; height: 18px; }
        .app-badges { display: flex; gap: 12px; }
        .app-badges img { height: 36px; border-radius: 6px; }

        @media (max-width: 1024px) {
            .wrapper { grid-template-columns: 1fr; }
            .course-hero { grid-template-columns: 1fr; gap: 30px; }
            .reviews-container { grid-template-columns: 1fr; gap: 30px; }
            .footer-inner { flex-direction: column; gap: 40px; }
            .f-right-col { align-items: flex-start; border-top: 1px solid #e2e8f0; padding-top: 30px; }
        }

        @media (max-width: 768px) {
            header { padding: 12px 24px; height: auto; position: fixed; top: 0; width: 100%; box-sizing: border-box; background: #fff; z-index: 1000; }
            .header-pill { height: auto; padding: 15px 20px; border-radius: 20px; flex-direction: column; gap: 10px; width: 100%; max-width: 100%; }
            .search-wrap { width: 100%; }
            .logo img { height: 32px; }
            .header-right { width: 100%; justify-content: center; }
            
            .wrapper { padding: 140px 24px 40px; }
            .main-card { padding: 40px 24px; }
            .title-price-row h1 { font-size: 24px; }
            .price-text { font-size: 22px; }
            .tab-strip { gap: 15px; overflow-x: auto; justify-content: flex-start; padding: 0 5px; }
            footer { padding: 40px 24px; }
        }

        @media (max-width: 480px) {
            .hero-btns { flex-direction: column; }
            .btn-dark-blue { width: 100%; text-align: center; }
            .rev-card { padding: 20px 15px; gap: 15px; flex-direction: column; align-items: center; text-align: center; }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="shared-shell">
        @include('partials.sidebar', ['activePage' => 'courses'])

        <main class="main-card">
            <div class="course-hero">
                <div class="hero-left">
                    <div class="teacher-row">
                        <div class="t-info">
                            <div class="t-avatar"></div>
                            <div class="t-content">
                                <p>Created by : <span>Teacher</span></p>
                                <div class="t-meta" style="display: flex; gap: 15px; align-items: center; margin-top: 4px;">
                                    <span style="display: inline-flex; align-items: center; font-size: 11px; color: #94a3b8;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b" style="margin-right: 4px;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 0 Ratings
                                    </span>
                                    <span style="display: inline-flex; align-items: center; font-size: 11px; color: #94a3b8;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" style="margin-right: 4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> 0 Students
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="hero-left-actions">
                            <a href="#" class="btn-outline-sm">Save</a>
                            <a href="#" class="btn-outline-sm">Share</a>
                        </div>
                    </div>
                    <div class="title-price-row">
                        <h1>Veterinary Nursing Assistant Course</h1>
                        <span class="price-text">Free</span>
                    </div>
                    <div class="update-date" style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: #94a3b8; margin-bottom: 20px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Updated date : 26 march 2026
                    </div>
                    <p class="course-short-desc">To ensure the content is up-to-date with technology or aligns with learning outcomes.</p>
                    <div class="date-info" style="font-size: 13px; color: #64748b; margin-top: 15px;">
                        Course start date : <span style="color: #2563eb; font-weight: 700; margin-right: 25px;">26 march 2026</span>
                        Course end date : <span style="color: #2563eb; font-weight: 700;">26 June 2026</span>
                    </div>
                    <div class="hero-btns">
                        <button class="btn-dark-blue" style="background: #002b55;">Add to Cart</button>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="video-preview">
                        <div class="play-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-strip">
                <a href="{{ route('course.detail') }}" class="tab-item">About</a>
                <a href="{{ route('courses') }}" class="tab-item">Outcomes</a>
                <a href="{{ route('modules') }}" class="tab-item">Modules</a>
                <a href="{{ route('recommendations') }}" class="tab-item">Recommendations</a>
                <a href="{{ route('testimonials') }}" class="tab-item">Testimonials</a>
                <div class="tab-item active">Reviews</div>
            </div>

            <div class="reviews-container" style="min-height: 200px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 14px;">
                <p>No reviews available yet for this course.</p>
            </div>
        </main>

        <footer>
            <div class="footer-inner">
                <div class="f-brand">
                    <div class="f-logo-circle"><img src="{{ asset('images/icons/logo.svg') }}"></div>
                    <p>Learn anytime and anywhere from IL2 career skills</p>
                </div>
                <div class="f-col">
                    
                    <ul>
                        <li><a href="#">Teach on IL2</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Help and Support</a></li>
                    </ul>
                </div>
                <div class="f-col">
                    
                    <ul>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookies Policy</a></li>
                        <li><a href="#">Career</a></li>
                    </ul>
                </div>
                <div class="f-right-col">
                    <select class="lang-picker"><option>English</option></select>
                    <div class="social-row">
                        <div class="s-link"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"></div>
                        <div class="s-link"><img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg"></div>
                        <div class="s-link"><img src="https://upload.wikimedia.org/wikipedia/commons/c/ce/Twitter_Logo.png"></div>
                    </div>
                    <div class="app-badges">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg">
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
