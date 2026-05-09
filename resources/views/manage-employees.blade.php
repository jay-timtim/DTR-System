<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | Manage Employees</title>
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

        /* PRINT STYLES */
        @media print {
            .sidebar, .topbar, .search-bar, .view-switcher, .actions, .modal, .theme-toggle-btn, .btn-add, .btn-export-group {
                display: none !important;
            }
            .main { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            .table-container { box-shadow: none !important; border: 1px solid #ccc !important; width: 100% !important; }
            body { background: white !important; color: black !important; }
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid #ddd !important; color: black !important; font-size: 10pt !important; }
            .employee-photo { width: 30px !important; height: 30px !important; }
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body { display: flex; background-color: var(--bg-body); color: var(--text-main); min-height: 100vh; transition: 0.3s; }

        .sidebar { width: 260px; height: 100vh; background: var(--bg-container); padding: 30px 20px; position: fixed; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; z-index: 100; }
        .sidebar h2 { font-size: 18px; font-weight: 800; color: var(--text-gold); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 40px; text-align: center; border-bottom: 2px solid var(--dark-gold); padding-bottom: 15px; }
        .sidebar a { display: block; color: var(--text-muted); text-decoration: none; padding: 14px 18px; border-radius: 8px; margin-bottom: 8px; transition: 0.3s; font-size: 14px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(212, 175, 55, 0.1); color: var(--text-gold); }

        .main { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }

        .view-switcher { display: flex; gap: 10px; margin-bottom: 20px; background: var(--bg-container); padding: 5px; border-radius: 10px; width: fit-content; border: 1px solid var(--border-color); }
        .view-btn { padding: 8px 20px; border: none; background: transparent; color: var(--text-muted); cursor: pointer; border-radius: 8px; font-size: 13px; font-weight: 600; transition: 0.3s; }
        .view-btn.active { background: var(--logo-gold); color: black; }

        .btn-export-group { display: flex; gap: 10px; margin-bottom: 20px; }
        .btn-export { padding: 8px 15px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--bg-container); color: var(--text-main); cursor: pointer; font-size: 12px; font-weight: 600; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-export:hover { border-color: var(--logo-gold); color: var(--text-gold); }

        .search-bar { margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .search-bar input { padding: 12px 20px; width: 350px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-container); color: var(--text-main); outline: none; }

        .table-container { background: var(--bg-container); padding: 25px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 12px; text-transform: uppercase; color: var(--logo-gold); padding: 15px; border-bottom: 2px solid var(--border-color); }
        td { padding: 15px; font-size: 14px; color: var(--text-main); border-bottom: 1px solid var(--border-color); }
        tr:hover td { background: var(--row-hover); }

        .employee-photo { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--dark-gold); }
        .hidden { display: none; }

        .btn-add { background: var(--logo-gold); color: #000; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; text-transform: uppercase; font-size: 13px; }
        .btn-edit { background: rgba(212, 175, 55, 0.1); color: var(--text-gold); padding: 8px 12px; border-radius: 6px; text-decoration: none; border: 1px solid var(--dark-gold); font-size: 12px; }
        .btn-delete { background: rgba(231, 76, 60, 0.1); color: #ff6b6b; padding: 8px 12px; border-radius: 6px; border: 1px solid #962d22; cursor: pointer; font-size: 12px; }

        .currency-symbol { position: absolute; left: 12px; color: var(--text-gold); font-weight: 600; pointer-events: none; }
        .salary-input-wrapper { position: relative; display: flex; align-items: center; }

        /* Modal Styles */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); justify-content: center; align-items: center; z-index: 1000; backdrop-filter: blur(5px); }
        .modal-content { background: var(--bg-container); padding: 35px; border-radius: 15px; width: 600px; border-top: 5px solid var(--logo-gold); max-height: 90vh; overflow-y: auto; }
        /* MODAL STYLING */

        .modal {

            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0,0,0,0.85);

            justify-content: center;

            align-items: center;

            z-index: 1000;

            backdrop-filter: blur(5px);

        }



        .modal-content {

            background: var(--bg-container);

            padding: 35px;

            border-radius: 15px;

            width: 550px;

            border-top: 5px solid var(--logo-gold);

            box-shadow: 0 20px 50px rgba(0,0,0,0.5);

            max-height: 90vh;

            overflow-y: auto;

        }



        .modal-content h3 {

            color: var(--text-gold);

            margin-bottom: 20px;

            text-transform: uppercase;

        }



        .form-group label {

            display: block;

            font-size: 12px;

            color: var(--text-muted);

            margin-bottom: 5px;

            text-transform: uppercase;

        }



        .form-group input, .form-group select {

            width: 100%;

            padding: 12px;

            border-radius: 6px;

            background: var(--bg-input);

            border: 1px solid var(--border-color);

            color: var(--text-main);

            outline: none;

        }



        .schedule-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 15px;

            background: var(--row-hover);

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 20px;

        }



        .modal-actions {

            display: flex;

            justify-content: flex-end;

            gap: 12px;

            margin-top: 25px;

        }



        .btn-save {

            background: var(--logo-gold);

            color: black;

            border: none;

            padding: 10px 25px;

            border-radius: 6px;

            font-weight: 700;

            cursor: pointer;

        }



        .btn-cancel {

            background: var(--border-color);

            color: var(--text-main);

            border: none;

            padding: 10px 25px;

            border-radius: 6px;

            cursor: pointer;

        }



        .salary-input-wrapper {

            position: relative;

            display: flex;

            align-items: center;

        }



        .currency-symbol {

            position: absolute;

            left: 12px;

            color: var(--text-gold); /* Or your preferred color */

            font-weight: 600;

            pointer-events: none;

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
    <a href="/manage-employees" class="active"><i class="fas fa-users" style="margin-right: 8px;"></i> Manage Employees</a>
    <a href="/view-dtr"><i class="fas fa-calendar-check" style="margin-right: 8px;"></i> View DTR Records</a>
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
    <div class="topbar">
        <h1>Employee Directory</h1>
        <div style="display: flex; align-items: center; gap: 15px;">
            <button id="theme-toggle" class="theme-toggle-btn" style="background:var(--bg-container); border:1px solid var(--border-color); color:var(--text-main); padding:8px 15px; border-radius:20px; cursor:pointer;">
                <span id="theme-icon">☀️</span>
                <span id="theme-text">Light Mode</span>
            </button>
            <button class="btn-add" onclick="openModal()">+ Add Employee</button>
        </div>
    </div>

    <div class="view-switcher">
        <button class="view-btn active" onclick="switchTable('general')">General Information</button>
        <button class="view-btn" onclick="switchTable('schedule')">Work Schedules</button>
    </div>

    <div class="search-bar">
        <input type="text" id="employeeSearch" placeholder="Filter current view...">
        <div class="btn-export-group">
            <button class="btn-export" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i> Export Excel</button>
            <button class="btn-export" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Print PDF</button>
        </div>
    </div>

    <div id="general-table-container" class="table-container">
        <table id="generalTable">
            <thead>
            <tr>
                <th>Profile</th>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Status</th>
                <th class="actions">Actions</th>
            </tr>
            </thead>
            <tbody class="employee-tbody">
            @foreach($employees as $employee)
                <tr>
                    <td><img src="{{ $employee->photo_path ? asset('storage/'.$employee->photo_path) : 'https://i.pravatar.cc/40?img='.$loop->index }}" class="employee-photo"></td>
                    <td style="font-family: monospace; color: var(--accent-gold);">{{ $employee->employee_id }}</td>
                    <td style="font-weight: 600;">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->position }}</td>
                    <td style="color: var(--text-gold);">₱{{ number_format($employee->basic_salary, 2) }}</td>
                    <td><span style="color: {{ $employee->employment_status == 'Regular' ? '#2ecc71' : '#f1c40f' }}">{{ $employee->employment_status }}</span></td>
                    <td class="actions">
                        <div class="actions">
                            <a href="{{ route('employees.edit',$employee->employee_id) }}" class="btn-edit">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div id="schedule-table-container" class="table-container hidden">
        <table id="scheduleTable">
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Shift Start</th>
                <th>Break Time</th>
                <th>Shift End</th>
                <th>Department</th>
                <th class="actions">Actions</th>
            </tr>
            </thead>
            <tbody class="employee-tbody">
            @foreach($employees as $employee)
                <tr>
                    <td style="font-family: monospace; color: var(--accent-gold);">{{ $employee->employee_id }}</td>
                    <td style="font-weight: 600;">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td style="color: #2ecc71;">{{ \Carbon\Carbon::parse($employee->schedule_start)->format('h:i A') }}</td>
                    <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($employee->break_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($employee->break_end)->format('h:i A') }}</td>
                    <td style="color: #ff6b6b;">{{ \Carbon\Carbon::parse($employee->schedule_end)->format('h:i A') }}</td>
                    <td>{{ $employee->department }}</td>
                    <td class="actions">
                        <a href="{{ route('employees.edit',$employee->employee_id) }}" class="btn-edit">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal remains mostly the same, but inherits CSS Variable improvements -->

