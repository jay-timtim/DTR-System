<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employees | DTR Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            display:flex;
            background:#f4f6f9;
        }

        /* SIDEBAR */

        .sidebar{
            width:250px;
            height:100vh;
            background:linear-gradient(180deg,#1e3c72,#2a5298);
            padding:25px;
            color:white;
            position:fixed;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:35px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px;
            border-radius:8px;
            margin-bottom:8px;
            font-size:14px;
            transition:.3s;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,0.15);
        }

        /* MAIN */

        .main{
            margin-left:250px;
            width:100%;
            padding:30px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }

        .topbar h1{
            font-size:22px;
            color:#333;
        }

        .btn-add{
            background:#2a5298;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            cursor:pointer;
        }

        .btn-add:hover{
            background:#1e3c72;
        }

        /* SEARCH */

        .search-bar{
            margin-bottom:15px;
        }

        .search-bar input{
            padding:10px;
            width:300px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        /* TABLE */

        .table-container{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            padding:12px;
            font-size:13px;
            text-align:left;
        }

        th{
            background:#2a5298;
            color:white;
        }

        tr:nth-child(even){
            background:#f9f9f9;
        }

        .employee-photo{
            width:40px;
            height:40px;
            border-radius:50%;
            object-fit:cover;
        }

        /* BUTTONS */

        .btn-edit{
            background:#ffc107;
            border:none;
            padding:6px 10px;
            border-radius:5px;
            cursor:pointer;
            font-size:12px;
        }

        .btn-delete{
            background:#dc3545;
            color:white;
            border:none;
            padding:6px 10px;
            border-radius:5px;
            cursor:pointer;
            font-size:12px;
        }

        /* MODAL */

        .modal{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.5);
            justify-content:center;
            align-items:center;
        }

        .modal-content{
            background:white;
            padding:25px;
            border-radius:12px;
            width:500px;
            max-height:90vh;
            overflow-y:auto;
        }

        .modal-content h3{
            margin-bottom:15px;
        }

        .form-group{
            margin-bottom:10px;
        }

        .form-group label{
            font-size:13px;
        }

        .form-group input,
        .form-group select{
            width:100%;
            padding:8px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        .schedule-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
        }

        .modal-actions{
            margin-top:10px;
            text-align:right;
        }

        .btn-save{
            background:#2a5298;
            color:white;
            border:none;
            padding:8px 15px;
            border-radius:6px;
        }

        .btn-cancel{
            background:#6c757d;
            color:white;
            border:none;
            padding:8px 15px;
            border-radius:6px;
        }

    </style>
</head>
<body>

<div class="sidebar">
    <h2>DTR ADMIN</h2>
    <a href="/admin">Dashboard</a>
    <a href="/manage-employees">Manage Employees</a>
    <a href="/view-dtr">View DTR Records</a>
    <a href="/reports">Reports</a>
    <a href="/logout">Logout</a>
</div>

<div class="main">

    <div class="topbar">
        <h1>Manage Employees</h1>
        <button class="btn-add" onclick="openModal()">+ Add Employee</button>
    </div>

    <div class="search-bar">
        <input type="text" id="employeeSearch" placeholder="Search employee...">
    </div>

    <div class="table-container">
        <table>

            <thead>
            <tr>
                <th>Photo</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Status</th>
                <th>Schedule</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody id="employeeTable">

            @foreach($employees as $employee)
                <tr>

                    <td>
                        <img
                            src="{{ $employee->photo_path ? asset('storage/'.$employee->photo_path) : 'https://i.pravatar.cc/40' }}"
                            class="employee-photo">
                    </td>

                    <td>{{ $employee->employee_id }}</td>

                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>

                    <td>{{ $employee->position }}</td>

                    <td>{{ $employee->employment_status }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($employee->schedule_start)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($employee->break_start)->format('H:i') }}
                        /
                        {{ \Carbon\Carbon::parse($employee->break_end)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($employee->schedule_end)->format('H:i') }}
                    </td>

                    <td>
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </td>

                </tr>
            @endforeach

            </tbody>

        </table>
    </div>

</div>

<!-- ADD EMPLOYEE MODAL -->

<div class="modal" id="employeeModal">

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="modal-content">

            <h3>Add New Employee</h3>

            <div class="form-group">
                <label>Generated Employee ID</label>
                <div style="font-weight:bold;font-size:20px;color:#1e3c72;" id="generatedEmployeeId">
                    <label> AUTO - GENERATED </label>
                </div>
                <input type="hidden" name="employee_id" id="employee_id">
            </div>

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address">
            </div>

            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position">
            </div>

            <div class="form-group">
                <label>Employment Status</label>
                <select name="employment_status">
                    <option value="Regular">Regular</option>
                    <option value="Probationary">Probationary</option>
                    <option value="Contractual">Contractual</option>
                </select>
            </div>

            <h4>Schedule</h4>

            <div class="schedule-grid">

                <div class="form-group">
                    <label>Start</label>
                    <input type="time" name="schedule_start">
                </div>

                <div class="form-group">
                    <label>Break Start</label>
                    <input type="time" name="break_start">
                </div>

                <div class="form-group">
                    <label>Break End</label>
                    <input type="time" name="break_end">
                </div>

                <div class="form-group">
                    <label>End</label>
                    <input type="time" name="schedule_end">
                </div>

            </div>

            <div class="form-group">
                <label>Photo</label>
                <input type="file" name="photo_path">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Employee</button>
            </div>

        </div>

    </form>

</div>

<script>

    function generateEmployeeIdPreview() {

        const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let randomPart = "";

        for (let i = 0; i < 6; i++) {
            randomPart += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        const employeeId = "EMP-" + randomPart;

        // Display only (visual preview)
        document.getElementById("generatedEmployeeId").innerText = 'AUTO-GENERATED';
    }

    function openModal() {
        generateEmployeeIdPreview();
        document.getElementById('employeeModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('employeeModal').style.display = 'none';
    }
    document.getElementById("employeeSearch").addEventListener("keyup", function () {

        let searchValue = this.value.toLowerCase();
        let tableRows = document.querySelectorAll("#employeeTable tr");

        tableRows.forEach(function(row){

            let text = row.innerText.toLowerCase();

            if(text.includes(searchValue)){
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

        });

    });
</script>

</body>
</html>
