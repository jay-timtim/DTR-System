<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deduction Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #0a0a0a; --bg-container: rgba(26, 26, 26, 0.95); --bg-input: #1f1f1f;
            --text-primary: #ffffff; --text-secondary: #b0b0b0; --gold-primary: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.15); --border-color: #333;
        }
        .light-theme {
            --bg-main: #f4f5f7; --bg-container: #ffffff; --bg-input: #f8f9fa;
            --text-primary: #1a1a1a; --text-secondary: #6c757d; --gold-primary: #c59b27;
            --gold-glow: rgba(197, 155, 39, 0.1); --border-color: #e2e8f0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        body { background-color: var(--bg-main); color: var(--text-primary); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .settings-card { background: var(--bg-container); width: 100%; max-width: 550px; padding: 40px; border-radius: 24px; border: 1px solid var(--border-color); }
        .top-action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); padding: 10px 18px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .theme-toggle-btn { background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .header { margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: 800; color: var(--gold-primary); display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-size: 12px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin-bottom: 10px; }
        .input-group { display: flex; align-items: center; background: var(--bg-input); border: 2px solid var(--border-color); border-radius: 12px; padding-left: 15px; }
        .currency-symbol { color: var(--text-secondary); font-weight: 600; margin-right: 10px; }
        input[type="number"] { width: 100%; padding: 15px 15px 15px 0; font-size: 15px; background: transparent; border: none; color: var(--text-primary); outline: none; }
        .btn-submit { width: 100%; padding: 16px; background: var(--gold-primary); color: #000; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; text-transform: uppercase; cursor: pointer; }
        .alert-success { background: rgba(39, 174, 96, 0.15); border: 1px solid #27ae60; color: #2ecc71; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; }
    </style>
</head>
<body>
<div class="settings-card">
    <div class="top-action-bar">
        <a href="/admin" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <button type="button" class="theme-toggle-btn" onclick="toggleTheme()"><i class="fas fa-sun" id="themeIcon"></i></button>
    </div>

    <div class="header">
        <h1><i class="fas fa-percent"></i> Deduction Settings</h1>
        <p>Configure operational and fixed statutory payroll deduction parameters</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.deductions.update') }}" method="POST">
        @csrf

        <!-- TIME-BASED OPERATIONAL PENALTIES -->
        <h3 style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 5px; letter-spacing: 0.5px;">Time-Based Penalties</h3>

        <div class="form-group">
            <label for="late_rate_per_minute">Late Fee (Per Minute)</label>
            <div class="input-group">
                <span class="currency-symbol">₱</span>
                <input type="number" step="0.01" id="late_rate_per_minute" name="late_rate_per_minute" value="{{ old('late_rate_per_minute', $settings->late_rate_per_minute) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="undertime_rate_per_minute">Undertime Fee (Per Minute)</label>
            <div class="input-group">
                <span class="currency-symbol">₱</span>
                <input type="number" step="0.01" id="undertime_rate_per_minute" name="undertime_rate_per_minute" value="{{ old('undertime_rate_per_minute', $settings->undertime_rate_per_minute) }}" required>
            </div>
        </div>



        <button type="submit" class="btn-submit" style="margin-top: 15px;">Save Deduction Configurations</button>
    </form>
</div>

<script>
    function toggleTheme() {
        const body = document.body; const icon = document.getElementById('themeIcon');
        if (body.classList.contains('light-theme')) {
            body.classList.remove('light-theme'); icon.className = 'fas fa-sun'; localStorage.setItem('themePreference', 'dark');
        } else { body.classList.add('light-theme'); icon.className = 'fas fa-moon'; localStorage.setItem('themePreference', 'light'); }
    }
    (function applyTheme() {
        const savedTheme = localStorage.getItem('themePreference'); const icon = document.getElementById('themeIcon');
        if (savedTheme === 'light') { document.body.classList.add('light-theme'); if (icon) icon.className = 'fas fa-moon'; }
    })();
</script>
</body>
</html>