<div class="modal" id="employeeModal">

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="modal-content">

            <h3>Register New Employee</h3>



            <div class="form-group">

                <label>Employee ID Assignment</label>

                <div style="font-weight:800; font-size:18px; color:var(--text-gold); padding: 10px; background: rgba(0,0,0,0.3); border-radius: 5px;" id="generatedEmployeeId">

                    AUTO-GENERATED

                </div>

            </div>



            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">

                <div class="form-group"><label>First Name</label><input type="text" name="first_name" required></div>

                <div class="form-group"><label>Middle Name</label><input type="text" name="middle_name" placeholder="Optional"></div>

                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required></div>

            </div>



            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

                <div class="form-group">

                    <label>Birthday</label>

                    <input type="date" name="birthday" required>

                </div>

                <div class="form-group">

                    <label>Gender</label>

                    <select name="gender" required>

                        <option value="Male">Male</option>

                        <option value="Female">Female</option>

                    </select>

                </div>

            </div>



            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

                <div class="form-group">

                    <label>Department</label>

                    <input type="text" name="department" placeholder="e.g. IT Department" required>

                </div>

                <div class="form-group">

                    <label>Position</label>

                    <input type="text" name="position" placeholder="e.g. Software Engineer" required>

                </div>

            </div>



            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

                <div class="form-group">

                    <label>Date Hired</label>

                    <input type="date" name="date_hired" id="datePicker" required>

                </div>

                <div class="form-group">

                    <label>Basic Salary</label>

                    <div class="salary-input-wrapper">

                        <span class="currency-symbol">₱</span>

                        <input type="number" name="basic_salary" step="0.01" placeholder="0.00" style="padding-left: 30px;" required>

                    </div>

                </div>

            </div>



            <div class="form-group">

                <label>Employment Status</label>

                <select name="employment_status">

                    <option value="Regular">Regular</option>

                    <option value="Probationary">Probationary</option>

                    <option value="Contractual">Contractual</option>

                </select>

            </div>



            <div class="form-group"><label>Home Address</label><input type="text" name="address" required></div>



            <h4 style="color: var(--logo-gold); font-size: 13px; margin: 20px 0 10px; text-transform: uppercase;">Work Schedule</h4>

            <div class="schedule-grid">

                <div class="form-group"><label>Start</label><input type="time" name="schedule_start"></div>

                <div class="form-group"><label>End</label><input type="time" name="schedule_end"></div>

                <div class="form-group"><label>Break Start</label><input type="time" name="break_start"></div>

                <div class="form-group"><label>Break End</label><input type="time" name="break_end"></div>

            </div>



            <div class="form-group"><label>Profile Picture</label><input type="file" name="photo_path"></div>



            <div class="modal-actions">

                <button type="button" class="btn-cancel" onclick="closeModal()">Dismiss</button>

                <button type="submit" class="btn-save">Confirm Registration</button>

            </div>

        </div>

    </form>

