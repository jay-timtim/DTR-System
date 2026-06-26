<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | View DTR Records</title>
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

        /* --- PRINT STYLES (PDF READY) --- */
        /* --- PRINT STYLES (PDF READY) --- */

        @media print {
            .export-group-ignore { display: none !important; }
        }

        @media print {
            @page { size: landscape; margin: 1cm; }
            body { background: white !important; color: black !important; background-image: none !important; }
            .sidebar, .filter-panel, .export-group, .topbar, .theme-toggle-btn { display: none !important; }
            .main { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            .table-container { background: white !important; border: none !important; box-shadow: none !important; padding: 0 !important; }
            table { width: 100% !important; border: 1px solid #ccc !important; }
            th { background: #f8f9fa !important; color: black !important; border: 1px solid #ccc !important; text-transform: uppercase; font-size: 10pt !important; }
            td { color: black !important; border: 1px solid #ccc !important; font-size: 9pt !important; padding: 5px !important; background: transparent !important; }
            .actual-time { color: black !important; font-weight: bold !important; }
            .sched-time { color: #555 !important; font-size: 8pt !important; }
            .status-badge { border: 1px solid #000 !important; color: black !important; background: transparent !important; }

            /* Updated layout for printing layout safely */
            .print-header {
                display: flex !important;
                justify-content: space-between;
                align-items: flex-end;
                flex-wrap: wrap;
                margin-bottom: 20px;
            }
            .print-header h1 { font-size: 20pt; color: black; margin: 0 0 5px 0; }
            .print-header p { margin: 0; }
            .print-header .text-right { text-align: right; }
        }

        /* Hides it completely on the web UI browser screen */
        .print-header { display: none; }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

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
        .main { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h1 { font-size: 24px; font-weight: 700; color: var(--text-main); letter-spacing: 0.5px; }

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

        .theme-toggle-btn:hover { border-color: var(--logo-gold); }

        /* FILTER PANEL */
        .filter-panel {
            background: var(--bg-container);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: background 0.3s ease;
        }

        .filter-panel h3 { margin-bottom: 20px; font-size: 15px; color: var(--accent-gold); text-transform: uppercase; }

        .filter-group { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }

        .filter-group input, .filter-group select {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-main);
            outline: none;
            font-size: 14px;
        }

        .btn-filter {
            background: var(--logo-gold);
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 12px;
        }

        /* EXPORT BUTTONS */
        .export-group { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; gap: 12px; }

        .btn-export { padding: 10px 18px; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; transition: 0.3s; text-transform: uppercase; border: 1px solid transparent; }
        .btn-excel { background: rgba(39, 174, 96, 0.1); color: #2ecc71; border-color: #27ae60; }
        .btn-excel:hover { background: #27ae60; color: white; }
        .btn-pdf { background: rgba(231, 76, 60, 0.1); color: #e74c3c; border-color: #c0392b; }
        .btn-pdf:hover { background: #e74c3c; color: white; }

        /* TABLE */
        .table-container {
            background: var(--bg-container);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow-x: auto;
            transition: background 0.3s ease;
        }

        table { width: 100%; border-collapse: collapse; min-width: 900px; }

        th { text-align: left; font-size: 12px; text-transform: uppercase; color: var(--logo-gold); padding: 15px; border-bottom: 2px solid var(--border-color); white-space: nowrap; }

        td { padding: 15px; font-size: 14px; color: var(--text-main); border-bottom: 1px solid var(--border-color); }

        tr:hover td { background: var(--row-hover); }

        /* ATTENDANCE STATUS */
        .status-badge { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .status-present { background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.3); }
        .status-late { background: rgba(241, 196, 15, 0.1); color: #f1c40f; border: 1px solid rgba(241, 196, 15, 0.3); }
        .status-absent { background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); }

        .time-container { display: flex; flex-direction: column; }
        .actual-time { font-family: monospace; color: var(--text-gold); font-weight: 600; font-size: 14px; }
        .sched-time { font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-top: 2px; }

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
    <a href="/view-dtr" class="active"><i class="fas fa-calendar-check" style="margin-right: 8px;"></i> View DTR Records</a>
    <a href="/reports"><i class="fas fa-file-invoice" style="margin-right: 8px;"></i> Reports</a>

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
    <div class="print-header">
        <div>
            <h1> {{config('app_settings.company_name', 'Company Name')}} </h1>
            <p>Daily Time Record - Detailed Attendance Logs</p>
        </div>
        <div class="text-right">
            <p>Date Generated: {{ date('M d, Y h:i A') }}</p>
        </div>
    </div>

    <div class="topbar">
        <h1>Detailed Attendance Logs</h1>
        <button id="theme-toggle" class="theme-toggle-btn">
            <span id="theme-icon">☀️</span>
            <span id="theme-text">Light Mode</span>
        </button>
    </div>

    <div class="filter-panel">
        <h3>Search & Filter</h3>
        <form method="GET" action="/view-dtr" id="filterForm">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search Name or ID..." value="{{ request('search') }}" style="width: 250px;">

                <select id="periodSelector" onchange="updateDateRange()">
                    <option value="custom" selected>Custom Range</option>
                    <option value="first_half">1st - 15th of the Month</option>
                    <option value="second_half">16th - End of Month</option>
                    <option value="full_month">Full Month (1 - 31)</option>
                    <option value="all">All Records</option>
                </select>

                <div id="dateInputs" style="display: flex; gap: 10px; align-items: center;">
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
                    <span style="color: var(--text-muted);">to</span>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
                </div>

                <button class="btn-filter" type="submit">Apply Filter</button>
            </div>
        </form>

        <div class="export-group">
            <button class="btn-export btn-excel" onclick="exportToExcel('dtrTable')">Excel Report</button>
            <button class="btn-export btn-pdf" onclick="exportToPDF()">PDF Document</button>
        </div>
    </div>

    <div class="table-container" id="dtrTableContainer">
        <table id="dtrTable">
            <thead>
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Employee Name</th>
                <th rowspan="2">Date</th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid var(--border-color); background: rgba(212, 175, 55, 0.05);">First Half (Morning)</th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid var(--border-color); background: rgba(212, 175, 55, 0.05);">First Time Out</th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid var(--border-color); background: rgba(212, 175, 55, 0.1);">Second Half (Afternoon)</th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid var(--border-color); background: rgba(212, 175, 55, 0.1);">Final Out</th>
                <th rowspan="2">Total Hours</th>
                <th rowspan="2" style="text-align: center;">Actions</th>
            </tr>
            <tr>
                <th style="font-size: 9px;">1st In <br><small>(Actual)</small></th>
                <th style="font-size: 9px;">Counted</th>
                <th style="font-size: 9px;">Remarks</th>
                <th style="font-size: 9px;">1st Out <br><small>(Actual)</small></th>
                <th style="font-size: 9px;">Counted</th>
                <th style="font-size: 9px;">Remarks</th>
                <th style="font-size: 9px;">2nd In <br><small>(Actual)</small></th>
                <th style="font-size: 9px;">Counted</th>
                <th style="font-size: 9px;">Remarks</th>
                <th style="font-size: 9px;">2nd Out <br><small>(Actual)</small></th>
                <th style="font-size: 9px;">Counted</th>
                <th style="font-size: 9px;">Remarks</th>
            </tr>
            </thead>

            <tbody>
            @if($records->isEmpty())
                <tr>
                    <td colspan="17" style="text-align:center; padding:50px; color:var(--text-muted);">No records found.</td>
                </tr>
            @else
                @foreach($records as $record)
                    @php
                        $sStart = $record->schedule_start ? \Carbon\Carbon::parse($record->date . ' ' . $record->schedule_start) : null;
                        $sBOut  = $record->break_start ? \Carbon\Carbon::parse($record->date . ' ' . $record->break_start) : null;
                        $sBIn   = $record->break_end ? \Carbon\Carbon::parse($record->date . ' ' . $record->break_end) : null;
                        $sEnd   = $record->schedule_end ? \Carbon\Carbon::parse($record->date . ' ' . $record->schedule_end) : null;

                        $t1In  = $record->time_in ? \Carbon\Carbon::parse($record->time_in) : null;
                        $t1Out = $record->break_out ? \Carbon\Carbon::parse($record->break_out) : null;
                        $t2In  = $record->break_in ? \Carbon\Carbon::parse($record->break_in) : null;
                        $t2Out = $record->time_out ? \Carbon\Carbon::parse($record->time_out) : null;

                        // Check if day is complete (all 4 punches must exist)
                        $isIncomplete = (!$t1In || !$t1Out || !$t2In || !$t2Out);

                        $c1In = ($t1In && $sStart && $t1In->gt($sStart)) ? $t1In : (($t1In && $sStart) ? $sStart : null);
                        $rem1In = ($t1In && $sStart && $t1In->gt($sStart)) ? 'LATE' : '✓';

                        $c1Out = ($t1Out && $sBOut && $t1Out->lt($sBOut)) ? $t1Out : (($t1Out && $sBOut) ? $sBOut : null);
                        $rem1Out = ($t1Out && $sBOut && $t1Out->lt($sBOut)) ? 'UNDERTIME' : '✓';

                        $c2In = ($t2In && $sBIn && $t2In->gt($sBIn)) ? $t2In : (($t2In && $sBIn) ? $sBIn : null);
                        $rem2In = ($t2In && $sBIn && $t2In->gt($sBIn)) ? 'LATE (BRK)' : '✓';

                        $c2Out = ($t2Out && $sEnd && $t2Out->lt($sEnd)) ? $t2Out : (($t2Out && $sEnd) ? $sEnd : null);
                        $rem2Out = ($t2Out && $sEnd && $t2Out->lt($sEnd)) ? 'UNDERTIME' : '✓';

                        $diff1 = ($c1In && $c1Out) ? $c1In->diffInMinutes($c1Out) : 0;
                        $diff2 = ($c2In && $c2Out) ? $c2In->diffInMinutes($c2Out) : 0;
                        $totalMinutes = $diff1 + $diff2;

                        $hours = floor(max(0, $totalMinutes) / 60);
                        $mins = max(0, $totalMinutes) % 60;
                    @endphp
                    <tr style="{{ $isIncomplete ? 'background: rgba(231, 76, 60, 0.04); border-left: 3px solid #e74c3c;' : '' }}">
                        <td style="color: var(--text-muted); font-size: 11px;">{{ $record->employee_id }}</td>
                        <td style="font-weight: 600; font-size: 12px;">{{ $record->first_name }} {{ $record->last_name }}</td>
                        <td style="font-size: 11px;">{{ \Carbon\Carbon::parse($record->date)->format('m/d/y') }}</td>

                        <td><span class="actual-time" style="font-size: 12px;">{{ $t1In ? $t1In->format('h:i A') : '--' }}</span></td>
                        <td style="color: var(--text-gold); font-weight: 700; font-size: 12px;">{{ $c1In ? $c1In->format('h:i A') : '--' }}</td>
                        <td style="color: #e74c3c; font-size: 9px; font-weight: bold;">{{ $rem1In }}</td>

                        <td><span class="actual-time" style="font-size: 12px;">{{ $t1Out ? $t1Out->format('h:i A') : '--' }}</span></td>
                        <td style="color: var(--text-gold); font-weight: 700; font-size: 12px;">{{ $c1Out ? $c1Out->format('h:i A') : '--' }}</td>
                        <td style="color: #e74c3c; font-size: 9px; font-weight: bold;">{{ $rem1Out }}</td>

                        <td><span class="actual-time" style="font-size: 12px;">{{ $t2In ? $t2In->format('h:i A') : '--' }}</span></td>
                        <td style="color: var(--text-gold); font-weight: 700; font-size: 12px;">{{ $c2In ? $c2In->format('h:i A') : '--' }}</td>
                        <td style="color: #e74c3c; font-size: 9px; font-weight: bold;">{{ $rem2In }}</td>

                        <td><span class="actual-time" style="font-size: 12px;">{{ $t2Out ? $t2Out->format('h:i A') : '--' }}</span></td>
                        <td style="color: var(--text-gold); font-weight: 700; font-size: 12px;">{{ $c2Out ? $c2Out->format('h:i A') : '--' }}</td>
                        <td style="color: #e74c3c; font-size: 9px; font-weight: bold;">{{ $rem2Out }}</td>

                        <td style="background: rgba(212, 175, 55, 0.05); font-family: monospace; font-weight: 800; text-align: center; font-size: 13px;">
                            {{ $hours }}h {{ $mins }}m
                        </td>

                        <td style="text-align: center;" class="export-group-ignore">
                            <button class="btn-filter" style="padding: 6px 12px; font-size: 11px;"
                                    onclick="openEditModal({
                                        id: '{{ $record->id }}',
                                        employee_id: '{{ $record->employee_id }}',
                                        name: '{{ $record->first_name }} {{ $record->last_name }}',
                                        date: '{{ $record->date }}',
                                        t1_in: '{{ $t1In ? $t1In->format('H:i') : '' }}',
                                        t1_out: '{{ $t1Out ? $t1Out->format('H:i') : '' }}',
                                        t2_in: '{{ $t2In ? $t2In->format('H:i') : '' }}',
                                        t2_out: '{{ $t2Out ? $t2Out->format('H:i') : '' }}'
                                    })">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

<div id="editLogModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div style="background: var(--bg-container); width: 100%; max-width: 450px; padding: 30px; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        <h3 style="color: var(--text-gold); margin-bottom: 5px; font-size: 18px;"><i class="fas fa-user-edit"></i> Adjust Attendance Times</h3>
        <p id="modalSubTitle" style="color: var(--text-muted); font-size: 12px; margin-bottom: 20px;"></p>

        <form id="editLogForm" method="POST" action="/admin/dtr/update">
            @csrf
            <input type="hidden" name="employee_id" id="modalEmployeeId">

            <input type="hidden" name="record_id" id="modalRecordId">
            <input type="hidden" name="record_date" id="modalRecordDate">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="font-size: 11px; color: var(--text-muted); display:block; margin-bottom:5px;">1st In (Morning)</label>
                    <input type="time" name="time_in" id="inputTimeIn" style="width:100%; padding:10px; background:var(--bg-input); border:1px solid var(--border-color); color:var(--text-primary); border-radius:6px;">
                </div>
                <div>
                    <label style="font-size: 11px; color: var(--text-muted); display:block; margin-bottom:5px;">1st Out (Break)</label>
                    <input type="time" name="break_out" id="inputBreakOut" style="width:100%; padding:10px; background:var(--bg-input); border:1px solid var(--border-color); color:var(--text-primary); border-radius:6px;">
                </div>
                <div>
                    <label style="font-size: 11px; color: var(--text-muted); display:block; margin-bottom:5px;">2nd In (Return)</label>
                    <input type="time" name="break_in" id="inputBreakIn" style="width:100%; padding:10px; background:var(--bg-input); border:1px solid var(--border-color); color:var(--text-primary); border-radius:6px;">
                </div>
                <div>
                    <label style="font-size: 11px; color: var(--text-muted); display:block; margin-bottom:5px;">2nd Out (End Shift)</label>
                    <input type="time" name="time_out" id="inputTimeOut" style="width:100%; padding:10px; background:var(--bg-input); border:1px solid var(--border-color); color:var(--text-primary); border-radius:6px;">
                </div>
            </div>

            <div style="display:flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-export" style="background:#444; color:#fff;" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-filter" style="border-radius:6px;">Save Changes</button>
            </div>
        </form>
    </div>
</div>


<script>
    function updateDateRange() {
        const selector = document.getElementById('periodSelector');
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');

        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth(); // 0-indexed

        // Helper to format date to YYYY-MM-DD
        const formatDate = (date) => date.toISOString().split('T')[0];

        switch(selector.value) {
            case 'first_half':
                startInput.value = formatDate(new Date(year, month, 1+1));
                endInput.value = formatDate(new Date(year, month, 15+1));
                break;
            case 'second_half':
                startInput.value = formatDate(new Date(year, month, 16+1));
                // Sets to last day of current month (day 0 of next month)
                endInput.value = formatDate(new Date(year, month + 1, 1));
                break;
            case 'full_month':
                startInput.value = formatDate(new Date(year, month, 1+1));
                endInput.value = formatDate(new Date(year, month + 1, 1));
                break;
            case 'all':
                startInput.value = "";
                endInput.value = "";
                break;
            default:
                // custom - do nothing, let user type
                break;
        }
    }

    // Keep the selection active if page reloads with these dates
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        // Add logic here if you want to auto-select the dropdown based on URL params
    });
    // --- THEME TOGGLE LOGIC ---
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const themeText = document.getElementById('theme-text');
    const body = document.body;

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

    /**
     * EXCEL EXPORT LOGIC
     */
    function exportToExcel(tableID) {
        let table = document.getElementById(tableID);
        let rows = table.querySelectorAll('tr');
        let csvContent = "";
        rows.forEach(row => {
            let rowData = [];
            let cols = row.querySelectorAll('th, td');
            cols.forEach(col => {
                let text = col.innerText.replace(/\n/g, " | ");
                rowData.push('"' + text.trim() + '"');
            });
            csvContent += rowData.join(",") + "\n";
        });
        let filename = 'DTR_Report_' + new Date().toISOString().slice(0,10) + '.csv';
        let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        let link = document.createElement("a");
        let url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", filename);
        link.click();
    }

    /**
     * PDF EXPORT LOGIC
     */
    function exportToPDF() {
        window.print();
    }

    // --- ADJUSTMENT MODAL CONTROLLERS ---
    function openEditModal(data) {
        document.getElementById('modalRecordId').value = data.id;
        document.getElementById('modalRecordDate').value = data.date;

        // Add this line so JavaScript maps the employee ID parameter to the input field frame
        document.getElementById('modalEmployeeId').value = data.employee_id;

        document.getElementById('modalSubTitle').innerText = `${data.name} — ${data.date}`;

        document.getElementById('inputTimeIn').value = data.t1_in;
        document.getElementById('inputTimeOut').value = data.t2_out;
        document.getElementById('inputBreakIn').value = data.t2_in;
        document.getElementById('inputBreakOut').value = data.t1_out;

        document.getElementById('editLogModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editLogModal').style.display = 'none';
    }



</script>

</body>
</html>
