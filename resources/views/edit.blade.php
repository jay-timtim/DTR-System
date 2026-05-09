<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIZMATECH | Edit Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Dark Mode Variables */
            --primary-black: #080808;
            --container-black: #1a1a1a;
            --logo-gold: #d4af37;
            --accent-gold: #f5e0a0;
            --dark-gold: #a67c00;
            --text-gold: #ffd700;
            --light-text: #f0f0f0;
            --muted-text: #b0b0b0;
            --input-bg: #222222;
            --border-color: #333;
            --input-border: #444;
            --shadow-color: rgba(0,0,0,0.5);
        }

        body.light-mode {
            /* Light Mode Variables */
            --primary-black: #f4f7f6;
            --container-black: #ffffff;
            --logo-gold: #a67c00;
            --accent-gold: #8b6508;
            --dark-gold: #5e4300;
            --text-gold: #a67c00;
            --light-text: #1a1a1a;
            --muted-text: #666666;
            --input-bg: #f9f9f9;
            --border-color: #ddd;
            --input-border: #ccc;
            --shadow-color: rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--primary-black);
            background-image: radial-gradient(circle at top right, rgba(255, 215, 0, 0.05) 0%, rgba(0,0,0,0) 50%);
            color: var(--light-text);
            padding: 60px 20px;
            display: flex;
            justify-content: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .container {
            max-width: 850px;
            width: 100%;
            background: var(--container-black);
            padding: 40px;
            border-radius: 16px;
            border-top: 5px solid var(--logo-gold);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 20px 50px var(--shadow-color);
            position: relative;
            transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* --- THEME TOGGLE SWITCH --- */
        .theme-toggle-btn {
            position: absolute;
            top: 25px;
            right: 25px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--logo-gold);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover {
            transform: scale(1.1);
            border-color: var(--logo-gold);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .header img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--logo-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .header h2 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-gold);
            letter-spacing: -0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Name Grid: 3 columns */
        .name-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 600;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--light-text);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--logo-gold);
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
        }

        .salary-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .currency-symbol {
            position: absolute;
            left: 15px;
            color: var(--logo-gold);
            font-weight: 600;
            pointer-events: none;
        }

        .salary-input-wrapper input {
            width: 100%;
            padding-left: 35px !important;
        }

        .section-title {
            margin: 35px 0 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--logo-gold);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: "";
            height: 1px;
            flex-grow: 1;
            background: linear-gradient(90deg, var(--border-color), transparent);
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(0.8) sepia(100%) saturate(1000%) hue-rotate(10deg);
            cursor: pointer;
        }
        body.light-mode input[type="time"]::-webkit-calendar-picker-indicator {
            filter: none;
        }

        .actions {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-save {
            background: var(--logo-gold);
            color: var(--primary-black);
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-cancel {
            background: transparent;
            color: var(--muted-text);
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid var(--input-border);
            transition: 0.3s;
        }

        @media (max-width: 768px) {
            .name-grid { grid-template-columns: 1fr; }
            .form-grid, .schedule-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<div class="container">
    <button type="button" class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="header">
        <div class="header-img-container">
            <img src="{{ $employee->photo_path ? asset('storage/'.$employee->photo_path) : asset('Picture/bizmatech.jpg') }}">
        </div>
        <div>
            <p>Modify Staff Record</p>
            <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <span style="color: var(--logo-gold); font-family: monospace; font-size: 14px;">ID: {{ $employee->employee_id }}</span>
        </div>
    </div>

    <form action="{{ route('employees.update',$employee->employee_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-title">Personal Identification</div>

        <div class="form-grid">
            <div class="name-grid">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="{{ $employee->first_name }}" required>
                </div>
                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="{{ $employee->middle_name }}">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ $employee->last_name }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthday" value="{{ $employee->birthday }}" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="Male" {{ $employee->gender=='Male'?'selected':'' }}>Male</option>
                    <option value="Female" {{ $employee->gender=='Female'?'selected':'' }}>Female</option>
                </select>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Home Address</label>
                <input type="text" name="address" value="{{ $employee->address }}">
            </div>
        </div>

        <div class="section-title">Professional Status</div>

        <div class="form-grid">
            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" value="{{ $employee->department }}" placeholder="e.g. IT Department" required>
            </div>

            <div class="form-group">
                <label>Designation / Position</label>
                <input type="text" name="position" value="{{ $employee->position }}" required>
            </div>

            <div class="form-group">
                <label>Date Hired</label>
                <input type="date" name="date_hired" value="{{ $employee->date_hired }}" required>
            </div>

            <div class="form-group">
                <label>Basic Salary</label>
                <div class="salary-input-wrapper">
                    <span class="currency-symbol">₱</span>
                    <input type="number" name="basic_salary" value="{{ $employee->basic_salary }}" step="0.01" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Employment Status</label>
                <select name="employment_status">
                    <option value="Regular" {{ $employee->employment_status=='Regular'?'selected':'' }}>Regular</option>
                    <option value="Probationary" {{ $employee->employment_status=='Probationary'?'selected':'' }}>Probationary</option>
                    <option value="Contractual" {{ $employee->employment_status=='Contractual'?'selected':'' }}>Contractual</option>
                </select>
            </div>

            <div class="form-group">
                <label>System Access Status</label>
                <select name="status">
                    <option value="Active" {{ $employee->status=='Active'?'selected':'' }}>Active</option>
                    <option value="Inactive" {{ $employee->status=='Inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Update Credentials Photo</label>
                <input type="file" name="photo_path">
            </div>
        </div>

        <div class="section-title">Work Cycle (Standard Time)</div>

        <div class="schedule-grid">
            <div class="form-group"><label>Shift Start</label><input type="time" name="schedule_start" value="{{ $employee->schedule_start }}"></div>
            <div class="form-group"><label>Break Start</label><input type="time" name="break_start" value="{{ $employee->break_start }}"></div>
            <div class="form-group"><label>Break End</label><input type="time" name="break_end" value="{{ $employee->break_end }}"></div>
            <div class="form-group"><label>Shift End</label><input type="time" name="schedule_end" value="{{ $employee->schedule_end }}"></div>
        </div>

        <div class="actions">
            <a href="/manage-employees" class="btn-cancel">Discard Changes</a>
            <button type="submit" class="btn-save">Save Staff Record</button>
        </div>
    </form>
</div>

<script>
    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('themeIcon');
        body.classList.toggle('light-mode');
        if (body.classList.contains('light-mode')) {
            icon.classList.replace('fa-moon', 'fa-sun');
            localStorage.setItem('theme', 'light');
        } else {
            icon.classList.replace('fa-sun', 'fa-moon');
            localStorage.setItem('theme', 'dark');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
            document.getElementById('themeIcon').classList.replace('fa-moon', 'fa-sun');
        }
    });
</script>

</body>
</html>
