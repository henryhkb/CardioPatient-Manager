<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Korle Bu Cardio OPD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            overflow: hidden;
        }

        /* Heart Pulse */
        .heart {
            font-size: 60px;
            color: #ff4d4d;
            animation: pulse 1s infinite;
            margin-bottom: 20px;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(1); }
            75% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* ECG Line */
        .ecg-container {
            width: 300px;
            height: 60px;
            position: relative;
            overflow: hidden;
        }

        .ecg-line {
            width: 600px;
            height: 100%;
            background: transparent;
            border-bottom: 2px solid #00ffcc;
            position: absolute;
            animation: move 2s linear infinite;
        }

        .ecg-line::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent 0%,
                transparent 20%,
                #00ffcc 20%,
                #00ffcc 22%,
                transparent 22%,
                transparent 30%,
                #00ffcc 30%,
                #00ffcc 32%,
                transparent 32%,
                transparent 40%,
                #00ffcc 40%,
                #00ffcc 42%,
                transparent 42%
            );
        }

        @keyframes move {
            0% { left: 0; }
            100% { left: -300px; }
        }

        .title {
            margin-top: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 14px;
            opacity: 0.7;
        }
    </style>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('welcome') }}";
        }, 4000); // 4 seconds
    </script>
</head>
<body>

    <div class="heart">❤️</div>

    <div class="ecg-container">
        <div class="ecg-line"></div>
    </div>

    <div class="title">Korle Bu Cardio OPD</div>
    <div class="subtitle">Booking & Reminder System</div>

</body>
</html>
