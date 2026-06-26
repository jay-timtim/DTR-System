<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | ID Badge Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <style>
        :root {
            --bg-body: #080808;
            --bg-container: #1a1a1a;
            --bg-card: #222222;
            --text-main: #f0f0f0;
            --text-muted: #b0b0b0;
            --logo-gold: #d4af37;
            --dark-gold: #a67c00;
            --text-gold: #ffd700;
            --border-color: #333;
        }

        body.light-mode {
            --bg-body: #f4f6f9;
            --bg-container: #ffffff;
            --bg-card: #ffffff;
            --text-main: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --logo-gold: #a67c00;
            --text-gold: #856404;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background-color: var(--bg-body); color: var(--text-main); min-height: 100vh; transition: 0.3s; }

        .sidebar { width: 260px; height: 100vh; background: var(--bg-container); padding: 30px 20px; position: fixed; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 18px; font-weight: 800; color: var(--text-gold); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 40px; text-align: center; border-bottom: 2px solid var(--dark-gold); padding-bottom: 15px; }
        .sidebar a { display: block; color: var(--text-muted); text-decoration: none; padding: 14px 18px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(212, 175, 55, 0.1); color: var(--text-gold); }

        .main { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }

        .workspace { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start; }
        .control-panel { background: var(--bg-container); padding: 30px; border-radius: 12px; border: 1px solid var(--border-color); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .form-group select { width: 100%; padding: 12px; border-radius: 6px; background: var(--bg-body); border: 1px solid var(--border-color); color: var(--text-main); outline: none; font-size: 14px; }

        .btn-print { background: var(--logo-gold); color: #000; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; }

        /* PHYSICAL CARD FORMAT STANDARDS (CRITICAL FOR PRINTING) */
        .id-card-canvas { display: flex; justify-content: center; padding: 20px; }
        .id-badge {
            width: 320px;
            height: 480px;
            background: #fff;
            color: #000;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 4px solid #a67c00;
        }
        .badge-header { width: 100%; background: #111; padding: 20px 10px; text-align: center; border-bottom: 4px solid #d4af37; }
        .badge-header h4 { color: #ffd700; font-size: 16px; font-weight: 800; letter-spacing: 1.5px; }
        .badge-header p { color: #fff; font-size: 9px; letter-spacing: 1px; margin-top: 2px; }

        .photo-holder { width: 130px; height: 130px; border-radius: 50%; border: 4px solid #a67c00; margin-top: 25px; object-fit: cover; background: #eee; }
        .badge-name { font-size: 20px; font-weight: 700; color: #111; margin-top: 15px; text-align: center; padding: 0 15px; text-transform: uppercase; }
        .badge-title { font-size: 13px; color: #666; font-weight: 500; margin-top: 2px; text-transform: uppercase; }
        .badge-dept { font-size: 11px; background: #f4f6f9; color: #a67c00; padding: 4px 12px; border-radius: 20px; margin-top: 8px; font-weight: 600; }

        .barcode-area { margin-top: auto; margin-bottom: 20px; text-align: center; width: 90%; display: flex; flex-direction: column; align-items: center; }
        #barcode { max-width: 100%; height: 65px; }

        /* THEME TOGGLE */
        .theme-toggle-btn { background: var(--bg-container); border: 1px solid var(--border-color); color: var(--text-main); padding: 8px 15px; border-radius: 20px; cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        /* EXCLUSIVE CSS PRINT OVERRIDE ROUTINES */
        @media print {
            .sidebar, .topbar, .control-panel, .theme-toggle-btn { display: none !important; }
            body { background: transparent !important; color: #000 !important; }
            .main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
            .id-card-canvas { padding: 0 !important; margin: 0 !important; }
            .id-badge { box-shadow: none !important; border: 4px solid #a67c00 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>BIZMATECH</h2>
    <a href="/admin"><i class="fas fa-chart-line" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="/manage-employees" class="active"><i class="fas fa-users" style="margin-right: 8px;"></i> Manage Employees</a>
    <a href="/view-dtr"><i class="fas fa-calendar-check" style="margin-right: 8px;"></i> View DTR Records</a>
    <a href="/reports"><i class="fas fa-file-invoice" style="margin-right: 8px;"></i> Reports</a>
    <a style="margin-top: auto; color: #ff6b6b;" href="/logout"><i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h1>ID Badge Generator</h1>
        <button id="theme-toggle" class="theme-toggle-btn">
            <span id="theme-icon">☀️</span>
            <span id="theme-text">Light Mode</span>
        </button>
    </div>

    <div class="workspace">
        <div class="control-panel">
            <div class="form-group">
                <label>Select Target Employee</label>
                <select id="employeeSelector" onchange="renderBadgeCard()">
                    <option value="" disabled selected>-- Choose Employee --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->employee_id }}"
                                data-name="{{ $emp->first_name }} {{ $emp->last_name }}"
                                data-dept="{{ $emp->department }}"
                                data-pos="{{ $emp->position }}"
                                data-photo="{{ $emp->photo_path ? asset('storage/'.$emp->photo_path) : 'https://i.pravatar.cc/150?img='.$loop->index }}">
                            [{{ $emp->employee_id }}] {{ $emp->last_name }}, {{ $emp->first_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Print ID Badge</button>
        </div>

        <div class="id-card-canvas">
            <div class="id-badge" id="badgeCard">
                <div class="badge-header">
                    <h4>BIZMATECH</h4>
                    <p>OFFICIAL IDENTIFICATION CARD</p>
                </div>

                <img src="https://i.pravatar.cc/150?img=blank" class="photo-holder" id="cardPhoto">
                <div class="badge-name" id="cardName">Select Employee</div>
                <div class="badge-title" id="cardPos">Position</div>
                <div class="badge-dept" id="cardDept">Department</div>

                <div class="barcode-area">
                    <svg id="barcode"></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function renderBadgeCard() {
        const select = document.getElementById('employeeSelector');
        const selectedOption = select.options[select.selectedIndex];

        if (!selectedOption.value) return;

        // Pull active parameters out from dataset metrics
        const empId = selectedOption.value;
        const name = selectedOption.getAttribute('data-name');
        const dept = selectedOption.getAttribute('data-dept');
        const pos = selectedOption.getAttribute('data-pos');
        const photo = selectedOption.getAttribute('data-photo');

        // Apply string configurations directly to the structural card node targets
        document.getElementById('cardName').innerText = name;
        document.getElementById('cardDept').innerText = dept;
        document.getElementById('cardPos').innerText = pos;
        document.getElementById('cardPhoto').src = photo;

        // TRANSLATE EMPLOYEE ID INTO INDUSTRIAL BARCODE FORMAT VIA CLIENT RUNTIME ENGINE
        JsBarcode("#barcode", empId, {
            format: "CODE128",
            width: 2,
            height: 55,
            displayValue: true,
            fontSize: 12,
            font: "monospace",
            lineColor: "#000000",
            background: "transparent"
        });
    }

    // Initialize blank default bar metrics safely on initial viewport processing sequences
    document.addEventListener("DOMContentLoaded", () => {
        JsBarcode("#barcode", "00000000", { format: "CODE128", height: 55, displayValue: false, lineColor: "#cccccc" });
    });

    // Theme Management Controls Sync
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
