<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | System Maintenance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #080808;
            --bg-container: #1a1a1a;
            --bg-card: #222222;
            --bg-input: #252525;
            --text-main: #f0f0f0;
            --text-muted: #b0b0b0;
            --logo-gold: #d4af37;
            --dark-gold: #a67c00;
            --text-gold: #ffd700;
            --border-color: #333;
            --danger-red: #ff6b6b;
            --danger-bg: rgba(231, 76, 60, 0.1);
        }

        body.light-mode {
            --bg-body: #f4f6f9;
            --bg-container: #ffffff;
            --bg-card: #f8f9fa;
            --bg-input: #ffffff;
            --text-main: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --logo-gold: #a67c00;
            --text-gold: #856404;
            --danger-red: #c0392b;
            --danger-bg: rgba(192, 57, 43, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background-color: var(--bg-body); color: var(--text-main); min-height: 100vh; transition: 0.3s; }

        .sidebar { width: 260px; height: 100vh; background: var(--bg-container); padding: 30px 20px; position: fixed; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 18px; font-weight: 800; color: var(--text-gold); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 40px; text-align: center; border-bottom: 2px solid var(--dark-gold); padding-bottom: 15px; }
        .sidebar a { display: block; color: var(--text-muted); text-decoration: none; padding: 14px 18px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(212, 175, 55, 0.1); color: var(--text-gold); }

        .main { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .theme-toggle-btn { background: var(--bg-container); border: 1px solid var(--border-color); color: var(--text-main); padding: 8px 15px; border-radius: 20px; cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        /* MAINTENANCE MODULE WORKSPACE LAYOUT */
        .maintenance-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .option-card {
            background: var(--bg-container);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .option-card:hover { border-color: var(--danger-red); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .option-card.selected { border-color: var(--danger-red); background: var(--danger-bg); }

        .option-card i { font-size: 28px; color: var(--danger-red); margin-bottom: 15px; }
        .option-card h3 { font-size: 16px; margin-bottom: 10px; font-weight: 600; }
        .option-card p { font-size: 13px; color: var(--text-muted); line-height: 1.5; }

        .radio-anchor { position: absolute; top: 20px; right: 20px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; }
        .option-card.selected .radio-anchor { border-color: var(--danger-red); }
        .option-card.selected .radio-anchor::after { content: ''; width: 10px; height: 10px; background: var(--danger-red); border-radius: 50%; }

        /* FORM MANAGEMENT WRAPPER BLOCK */
        .execution-panel { background: var(--bg-container); border: 1px solid var(--border-color); border-radius: 12px; padding: 35px; max-width: 600px; margin: 0 auto; display: none; }
        .warning-banner { background: rgba(231, 76, 60, 0.08); border-left: 4px solid var(--danger-red); padding: 15px; border-radius: 4px; margin-bottom: 25px; font-size: 13px; line-height: 1.5; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 12px 15px; border-radius: 6px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-main); outline: none; font-size: 14px; text-align: center; font-weight: 700; letter-spacing: 2px; }

        .btn-purge { width: 100%; background: var(--danger-red); color: white; border: none; padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; transition: 0.3s; }
        .btn-purge:disabled { opacity: 0.4; cursor: not-allowed; }

        /* SYSTEM ALERT STRIPS */
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; font-size: 14px; font-weight: 500; }
        .alert-success { background: rgba(46, 204, 113, 0.15); color: #2ecc71; border: 1px solid #2ecc71; }
        .alert-error { background: rgba(231, 76, 60, 0.15); color: #ff6b6b; border: 1px solid #e74c3c; }
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

    <a href="/admin" class="active"><i class="fas fa-chart-line" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="/manage-employees"><i class="fas fa-users" style="margin-right: 8px;"></i> Manage Employees</a>
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
            <a href="/admin/factory-reset" style="font-size: 13px; padding: 10px 15px; color: #ff6b6b;"><i class="fas fa-radiation" style="margin-right: 8px;"></i> Factory Reset</a>
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
        <h1>System Maintenance Settings</h1>
        <button id="theme-toggle" class="theme-toggle-btn">
            <span id="theme-icon">☀️</span>
            <span id="theme-text">Light Mode</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="maintenance-grid">
        <div class="option-card" onclick="selectResetTarget('attendance_only', this)">
            <div class="radio-anchor"></div>
            <i class="fas fa-clock-rotate-left"></i>
            <h3>Clear Attendance Logs</h3>
            <p>Completely empties the <code>attendance_logs</code> data. Useful at the start of a new fiscal cycle or testing phase. Employee configurations remain untouched.</p>
        </div>

        <div class="option-card" onclick="selectResetTarget('employees_only', this)">
            <div class="radio-anchor"></div>
            <i class="fas fa-users-slash"></i>
            <h3>Purge Employee Directory</h3>
            <p>Deletes all registered users inside the <code>employees</code> directory table database. Leaves baseline application system structural definitions active.</p>
        </div>

        <div class="option-card" onclick="selectResetTarget('full_system', this)">
            <div class="radio-anchor"></div>
            <i class="fas fa-dumpster-fire"></i>
            <h3>Full Factory Reset</h3>
            <p>Drops all tables entirely, rebuilds the baseline application migration blueprints, and executes default database seed scripts sequentially.</p>
        </div>
    </div>

    <div class="execution-panel" id="actionPanel">
        <div class="warning-banner">
            <i class="fas fa-exclamation-triangle"></i> <strong>CRITICAL WARNING:</strong> <span id="warningText">This operation cannot be reversed. Please make sure you have an external backup before running this query.</span>
        </div>

        <form action="{{ route('admin.reset-execute') }}" method="POST" id="maintenanceForm">
            @csrf
            <input type="hidden" name="reset_target" id="hiddenTargetField">

            <div class="form-group">
                <label id="verificationLabel">Type "RESET" to confirm authorization:</label>
                <input type="text" id="confirmPhrase" name="confirm_phrase" placeholder="RESET" autocomplete="off" required>
            </div>

            <button type="submit" class="btn-purge" id="submitPurgeBtn" disabled>Execute Selected Purge</button>
        </form>
    </div>
</div>

<script>
    function selectResetTarget(targetType, element) {
        // Remove selection states from other sibling elements
        document.querySelectorAll('.option-card').forEach(card => card.classList.remove('selected'));

        // Highlight active targeted option card component
        element.classList.add('selected');

        // Set structural configurations on form elements
        document.getElementById('hiddenTargetField').value = targetType;
        document.getElementById('confirmPhrase').value = '';
        document.getElementById('submitPurgeBtn').disabled = true;

        const actionPanel = document.getElementById('actionPanel');
        const warningText = document.getElementById('warningText');
        actionPanel.style.display = 'block';

        // Tailor contextual warning copy blocks dynamically
        if(targetType === 'attendance_only') {
            warningText.innerHTML = "You are about to permanently erase all records from the <strong>attendance_logs</strong> database. This will destroy all calculated hours and check-in records.";
        } else if(targetType === 'employees_only') {
            warningText.innerHTML = "You are about to completely wipe the <strong>employees</strong> database table. Profiles, basic salary details, and individual scheduling architectures will be deleted.";
        } else if(targetType === 'full_system') {
            warningText.innerHTML = "<strong>CRITICAL SYSTEM FLUSH:</strong> This will drop all database assets entirely. The application will log you out, clear core caches, and build your layout fresh from seed records.";
        }

        // Auto-focus confirmation box
        document.getElementById('confirmPhrase').focus();
    }

    // Monitor confirmation entry matching to toggle lockout constraints
    document.getElementById('confirmPhrase').addEventListener('input', function() {
        const btn = document.getElementById('submitPurgeBtn');
        if(this.value.trim() === 'RESET') {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });

    // Provide visual load state feedback during heavy artisan processing executions
    document.getElementById('maintenanceForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitPurgeBtn');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Processing Database Purge...';
        btn.disabled = true;
    });

    // Theme Management Controls Sync Engine
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
</script>
</body>
</html>
