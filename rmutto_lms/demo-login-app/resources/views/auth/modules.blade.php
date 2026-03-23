<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Modules | IL2 RMUTTO</title>
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
        }

        body {
            background-color: var(--bg-gray);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        /* ─── HEADER ─── */
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
        .header-pill { 
            width: 100%; 
            max-width: 1400px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
        }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .logo img { height: 38px; }
        .search-wrap { position: relative; width: 280px; }
        .search-wrap input { width: 100%; height: 42px; background: #f1f5f9; border: none; border-radius: 25px; padding: 0 15px 0 40px; font-size: 13.5px; outline: none; }
        .search-wrap svg { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .header-right { display: flex; align-items: center; gap: 15px; }
        .h-icon-btn { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; position: relative; }
        .profile-pill { display: flex; align-items: center; gap: 10px; padding: 5px 15px 5px 5px; border-radius: 35px; background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; font-size: 13.5px; text-decoration: none; }
        .avatar-head { width: 32px; height: 32px; border-radius: 50%; background: #94a3b8; }

        /* ─── SHELL ─── */
        .wrapper { display: grid; grid-template-columns: 240px 1fr; gap: 30px; max-width: 1450px; margin: 0 auto; padding: 100px 30px 40px; }
        
        .sidebar { background: #fff; border-radius: 24px; padding: 25px 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); position: sticky; top: 100px; height: fit-content; grid-row: 1/span 2; }
        .nav-link { display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 14px; text-decoration: none; color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 4px; transition: 0.2s; }
        .nav-link:hover { background: #f8fafc; color: #0f172a; }
        .nav-link.active { background: #f8fafc; color: var(--primary); font-weight: 700; }
        .nav-link img { width: 22px; height: 22px; opacity: 0.7; }
        .nav-link.active img { opacity: 1; }

        /* ─── MAIN CONTENT ─── */
        .main-card { background: #white; border-radius: 30px; padding: 0; box-shadow: 0 4px 25px rgba(0,0,0,0.02); overflow: hidden; }
        .card-inner { padding: 40px; background: #fff; }

        /* HERO SECTION */
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
        .title-price-row h1 { font-size: 32px; font-weight: 800; margin: 0; color: #1e293b; }
        .price-text { font-size: 28px; font-weight: 800; color: #f97316; }

        .update-date { font-size: 11px; color: #94a3b8; margin-bottom: 20px; }
        .course-short-desc { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 25px; }
        
        .date-info { font-size: 12px; color: #64748b; margin-top: 15px; }
        .date-info span { color: #2563eb; font-weight: 700; margin-right: 15px; }

        .hero-btns { display: flex; gap: 12px; margin-top: 30px; }
        .btn-dark-blue { padding: 12px 30px; border-radius: 10px; font-size: 14px; font-weight: 700; color: #fff; background: #003a70; text-decoration: none; border: none; cursor: pointer; }

        .hero-right .video-preview {     border: 1px solid #94a3b8;width: 100%; aspect-ratio: 1.6; background: url('{{ asset('images/9. Animal care.jpg') }}') center/cover no-repeat; border-radius: 20px; position: relative; display: flex; align-items: center; justify-content: center; }
        .play-btn { background: #e11d1d; border-radius: 50px; width: 72px; height: 36px; display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; box-shadow: 0 4px 15px rgba(225,29,29,0.4); transition: transform 0.2s ease; }
        .play-btn:hover { transform: scale(1.08); }

        /* ─── TAB NAVIGATION ─── */
        .tab-strip { display: flex; justify-content: center; gap: 60px; border-bottom: 1px solid #f1f5f9; margin-bottom: 50px; }
        .tab-item { padding: 15px 0; font-size: 13px; font-weight: 500; color: #94a3b8; border-bottom: 3px solid transparent; cursor: pointer; transition: 0.2s; text-decoration: none; }
        .tab-item:hover { color: #1e293b; }
        .tab-item.active { color: #1e293b; border-bottom-color: var(--primary); font-weight: 600; background: #fff; border-radius: 10px 10px 0 0; box-shadow: 0 -4px 10px rgba(0,0,0,0.02); padding-left: 30px; padding-right: 30px; position: relative; bottom: -1px; }

        /* MODULES LIST DESIGN */
        .modules-content { max-width: 1100px; padding-bottom: 60px; }
        .modules-header-info { margin-bottom: 40px; }
        .modules-header-info h2 { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 15px; }
        .modules-header-info p { font-size: 13.5px; color: #475569; line-height: 1.7; margin: 0; }
        .read-more-btn { color: #2563eb; font-size: 12.5px; font-weight: 700; text-decoration: none; display: inline-block; margin-top: 12px; }

        .modules-list-outer { border: 1px solid #eef6ff; border-radius: 24px; padding: 2px; }
        
        .mod-item { border-bottom: 1px solid #f1f5f9; }
        .mod-item:last-child { border-bottom: none; }
        
        .mod-header { padding: 25px 35px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
        .mh-left-col h3 { font-size: 15px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0; }
        .mh-left-col p { font-size: 12px; color: #64748b; margin: 0; }
        .mh-right-col { display: flex; align-items: center; gap: 15px; }
        .mh-right-col span { font-size: 12.5px; font-weight: 700; color: #2563eb; }
        .chevron { width: 18px; height: 18px; color: #1e293b; transition: 0.3s; }
        .mod-item.expanded .chevron { transform: rotate(180deg); }

        .mod-expanded-content { padding: 0 35px 35px 35px; }
        .mod-desc { font-size: 13.5px; color: #475569; line-height: 1.7; margin-bottom: 25px; }
        
        .whats-included { margin-bottom: 30px; }
        .whats-included h4 { font-size: 13.5px; font-weight: 800; color: #1e293b; margin-bottom: 12px; }
        .incl-row { display: flex; flex-wrap: wrap; gap: 20px; }
        .incl-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #1e293b; }
        .incl-item::before { content: '•'; color: #000; font-weight: 900; }

        .hide-info-btn { font-size: 13.5px; font-weight: 800; color: #1e293b; text-decoration: none; display: block; margin-bottom: 25px; }

        .lesson-list { border-top: 1px solid #f1f5f9; padding-top: 25px; display: grid; gap: 18px; }
        .lesson-row { display: flex; justify-content: space-between; align-items: center; font-size: 13.5px; color: #475569; }
        .lesson-left { display: flex; align-items: center; gap: 10px; }
        .lesson-duration { font-size: 12.5px; color: #94a3b8; }

        /* ─── FOOTER ─── */
        footer { grid-column: 2; border-radius: 26px; background: #fff; padding: 60px 40px; border-top: 1px solid #f1f5f9; display: flex; justify-content: center; width: 100%; margin-top: 10px; box-sizing: border-box; }
        .footer-inner { max-width: 1400px; width: 100%; display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.2fr; gap: 60px; }
        
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

    </style>
</head>
<body>

    <header>
        <div class="header-pill">
            <div class="header-left">
                <a href="{{ route('dashboard.1') }}" class="logo"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
                <div class="search-wrap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><input type="text" placeholder="Search here"></div>
            </div>
            <div class="header-right">
                <div class="h-icon-btn"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
                <div class="h-icon-btn"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
                <a href="{{ route('account.new') }}" class="profile-pill"><div class="avatar-head"></div><span>Student</span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" opacity="0.6"><path d="m6 9 6 6 6-6"/></svg></a>
            </div>
        </div>
    </header>

    <div class="wrapper">
        <aside class="sidebar">
            <a href="{{ route('dashboard.1') }}" class="nav-link">
                <img src="{{ asset('images/icons/1.png') }}" style="width: 22px; height: 22px;">
                Dashboard
            </a>
            <a href="{{ route('calendar') }}" class="nav-link">
                <img src="{{ asset('images/icons/2.png') }}" style="width: 22px; height: 22px;">
                Calendar
            </a>
            <a href="{{ route('learning') }}" class="nav-link">
                <img src="{{ asset('images/icons/3.png') }}" style="width: 22px; height: 22px;">
                Learning
            </a>
            <a href="{{ route('courses') }}" class="nav-link active">
                <img src="{{ asset('images/icons/4.png') }}" style="width: 22px; height: 22px;">
                Exam
            </a>
            <a href="#" class="nav-link">
                <img src="{{ asset('images/icons/5.png') }}" style="width: 22px; height: 22px;">
                Quiz
            </a>
            <a href="{{ route('account.new') }}" class="nav-link">
                <img src="{{ asset('images/icons/6.png') }}" style="width: 22px; height: 22px;">
                Account
            </a>
            <a href="#" class="nav-link">
                <img src="{{ asset('images/icons/7.png') }}" style="width: 22px; height: 22px;">
                Wallet Address
            </a>
            <a href="{{ route('transaction') }}" class="nav-link">
                <img src="{{ asset('images/icons/8.png') }}" style="width: 22px; height: 22px;">
                Transaction
            </a>
            <a href="{{ route('shopping.cart') }}" class="nav-link">
                <img src="{{ asset('images/icons/9.png') }}" style="width: 22px; height: 22px;">
                Payment
            </a>
        </aside>

        <main class="main-card">
            <div class="card-inner">
                <div class="course-hero">
                    <div class="hero-left">
                        <div class="teacher-row">
                            <div class="t-info">
                                <div class="t-avatar"></div>
                                <div class="t-content">
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
                        <div class="hero-btns" style="margin-top:25px;">
                            <button class="btn-dark-blue" style="background: #002b55; padding:10px 25px; border-radius:10px; color:#fff; border:none; font-weight:700; cursor:pointer;">Add to Cart</button>
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
                    <div class="tab-item active">Modules</div>
                    <a href="{{ route('recommendations') }}" class="tab-item">Recommendations</a>
                    <a href="{{ route('testimonials') }}" class="tab-item">Testimonials</a>
                    <a href="{{ route('reviews') }}" class="tab-item">Reviews</a>
                </div>

                <div class="modules-content">
                    <div class="modules-header-info">
                        <h2>There are 17 modules in this course</h2>
                        <p>This course provides comprehensive training for veterinary nursing assistants, covering animal care, health management, business operations, and relevant laws. You'll progress through theoretical concepts and practical applications to prepare for a professional career in animal healthcare and pet business management.</p>
                    </div>

                    <div class="modules-list-outer">
                        @php
                        $modules = [
                            ['title' => 'Introduction to Animals', 'desc' => 'Introducing the course, Types and kinds of animals, Liang', 'clos' => '2', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Associate Professor Suphansa'],
                            ['title' => 'Pet Care Management', 'desc' => 'Pet care management', 'clos' => '2', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Rainy Season Army)'],
                            ['title' => 'Disease and Health Management', 'desc' => 'Disease and management, Health', 'clos' => '2', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. Sri (Characteristics Suwan)'],
                            ['title' => 'Characteristics and Properties of Entrepreneur', 'desc' => 'Characteristics and properties of entrepreneur', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Small-Scale and Large-Scale Business', 'desc' => 'Small-scale business, Large and small business concepts, Organization models', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Marketing Management', 'desc' => 'Marketing management, Finance, Production', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Human Law and Ethics', 'desc' => 'Human law, Related ethics, Entrepreneurial ethics', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Evaluation', 'desc' => 'Evaluation, Conducting business systems', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Midterm test', 'desc' => 'Midterm Assessment', 'clos' => '-', 'hours' => '-', 'activities' => 'Examination', 'media' => 'Test Paper', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Business Operations', 'desc' => 'Business operations', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Professor'],
                            ['title' => 'Types of Livestock Farming Businesses', 'desc' => 'Types of livestock farming businesses', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Suwan)'],
                            ['title' => 'Information Systems', 'desc' => 'Information systems', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Assistant Professor (Pramote Thawitdika)'],
                            ['title' => 'Hospital Technology for Animals', 'desc' => 'Equipment and products for animals, Liang', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Suwan)'],
                            ['title' => 'Laws Related to Livestock', 'desc' => 'Laws related to livestock, Business of raising livestock', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Army)'],
                            ['title' => 'Health of Employees in Clinics and Hospitals', 'desc' => 'Health of employees, Work environment in clinics and hospitals, Body (basic health considerations)', 'clos' => '1', 'hours' => '3', 'activities' => 'Online/Onsite presentation', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Suwan)'],
                            ['title' => 'Business Plan Presentation', 'desc' => 'Presenting a business plan, Self-sustaining business planning, Liang', 'clos' => '1, 2', 'hours' => '3', 'activities' => 'Presenting a business plan', 'media' => 'PowerPoint, Canva, YouTube', 'teacher' => 'Asst. Prof. Dr. (Tha)'],
                            ['title' => 'Final Assessment', 'desc' => 'Final Exam', 'clos' => '-', 'hours' => '-', 'activities' => 'Examination', 'media' => 'Test Paper', 'teacher' => 'Asst. Professor'],
                        ];
                        @endphp

                        @foreach($modules as $index => $mod)
                        <div class="mod-item {{ $index === 0 ? 'expanded' : '' }}">
                            <div class="mod-header" onclick="this.parentElement.classList.toggle('expanded')">
                                <div class="mh-left-col">
                                    <h3>{{ $mod['title'] }}</h3>
                                    <p>{{ $mod['hours'] }} hours • CLOs: {{ $mod['clos'] }}</p>
                                </div>
                                <div class="mh-right-col">
                                    <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                                </div>
                            </div>
                            <div class="mod-expanded-content" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                <p class="mod-desc">{{ $mod['desc'] }}</p>
                                <div class="lesson-list">
                                    <div class="lesson-row"><strong>Teaching & Learning:</strong> <span>{{ $mod['activities'] }}</span></div>
                                    <div class="lesson-row"><strong>Media Used:</strong> <span>{{ $mod['media'] }}</span></div>
                                    <div class="lesson-row"><strong>Teacher:</strong> <span>{{ $mod['teacher'] }}</span></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.querySelectorAll('.mod-header').forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    const isExpanded = content.style.display === 'block';
                    content.style.display = isExpanded ? 'none' : 'block';
                    header.parentElement.classList.toggle('expanded');
                });
            });
        </script>
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
