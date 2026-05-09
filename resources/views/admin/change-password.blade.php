<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIZMATECH | Account Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #0a0a0a;
            --bg-container: rgba(26, 26, 26, 0.95);
            --bg-input: #1f1f1f;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --gold-primary: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.15);
            --border-color: #333;
            --btn-shadow: rgba(0, 0, 0, 0.4);
            --icon-color: #d4af37;
        }

        .light-theme {
            --bg-main: #f4f5f7;
            --bg-container: #ffffff;
            --bg-input: #f8f9fa;
            --text-primary: #1a1a1a;
            --text-secondary: #6c757d;
            --gold-primary: #c59b27;
            --gold-glow: rgba(197, 155, 39, 0.1);
            --border-color: #e2e8f0;
            --btn-shadow: rgba(0, 0, 0, 0.05);
            --icon-color: #c59b27;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .settings-card {
            background: var(--bg-container);
            width: 100%;
            max-width: 550px;
            padding: 40px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 50px var(--btn-shadow);
            backdrop-filter: blur(10px);
        }

        .top-action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-back:hover {
            border-color: var(--gold-primary);
            transform: translateX(-3px);
        }

        .theme-toggle-btn {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--gold-primary);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--gold-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            font-size: 15px;
            border-radius: 12px;
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
        }

        input[type="password"] {
            padding-right: 50px;
        }

        input:focus {
            border-color: var(--gold-primary);
            outline: none;
            box-shadow: 0 0 15px var(--gold-glow);
        }

        .password-toggle-icon {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 16px;
        }

        .password-toggle-icon:hover {
            color: var(--gold-primary);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--gold-primary);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 10px 20px var(--gold-glow);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .alert-success {
            background: rgba(39, 174, 96, 0.15);
            border: 1px solid #27ae60;
            color: #2ecc71;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.15);
            border: 1px solid #e74c3c;
            color: #ea5455;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="settings-card">
    <div class="top-action-bar">
        <a href="/admin" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <button type="button" class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()">
            <i class="fas fa-sun" id="themeIcon"></i>
        </button>
    </div>

    <div class="header">
        <h1><i class="fas fa-user-cog" style="color: var(--icon-color);"></i> Account Settings</h1>
        <p>Update your administrator panel access username and password credentials</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <ul style="list-style: none; padding-left: 0;">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="username">Admin Username</label>
            <div class="input-wrapper">
                <input type="text" id="username" name="username" required value="{{ old('username', $admin->username ?? '') }}" placeholder="Enter username">
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 25px 0;">

        <div class="form-group">
            <label for="current_password">Current Password (Required to Save)</label>
            <div class="input-wrapper">
                <input type="password" id="current_password" name="current_password" required placeholder="Verify current admin password">
                <i class="far fa-eye password-toggle-icon" onclick="toggleFieldVisibility('current_password', this)"></i>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password">New Password (Leave blank to keep current)</label>
            <div class="input-wrapper">
                <input type="password" id="new_password" name="new_password" minlength="8" placeholder="Minimum 8 characters">
                <i class="far fa-eye password-toggle-icon" onclick="toggleFieldVisibility('new_password', this)"></i>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <div class="input-wrapper">
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Retype new password">
                <i class="far fa-eye password-toggle-icon" onclick="toggleFieldVisibility('new_password_confirmation', this)"></i>
            </div>
        </div>

        <button type="submit" class="btn-submit">Save Settings</button>
    </form>
</div>

<script>
    function toggleFieldVisibility(fieldId, iconElement) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            iconElement.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            field.type = "password";
            iconElement.classList.replace("fa-eye-slash", "fa-eye");
        }
    }

    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('themeIcon');
        if (body.classList.contains('light-theme')) {
            body.classList.remove('light-theme');
            icon.className = 'fas fa-sun';
            localStorage.setItem('themePreference', 'dark');
        } else {
            body.classList.add('light-theme');
            icon.className = 'fas fa-moon';
            localStorage.setItem('themePreference', 'light');
        }
    }

    (function applyTheme() {
        const savedTheme = localStorage.getItem('themePreference');
        const icon = document.getElementById('themeIcon');
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
            if (icon) icon.className = 'fas fa-moon';
        } else {
            document.body.classList.remove('light-theme');
            if (icon) icon.className = 'fas fa-sun';
        }
    })();
</script>

</body>
</html>
