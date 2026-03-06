<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employees | DTR Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f6f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            padding: 25px 20px;
            color: white;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.3s;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.15);
        }

        /* MAIN */
        .main {
            margin-left: 250px;
            width: 100%;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .btn-add {
            padding: 10px 18px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: #1e3c72;
        }

        /* SEARCH */
        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 300px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* TABLE */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #2a5298;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* ACTION BUTTONS */
        .btn-edit {
            padding: 6px 10px;
            background: #ffc107;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-delete {
            padding: 6px 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 400px;
        }

        .modal-content h3 {
            margin-bottom: 15px;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .modal-actions {
            text-align: right;
        }

        .btn-save {
            background: #2a5298;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
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
        <input type="text" placeholder="Search by name or employee ID">
    </div>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Date Hired</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>EMP001</td>
                <td>Juan Dela Cruz</td>
                <td>IT Department</td>
                <td>Jan 10, 2024</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Delete</button>
                </td>
            </tr>
            <tr>
                <td>EMP002</td>
                <td>Maria Santos</td>
                <td>HR Department</td>
                <td>Feb 05, 2023</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- ADD EMPLOYEE MODAL -->
<div class="modal" id="employeeModal">
    <div class="modal-content">
        <h3>Add New Employee</h3>

        <input type="text" placeholder="Employee ID">
        <input type="text" placeholder="First Name">
        <input type="text" placeholder="Last Name">
        <input type="text" placeholder="Department">

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button class="btn-save">Save</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('employeeModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('employeeModal').style.display = 'none';
    }
</script>

</body>
</html>
