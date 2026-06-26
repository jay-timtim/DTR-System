<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculator</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg-main: #0a0a0a; --bg-container: rgba(26, 26, 26, 0.95); --bg-input: #1f1f1f;
            --text-primary: #ffffff; --text-secondary: #b0b0b0; --gold-primary: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.15); --border-color: #333;
            --modal-overlay: rgba(0, 0, 0, 0.8);
        }
        .light-theme {
            --bg-main: #f4f5f7; --bg-container: #ffffff; --bg-input: #f8f9fa;
            --text-primary: #1a1a1a; --text-secondary: #6c757d; --gold-primary: #c59b27;
            --gold-glow: rgba(197, 155, 39, 0.1); --border-color: #e2e8f0;
            --modal-overlay: rgba(0, 0, 0, 0.5);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        body { background-color: var(--bg-main); color: var(--text-primary); min-height: 100vh; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; }
        .dashboard-container { width: 100%; max-width: 1450px; background: var(--bg-container); padding: 40px; border-radius: 24px; border: 1px solid var(--border-color); }
        .top-action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); padding: 10px 18px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .theme-toggle-btn { background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .header { margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: 800; color: var(--gold-primary); display: flex; align-items: center; gap: 10px; }

        .filter-section { display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px; }
        .filter-row { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { flex: 1; min-width: 200px; }
        .filter-group label { display: block; font-size: 11px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin-bottom: 8px; }
        .filter-group input { width: 100%; padding: 12px; border-radius: 8px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); }

        .search-group { width: 100%; position: relative; }
        .search-group input { width: 100%; padding: 14px 14px 14px 45px; border-radius: 12px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); font-size: 14px; }
        .search-group i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--gold-primary); font-size: 16px; }

        .btn-filter { padding: 12px 30px; background: var(--gold-primary); color: #000; border: none; border-radius: 8px; font-weight: 700; text-transform: uppercase; cursor: pointer; }
        .btn-print { background: var(--gold-primary); color: #000; border: none; padding: 10px 20px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; }
        .btn-print:hover { opacity: 0.9; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; color: var(--gold-primary); border-bottom: 2px solid var(--border-color); font-size: 11px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 13px; vertical-align: middle; }
        tr:hover { background: rgba(255, 255, 255, 0.02); }
        .danger-text { color: #e74c3c; font-weight: 600; display: block; font-size: 11px; margin-top: 2px; }
        .success-text { color: #2ecc71; font-weight: 700; font-size: 15px; }

        #toast-alert { position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 8px; color: #fff; font-weight: 600; z-index: 10000; display: none; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }

        /* MODAL BACKDROP & BOX STYLES */
        .modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: var(--modal-overlay); display: flex; align-items: center; justify-content: center; z-index: 2000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }
        .modal-box { background: var(--bg-container); border: 1px solid var(--border-color); width: 100%; max-width: 600px; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); transform: translateY(-20px); transition: transform 0.3s ease; }
        .modal-overlay.active .modal-box { transform: translateY(0); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px; }
        .modal-header h2 { font-size: 18px; font-weight: 700; color: var(--gold-primary); }
        .modal-close-btn { background: transparent; border: none; color: var(--text-secondary); font-size: 20px; cursor: pointer; }
        .modal-close-btn:hover { color: #e74c3c; }

        .modal-section-title { font-size: 12px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin: 15px 0 10px 0; border-left: 3px solid var(--gold-primary); padding-left: 8px; }
        .modal-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .modal-field { display: flex; flex-direction: column; gap: 6px; }
        .modal-field label { font-size: 11px; color: var(--text-secondary); font-weight: 500; }
        .modal-field input { padding: 10px; background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 8px; font-size: 13px; }
        .modal-field input:focus { border-color: var(--gold-primary); outline: none; }
        .modal-field input.deduct-input { color: #e74c3c; font-weight: 600; }

        .modal-summary-box { background: var(--bg-input); border: 1px solid var(--border-color); padding: 15px; border-radius: 12px; margin-top: 20px; display: flex; flex-direction: column; gap: 8px; }
        .modal-summary-row { display: flex; justify-content: space-between; font-size: 13px; }
        .modal-summary-row.total-row { border-top: 1px dashed var(--border-color); padding-top: 8px; margin-top: 4px; font-weight: 700; font-size: 16px; color: #2ecc71; }

        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px; }
        .btn-modal-cancel { background: var(--bg-input); border: 1px solid var(--border-color); color: var(--text-primary); padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-modal-print { background: #27ae60; border: none; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 700; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-modal-print:hover { opacity: 0.9; }

        #print-payslip-area { display: none; }

        @media print {
            body * { display: none !important; }
            #print-payslip-area { display: block !important; background: #fff !important; color: #000 !important; width: 100% !important; height: auto !important; padding: 0 !important; margin: 0 !important; }
            #print-payslip-area * { display: block !important; color: #000 !important; background: transparent !important; }

            .payslip-box { width: 100%; max-width: 650px; margin: 40px auto; padding: 30px; border: 2px double #000; font-family: 'Courier New', Courier, monospace; }
            .payslip-header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 15px; margin-bottom: 20px; }
            .payslip-header h2 { font-size: 22px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
            .payslip-header p { font-size: 12px; }
            .payslip-row { display: flex !important; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
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
<div id="toast-alert"></div>

<div class="modal-overlay" id="payslipModal">
    <div class="modal-box">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Review & Modify Payslip</h2>
            <button class="modal-close-btn" onclick="closePayslipModal()"><i class="fas fa-times"></i></button>
        </div>

        <div class="modal-section-title">Employee Context</div>
        <div class="modal-grid">
            <div class="modal-field">
                <label>Employee Name</label>
                <input type="text" id="modalEmpName" readonly>
            </div>
            <div class="modal-field">
                <label>Employee ID</label>
                <input type="text" id="modalEmpId" readonly>
            </div>
        </div>

        <div class="modal-section-title">Variable Earnings / Time Deductions</div>
        <div class="modal-grid">
            <div class="modal-field">
                <label>Gross Earned (₱)</label>
                <input type="number" step="0.01" id="modalGross" oninput="modalLiveRecalculate()" readonly>
            </div>
            <div class="modal-field">
                <label>Late Deduction (₱)</label>
                <input type="number" step="0.01" class="deduct-input" id="modalLateDeduct" oninput="modalLiveRecalculate()">
            </div>
            <div class="modal-field">
                <label>Undertime Deduction (₱)</label>
                <input type="number" step="0.01" class="deduct-input" id="modalUndertimeDeduct" oninput="modalLiveRecalculate()">
            </div>
        </div>

        <div class="modal-section-title">Statutory Profiles (Modifiable)</div>
        <div class="modal-grid">
            <div class="modal-field">
                <label>Pag-IBIG Contribution</label>
                <input type="number" step="0.01" class="deduct-input" id="modalPagibig" oninput="modalLiveRecalculate()">
            </div>
            <div class="modal-field">
                <label>SSS Contribution</label>
                <input type="number" step="0.01" class="deduct-input" id="modalSss" oninput="modalLiveRecalculate()">
            </div>
            <div class="modal-field">
                <label>PhilHealth Insurance</label>
                <input type="number" step="0.01" class="deduct-input" id="modalPhilhealth" oninput="modalLiveRecalculate()">
            </div>
            <div class="modal-field">
                <label>Other Structural Deductions</label>
                <input type="number" step="0.01" class="deduct-input" id="modalOthers" oninput="modalLiveRecalculate()">
            </div>
        </div>

        <div class="modal-summary-box">
            <div class="modal-summary-row">
                <span>Total Calculated Deductions:</span>
                <span id="modalTotalDeductionsDisplay" style="color:#e74c3c; font-weight:600;">₱0.00</span>
            </div>
            <div class="modal-summary-row total-row">
                <span>Net Payout:</span>
                <span id="modalNetPayDisplay">₱0.00</span>
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closePayslipModal()">Cancel</button>
            <button class="btn-modal-print" onclick="executeFinalPrint()">
                <i class="fas fa-print"></i> Print Payslip
            </button>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <div class="top-action-bar">
        <a href="/admin" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <button type="button" class="theme-toggle-btn" onclick="toggleTheme()"><i class="fas fa-sun" id="themeIcon"></i></button>
    </div>

    <div class="header">
        <h1><i class="fas fa-calculator"></i> Payroll & Salary Calculator</h1>
        <p>Calculations derived from attendance parameters and statutory configurations</p>
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
                <th>Late (Mins/Deduct)</th>
                <th>Undertime (Mins/Deduct)</th>
                <th>Statutory Deductions</th>
                <th>Net Payroll Pay</th>
                <th style="text-align: center;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payrollData as $data)
                <tr class="employee-row"
                    data-emp-id="{{ $data['employee_id'] }}"
                    data-gross="{{ $data['gross_earned'] }}"
                    data-late-deduct="{{ $data['late_deduction'] }}"
                    data-undertime-deduct="{{ $data['undertime_deduction'] }}"
                    data-pagibig="{{ $data['pagibig_deduction'] }}"
                    data-sss="{{ $data['sss_deduction'] }}"
                    data-philhealth="{{ $data['philhealth_deduction'] }}"
                    data-others="{{ $data['other_deductions'] }}">

                    <td class="emp-id">{{ $data['employee_id'] }}</td>
                    <td class="emp-name"><strong>{{ $data['name'] }}</strong></td>
                    <td>₱{{ number_format($data['basic_salary'], 2) }}</td>
                    <td>{{ $data['days_worked'] }} Days</td>
                    <td>₱{{ number_format($data['gross_earned'], 2) }}</td>
                    <td>
                        {{ $data['late_minutes'] }} mins
                        <span class="danger-text">-₱{{ number_format($data['late_deduction'], 2) }}</span>
                    </td>
                    <td>
                        {{ number_format($data['undertime_minutes'], 2) }} mins
                        <span class="danger-text">-₱{{ number_format($data['undertime_deduction'], 2) }}</span>
                    </td>
                    <td>
                        <div style="font-size: 11px; color: var(--text-secondary); line-height: 1.4;">
                            Pag-IBIG: <span style="color:#e74c3c;">₱{{ number_format($data['pagibig_deduction'], 2) }}</span><br>
                            SSS: <span style="color:#e74c3c;">₱{{ number_format($data['sss_deduction'], 2) }}</span><br>
                            PhilHealth: <span style="color:#e74c3c;">₱{{ number_format($data['philhealth_deduction'], 2) }}</span><br>
                            Others: <span style="color:#e74c3c;">₱{{ number_format($data['other_deductions'], 2) }}</span>
                        </div>
                    </td>
                    <td class="success-text">₱{{ number_format($data['net_pay'], 2) }}</td>
                    <td style="text-align: center;">
                        <button class="btn-print" onclick="openPayslipModal(this)">
                            <i class="fas fa-print"></i> Payslip
                        </button>
                    </td>
                </tr>
            @empty
                <tr id="noResultsRow">
                    <td colspan="10" style="text-align: center; color: var(--text-secondary);">No calculations available for selected date range.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="print-payslip-area"></div>

<script>
    // Variables holding the target print dates globally for extraction
    const globalPeriodStart = "{{ $startDate }}";
    const globalPeriodEnd = "{{ $endDate }}";

    function filterEmployeesTable() {
        const input = document.getElementById('hrSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#payrollTable tbody .employee-row');

        rows.forEach(row => {
            const name = row.querySelector('.emp-name').innerText.toLowerCase();
            const id = row.querySelector('.emp-id').innerText.toLowerCase();

            if (name.includes(input) || id.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Modal Operations Engine
    function openPayslipModal(buttonElement) {
        const row = buttonElement.closest('.employee-row');

        // Feed dataset metrics directly into modal input structures
        document.getElementById('modalEmpName').value = row.querySelector('.emp-name').innerText;
        document.getElementById('modalEmpId').value = row.getAttribute('data-emp-id');
        document.getElementById('modalGross').value = parseFloat(row.getAttribute('data-gross')) || 0;
        document.getElementById('modalLateDeduct').value = parseFloat(row.getAttribute('data-late-deduct')) || 0;
        document.getElementById('modalUndertimeDeduct').value = parseFloat(row.getAttribute('data-undertime-deduct')) || 0;
        document.getElementById('modalPagibig').value = parseFloat(row.getAttribute('data-pagibig')) || 0;
        document.getElementById('modalSss').value = parseFloat(row.getAttribute('data-sss')) || 0;
        document.getElementById('modalPhilhealth').value = parseFloat(row.getAttribute('data-philhealth')) || 0;
        document.getElementById('modalOthers').value = parseFloat(row.getAttribute('data-others')) || 0;

        modalLiveRecalculate();
        document.getElementById('payslipModal').classList.add('active');
    }

    function closePayslipModal() {
        document.getElementById('payslipModal').classList.remove('active');
    }

    // Recalculates parameters dynamically inside modal panel wrapper
    function modalLiveRecalculate() {
        const gross = parseFloat(document.getElementById('modalGross').value) || 0;
        const late = parseFloat(document.getElementById('modalLateDeduct').value) || 0;
        const undertime = parseFloat(document.getElementById('modalUndertimeDeduct').value) || 0;
        const pagibig = parseFloat(document.getElementById('modalPagibig').value) || 0;
        const sss = parseFloat(document.getElementById('modalSss').value) || 0;
        const philhealth = parseFloat(document.getElementById('modalPhilhealth').value) || 0;
        const others = parseFloat(document.getElementById('modalOthers').value) || 0;

        const totalDeductions = late + undertime + pagibig + sss + philhealth + others;
        const netPay = Math.max(0, gross - totalDeductions);

        document.getElementById('modalTotalDeductionsDisplay').innerText = '₱' + totalDeductions.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('modalNetPayDisplay').innerText = '₱' + netPay.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Renders the tailored variables explicitly to the layout stream before executing print task
    function executeFinalPrint() {
        const printArea = document.getElementById('print-payslip-area');

        const name = document.getElementById('modalEmpName').value;
        const empId = document.getElementById('modalEmpId').value;
        const gross = parseFloat(document.getElementById('modalGross').value) || 0;
        const lateDeduct = parseFloat(document.getElementById('modalLateDeduct').value) || 0;
        const undertimeDeduct = parseFloat(document.getElementById('modalUndertimeDeduct').value) || 0;
        const pagibig = parseFloat(document.getElementById('modalPagibig').value) || 0;
        const sss = parseFloat(document.getElementById('modalSss').value) || 0;
        const philhealth = parseFloat(document.getElementById('modalPhilhealth').value) || 0;
        const others = parseFloat(document.getElementById('modalOthers').value) || 0;

        const totalDeductions = lateDeduct + undertimeDeduct + pagibig + sss + philhealth + others;
        const netPay = Math.max(0, gross - totalDeductions);

        printArea.innerHTML = `
            <div class="payslip-box">
                <div class="payslip-header">
                    <h2>OFFICIAL PAYSLIP</h2>
                    <p>Payroll Period: ${globalPeriodStart} to ${globalPeriodEnd}</p>
                </div>

                <div class="payslip-section-title">Employee Details</div>
                <div class="payslip-row"><span>Employee Name:</span><span><strong>${name}</strong></span></div>
                <div class="payslip-row"><span>Employee ID:</span><span>${empId}</span></div>

                <div class="payslip-divider"></div>

                <div class="payslip-section-title">Earnings Breakdown</div>
                <div class="payslip-row"><span>Basic Earned (Gross):</span><span><strong>₱${gross.toLocaleString(undefined, {minimumFractionDigits: 2})}</strong></span></div>

                <div class="payslip-divider"></div>

                <div class="payslip-section-title">Deductions Ledger</div>
                <div class="payslip-row"><span>Lateness Deduction:</span><span>- ₱${lateDeduct.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row"><span>Undertime Deduction:</span><span>- ₱${undertimeDeduct.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row"><span>Pag-IBIG Contribution:</span><span>- ₱${pagibig.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row"><span>SSS Contribution:</span><span>- ₱${sss.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row"><span>PhilHealth Insurance:</span><span>- ₱${philhealth.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row"><span>Other Deductions:</span><span>- ₱${others.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>
                <div class="payslip-row bold" style="margin-top: 12px;"><span>Total Combined Deductions:</span><span>- ₱${totalDeductions.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>

                <div class="payslip-divider"></div>

                <div class="payslip-row bold" style="font-size: 16px;"><span>NET PAYOUT:</span><span>₱${netPay.toLocaleString(undefined, {minimumFractionDigits: 2})}</span></div>

                <div class="payslip-divider"></div>

                <div class="signatures">
                    <div class="sig-line">Prepared By (HR)</div>
                    <div class="sig-line">Employee Signature</div>
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
