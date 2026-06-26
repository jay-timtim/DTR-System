<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | Professional DTR System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            /* Dark Theme Variables */
            --bg-main: #0a0a0a;
            --bg-container: rgba(26, 26, 26, 0.95);
            --bg-input: #1f1f1f;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --gold-primary: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.3);
            --border-color: #333;
            --btn-shadow: rgba(0, 0, 0, 0.4);
        }

        body.light-mode {
            --bg-main: #f4f7f6;
            --bg-container: rgba(255, 255, 255, 0.95);
            --bg-input: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #555555;
            --gold-primary: #a67c00;
            --gold-glow: rgba(166, 124, 0, 0.1);
            --border-color: #ddd;
            --btn-shadow: rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            height: 100vh;
            background-color: var(--bg-main);
            background-image: radial-gradient(circle at top right, var(--gold-glow) 0%, rgba(0,0,0,0) 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-primary);
            overflow: hidden;
            transition: background 0.3s ease;
        }

        /* --- LOADING SCREEN --- */
        #loader-wrapper {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #000; display: flex; flex-direction: column;
            justify-content: center; align-items: center; z-index: 10000;
            transition: opacity 0.6s ease;
        }
        .loader-logo { width: 120px; animation: pulse 2s infinite; border-radius: 50%; margin-bottom: 20px; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(1.1); opacity: 1; } }

        /* --- MAIN UI CONTAINER --- */
        .container {
            background: var(--bg-container);
            width: 450px;
            padding: 50px 40px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 50px var(--btn-shadow);
            text-align: center;
            backdrop-filter: blur(10px);
            z-index: 5;
        }

        /* Branding Image Replacement for Camera */
        .brand-center {
            width: 140px;
            height: 140px;
            background: #fff;
            margin: 0 auto 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid var(--gold-primary);
            overflow: hidden;
            box-shadow: 0 0 25px var(--gold-glow);
        }
        .brand-center img { width: 90%; height: auto; }

        .company-name { font-size: 22px; font-weight: 800; color: var(--gold-primary); letter-spacing: 2px; }
        .title { font-size: 14px; color: var(--text-secondary); margin-bottom: 30px; text-transform: uppercase; }

        /* Input Styling */
        .input-group { margin-bottom: 25px; position: relative; }
        input[type="text"] {
            width: 100%; padding: 18px; font-size: 16px; border-radius: 12px;
            background: var(--bg-input); border: 2px solid var(--border-color);
            color: var(--text-primary); text-align: center; transition: 0.3s;
        }
        input[type="text"]:focus { border-color: var(--gold-primary); outline: none; box-shadow: 0 0 15px var(--gold-glow); }

        /* Action Buttons */
        .button-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn {
            padding: 15px; font-size: 13px; font-weight: 700; border-radius: 10px;
            border: none; cursor: pointer; color: #fff; text-transform: uppercase;
            transition: 0.3s;
        }
        .btn:disabled { background: #444 !important; opacity: 0.5; cursor: not-allowed; }
        .btn-firsttimein { background: #27ae60; }
        .btn-firsttimeout { background: #c0392b; }
        .btn-secondtimeout { background: #f39c12; }
        .btn-secondtimein { background: #2980b9; }
        .btn:hover:not(:disabled) { transform: translateY(-2px); filter: brightness(1.2); }

        .footer-time { margin-top: 30px; color: var(--gold-primary); font-weight: 600; font-size: 15px; }
        .seconds { color: #e74c3c; }

        /* --- FLOATING ACTION BUTTON (FAB) --- */
        .fab-wrapper { position: fixed; bottom: 30px; right: 30px; z-index: 9999; }
        .fab-main {
            width: 60px; height: 60px; background: var(--gold-primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #000; font-size: 24px; cursor: pointer; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .fab-main.active { transform: rotate(45deg); background: #333; color: #fff; }

        .fab-menu {
            position: absolute; bottom: 80px; right: 0;
            display: flex; flex-direction: column; gap: 15px;
            pointer-events: none; opacity: 0; transform: translateY(20px); transition: 0.3s;
        }
        .fab-menu.show { pointer-events: auto; opacity: 1; transform: translateY(0); }

        .fab-item {
            display: flex; align-items: center; justify-content: flex-end; gap: 15px;
            text-decoration: none; white-space: nowrap;
        }
        .fab-label {
            background: var(--bg-container); padding: 5px 15px; border-radius: 8px;
            font-size: 12px; font-weight: 600; color: var(--text-primary);
            border: 1px solid var(--border-color); box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .fab-icon {
            width: 45px; height: 45px; background: var(--bg-container); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold-primary); border: 1px solid var(--border-color); transition: 0.3s;
        }
        .fab-icon:hover { background: var(--gold-primary); color: #000; }

        /* Camera Overlay */
        #camera-modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9); z-index: 10001; display: none;
            flex-direction: column; align-items: center; justify-content: center;
        }
        #scanner-view { width: 90%; max-width: 500px; height: 300px; border: 2px solid var(--gold-primary); border-radius: 15px; overflow: hidden; }
        .close-camera { margin-top: 20px; color: #fff; cursor: pointer; font-size: 20px; }

        /* Recent Logs Toast */
        #recent-logs {
            position: fixed; bottom: 100px; right: 100px; width: 300px;
            background: var(--bg-container); border: 1px solid var(--border-color);
            border-radius: 12px; padding: 15px; display: none; z-index: 9998;
        }
        .clock-section { margin-bottom: 25px; }
        #liveDayDate { font-size: 14px; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        #liveClock { font-size: 36px; font-weight: 800; margin-top: 5px; }
        .seconds { color: #e74c3c; }

        /* Fix for dynamic buttons */
        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            width: 100%;
        }

        /* Ensure the form takes up full width */
        #actionButtons form {
            width: 100%;
        }

        /* --- SIDEWAYS KEYBOARD SHORTCUT REMINDER MODAL --- */
        .shortcut-reminder {
            position: fixed;
            left: 30px;
            top: 50%;
            transform: translateY(-50%) translateX(-150%);
            width: 260px;
            background: var(--bg-container);
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--gold-primary);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 15px 35px var(--btn-shadow);
            backdrop-filter: blur(10px);
            z-index: 100;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.2);
            pointer-events: none;
        }
        .shortcut-reminder.visible {
            transform: translateY(-50%) translateX(0);
        }
        .shortcut-header {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold-primary);
            font-weight: 800;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .shortcut-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .shortcut-row:last-child { margin-bottom: 0; }
        .key-badge {
            background: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-bottom: 3px solid var(--border-color);
            padding: 2px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-weight: 700;
            font-size: 11px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .action-label {
            color: var(--text-secondary);
            font-weight: 500;
        }
    </style>
</head>
<body>

<div id="loader-wrapper">
    <img src="{{  config('app_settings.loader_logo') ? asset('storage/' . config('app_settings.loader_logo')) : asset('Picture/Default Logo.png')}}" alt="Logo" class="loader-logo">
    <p style="color: #d4af37; letter-spacing: 2px; font-size: 10px;">SECURE ACCESS VERIFICATION</p>
</div>

<div class="shortcut-reminder" id="shortcutReminder">
    <div class="shortcut-header">
        <i class="fas fa-keyboard"></i> DTR Shortcuts
    </div>
    <div class="shortcut-row">
        <span class="action-label">First Time In</span>
        <kbd class="key-badge">F1</kbd>
    </div>
    <div class="shortcut-row">
        <span class="action-label">First Time Out</span>
        <kbd class="key-badge">F2</kbd>
    </div>
    <div class="shortcut-row">
        <span class="action-label">Second Time In</span>
        <kbd class="key-badge">F3</kbd>
    </div>
    <div class="shortcut-row">
        <span class="action-label">Second Time Out</span>
        <kbd class="key-badge">F4</kbd>
    </div>
</div>

<div id="camera-modal">
    <div id="scanner-view"></div>
    <div class="close-camera" onclick="toggleCamera()"><i class="fas fa-times-circle"></i> Close Scanner</div>
</div>

<div class="container">
    <div id="responseMsg"></div>

    <div class="brand-center">
        <img src="{{  config('app_settings.company_logo') ? asset('storage/' . config('app_settings.company_logo')) : asset('Picture/Default Logo.png') }}" alt="Logo Branding">
    </div>

    <div class="company-name">{{ config('app_settings.company_name',"Company Name") }}</div>
    <div class="title">Attendance Management System</div>
    <div class="clock-section">
        <div id="liveDayDate">Day, Month 00, 0000</div>
        <div id="liveClock">00:00:<span class="seconds">00</span> AM</div>
    </div>
    <div class="input-group">
        <input type="text" name="employee_id" id="employeeInput" placeholder="Enter or Scan ID" autocomplete="off" required>
    </div>
    <div id="actionButtons">
        <div class="button-grid">
            <button disabled class="btn">Waiting for ID...</button>
        </div>
    </div>
</div>

<div class="fab-wrapper">
    <div class="fab-menu" id="fabMenu">
        <div class="fab-item" onclick="toggleTheme()">
            <span class="fab-label">Toggle Theme</span>
            <div class="fab-icon"><i class="fas fa-moon"></i></div>
        </div>
        <div class="fab-item" onclick="toggleCamera()">
            <span class="fab-label">Use Camera</span>
            <div class="fab-icon"><i class="fas fa-camera"></i></div>
        </div>
        <div class="fab-item" onclick="toggleLogs()">
            <span class="fab-label">Recent Logs</span>
            <div class="fab-icon"><i class="fas fa-history"></i></div>
        </div>
        <a href="/admin/login" class="fab-item">
            <span class="fab-label">Admin Login</span>
            <div class="fab-icon"><i class="fas fa-user-shield"></i></div>
        </a>
    </div>
    <div class="fab-main" id="fabBtn" onclick="toggleFab()">
        <i class="fas fa-plus"></i>
    </div>
</div>

<div id="recent-logs">
    <h4 style="font-size: 12px; margin-bottom: 10px; color: var(--gold-primary);">Recent Activity</h4>
    <div id="logs-list" style="font-size: 11px;">
        <p style="color: var(--text-secondary);">No recent logs today.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>

<script>
    // --- FAB & UTILITIES ---
    function toggleFab() {
        document.getElementById('fabBtn').classList.toggle('active');
        document.getElementById('fabMenu').classList.toggle('show');
    }

    function toggleTheme() {
        document.body.classList.toggle('light-mode');
        const icon = document.querySelector('.fab-item .fa-moon');
        if(document.body.classList.contains('light-mode')) {
            icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            icon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    // --- RECENT LOGS ENGINE ---
    function toggleLogs() {
        const panel = document.getElementById('recent-logs');
        if (panel.style.display === 'block') {
            panel.style.display = 'none';
        } else {
            panel.style.display = 'block';
            fetchRecentLogs(); // Refresh instantly when opened
        }
    }

    function fetchRecentLogs() {
        fetch('/dtr/recent-logs')
            .then(res => res.json())
            .then(logs => {
                const listContainer = document.getElementById('logs-list');

                if (logs.length === 0) {
                    listContainer.innerHTML = `<p style="color: var(--text-secondary); padding: 10px 0; text-align: center;">No recent logs today.</p>`;
                    return;
                }

                let html = '';
                logs.forEach(log => {
                    let logTime = new Date(log.log_time);
                    let formattedTime = logTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    let isIn = log.log_type.toLowerCase().includes('in');
                    let statusColor = isIn ? '#2ecc71' : '#e74c3c';

                    html += `
                        <div style="padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <span style="font-weight: 600; color: var(--text-primary); display: block;">${log.first_name} ${log.last_name}</span>
                                <span style="font-size: 10px; font-weight: 700; color: ${statusColor}; text-transform: uppercase;">${log.log_type.replace(/_/g, ' ')}</span>
                            </div>
                            <div style="color: var(--gold-primary); font-family: monospace; font-weight: 600; white-space: nowrap;">
                                ${formattedTime}
                            </div>
                        </div>
                    `;
                });

                listContainer.innerHTML = html;
            })
            .catch(err => console.error("Error fetching logs:", err));
    }

    setInterval(() => {
        const panel = document.getElementById('recent-logs');
        if (panel.style.display === 'block') {
            fetchRecentLogs();
        }
    }, 15000);

    // --- CLOCK ---
    function updateClock() {
        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        const day = days[now.getDay()];
        const month = months[now.getMonth()];
        const date = now.getDate();
        const year = now.getFullYear();

        document.getElementById('liveDayDate').innerHTML = `${day}, ${month} ${date}, ${year}`;

        let h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('liveClock').innerHTML = `${h}:${m}:<span class="seconds">${s}</span> ${ampm}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // --- FORM LOGIC ---
    const empInput = document.getElementById('employeeInput');
    const btnBox = document.getElementById('actionButtons');
    const responseMsg = document.getElementById('responseMsg');
    const shortcutReminder = document.getElementById('shortcutReminder');

    // Handle dynamic button generation and side modal visibility
    empInput.addEventListener('keyup', function() {
        let id = this.value.trim();

        // Show/Hide Reminder based on whether field is empty
        if (id.length > 0) {
            shortcutReminder.classList.add('visible');
        } else {
            shortcutReminder.classList.remove('visible');
        }

        if(id.length < 3) {
            btnBox.innerHTML = `<button disabled class="btn">Waiting for ID...</button>`;
            return;
        }

        fetch(`/dtr/status/${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    btnBox.innerHTML = `<div style="color:#e74c3c; margin-top:10px;">${data.error}</div>`;
                    return;
                }
                if(data.next.length === 0) {
                    btnBox.innerHTML = `<div style="color:#27ae60; font-weight:700; margin-top:10px;">Shift Completed</div>`;
                    return;
                }

                let html = `
            <form id="ajaxLogForm">
                <input type="hidden" name="employee_id" value="${id}">
                <div class="button-group">`;

                data.next.forEach(type => {
                    let cls = type.toLowerCase().replace(/_/g, '').replace(/ /g, '');
                    let label = type.replace(/_/g, ' ').toUpperCase();
                    html += `<button type="submit" name="log_type" value="${type}" class="btn btn-${cls}">${label}</button>`;
                });

                html += `</div></form>`;
                btnBox.innerHTML = html;
            });
    });

    // Handle the actual logging via AJAX
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'ajaxLogForm') {
            e.preventDefault();

            const formData = new FormData(e.target);
            formData.append('log_type', e.submitter.value);

            fetch('/dtr/log', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    responseMsg.innerHTML = `
                <div style="padding: 15px; border-radius: 10px; margin-bottom: 20px;
                background: ${data.success ? 'rgba(39, 174, 96, 0.2)' : 'rgba(231, 76, 60, 0.2)'};
                color: ${data.success ? '#2ecc71' : '#e74c3c'}; border: 1px solid">
                    ${data.message}
                </div>`;

                    // Reset elements and hide reminder modal instantly
                    empInput.value = '';
                    shortcutReminder.classList.remove('visible');
                    btnBox.innerHTML = `<button disabled class="btn">Waiting for ID...</button>`;

                    if (data.success) {
                        fetchRecentLogs();
                    }

                    setTimeout(() => { responseMsg.innerHTML = ''; }, 5000);
                })
                .catch(err => {
                    console.error("An error occurred during submission:", err);
                });
        }
    });

    // --- CAMERA SCANNER ---
    let isCameraOpen = false;
    function toggleCamera() {
        const modal = document.getElementById('camera-modal');
        if(!isCameraOpen) {
            modal.style.display = 'flex';
            startScanner();
        } else {
            modal.style.display = 'none';
            Quagga.stop();
        }
        isCameraOpen = !isCameraOpen;
    }

    function startScanner() {
        Quagga.init({
            inputStream: { type: "LiveStream", target: document.querySelector('#scanner-view'), constraints: { facingMode: "environment" } },
            decoder: { readers: ["code_128_reader"] }
        }, (err) => { if(!err) Quagga.start(); });
    }

    Quagga.onDetected((data) => {
        empInput.value = data.codeResult.code;
        toggleCamera();
        empInput.dispatchEvent(new Event('keyup'));
    });

    // --- INITIALIZE ---
    window.onload = () => {
        setTimeout(() => { document.getElementById('loader-wrapper').style.opacity = '0';
            setTimeout(() => { document.getElementById('loader-wrapper').style.display = 'none'; }, 600);
        }, 2000);
    };

    // --- KEYBOARD SHORTCUTS ENGINE (F1 - F4) ---
    document.addEventListener('keydown', function(e) {
        const keyMap = {
            'F1': 'FIRST TIME IN',
            'F2': 'FIRST TIME OUT',
            'F3': 'SECOND TIME IN',
            'F4': 'SECOND TIME OUT'

        };

        if (keyMap[e.key]) {
            e.preventDefault();

            const targetButton = document.querySelector(`#ajaxLogForm button[value="${keyMap[e.key]}"]`);

            if (targetButton) {
                targetButton.click();
            } else {
                console.warn(`Shortcut ${e.key} pressed, but action button "${keyMap[e.key]}" is not active or visible.`);
            }
        }
    });
</script>

</body>
</html>
