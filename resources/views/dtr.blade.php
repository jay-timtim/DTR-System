<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DTR System</title>
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
            height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #ffffff;
            width: 450px;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
        }

        .company-name {
            font-size: 22px;
            font-weight: 600;
            color: #2c5364;
            margin-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: 400;
            color: #555;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 25px;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border-radius: 8px;
            border: 2px solid #ddd;
            text-align: center;
            transition: 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #2c5364;
            outline: none;
            box-shadow: 0 0 8px rgba(44, 83, 100, 0.3);
        }

        .button-group {
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
            color: white;
        }

        .btn-timein {
            background-color: #28a745;
        }

        .btn-timein:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-timeout {
            background-color: #dc3545;
        }

        .btn-timeout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .admin-link {
            margin-top: 25px;
        }

        .admin-link a {
            text-decoration: none;
            font-size: 14px;
            color: #2c5364;
            font-weight: 500;
        }

        .admin-link a:hover {
            text-decoration: underline;
        }

        /* 🔥 Enhanced Live Clock Styling */
        .footer-time {
            margin-top: 25px;
            font-size: 16px;
            font-weight: 600;
            color: #2c5364;
            letter-spacing: 1px;
        }

        .seconds {
            color: #dc3545;
            font-weight: 700;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="company-name">
        BIZMATECH PHILIPPINES
    </div>

    <div class="title">
        Daily Time Record System
    </div>

    <form method="POST">
        @csrf

        <div class="input-group">
            <input type="text" name="employee_id" placeholder="Enter Employee ID" required>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-timein">
                TIME IN
            </button>

            <button type="submit" class="btn btn-timeout">
                TIME OUT
            </button>
        </div>
    </form>

    <div class="admin-link">
        <a href="/admin/login">Administrator Login</a>
    </div>

    <!-- 🔥 Live Running Clock -->
    <div class="footer-time" id="liveClock">
        Loading time...
    </div>

</div>

<!-- 🔥 Live Clock Script -->
<script>
    function updateClock() {
        const now = new Date();

        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: '2-digit'
        };

        const date = now.toLocaleDateString('en-US', options);

        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();

        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        const time = `
            ${hours}:${minutes}:<span class="seconds">${seconds}</span> ${ampm}
        `;

        document.getElementById('liveClock').innerHTML = `${date} | ${time}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>