</div>
<script>
    let activeTableId = 'generalTable';

    function switchTable(view) {
        const genContainer = document.getElementById('general-table-container');
        const schedContainer = document.getElementById('schedule-table-container');
        const btns = document.querySelectorAll('.view-btn');

        btns.forEach(btn => btn.classList.remove('active'));

        if(view === 'general') {
            genContainer.classList.remove('hidden');
            schedContainer.classList.add('hidden');
            btns[0].classList.add('active');
            activeTableId = 'generalTable';
        } else {
            genContainer.classList.add('hidden');
            schedContainer.classList.remove('hidden');
            btns[1].classList.add('active');
            activeTableId = 'scheduleTable';
        }
    }

    // Dynamic Search Filter for both tables
    document.getElementById("employeeSearch").addEventListener("keyup", function () {
        let searchValue = this.value.toLowerCase();
        document.querySelectorAll(".employee-tbody tr").forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchValue) ? "" : "none";
        });
    });

    // Excel Export Logic (Exports only the visible table)
    function exportToExcel() {
        const table = document.getElementById(activeTableId);
        let csv = [];
        const rows = table.querySelectorAll("tr");

        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                // Exclude the Actions column from export
                if (cols[j].classList.contains('actions')) continue;

                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/,/g, ";");
                row.push(data);
            }
            csv.push(row.join(","));
        }

        const csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", activeTableId + "_" + new Date().toLocaleDateString() + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Theme Logic
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const themeText = document.getElementById('theme-text');
    const body = document.body;

    // Check localStorage for preference on load
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'light') {
        body.classList.add('light-mode');
        themeIcon.innerText = '🌙';
        themeText.innerText = 'Dark Mode';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light-mode');

        if (body.classList.contains('light-mode')) {
            localStorage.setItem('theme', 'light');
            themeIcon.innerText = '🌙';
            themeText.innerText = 'Dark Mode';
        } else {
            localStorage.setItem('theme', 'dark');
            themeIcon.innerText = '☀️';
            themeText.innerText = 'Light Mode';
        }
    });

    function openModal() { document.getElementById('employeeModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('employeeModal').style.display = 'none'; }

    document.addEventListener('DOMContentLoaded', function() {

// Set default date to today

        const dateInput = document.getElementById('datePicker');

        const today = new Date().toISOString().split('T')[0];

        dateInput.value = today;

    });

</script>

</body>
</html>
