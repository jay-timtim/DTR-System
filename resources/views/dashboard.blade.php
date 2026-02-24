<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | DTR System</title>
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

        /* MAIN CONTENT */
        .main {
            margin-left: 250px;
            width: 100%;
            padding: 30px;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .admin-info {
            font-size: 14px;
            color: #555;
        }

        /* DASHBOARD CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .card h3 {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 22px;
            font-weight: 600;
            color: #2a5298;
        }

        /* FILTER SECTION */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .filter-section h3 {
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        input[type="date"] {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn-filter {
            padding: 10px 20px;
            border: none;
            background: #2a5298;
            color: white;
            border-radius: 6px;
            cursor: pointer;
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

    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>DTR ADMIN</h2>

    <a href="/admin">Dashboard</a>
    <a href="/manage-employees">Manage Employees</a>
    <a href="/view-dtr">View DTR Records</a>
    <a href="/reports">Reports</a>
    <a href="/">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <h1>Admin Dashboard</h1>
        <div class="admin-info">
            Welcome, Admin
        </div>
    </div>

    <!-- DASHBOARD CARDS -->
    <div class="cards">
        <div class="card">
            <h3>Total Employees</h3>
            <p>120</p>
        </div>

        <div class="card">
            <h3>Present Today</h3>
            <p>98</p>
        </div>

        <div class="card">
            <h3>Late Today</h3>
            <p>5</p>
        </div>

        <div class="card">
            <h3>Absent Today</h3>
            <p>17</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <h3>Filter DTR by Date Range</h3>

        <div class="filter-group">
            <input type="date">
            <input type="date">
            <button class="btn-filter">Filter</button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-container">
        <h3 style="margin-bottom:15px;">Recent Attendance Records</h3>

        <table>
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>EMP001</td>
                <td>Juan Dela Cruz</td>
                <td>Feb 24, 2026</td>
                <td>08:01 AM</td>
                <td>05:02 PM</td>
            </tr>
            <tr>
                <td>EMP002</td>
                <td>Maria Santos</td>
                <td>Feb 24, 2026</td>
                <td>08:15 AM</td>
                <td>—</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
