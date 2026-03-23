<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search | IL2 RMUTTO</title>
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
            grid-template-columns: 280px 1fr;
            gap: 25px;
            max-width: 1450px;
            margin: 0 auto;
            padding: 90px 30px 50px;
            flex: 1;
            width: 100%;
        }

        /* â”€â”€â”€ SIDEBAR FILTERS â”€â”€â”€ */
        .filter-sidebar {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            position: sticky; top: 80px; align-self: start;
        }
        .sidebar-header { font-size: 14px; color: #1e293b; margin-bottom: 24px; font-weight: 500; }
        
        .filter-group { margin-bottom: 24px; }
        .filter-title {
            display: flex; align-items: center; justify-content: space-between;
            font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; cursor: pointer;
        }
        .filter-content { display: flex; flex-direction: column; gap: 10px; padding-left: 2px; }
        .filter-item {
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer;
        }
        .filter-item label {
            display: flex; align-items: center; gap: 12px; font-size: 13.5px; color: #94a3b8; font-weight: 400; cursor: pointer;
        }
        .filter-item input {
            width: 18px; height: 18px; border-radius: 4px; border: 1px solid #e2e8f0; 
            appearance: none; cursor: pointer; background: #fff; position: relative;
        }
        .filter-item input:checked::after {
            content: ''; position: absolute; inset: 0; background: #003a70; border-radius: 3px;
        }
        .filter-count { font-size: 13px; color: #94a3b8; }

        /* â”€â”€â”€ MAIN CONTENT â”€â”€â”€ */
        .main-card {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .main-header {
            display: flex; align-items: center; justify-content: space-between;
        }
        .main-header h2 { font-size: 16px; font-weight: 700; color: #1e293b; }
        
        .sort-wrap { display: flex; align-items: center; gap: 12px; }
        .sort-label { font-size: 13.5px; color: #64748b; font-weight: 400; }
        .sort-select {
            padding: 8px 16px; border-radius: 20px; border: 1px solid #e2e8f0;
            background: #fff; color: #1e293b; font-size: 13px; font-weight: 600; outline: none; cursor: pointer;
            min-width: 110px;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .course-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        
        .thumb-wrap { position: relative; aspect-ratio: 16/9; }
        .thumb-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .badge-free {
            position: absolute; top: 12px; left: 12px;
            background: #003a70; color: #fff;
            padding: 4px 14px; border-radius: 20px;
            font-size: 11px; font-weight: 800;
        }

        .card-body { padding: 20px; display: flex; flex-direction: column; gap: 8px; }
        .card-title { font-size: 14.5px; font-weight: 800; color: #1e293b; line-height: 1.3; }
        .card-desc { font-size: 11px; color: #94a3b8; line-height: 1.4; }

        .card-footer {
            margin-top: 10px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-left { display: flex; align-items: center; gap: 12px; }
        .c-avatar { width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; }
        
        .meta-stats { display: flex; align-items: center; gap: 8px; }
        .stat-item { display: flex; align-items: center; gap: 4px; font-size: 10px; color: #94a3b8; font-weight: 500; }
        .stat-item svg { width: 12px; height: 12px; }
        
        .heart-icon { color: #1e293b; cursor: pointer; margin-left: auto; }

    </style>
</head>
<body>

    <!-- â”€â”€ HEADER â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    @include('partials.header')

    <!-- â”€â”€ SHELL â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <div class="shared-shell">

        <!-- Filters Sidebar -->
        <aside class="filter-sidebar">
            <div class="sidebar-header">Filters:</div>

            <div class="filter-group">
                <div class="filter-title">Category 1 <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg></div>
                <div class="filter-content">
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">0</span>
                    </div>
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">4</span>
                    </div>
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">4</span>
                    </div>
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">0</span>
                    </div>
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">4</span>
                    </div>
                    <div class="filter-item">
                        <label><input type="checkbox"> Category 1</label>
                        <span class="filter-count">4</span>
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-title">Lorem Ipsum <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg></div>
                <div class="filter-content">
                    <div class="filter-item"><label><input type="checkbox"> Lorem Ipsum</label></div>
                    <div class="filter-item"><label><input type="checkbox"> Lorem Ipsum</label></div>
                    <div class="filter-item"><label><input type="checkbox"> Lorem Ipsum</label></div>
                </div>
            </div>

            <div class="filter-group" style="margin-bottom:0">
                <div class="filter-title">Lorem Ipsum <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="transform: rotate(-90deg)"><path d="m6 9 6 6 6-6"/></svg></div>
            </div>
        </aside>

        <!-- Main Search Area -->
        <main class="main-card">
            <div class="main-header">
                <h2>Search</h2>
                <div class="sort-wrap">
                    <span class="sort-label">Sort by</span>
                    <select class="sort-select">
                        <option>Default</option>
                        <option>Most Popular</option>
                        <option>Most Rated</option>
                        <option>Date</option>
                    </select>
                </div>
            </div>

            <div class="course-grid">
                @for ($i = 0; $i < 6; $i++)
                <a href="{{ route('course.detail') }}" class="course-card" style="text-decoration:none; color:inherit;">
                    <div class="thumb-wrap">
                        <img src="{{ asset('images/learning.png') }}" alt="Course">
                        <span class="badge-free">Free</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">The most complete scien..</div>
                        <div class="card-desc">Topic Description Lorem ipsum dolor sit amet, consectetur adip..</div>
                        
                        <div class="card-footer">
                            <div class="footer-left">
                                <div class="c-avatar"></div>
                                <div class="meta-stats">
                                    <div class="stat-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        4k
                                    </div>
                                    <div class="stat-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        200
                                    </div>
                                    <div class="stat-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        4.5
                                    </div>
                                </div>
                            </div>
                            <svg class="heart-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </div>
                    </div>
                </a>
                @endfor
            </div>
        </main>
    </div>

</body>
</html>
