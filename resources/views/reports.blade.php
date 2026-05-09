<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* DEFAULT DARK MODE COLORS */
            --bg-body: #080808;
            --bg-container: #1a1a1a;
            --bg-card: #222222;
            --bg-input: #222;

            --text-main: #f0f0f0;
            --text-muted: #b0b0b0;

            --logo-gold: #d4af37;
            --accent-gold: #f5e0a0;
            --dark-gold: #a67c00;
            --text-gold: #ffd700;

            --border-color: #333;
            --row-hover: rgba(255, 255, 255, 0.02);
            --gradient-color: rgba(255, 215, 0, 0.05);
        }

        /* LIGHT MODE OVERRIDES */
        body.light-mode {
            --bg-body: #f4f6f9;
            --bg-container: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #f8f9fa;

            --text-main: #212529;
            --text-muted: #6c757d;

            --border-color: #dee2e6;
            --row-hover: rgba(0, 0, 0, 0.03);
            --gradient-color: rgba(212, 175, 55, 0.1);

            --logo-gold: #a67c00;
            --text-gold: #856404;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background-color: var(--bg-body);
            background-image: radial-gradient(circle at top right, var(--gradient-color) 0%, rgba(0,0,0,0) 50%);
            color: var(--text-main);
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--bg-container);
            padding: 30px 20px;
            position: fixed;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .sidebar h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 40px;
            text-align: center;
            border-bottom: 2px solid var(--dark-gold);
            padding-bottom: 15px;
        }

        .sidebar a {
            display: block;
            color: var(--text-muted);
            text-decoration: none;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--text-gold);
            padding-left: 25px;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: 0.5px;
        }

        /* THEME TOGGLE BUTTON */
        .theme-toggle-btn {
            background: var(--bg-container);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .theme-toggle-btn:hover {
            border-color: var(--logo-gold);
        }

        /* ANALYTICS CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            border-top: 3px solid var(--dark-gold);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .card:hover {
            border-color: var(--logo-gold);
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
        }

        .card p {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-gold);
            margin-top: 10px;
        }

        /* FILTER PANEL */
        .filter-panel {
            background: var(--bg-container);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: background 0.3s ease;
        }

        .filter-panel h3 {
            margin-bottom: 20px;
            font-size: 15px;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group input,
        .filter-group select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-main);
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .filter-group input:focus, .filter-group select:focus {
            border-color: var(--logo-gold);
        }

        .btn-generate {
            background: var(--logo-gold);
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 12px;
        }

        .btn-generate:hover {
            background: var(--text-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        /* TABLE */
        .table-container {
            background: var(--bg-container);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: background 0.3s ease;
        }

        .table-header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header-box h3 {
            color: var(--accent-gold);
            font-size: 16px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--logo-gold);
            padding: 15px;
            border-bottom: 2px solid var(--border-color);
            letter-spacing: 1px;
        }

        td {
            padding: 15px;
            font-size: 14px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover td {
            background: var(--row-hover);
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .status-pending {
            background: rgba(241, 196, 15, 0.1);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.3);
        }

        .time-text {
            font-family: monospace;
            color: var(--accent-gold);
        }

    </style>
</head>

<body>

<div class="sidebar">
    <div class="sidebar-logo-container" style="text-align: center; margin-bottom: 15px; padding: 10px 0;">
        <img src="{{ config('app_settings.company_logo') ? asset('storage/' . config('app_settings.company_logo')) : asset('Picture/Default Logo.png') }}"
             alt="Company Logo"
             style="max-width: 80px; max-height: 80px; width: auto; height: auto; object-fit: contain; border-radius: 8px;">
    </div>

    <h2>{{ config('app_settings.company_name', 'Company Name') }}</h2>

    <a href="/admin"><i class="fas fa-chart-line" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="/manage-employees"><i class="fas fa-users" style="margin-right: 8px;"></i> Manage Employees</a>
    <a href="/view-dtr"><i class="fas fa-calendar-check" style="margin-right: 8px;"></i> View DTR Records</a>
    <a href="/reports" class="active"><i class="fas fa-file-invoice" style="margin-right: 8px;"></i> Reports</a>

    <div class="settings-dropdown">
        <a href="javascript:void(0)" class="dropdown-trigger" onclick="toggleSettingsMenu()" style="display: flex; justify-content: space-between; align-items: center;">
            <span><i class="fas fa-cog" style="margin-right: 8px;"></i> Settings</span>
            <i class="fas fa-chevron-down" id="settingsChevron" style="font-size: 11px; transition: transform 0.3s;"></i>
        </a>
        <div class="dropdown-container" id="settingsSubMenu" style="display: none; background: rgba(0, 0, 0, 0.2); padding-left: 15px; border-radius: 8px;">
            <a href="/admin/change-password" style="font-size: 13px; padding: 10px 15px;"><i class="fas fa-key" style="margin-right: 8px;"></i> Change Password</a>
            <a href="/admin/salary-calculator" style="font-size: 13px; padding: 10px 15px;"><i class="fas fa-calculator" style="margin-right: 8px;"></i> Salary Calculator</a>
            <a href="/admin/deductions" style="font-size: 13px; padding: 10px 15px;"><i class="fas fa-percent" style="margin-right: 8px;"></i> Deduction Settings</a>
            <a href="/admin/settings" style="font-size: 13px; padding: 10px 15px;"><i class="fas fa-sliders-h" style="margin-right: 8px;"></i> System Settings</a>
            <a href="/admin/settings#factory-reset" style="font-size: 13px; padding: 10px 15px; color: #ff6b6b;"><i class="fas fa-radiation" style="margin-right: 8px;"></i> Factory Reset</a>
        </div>
    </div>
    <a style="margin-top: auto; color: #ff6b6b;" href="/logout"><i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout</a>
</div>

<script>
    function toggleSettingsMenu() {
        const subMenu = document.getElementById('settingsSubMenu');
        const chevron = document.getElementById('settingsChevron');

        if (subMenu.style.display === "none" || subMenu.style.display === "") {
            subMenu.style.display = "block";
            chevron.style.transform = "rotate(180deg)";
        } else {
            subMenu.style.display = "none";
            chevron.style.transform = "rotate(0deg)";
        }
    }

    // Keep menu open automatically if we are currently visiting a settings sub-page
    document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.pathname;
        if (currentUrl.includes('/admin/change-password') ||
            currentUrl.includes('/admin/salary-calculator') ||
            currentUrl.includes('/admin/deductions') ||
            currentUrl.includes('/admin/settings')) {
            toggleSettingsMenu();
        }
    });
</script>

<div class="main">

    <div class="topbar">
        <h1>Analytics & Reports</h1>
        <button id="theme-toggle" class="theme-toggle-btn">
            <span id="theme-icon">☀️</span>
            <span id="theme-text">Light Mode</span>
        </button>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Total System Logs</h3>
            <p>{{ $totalAttendance }}</p>
        </div>

        <div class="card">
            <h3>Top Performer</h3>
            <p>{{ $mostPresentName ?? 'N/A' }}</p>
        </div>

        <div class="card">
            <h3>Late Arrivals (Today)</h3>
            <p>{{ $lateToday }}</p>
        </div>
    </div>

    <div class="filter-panel">
        <h3>Report Parameters</h3>
        <form method="GET" action="/reports">
            <div class="filter-group">
                <select name="employee_id">
                    <option value="">Full Staff Report</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->employee_id }}">
                            {{ $emp->employee_id }} - {{ $emp->first_name }} {{ $emp->last_name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="start_date">
                <span style="color: var(--text-muted);">to</span>
                <input type="date" name="end_date">

                <button class="btn-generate" type="submit">
                    Run Analysis
                </button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-header-box">
            <h3>Document Preview</h3>
        </div>

        <table>
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Staff Name</th>
                <th>Log Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            @if($records->isEmpty())
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--text-muted); padding:40px;">
                        No data found for the selected parameters.
                    </td>
                </tr>
            @else
                @foreach($records as $record)
                    <tr>
                        <td style="color: var(--text-muted);">{{ $record->employee_id }}</td>
                        <td style="font-weight: 600;">{{ $record->first_name }} {{ $record->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}</td>
                        <td class="time-text">
                            {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '—' }}
                        </td>
                        <td class="time-text">
                            {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '—' }}
                        </td>
                        <td>
                            @if($record->status == 'SECOND TIME OUT')
                                <span class="status-pill status-completed">COMPLETED</span>
                            @else
                                <span class="status-pill status-pending">IN PROGRESS</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $records->links() }}
        </div>
    </div>

</div>

<script>
    // --- THEME TOGGLE LOGIC ---
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const themeText = document.getElementById('theme-text');
    const body = document.body;

    // Check localStorage on load
    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-mode');
        themeIcon.innerText = '🌙';
        themeText.innerText = 'Dark Mode';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light-mode');
        const isLight = body.classList.contains('light-mode');

        localStorage.setItem('theme', isLight ? 'light' : 'dark');

        themeIcon.innerText = isLight ? '🌙' : '☀️';
        themeText.innerText = isLight ? 'Dark Mode' : 'Light Mode';
    });
</script>

</body>
</html>
