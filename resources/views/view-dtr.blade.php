<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View DTR Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
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

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .topbar h1{
            font-size:22px;
            color:#333;
            font-weight:600;
        }

        /* Filter Panel */

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

        .btn-filter{
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

        /* Attendance Status */

        .status-present{
            color:#198754;
            font-weight:600;
        }

        .status-late{
            color:#ffc107;
            font-weight:600;
        }

        .status-absent{
            color:#dc3545;
            font-weight:600;
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
    <a href="/logout">Logout</a>
</div>

<!-- Main Content -->

<div class="main">

    <div class="topbar">
        <h1>View DTR Records</h1>
    </div>

    <!-- Filter Panel -->

    <div class="filter-panel">

        <h3>Attendance Records Filter</h3>

        <form method="GET" action="/view-dtr">

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

                <button class="btn-filter" type="submit">
                    Apply Filter
                </button>

            </div>

        </form>

        <div class="export-group">
            <button class="btn-export btn-excel">
                Export Excel
            </button>

            <button class="btn-export btn-pdf">
                Export PDF
            </button>
        </div>

    </div>

    <!-- Attendance Table -->

    <div class="table-container">

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
                        No attendance records found
                    </td>
                </tr>

            @else

                @foreach($records as $record)

                    <tr>

                        <td>{{ $record->employee_id }}</td>

                        <td>{{ $record->first_name }} {{ $record->last_name }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($record->log_time)->format('M d, Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($record->log_time)->format('h:i A') }}
                        </td>

                        <td>
                            {{ $record->log_type == 'TIME_OUT'
                            ? \Carbon\Carbon::parse($record->log_time)->format('h:i A')
                            : '—' }}
                        </td>

                        <td>

                            @php
                                $status = '';

                                if($record->log_type == 'TIME_IN'){
                                    $status = 'Present';
                                }
                                elseif($record->log_type == 'BREAK_OUT'){
                                    $status = 'On Break';
                                }
                                elseif($record->log_type == 'BREAK_IN'){
                                    $status = 'Returned';
                                }
                                elseif($record->log_type == 'TIME_OUT'){
                                    $status = 'Completed';
                                }
                            @endphp

                            <span class="
{{ $status == 'Present' ? 'status-present' :
($status == 'On Break' ? 'status-late' : 'status-absent') }}
">

{{ $status }}

</span>

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
