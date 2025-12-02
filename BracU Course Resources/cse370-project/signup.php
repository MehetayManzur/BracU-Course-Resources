<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Resources Interface</title>
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
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #1a0033, #000);
            overflow: hidden;
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
            z-index: -1;
        }

        @keyframes gridMove {
            from { transform: translateY(0); }
            to { transform: translateY(50px); }
        }

        .container {
            background: rgba(10, 10, 25, 0.9);
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 40px;
            position: relative;
            animation: borderColor 8s linear infinite;
            text-align: center;
            max-width: 800px;
            width: 90%;
        }

        @keyframes borderColor {
            0% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff; }
            33% { border-color: #00ffff; box-shadow: 0 0 20px #00ffff; }
            66% { border-color: #ff0000; box-shadow: 0 0 20px #ff0000; }
            100% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff; }
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #ff00ff, #00ffff, #ff0000);
            animation: scan 2s linear infinite;
            opacity: 0.5;
            left: 0;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 40px;
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

        .button-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .cyber-button {
            padding: 20px 40px;
            font-size: 1.2em;
            text-decoration: none;
            color: #fff;
            background: transparent;
            border: 2px solid;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
            animation: buttonColor 8s linear infinite;
            margin: 10px;
        }

        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        .cyber-button:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(255, 0, 255, 0.5);
        }

        .cyber-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .cyber-button:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    <div class="container">
        <div class="scan-line"></div>
        <h1>Course Resources Interface</h1>
        <div class="button-container">
            <a href="search.php" class="cyber-button">Explore Courses</a>
            <a href="searchr.php" class="cyber-button">Browse Resources</a>
            <a href="gsf.php" class="cyber-button">Feedback</a>
            <a href="department.php" class="cyber-button">About Department</a>
			<a href="facultyinfo.php" class="cyber-button">Faculty Info</a>
			<a href="logout.php" class="cyber-button">Logout</a>
			
        </div>
    </div>
</body>
</html>