<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Resource Updater</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Orbitron', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: radial-gradient(circle at center, #1a0033, #000);
        }

        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(transparent 0%, rgba(255, 0, 255, 0.05) 2%, transparent 3%),
                linear-gradient(90deg, transparent 0%, rgba(0, 255, 255, 0.05) 2%, transparent 3%);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
        }

        @keyframes gridMove {
            from { transform: translateY(0); }
            to { transform: translateY(50px); }
        }

        .container {
            position: relative;
            width: 900px;
            background: rgba(10, 10, 25, 0.9);
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 40px;
            margin: 20px;
            animation: borderColor 8s linear infinite;
        }

        @keyframes borderColor {
            0% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff, inset 0 0 20px rgba(255, 0, 255, 0.5); }
            33% { border-color: #00ffff; box-shadow: 0 0 20px #00ffff, inset 0 0 20px rgba(0, 255, 255, 0.5); }
            66% { border-color: #ff0000; box-shadow: 0 0 20px #ff0000, inset 0 0 20px rgba(255, 0, 0, 0.5); }
            100% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff, inset 0 0 20px rgba(255, 0, 255, 0.5); }
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: titleColor 8s linear infinite;
        }

        @keyframes titleColor {
            0% { color: #ff00ff; text-shadow: 0 0 10px #ff00ff; }
            33% { color: #00ffff; text-shadow: 0 0 10px #00ffff; }
            66% { color: #ff0000; text-shadow: 0 0 10px #ff0000; }
            100% { color: #ff00ff; text-shadow: 0 0 10px #ff00ff; }
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9em;
            animation: toggleColor 8s linear infinite;
        }

        input {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid;
            border-radius: 10px;
            color: #fff;
            font-size: 1em;
            letter-spacing: 1px;
            outline: none;
            transition: 0.3s;
            animation: inputBorder 8s linear infinite;
        }

        @keyframes inputBorder {
            0% { border-color: #ff00ff; }
            33% { border-color: #00ffff; }
            66% { border-color: #ff0000; }
            100% { border-color: #ff00ff; }
        }

        input:focus {
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
        }

        button {
            width: 200px;
            padding: 15px;
            margin: 20px auto;
            background: transparent;
            border: 2px solid;
            border-radius: 10px;
            font-size: 1.1em;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            animation: buttonColor 8s linear infinite;
        }

        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        button:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            animation: buttonHover 8s linear infinite;
        }

        @keyframes buttonHover {
            0% { box-shadow: 0 0 20px rgba(255, 0, 255, 0.5); }
            33% { box-shadow: 0 0 20px rgba(0, 255, 255, 0.5); }
            66% { box-shadow: 0 0 20px rgba(255, 0, 0, 0.5); }
            100% { box-shadow: 0 0 20px rgba(255, 0, 255, 0.5); }
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #ff00ff, #00ffff, #ff0000);
            animation: scan 2s linear infinite;
            opacity: 0.5;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        .message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 30px;
            border-radius: 5px;
            color: #fff;
            font-size: 1.1em;
            z-index: 1000;
            animation: messageAppear 0.3s ease-out;
        }

        .success {
            background: rgba(0, 255, 0, 0.2);
            border: 2px solid #00ff00;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            border: 2px solid #ff0000;
        }

        @keyframes messageAppear {
            from { transform: translate(-50%, -100%); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    
    <!-- Search Form -->
    <div class="container">
        <div class="scan-line"></div>
        <h1>Resource Updater</h1>
        <form action="" method="POST" class="search-form">
            <div class="input-group">
                <label for="course_code">Course Code</label>
                <input type="text" id="course_code" name="course_code" placeholder="Enter course code" required>
            </div>
            <button type="submit">Search Course</button>
        </form>
    </div>

    <script>
        // Auto-hide messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>