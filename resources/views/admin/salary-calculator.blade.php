<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculator</title>
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
        body { background-color: var(--bg-main); color: var(--text-primary); min-height: 100vh; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; }
        .dashboard-container { width: 100%; max-width: 1200px; background: var(--bg-container); padding: 40px; border-radius: 24px; border: 1px solid var(--border-color); }
        .top-action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); padding: 10px 18px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .theme-toggle-btn { background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .header { margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: 800; color: var(--gold-primary); display: flex; align-items: center; gap: 10px; }

        /* Filter & Search Layout */
        .filter-section { display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px; }
        .filter-row { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { flex: 1; min-width: 200px; }
        .filter-group label { display: block; font-size: 11px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin-bottom: 8px; }
        .filter-group input { width: 100%; padding: 12px; border-radius: 8px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); }

        .search-group { width: 100%; position: relative; }
        .search-group input { width: 100%; padding: 14px 14px 14px 45px; border-radius: 12px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); font-size: 14px; }
        .search-group i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--gold-primary); font-size: 16px; }

        .btn-filter { padding: 12px 30px; background: var(--gold-primary); color: #000; border: none; border-radius: 8px; font-weight: 700; text-transform: uppercase; cursor: pointer; }
        .btn-print { background: var(--gold-primary); color: #000; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; }
        .btn-print:hover { opacity: 0.9; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; color: var(--gold-primary); border-bottom: 2px solid var(--border-color); font-size: 12px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 14px; vertical-align: middle; }
        tr:hover { background: rgba(255, 255, 255, 0.02); }
        .danger-text { color: #e74c3c; font-weight: 600; }
        .success-text { color: #2ecc71; font-weight: 600; }

        /* CSS Print-only styling for the Payslip template */
        #print-payslip-area { display: none; }

        @media print {
            body * { display: none !important; }
            #print-payslip-area { display: block !important; background: #fff !important; color: #000 !important; width: 100% !important; height: auto !important; padding: 0 !important; margin: 0 !important; }
            #print-payslip-area * { display: block !important; color: #000 !important; background: transparent !important; }

            .payslip-box {
                width: 100%;
                max-width: 650px;
                margin: 40px auto;
                padding: 30px;
                border: 2px double #000;
                font-family: 'Courier New', Courier, monospace;
            }
            .payslip-header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 15px; margin-bottom: 20px; }
            .payslip-header h2 { font-size: 22px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
            .payslip-header p { font-size: 12px; }

            .payslip-row { display: flex !important; justify-content: space-between; margin-bottom: 10px; font-size: 13px; }
            .payslip-row span { display: inline-block !important; }
            .payslip-row.bold { font-weight: bold; }

            .payslip-divider { border-top: 1px dashed #000; margin: 15px 0; }
            .payslip-section-title { font-weight: bold; text-transform: uppercase; margin-bottom: 10px; font-size: 14px; text-decoration: underline; }

            .payslip-footer { text-align: center; margin-top: 40px; font-size: 11px; }
            .signatures { display: flex !important; justify-content: space-between; margin-top: 50px; }
            .sig-line { width: 200px; border-top: 1px solid #000; text-align: center; padding-top: 5px; font-size: 11px; font-weight: bold; }
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="top-action-bar">
        <a href="/admin" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <button type="button" class="theme-toggle-btn" onclick="toggleTheme()"><i class="fas fa-sun" id="themeIcon"></i></button>
    </div>

    <div class="header">
        <h1><i class="fas fa-calculator"></i> Payroll & Salary Calculator</h1>
        <p>Dynamic calculations derived from daily attendance log limits vs default configurations</p>
    </div>

    <div class="filter-section">
        <form method="GET" action="{{ route('admin.salary.index') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Start Cut-off Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="filter-group">
                    <label>End Cut-off Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn-filter">Calculate Payroll</button>
            </div>
        </form>

        <div class="search-group">
            <i class="fas fa-search"></i>
            <input type="text" id="hrSearchInput" onkeyup="filterEmployeesTable()" placeholder="Search employee by Name or Employee ID...">
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table id="payrollTable">
            <thead>
            <tr>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>Basic Salary</th>
                <th>Days Logged</th>
                <th>Gross Earned</th>
                <th>Late (Mins / Deduct)</th>
                <th>Undertime (Mins / Deduct)</th>
                <th>Net Payroll Pay</th>
                <th style="text-align: center;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payrollData as $data)
                <tr class="employee-row">
                    <td class="emp-id">{{ $data['employee_id'] }}</td>
                    <td class="emp-name"><strong>{{ $data['name'] }}</strong></td>
                    <td>₱{{ number_format($data['basic_salary'], 2) }}</td>
                    <td>{{ $data['days_worked'] }} Days</td>
                    <td>₱{{ number_format($data['gross_earned'], 2) }}</td>
                    <td>
                        {{ $data['late_minutes'] }} mins
                        <span class="danger-text">(-₱{{ number_format($data['late_deduction'], 2) }})</span>
                    </td>
                    <td>
                        {{ number_format($data['undertime_minutes'], 2) }} mins
                        <span class="danger-text">(-₱{{ number_format($data['undertime_deduction'], 2) }})</span>
                    </td>
                    <td class="success-text">₱{{ number_format($data['net_pay'], 2) }}</td>
                    <td style="text-align: center;">
                        <button class="btn-print" onclick="printPayslip({{ json_encode($data) }}, '{{ $startDate }}', '{{ $endDate }}')">
                            <i class="fas fa-print"></i> Payslip
                        </button>
                    </td>
                </tr>
            @empty
                <tr id="noResultsRow">
                    <td colspan="9" style="text-align: center; color: var(--text-secondary);">No calculations available for selected date range.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="print-payslip-area"></div>

<script>
    // Live Search Filter logic
    function filterEmployeesTable() {
        const input = document.getElementById('hrSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#payrollTable tbody .employee-row');
        let visibleRows = 0;

        rows.forEach(row => {
            const name = row.querySelector('.emp-name').innerText.toLowerCase();
            const id = row.querySelector('.emp-id').innerText.toLowerCase();

            if (name.includes(input) || id.includes(input)) {
                row.style.display = "";
                visibleRows++;
            } else {
                row.style.display = "none";
            }
        });
    }

    // Dynamic clean Payslip generator & trigger
    function printPayslip(data, start, end) {
        const printArea = document.getElementById('print-payslip-area');

        // Classic receipt-styled ledger layout HTML
        printArea.innerHTML = `
            <div class="payslip-box">
                <div class="payslip-header">
                    <h2>OFFICIAL PAYSLIP</h2>
                    <p>Payroll Period: ${start} to ${end}</p>
                </div>

                <div class="payslip-section-title">Employee Details</div>
                <div class="payslip-row">
                    <span>Employee Name:</span>
                    <span><strong>${data.name}</strong></span>
                </div>
                <div class="payslip-row">
                    <span>Employee ID:</span>
                    <span>${data.employee_id}</span>
                </div>
                <div class="payslip-row">
                    <span>Basic Rate:</span>
                    <span>₱${Number(data.basic_salary).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                </div>
                <div class="payslip-row">
                    <span>Days Worked:</span>
                    <span>${data.days_worked} Days</span>
                </div>

                <div class="payslip-divider"></div>

                <div class="payslip-section-title">Earnings Breakdown</div>
                <div class="payslip-row">
                    <span>Basic Earned (Pro-rated Gross):</span>
                    <span>₱${Number(data.gross_earned).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                </div>

                <div class="payslip-divider"></div>

                <div class="payslip-section-title">Deductions</div>
                <div class="payslip-row">
                    <span>Lateness (${data.late_minutes} mins):</span>
                    <span>- ₱${Number(data.late_deduction).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                </div>
                <div class="payslip-row">
                             <span>Undertime (${Number(data.undertime_minutes).toFixed(2)} mins):</span>
                            <span>- ₱${Number(data.undertime_deduction).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                             </div>
                <div class="payslip-row bold">
                    <span>Total Deductions:</span>
                    <span>- ₱${Number(data.total_deductions).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                </div>

                <div class="payslip-divider"></div>

                <div class="payslip-row bold" style="font-size: 16px;">
                    <span>NET PAYOUT:</span>
                    <span>₱${Number(data.net_pay).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                </div>

                <div class="payslip-divider"></div>

                <div class="signatures">
                    <div class="sig-line">Prepared By (HR)</div>
                    <div class="sig-line">Employee Signature</div>
                </div>

                <div class="payslip-footer">
                    <p>Thank you for your hard work!</p>
                </div>
            </div>
        `;

        window.print();
    }

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
