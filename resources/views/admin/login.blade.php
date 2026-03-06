<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
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
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
        }

        .login-box{
            width:380px;
            background:white;
            padding:40px;
            border-radius:15px;
            box-shadow:0 20px 40px rgba(0,0,0,.2);
            text-align:center;
        }

        .login-box h2{
            color:#2a5298;
            margin-bottom:30px;
        }

        .input-group{
            margin-bottom:20px;
        }

        .input-group input{
            width:100%;
            padding:14px;
            border-radius:8px;
            border:2px solid #eee;
            font-size:14px;
            transition:.3s;
        }

        .input-group input:focus{
            border-color:#2a5298;
            outline:none;
        }

        .btn-login{
            width:100%;
            padding:14px;
            background:#2a5298;
            border:none;
            color:white;
            border-radius:8px;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        .btn-login:hover{
            background:#1e3c72;
        }

        .error-msg{
            color:#dc3545;
            font-size:13px;
            margin-bottom:15px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>Administrator Login</h2>

    @if(session('error'))
        <div class="error-msg">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf

        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button class="btn-login" type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>
