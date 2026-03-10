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

        .btn{
            flex:1;
            padding:18px;
            font-size:18px;
            font-weight:600;
            border:none;
            border-radius:10px;
            cursor:pointer;
            color:white;
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
        .button-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
        }

        .btn-breakout{
            background:#ff9800;
        }

        .btn-breakout:hover{
            background:#e68900;
            transform:translateY(-2px);
        }

        .btn-breakin{
            background:#17a2b8;
        }

        .btn-breakin:hover{
            background:#138496;
            transform:translateY(-2px);
        }



        #barcode-scanner {
                 /* fixed relative to container */
            top: 20px;                /* distance from container top */
            left: 50%;                /* center horizontally */
            width: 400px;             /* fixed width */
            height: 250px;            /* fixed height */
            border: 2px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
            z-index: 10;              /* above other container content if needed */
        }

        #barcode-scanner video {
            width: 100%;
            height: 100%;
            object-fit: cover;        /* maintain aspect ratio */
        }

        /* Adjust container padding to make room for scanner */


        /* Overlay for scanning guidance */

    </style>

</head>
<body>


<div class="container">
    @if(session('error'))
        <div style="color:red;font-weight:bold;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="color:green;font-weight:bold;">
            {{ session('success') }}
        </div>
    @endif
    <div class="company-name">
        BIZMATECH PHILIPPINES
    </div>

    <div class="title">
        Daily Time Record System
    </div>
        <div id="barcode-scanner">
        </div>
    <form method="POST" action="/dtr/log">
        @csrf


            <input type="text" name="employee_id" id="employeeInput" placeholder="Scan barcode or enter ID" autocomplete="off" required>


        <div class="button-grid" id="actionButtons">
            <button disabled class="btn">Enter Employee ID</button>
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
<script>

    const employeeInput = document.querySelector("input[name='employee_id']");
    const buttonContainer = document.getElementById("actionButtons");

    employeeInput.addEventListener("keyup", function(){

        let id = this.value.trim();

        if(id.length < 3){
            buttonContainer.innerHTML =
                `<button disabled class="btn">Enter Employee ID</button>`;
            return;
        }

        fetch(`/dtr/status/${id}`)
            .then(res => res.json())
            .then(data => {

                if(data.next.length === 0){
                    buttonContainer.innerHTML =
                        `<div style="font-weight:600;color:#28a745;">
                        Shift Completed
                    </div>`;
                    return;
                }

                let buttons = '';

                data.next.forEach(type => {

                    let label = type.replace('_',' ');
                    let className = '';

                    if(type==='TIME_IN') className='btn-timein';
                    if(type==='TIME_OUT') className='btn-timeout';
                    if(type==='BREAK_OUT') className='btn-breakout';
                    if(type==='BREAK_IN') className='btn-breakin';

                    buttons += `
                <button type="submit"
                    name="log_type"
                    value="${type}"
                    class="btn ${className}">
                    ${label}
                </button>
                `;
                });

                buttonContainer.innerHTML = buttons;

            });

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<audio id="beepSound">
    <source src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg">
</audio>


<script>
    const scannerContainer = document.getElementById("barcode-scanner");
    const beep = document.getElementById("beepSound");

    let lastScan = null;
    let scanning = false;

    console.log("🚀 Initializing Quagga2 scanner...");

    function startScanner() {
        if (scanning) {
            console.warn("⚠️ Scanner already running.");
            return;
        }

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: scannerContainer,
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                }
            },
            locator: { patchSize: "medium", halfSample: true },
            decoder: { readers: ["code_128_reader"] },
            locate: true,
            frequency: 10
        }, function(err) {
            if (err) {
                console.error("❌ Quagga2 init failed:", err);
                return;
            }
            console.log("✅ Quagga2 initialized successfully");
            Quagga.start();
            scanning = true;
            console.log("📷 Camera stream started");
        });
    }

    /* Triggered when a barcode is detected */
    Quagga.onDetected(function(data) {
        const code = data.codeResult?.code;

        if (!code) {
            console.warn("⚠️ No code in result");
            return;
        }

        console.log("🎯 Barcode detected:", code);

        if (code === lastScan) {
            console.log("⚠️ Duplicate scan ignored");
            return;
        }

        lastScan = code;

        // Only accept Code128 format (EMP-XXXXX)
        const valid = /^EMP-[A-Z0-9]+$/;
        if (!valid.test(code)) {
            console.warn("⚠️ Barcode format invalid:", code);
            return;
        }

        console.log("✅ Valid scan:", code);
        employeeInput.value = code;

        // Play beep sound
        try { beep.play(); } catch(err) { console.error("Beep failed", err); }

        // Fetch employee status automatically
        fetch(`/dtr/status/${code}`)
            .then(res => res.json())
            .then(data => {
                console.log("📡 Employee status fetched:", data);

                if (data.next.length === 0) {
                    buttonContainer.innerHTML = `
                    <div style="font-weight:600;color:#28a745;">
                        Shift Completed
                    </div>`;
                    return;
                }

                let buttons = '';
                data.next.forEach(type => {
                    let label = type.replace('_', ' ');
                    let className = '';
                    if(type === 'TIME_IN') className = 'btn-timein';
                    if(type === 'TIME_OUT') className = 'btn-timeout';
                    if(type === 'BREAK_OUT') className = 'btn-breakout';
                    if(type === 'BREAK_IN') className = 'btn-breakin';

                    buttons += `<button type="submit"
                    name="log_type"
                    value="${type}"
                    class="btn ${className}">
                    ${label}
                </button>`;
                });

                buttonContainer.innerHTML = buttons;

                // Optionally: automatically submit first action
                // attendanceForm.submit();
            })
            .catch(err => {
                console.error("❌ Error fetching employee status:", err);
            });

        // Reset lastScan after a short delay
        setTimeout(() => {
            lastScan = null;
            console.log("🔄 Ready for next scan");
        }, 1500);
    });

    /* Stop scanner */
    function stopScanner() {
        if (scanning) {
            Quagga.stop();
            scanning = false;
            console.log("🛑 Scanner stopped");
        }
    }

    /* Start scanner automatically */
    startScanner();
</script>

</body>
</html>
