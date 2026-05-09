<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* DARK THEME (Default) */
            --bg-main: #080808;
            --bg-container: #1a1a1a;
            --bg-input: #222;
            --text-primary: #f0f0f0;
            --text-muted: #b0b0b0;
            --logo-gold: #d4af37;
            --accent-gold: #f5e0a0;
            --dark-gold: #a67c00;
            --text-gold: #ffd700;
            --border-color: #333;
            --shadow-color: rgba(0,0,0,0.6);
            --gradient-glow: rgba(255, 215, 0, 0.08);
        }

        /* LIGHT THEME OVERRIDES */
        body.light-mode {
            --bg-main: #f4f7f6;
            --bg-container: #ffffff;
            --bg-input: #f8f9fa;
            --text-primary: #212529;
            --text-muted: #6c757d;
            --logo-gold: #a67c00;
            --text-gold: #856404;
            --border-color: #dee2e6;
            --shadow-color: rgba(0,0,0,0.1);
            --gradient-glow: rgba(212, 175, 55, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background-color: var(--bg-main);
            background-image: radial-gradient(circle at top right, var(--gradient-glow) 0%, rgba(0,0,0,0) 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-primary);
            transition: background 0.3s ease;
        }

        .login-box {
            background: var(--bg-container);
            width: 400px;
            padding: 50px 40px;
            border-radius: 20px;
            border-top: 8px solid var(--logo-gold);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-bottom: 2px solid var(--dark-gold);
            box-shadow: 0 15px 40px var(--shadow-color);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .login-box h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-gold);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .input-group input {
            width: 100%;
            padding: 16px;
            font-size: 15px;
            border-radius: 10px;
            background-color: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            transition: 0.3s ease;
        }

        .input-group input:focus {
            border-color: var(--logo-gold);
            outline: none;
            box-shadow: 0 0 10px var(--gradient-glow);
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            margin-top: 10px;
            background: var(--bg-input);
            border: 2px solid var(--logo-gold);
            color: var(--text-primary);
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: var(--logo-gold);
            color: #000;
            box-shadow: 0 5px 15px var(--gradient-glow);
            transform: translateY(-2px);
        }

        .error-msg {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid rgba(220, 53, 69, 0.3);
            font-weight: 600;
        }

        .back-link {
            margin-top: 25px;
        }

        .back-link a {
            text-decoration: none;
            font-size: 13px;
            color: var(--text-muted);
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .back-link a:hover {
            color: var(--logo-gold);
        }

        /* --- SIMPLIFIED FLOATING ACTION BUTTON --- */
        .fab-wrapper {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
        }

        .fab-main {
            width: 60px;
            height: 60px;
            background: var(--logo-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .fab-main:hover {
            transform: scale(1.1);
            background: var(--text-gold);
        }

        .fab-label {
            position: absolute;
            right: 75px;
            background: var(--bg-container);
            padding: 6px 15px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.3s;
        }

        .fab-wrapper:hover .fab-label {
            opacity: 1;
        }

    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Portal</h2>

    @if(session('error'))
        <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Administrator Username" required autofocus>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button class="btn-login" type="submit">
            <i class="fas fa-shield-alt"></i> Secure Login
        </button>
    </form>

    <div class="back-link">
        <a href="/"><i class="fas fa-arrow-left"></i> Return to DTR System</a>
    </div>
</div>

<!-- Floating Action Button for Theme Toggle -->
<div class="fab-wrapper">
    <span class="fab-label" id="theme-text">Switch to Light Mode</span>
    <div class="fab-main" id="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon" id="theme-icon"></i>
    </div>
</div>

<script>
    const body = document.body;
    const themeIcon = document.getElementById('theme-icon');
    const themeText = document.getElementById('theme-text');

    // Load saved theme from localStorage
    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-mode');
        themeIcon.classList.replace('fa-moon', 'fa-sun');
        themeText.innerText = 'Switch to Dark Mode';
    }

    function toggleTheme() {
        body.classList.toggle('light-mode');
        const isLight = body.classList.contains('light-mode');

        // Save preference
        localStorage.setItem('theme', isLight ? 'light' : 'dark');

        // Update Icon and Text
        if (isLight) {
            themeIcon.classList.replace('fa-moon', 'fa-sun');
            themeText.innerText = 'Switch to Dark Mode';
        } else {
            themeIcon.classList.replace('fa-sun', 'fa-moon');
            themeText.innerText = 'Switch to Light Mode';
        }
    }
</script>

</body>
</html>
