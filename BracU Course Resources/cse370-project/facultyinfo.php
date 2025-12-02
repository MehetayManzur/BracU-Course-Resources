<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bracu_course_resources";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_result = null;
$error_message = null;

// Handling course search
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_faculty'])) {
    $course_code = $_POST['course_code'];
    $sql = "SELECT initial FROM teaches WHERE code = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $course_code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $search_result = $result->fetch_assoc();
        } else {
            $error_message = "Faculty not available.";
        }
        $stmt->close();
    } else {
        $error_message = "Error preparing statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber faculty Details</title>
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
            max-width: 1000px;
            margin: 40px auto;
        }

        .search-box {
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

        .search-form {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .input-group {
            flex: 1;
        }

        .input-group input {
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

        
        .search-btn, .available-btn {
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
            animation: buttonColor 8s linear infinite;
            text-decoration: none;
        }

        .button-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }


        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        .search-btn.available-btn:hover :hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .result-box {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid;
            border-radius: 10px;
            animation: resultBorder 8s linear infinite;
        }

        @keyframes resultBorder {
            0% { border-color: #ff00ff; box-shadow: 0 0 10px rgba(255, 0, 255, 0.2); }
            33% { border-color: #00ffff; box-shadow: 0 0 10px rgba(0, 255, 255, 0.2); }
            66% { border-color: #ff0000; box-shadow: 0 0 10px rgba(255, 0, 0, 0.2); }
            100% { border-color: #ff00ff; box-shadow: 0 0 10px rgba(255, 0, 255, 0.2); }
        }

        .result-box h2 {
            color: #00ffff;
            margin-bottom: 20px;
            font-size: 1.8em;
            text-transform: uppercase;
        }

        .result-box p {
            margin: 15px 0;
            line-height: 1.6;
        }

        .result-box strong {
            color: #ff00ff;
            margin-right: 10px;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    
    <div class="container">
        <div class="search-box">
            <div class="scan-line"></div>
            <h1>Faculty Details Interface</h1>
            
            <form method="POST" class="search-form" id="searchForm">
                <div class="input-group">
                    <input type="text" name="course_code" placeholder="Enter Course Code" required>
                </div>
                <button type="submit" name="search_faculty" class="search-btn">Initialize Search</button>
            </form>
			<div class="button-group">
                <a href="availablerfaculty.php" class="available-btn">Available Faculties</a>
				<a href="addfaculty.php" class="available-btn">Add faculties</a>
				<a href="facultyfeedback.php" class="available-btn">Feedbacks</a>
            </div>

            <?php if ($error_message): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <?php if ($search_result): ?>
                <div class="result-box">
                    <h2>Faculty</h2>
                    <p><strong>initial:</strong> <?php echo htmlspecialchars($search_result['initial']); ?></p>
                    
                </div>
            <?php endif; ?>
        </div>
    </div>
	
    
    <!-- Audio element for success sound -->
    <audio id="successSound">
        <source src="data:audio/mpeg;base64,//OEZAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAAXAAAGQAAEBAQECQkJCQ4ODg4TExMTGBgYGB0dHR0iIiIiJycnJywsLCwxMTExNjY2Njs7Ozs/Pz8/RERERElJSUlOTk5OU1NTU1hYWFhdXV1dYmJiYmdnZ2dsbGxscXFxcXZ2dna7u7u7wMDAwMXFxcXKysrKz8/Pz9TU1NTZ2dnZ3t7e3uPj4+Po6Ojo7e3t7fLy8vL39/f3/Pz8/P///" type="audio/mpeg">
    </audio>

    <script>
        // Function to play success sound
        function playSuccessSound() {
            const audio = document.getElementById('successSound');
            audio.play();
        }

        // Play sound when results are shown
        <?php if ($search_result): ?>
            playSuccessSound();
        <?php endif; ?>
    </script>
</body>
</html>
<?php $conn->close(); ?>