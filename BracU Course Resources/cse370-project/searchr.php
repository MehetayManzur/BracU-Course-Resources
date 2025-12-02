<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Resources</title>
   
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

        .resources-box {
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

        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .cyber-btn {
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
            animation: buttonColor 8s linear infinite;
        }

        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        .cyber-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
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
        }

        td a {
            color: #ff00ff;
            text-decoration: none;
            transition: 0.3s;
        }

        td a:hover {
            color: #00ffff;
            text-shadow: 0 0 5px #00ffff;
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
        <div class="resources-box">
            <div class="scan-line"></div>
            <h1>Course Resources</h1>
            
            <form method="POST" class="search-form">
                <div class="input-group">
                    <input type="text" name="course_code" placeholder="Enter Course Code" required>
                </div>
                <button type="submit" class="cyber-btn">Search Resources</button>
            </form>

            <?php
            // Database connection settings
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bracu_course_resources";

            // Create a connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Check if form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $course_code = $_POST['course_code'];
                
                // Query to search for the course resources
                $sql = "SELECT * FROM resources WHERE course_code = '$course_code'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr>
                            <th>Number</th>
                            <th>Course Code</th>
                            <th>Video Link</th>
                            <th>Slide Link</th>
                            <th>Notes Link</th>
                            <th>Book Link</th>
                          </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['number']}</td>
                                <td>{$row['course_code']}</td>
                                <td><a href='{$row['video_link']}' target='_blank'>Video</a></td>
                                <td><a href='{$row['slide_link']}' target='_blank'>Slides</a></td>
                                <td><a href='{$row['notes_link']}' target='_blank'>Notes</a></td>
                                <td><a href='{$row['book_link']}' target='_blank'>Book</a></td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='error'>No resources found for the course code '$course_code'.</p>";
                }
            }

            // Close connection
            $conn->close();
            ?>

            <div class="nav-buttons">
                <a href="availabler.php" class="cyber-btn">Available Courses</a>
                <a href="updater.php" class="cyber-btn">Update Courses</a>
                <a href="insertr.php" class="cyber-btn">Insert Courses</a>
            </div>
        </div>
    </div>

    <!-- Audio element for success sound -->
    <audio id="successSound">
        <source src="data:audio/mpeg;base64,//OEZAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAAXAAAGQAAEBAQECQkJCQ4ODg4TExMTGBgYGB0dHR0iIiIiJycnJywsLCwxMTExNjY2Njs7Ozs/Pz8/RERERElJSUlOTk5OU1NTU1hYWFhdXV1dYmJiYmdnZ2dsbGxscXFxcXZ2dna7u7u7wMDAwMXFxcXKysrKz8/Pz9TU1NTZ2dnZ3t7e3uPj4+Po6Ojo7e3t7fLy8vL39/f3/Pz8/P///" type="audio/mpeg">
    </audio>

    <script>
        // Play sound when search results are found
        <?php if (isset($result) && $result->num_rows > 0): ?>
            const audio = document.getElementById('successSound');
            audio.play();
        <?php endif; ?>
    </script>
</body>
</html>