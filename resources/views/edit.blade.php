<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Edit Employee</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#f4f6f9;
            padding:40px;
        }

        .container{
            max-width:900px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,.05);
        }

        .header{
            display:flex;
            align-items:center;
            gap:20px;
            margin-bottom:25px;
        }

        .header img{
            width:80px;
            height:80px;
            border-radius:50%;
            object-fit:cover;
        }

        .header h2{
            font-size:22px;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
        }

        .form-group{
            display:flex;
            flex-direction:column;
        }

        .form-group label{
            font-size:13px;
            margin-bottom:4px;
        }

        .form-group input,
        .form-group select{
            padding:8px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        .section-title{
            margin-top:20px;
            margin-bottom:10px;
            font-weight:600;
        }

        .schedule-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
        }

        .actions{
            margin-top:25px;
            display:flex;
            justify-content:flex-end;
            gap:10px;
        }

        .btn-save{
            background:#2a5298;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:6px;
            cursor:pointer;
        }

        .btn-cancel{
            background:#6c757d;
            color:white;
            padding:10px 18px;
            border-radius:6px;
            text-decoration:none;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <img src="{{ $employee->photo_path ? asset('storage/'.$employee->photo_path) : 'https://i.pravatar.cc/100' }}">

        <div>
            <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <p>ID: {{ $employee->employee_id }}</p>
        </div>

    </div>

    <form action="{{ route('employees.update',$employee->employee_id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ $employee->first_name }}">
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ $employee->last_name }}">
            </div>

            <div class="form-group">
                <label>Gender</label>

                <select name="gender">

                    <option value="Male" {{ $employee->gender=='Male'?'selected':'' }}>Male</option>

                    <option value="Female" {{ $employee->gender=='Female'?'selected':'' }}>Female</option>

                </select>

            </div>

            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" value="{{ $employee->position }}">
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
                <label>Status</label>

                <select name="status">

                    <option value="Active" {{ $employee->status=='Active'?'selected':'' }}>Active</option>

                    <option value="Inactive" {{ $employee->status=='Inactive'?'selected':'' }}>Inactive</option>

                </select>

            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Address</label>
                <input type="text" name="address" value="{{ $employee->address }}">
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Change Photo</label>
                <input type="file" name="photo_path">
            </div>

        </div>

        <h3 class="section-title">Schedule</h3>

        <div class="schedule-grid">

            <div class="form-group">
                <label>Schedule Start</label>
                <input type="time" name="schedule_start" value="{{ $employee->schedule_start }}">
            </div>

            <div class="form-group">
                <label>Break Start</label>
                <input type="time" name="break_start" value="{{ $employee->break_start }}">
            </div>

            <div class="form-group">
                <label>Break End</label>
                <input type="time" name="break_end" value="{{ $employee->break_end }}">
            </div>

            <div class="form-group">
                <label>Schedule End</label>
                <input type="time" name="schedule_end" value="{{ $employee->schedule_end }}">
            </div>

        </div>

        <div class="actions">

            <a href="/manage-employees" class="btn-cancel">Cancel</a>

            <button type="submit" class="btn-save">
                Update Employee
            </button>

        </div>

    </form>

</div>

</body>
</html>
