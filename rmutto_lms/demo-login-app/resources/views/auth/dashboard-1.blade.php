<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | IL2 RMUTTO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v={{ time() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Responsive Enhancements -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-1-responsive.css') }}?v={{ time() }}">
    <style>
        :root {
            --primary: #003a70;
            --primary-light: #004d95;
            --bg: #f3f6f9;
            --sidebar-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius-md: 12px;
            --radius-pill: 50px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════════════════════════════
        HEADER RESPONSIVENESS
        ═══════════════════════════════════════════════════════════════ */

        .profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 15px 5px 5px;
            border-radius: 35px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
        }

        .avatar-head {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #94a3b8;
        }

        /* â”€â”€â”€ MAIN LAYOUT â”€â”€â”€ */
        .wrapper {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 25px;
            max-width: 1440px;
            margin: 0 auto;
            padding: 90px 30px 50px;
            flex: 1;
        }

        /* â”€â”€â”€ SIDEBAR â”€â”€â”€ */
        .sidebar {
            background: #fff;
            border-radius: 20px;
            padding: 20px 10px 40px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            min-height: 850px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 12px;
            text-decoration: none;
            color: #64748b;
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 2px;
            transition: 0.2s;
        }

        .nav-link:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .nav-link.active {
            background: #f1f5f9;
            color: var(--primary);
            font-weight: 800;
        }

        .nav-link img {
            width: 22px;
            height: 22px;
            opacity: 0.7;
        }

        .nav-link.active img {
            opacity: 1;
        }

        /* â”€â”€â”€ CONTENT AREA â”€â”€â”€ */
        .content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .flex-container {
            display: flex;
            gap: 25px;
            padding-top: 30px;
        }

        .main-col { flex: 2; display: flex; flex-direction: column; gap: 25px; }
        .side-col { flex: 1; display: flex; flex-direction: column; gap: 25px; }

        .section-card {
            background: #FFFFFF;
            border-radius: 26px; /* Matched Rectangle 1395 */
            padding: 25px 25px 60px;
            border: 1px solid #D7D7D7; /* Matched Rectangle 1395 */
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            position: relative;
        }

        .section-header {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* â”€â”€â”€ CHART â”€â”€â”€ */
        .chart-box {
            position: relative;
            height: 300px;
            margin-top: 40px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 0 10px 0 60px;
        }

        .y-labels {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 500;
            color: #718096;
        }

        .y-labels span {
            transform: translateY(50%);
        }

        .grid-line {
            position: absolute;
            left: 45px;
            right: 0;
            height: 1px;
            border-top: 1px dashed #cbd5e0;
            z-index: 1;
        }
        
        /* The chart container that holds the bars */
        .bars-wrapper {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: flex-end;
            justify-content: space-between;
            position: relative;
            z-index: 2;
            padding-bottom: 30px; /* Space for x-axis labels */
        }

        .bar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            position: relative;
            width: 40px;
        }

        .bar-actual {
            width: 40px;
            position: absolute;
            bottom: 0;
            background: linear-gradient(180deg, #149AA3 0%, #08686E 100%);
            border-radius: 20px 20px 0px 0px;
            transition: height 0.5s ease;
            z-index: 2;
        }

        .x-label {
            position: absolute;
            bottom: -30px;
            font-size: 13px;
            color: #4a5568;
            font-weight: 500;
        }

        /* â”€â”€â”€ ENROLLED CLASSES â”€â”€â”€ */
        .enrolled-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px dashed #edf2f7;
            position: relative;
            padding-left: 15px;
        }

        .enrolled-item:last-child { border-bottom: none; }

        .color-bar {
            position: absolute;
            left: 0;
            top: 15px;
            bottom: 15px;
            width: 4px;
            border-radius: 2px;
        }

        .enrolled-info h4 { font-size: 14px; font-weight: 700; color: #2d3748; }
        .enrolled-info p { font-size: 12px; color: #a0aec0; margin-top: 2px; }

        .chevron svg { color: #cbd5e0; }

        /* â”€â”€â”€ COURSES â”€â”€â”€ */
        .course-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            margin-bottom: 15px;
        }

        .course-circ {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #e2e8f0;
            flex-shrink: 0;
        }

        .course-body { flex: 1; }
        .course-body h4 { font-size: 14px; font-weight: 700; }
        .course-body p { font-size: 12px; color: #a0aec0; }

        .progress-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .prog-bg {
            flex: 1;
            height: 6px;
            background: #f1f5f9;
            border-radius: 3px;
            overflow: hidden;
        }

        .prog-fill {
            height: 100%;
            background: linear-gradient(360deg, #08686E 0%, #149AA3 100%);
            border-radius: 3px;
        }

        .prog-val { font-size: 11px; font-weight: 800; color: #4a5568; }

        /* â”€â”€â”€ NOTES â”€â”€â”€ */
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 10px;
        }

        .note-column {
            background: #f8fafc;
            border-radius: 15px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .note-col-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
        }

        .note-col-head span {
            font-size: 13.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .count-badge {
            background: #f97316;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 6px;
        }

        .note-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .note-tag {
            font-size: 9px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .tag-med { background: #fff7ed; color: #f97316; }
        .tag-high { background: #fef2f2; color: #ef4444; }

        .note-text { font-size: 13px; color: #475569; line-height: 1.4; }

        .plus-btn-card {
            background: #fff;
            border-radius: 10px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e0;
            cursor: pointer;
            border: 1px dashed #e2e8f0;
        }

        .add-task-form {
            background: #fff;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e2e8f0;
        }

        .add-task-form input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .prio-row {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .prio-tag {
            font-size: 9px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #e2e8f0;
        }

        .prio-tag.low { background: #f0fdf4; color: #22c55e; }
        .prio-tag.med { background: #fff7ed; color: #f97316; }
        .prio-tag.high { background: #fef2f2; color: #ef4444; }

        .form-btns {
            display: flex;
            gap: 10px;
        }

        .btn-add {
            background: #003a70;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-cancel {
            background: #f1f5f9;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }



        @media (max-width: 1024px) {
            .wrapper { display: flex; flex-direction: column; }
            .sidebar { order: 2; min-height: auto; margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
            .content { order: 1; width: 100%; }
            .flex-container { flex-direction: column; }
            .notes-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            header { padding: 15px; position: fixed; height: auto; outline: none; border: none; background: none; box-shadow: none; z-index: 1000;}
            .header-pill { height: auto; padding: 15px; border-radius: 20px; flex-direction: column; gap: 15px; width: 100%; max-width: 100%; }
            .header-left { width: 100%; flex-wrap: wrap; justify-content: space-between; }
            .search-wrap { width: 100%; order: 3; margin-top: 5px; }
            .logo img { height: 32px; }
            .header-right { width: 100%; flex-wrap: wrap; justify-content: center; }
            
            .wrapper { padding: 180px 15px 30px; }
            .section-card { padding: 25px 15px; }

            .section-header { flex-direction: column; align-items: flex-start; gap: 15px; }
            .notes-header-actions { width: 100%; flex-direction: column !important; align-items: stretch !important; gap: 10px !important; }
            .notes-header-actions .search-wrap { width: 100% !important; margin-top: 0; order: auto; }
            .notes-header-actions .btn-add { width: 100%; justify-content: center; margin-top: 10px; }

            .sidebar { grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 20px 15px;}
        }

        @media (max-width: 480px) {
            .nav-link { font-size: 13px; padding: 10px; border-radius: 8px; justify-content: center; flex-direction: column; gap: 5px; text-align: center;}
            .chart-box { padding-left: 20px; }
            .bar-container { width: 25px; }
            .bar-actual { width: 25px; }
            .x-label { font-size: 10px; }
            .y-labels { font-size: 10px; }
            .sidebar { grid-template-columns: repeat(2, 1fr); }
            .course-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <div class="shared-shell">
        @include('partials.sidebar', ['activePage' => 'dashboard'])

        <main class="shared-content">
            <div class="flex-container">
                <div class="main-col">
                    <div class="section-card">
                        <div class="section-header">Dashboard</div>
                        <p style="font-size:13px; font-weight:700; margin-bottom:10px;">This Week</p>
                        
                        <div class="chart-box">
                            <div class="y-labels">
                                <span>5h</span><span>4h</span><span>3h</span><span>2h</span><span>1h</span><span>0</span>
                            </div>
                            <!-- Grid lines -->
                            <div class="grid-line" style="top:0%"></div>
                            <div class="grid-line" style="top:20%"></div>
                            <div class="grid-line" style="top:40%"></div>
                            <div class="grid-line" style="top:60%"></div>
                            <div class="grid-line" style="top:80%"></div>

                            <div class="bars-wrapper">
                                @php
                                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                    $vals = [80, 25, 80, 60, 40, 55, 15]; // Adjusted to match image exactly
                                @endphp
                                @foreach($days as $i => $day)
                                <div class="bar-container">
                                    <div class="bar-actual" style="height: {{ $vals[$i] }}%;"></div>
                                    <span class="x-label">{{ $day }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-header">Enrolled Courses</div>
                        <div class="enrolled-list">
                            <div class="enrolled-item">
                                <div class="color-bar" style="background:#003a70;"></div>
                                <div class="enrolled-info">
                                    <h4>Veterinary Nursing Assistant Course</h4>
                                    <p>09:00 AM - 10:00 AM</p>
                                </div>
                                <div class="chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></div>
                            </div>
                            <div class="enrolled-item">
                                <div class="color-bar" style="background:#22c55e;"></div>
                                <div class="enrolled-info">
                                    <h4>Building a Sustainable Startup</h4>
                                    <p>11:00 AM - 01:00 PM</p>
                                </div>
                                <div class="chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></div>
                            </div>
                            <div class="enrolled-item">
                                <div class="color-bar" style="background:#8b5cf6;"></div>
                                <div class="enrolled-info">
                                    <h4>Rajamangala Identity Course</h4>
                                    <p>01:00 PM - 01:30 PM</p>
                                </div>
                                <div class="chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></div>
                            </div>
                            <div class="enrolled-item">
                                <div class="color-bar" style="background:#f97316;"></div>
                                <div class="enrolled-info">
                                    <h4>Building Relationships</h4>
                                    <p>03:30 PM - 04:30 PM</p>
                                </div>
                                <div class="chevron"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="side-col">
                    <div class="section-card">
                        <div class="section-header">Courses</div>
                        <a href="{{ route('course.detail') }}" class="course-card" style="text-decoration:none; color:inherit;">
                            <div class="course-circ"></div>
                            <div class="course-body">
                                <h4>Veterinary Nursing Assistant Course</h4>
                                <p>12 hours</p>
                                <div class="progress-row">
                                    <div class="prog-bg"><div class="prog-fill" style="width: 50%;"></div></div>
                                    <span class="prog-val">50%</span>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('course.detail') }}" class="course-card" style="text-decoration:none; color:inherit;">
                            <div class="course-circ"></div>
                            <div class="course-body">
                                <h4>Building a Sustainable Startup</h4>
                                <p>32 hours</p>
                                <div class="progress-row">
                                    <div class="prog-bg"><div class="prog-fill" style="width: 90%;"></div></div>
                                    <span class="prog-val">90%</span>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('course.detail') }}" class="course-card" style="text-decoration:none; color:inherit;">
                            <div class="course-circ"></div>
                            <div class="course-body">
                                <h4>Rajamangala Identity Course</h4>
                                <p>32 hours</p>
                                <div class="progress-row">
                                    <div class="prog-bg"><div class="prog-fill" style="width: 100%;"></div></div>
                                    <span class="prog-val">100%</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> -->
            </div>

            <!-- Notes Section -->
            <div class="section-card">
                <div class="section-header">
                    Notes
                    <div class="notes-header-actions" style="display:flex; gap:15px; align-items:center;">
                        <div class="search-wrap" style="width:180px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" placeholder="Search here" style="height:32px; font-size:12px;">
                        </div>
                        <button class="btn-add" style="height:32px; padding:0 15px;">+ Add List</button>
                    </div>
                </div>

                <div class="notes-grid">
                    <div class="note-column">
                        <div class="note-col-head">
                            <span>Reminder <span class="count-badge">3</span></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/><circle cx="6" cy="12" r="1.5"/></svg>
                        </div>
                        <div class="note-card">
                            <span class="note-tag tag-med">Medium</span>
                            <p class="note-text">(New Feature) Task</p>
                        </div>
                        <div class="plus-btn-card"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                        
                        <!-- Inline Add Form as shown in image -->
                        <div class="add-task-form">
                            <input type="text" placeholder="Enter task">
                            <div class="prio-row">
                                <span class="prio-tag low">Low</span>
                                <span class="prio-tag med">Medium</span>
                                <span class="prio-tag high">High</span>
                            </div>
                            <div class="form-btns">
                                <button class="btn-add">+ Add Task</button>
                                <button class="btn-cancel">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="note-column">
                        <div class="note-col-head">
                            <span>To Do <span class="count-badge">3</span></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/><circle cx="6" cy="12" r="1.5"/></svg>
                        </div>
                        <div class="note-card">
                            <span class="note-tag tag-high">High</span>
                            <p class="note-text">(New Feature) Task</p>
                        </div>
                        <div class="plus-btn-card"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                    </div>

                    <div class="note-column" style="background:transparent; border:1px dashed #e2e8f0;">
                         <div class="add-task-form" style="border:none;">
                            <input type="text" placeholder="Edit list title..." style="font-weight:600; font-size:14px;">
                            <div class="form-btns">
                                <button class="btn-add">+ Add List</button>
                                <button class="btn-cancel" style="background:#fff; border:1px solid #e2e8f0;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>

