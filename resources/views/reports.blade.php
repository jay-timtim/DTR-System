<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports | DTR System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Poppins, sans-serif;
        }

        body{
            display:flex;
            background:#f4f6f9;
        }

        /* Sidebar */

        .sidebar{
            width:250px;
            height:100vh;
            background:linear-gradient(180deg,#1e3c72,#2a5298);
            padding:25px 20px;
            color:white;
            position:fixed;
        }

        .sidebar h2{
            text-align:center;
            font-size:20px;
            margin-bottom:40px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px 15px;
            border-radius:8px;
            margin-bottom:10px;
            font-size:14px;
            transition:.3s;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,.15);
        }

        /* Main Content */

        .main{
            margin-left:250px;
            width:100%;
            padding:30px;
        }

        .topbar h1{
            font-size:22px;
            margin-bottom:25px;
        }

        /* Analytics Cards */

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,.05);
        }

        .card h3{
            font-size:14px;
            color:#777;
        }

        .card p{
            font-size:24px;
            font-weight:600;
            color:#2a5298;
            margin-top:10px;
        }

        /* Report Filter Panel */

        .filter-panel{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,.05);
            margin-bottom:25px;
        }

        .filter-panel h3{
            margin-bottom:15px;
            font-size:16px;
        }

        .filter-group{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .filter-group input,
        .filter-group select{
            padding:10px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        .btn-generate{
            background:#2a5298;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:6px;
            cursor:pointer;
        }

        /* Export Buttons */

        .export-group{
            margin-top:15px;
        }

        .btn-export{
            padding:8px 14px;
            border:none;
            border-radius:6px;
            font-size:13px;
            cursor:pointer;
            margin-right:10px;
            color:white;
        }

        .btn-excel{
            background:#198754;
        }

        .btn-pdf{
            background:#dc3545;
        }

        /* Table */

        .table-container{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,.05);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th, td{
            padding:12px;
            font-size:14px;
            text-align:left;
        }

        th{
            background:#2a5298;
            color:white;
        }

        tr:nth-child(even){
            background:#f9f9f9;
        }

    </style>
</head>

<body>

<!-- Sidebar -->

<div class="sidebar">
    <h2>DTR ADMIN</h2>

    <a href="/admin">Dashboard</a>
    <a href="/manage-employees">Manage Employees</a>
    <a href="/view-dtr">View DTR Records</a>
    <a href="/reports">Reports</a>
    <a href="logout">Logout</a>
</div>

<!-- Main Content -->

<div class="main">

    <div class="topbar">
        <h1>Reports</h1>
    </div>

    <!-- Analytics Cards -->

    <div class="cards">

        <div class="card">
            <h3>Total Attendance Records</h3>
            <p>{{ $totalAttendance }}</p>
        </div>

        <div class="card">
            <h3>Most Present Employee</h3>
            <p>
                {{ $mostPresentName ?? 'N/A' }}
            </p>
        </div>

        <div class="card">
            <h3>Late Today</h3>
            <p>{{ $lateToday }}</p>
        </div>

    </div>

    <!-- Report Filter Panel -->

    <div class="filter-panel">

        <h3>Generate Attendance Report</h3>

        <form method="GET" action="/reports">

            <div class="filter-group">

                <select name="employee_id">

                    <option value="">All Employees</option>

                    @foreach($employees as $emp)
                        <option value="{{ $emp->employee_id }}">
                            {{ $emp->employee_id }}
                            -
                            {{ $emp->first_name }}
                            {{ $emp->last_name }}
                        </option>
                    @endforeach

                </select>

                <input type="date" name="start_date">
                <input type="date" name="end_date">

                <button class="btn-generate" type="submit">
                    Generate Report
                </button>

            </div>

        </form>

    </div>

    <!-- Report Preview Table -->

    <div class="table-container">

        <h3 style="margin-bottom:15px;">Report Preview</h3>

        <table>

            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>

            @if($records->isEmpty())

                <tr>
                    <td colspan="6" style="text-align:center;color:#777;padding:30px;">
                        No report data found
                    </td>
                </tr>

            @else

                @foreach($records as $record)

                    <tr>

                        <td>{{ $record->employee_id }}</td>

                        <td>{{ $record->first_name }} {{ $record->last_name }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}
                        </td>

                        <td>
                            {{ $record->time_in
                            ? \Carbon\Carbon::parse($record->time_in)->format('h:i A')
                            : '—' }}
                        </td>

                        <td>
                            {{ $record->time_out
                            ? \Carbon\Carbon::parse($record->time_out)->format('h:i A')
                            : '—' }}
                        </td>

                        <td style="font-weight:600;
{{ $record->status=='TIME_OUT' ? 'color:#198754' : 'color:#ffc107' }}">

                            {{ $record->status }}

                        </td>

                    </tr>

                @endforeach

            @endif

            </tbody>

        </table>
        <div style="margin-top:15px;">
            {{ $records->links() }}
        </div>

    </div>

</div>

</body>
</html>
