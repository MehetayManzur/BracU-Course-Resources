<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses</title>
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
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
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
            z-index: -1;
        }

        @keyframes gridMove {
            from { transform: translateY(0); }
            to { transform: translateY(50px); }
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .courses-box {
            background: rgba(10, 10, 25, 0.9);
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            animation: borderColor 8s linear infinite;
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
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
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

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 20px;
        }

        th {
            background: rgba(255, 0, 255, 0.1);
            color: #00ffff;
            padding: 15px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #00ffff;
        }

        td {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-top: 1px solid rgba(0, 255, 255, 0.2);
            border-bottom: 1px solid rgba(0, 255, 255, 0.2);
            transition: 0.3s;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.1);
            color: #ff00ff;
            text-shadow: 0 0 5px #ff00ff;
        }

        .back-btn {
            display: inline-block;
            padding: 15px 30px;
            background: transparent;
            border: 2px solid;
            border-radius: 10px;
            color: #fff;
            font-size: 1.1em;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            text-decoration: none;
            margin-bottom: 20px;
            animation: buttonColor 8s linear infinite;
        }

        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .no-data {
            text-align: center;
            color: #ff0000;
            font-size: 1.2em;
            margin-top: 20px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
            animation: errorPulse 2s infinite;
        }

        @keyframes errorPulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }

        .error {
            color: #ff0000;
            text-align: center;
            font-size: 1.2em;
            margin-top: 20px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    
    <div class="container">
        <div class="courses-box">
            <div class="scan-line"></div>
            <h1>Faculty Info</h1>
            
            <a href="facultyinfo.php" class="back-btn">Return</a>

            <?php
            // Database connection settings
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bracu_course_resources"; 

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Query to fetch available courses
            $sql = "SELECT name, initial,email FROM faculty"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>Initial</th><th>Email</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['initial']) . "</td>";
					echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='no-data'>No data available.</p>";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Audio element for page load sound -->
    <audio id="pageLoadSound">
        <source src="data:audio/mpeg;base64,//OEZAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAAXAAAGQAAEBAQECQkJCQ4ODg4TExMTGBgYGB0dHR0iIiIiJycnJywsLCwxMTExNjY2Njs7Ozs/Pz8/RERERElJSUlOTk5OU1NTU1hYWFhdXV1dYmJiYmdnZ2dsbGxscXFxcXZ2dna7u7u7wMDAwMXFxcXKysrKz8/Pz9TU1NTZ2dnZ3t7e3uPj4+Po6Ojo7e3t7fLy8vL39/f3/Pz8/P///" type="audio/mpeg">
    </audio>

    <script>
        // Play sound when page loads
        window.addEventListener('load', function() {
            const audio = document.getElementById('pageLoadSound');
            audio.play();
        });
    </script>
</body>
</html>