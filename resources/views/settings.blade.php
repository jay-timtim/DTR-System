<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIZMATECH | System Configurations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Variables Supporting Dark & Light Modes */
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
            --preview-bg: #ffffff;
            --icon-color: #d4af37;
        }

        /* Light Theme Styles */
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
            --preview-bg: #f8f9fa;
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
            max-width: 700px;
            padding: 40px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 50px var(--btn-shadow);
            backdrop-filter: blur(10px);
            position: relative;
        }

        /* Top Action Bar (Back Button & Theme Toggle) */
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
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            border-color: var(--gold-primary);
            transform: translateX(-3px);
            box-shadow: 0 0 10px var(--gold-glow);
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
            transition: all 0.2s ease;
        }

        .theme-toggle-btn:hover {
            border-color: var(--gold-primary);
            color: var(--gold-primary);
            transform: scale(1.05);
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

        input[type="text"] {
            width: 100%;
            padding: 15px;
            font-size: 15px;
            border-radius: 12px;
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: var(--gold-primary);
            outline: none;
            box-shadow: 0 0 15px var(--gold-glow);
        }

        .file-upload-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            background: var(--bg-input);
            padding: 15px;
            border-radius: 12px;
            border: 2px dashed var(--border-color);
            transition: 0.3s;
        }

        .file-upload-wrapper:hover {
            border-color: var(--gold-primary);
        }

        .preview-box {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            background: var(--preview-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid var(--border-color);
        }

        .preview-box img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .upload-btn-wrapper {
            flex: 1;
        }

        .upload-btn-wrapper input[type="file"] {
            color: var(--text-secondary);
            font-size: 13px;
            cursor: pointer;
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
            transition: 0.3s;
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
    </style>
</head>
<body>

<div class="settings-card">
    <div class="top-action-bar">
        <a href="/admin" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <button type="button" class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()" title="Toggle Color Theme">
            <i class="fas fa-sun" id="themeIcon"></i>
        </button>
    </div>

    <div class="header">
        <h1><i class="fas fa-sliders-h" style="color: var(--icon-color);"></i> Branding Panel</h1>
        <p>Modify public layouts, kiosk machines, and loaders dynamically</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="company_name">Company Name Display</label>
            <input type="text" id="company_name" name="company_name" value="{{ config('app_settings.company_name', 'COMPANY NAME') }}" required>
        </div>

        <div class="form-group">
            <label>General Corporate Logo (Sidebar/Admin Panel)</label>
            <div class="file-upload-wrapper">
                <div class="preview-box">
                    <img id="companyLogoPreview" src="{{ config('app_settings.company_logo') ? asset('storage/' . config('app_settings.company_logo')) : asset('Picture/Default Logo.png') }}" alt="Sidebar Preview">
                </div>
                <div class="upload-btn-wrapper">
                    <input type="file" name="company_logo" onchange="previewImage(this, 'companyLogoPreview')">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Kiosk Interface Logo (Front Screen Dashboard)</label>
            <div class="file-upload-wrapper">
                <div class="preview-box">
                    <img id="dtrLogoPreview" src="{{ config('app_settings.dtr_logo') ? asset('storage/' . config('app_settings.dtr_logo')) : asset('Picture/Default Logo.png') }}" alt="DTR Preview">
                </div>
                <div class="upload-btn-wrapper">
                    <input type="file" name="dtr_logo" onchange="previewImage(this, 'dtrLogoPreview')">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>System Boot Loader Logo (Loading Screen)</label>
            <div class="file-upload-wrapper">
                <div class="preview-box">
                    <img id="loaderLogoPreview" src="{{ config('app_settings.loader_logo') ? asset('storage/' . config('app_settings.loader_logo')) : asset('Picture/Default Logo.png') }}" alt="Loader Preview">
                </div>
                <div class="upload-btn-wrapper">
                    <input type="file" name="loader_logo" onchange="previewImage(this, 'loaderLogoPreview')">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit">Update Branding Environment</button>
    </form>
</div>

<script>
    // Live Client-Side Image Previews
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Modern Light / Dark Mode Toggle and State Cache
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

    // Apply Cached Theme Preference on View Initialization
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
