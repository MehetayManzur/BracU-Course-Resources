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

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_code'])) {
        $course_code = $_POST['course_code'];
        // Fetch course details
        $sql = "SELECT * FROM resources WHERE course_code = '$course_code'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $update_form = true;
        } else {
            $error_message = "No course found with the code '$course_code'.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $course_code = $_POST['course_code'];
        $video_link = $_POST['video_link'];
        $slide_link = $_POST['slide_link'];
        $notes_link = $_POST['notes_link'];
        $book_link = $_POST['book_link'];
        $number = $_POST['number'];
        
        $update_sql = "UPDATE resources 
                       SET video_link = '$video_link', 
                           slide_link = '$slide_link', 
                           notes_link = '$notes_link', 
                           book_link = '$book_link', 
                           number = '$number'
                       WHERE course_code = '$course_code'";
        
        if ($conn->query($update_sql) === TRUE) {
            $success_message = "Resources for '$course_code' updated successfully!";
        } else {
            $error_message = "Error updating resources: " . $conn->error;
        }
    }

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Resource Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
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
            height: auto;
            min-height: 400px;
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

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            left: 0;
            background: linear-gradient(to right, #ff00ff, #00ffff, #ff0000);
            animation: scan 2s linear infinite;
            opacity: 0.5;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #fff;
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

        label {
            display: block;
            margin-bottom: 5px;
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
            color: #fff;
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

    <?php if (isset($success_message)): ?>
        <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if (!isset($update_form)): ?>
        <!-- Search Form -->
        <div class="container">
            <div class="scan-line"></div>
            <h1>Search Course to Update</h1>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="course_code">Course Code</label>
                    <input type="text" id="course_code" name="course_code" placeholder="Enter course code" required>
                </div>
                <button type="submit">Search Course</button>
            </form>
        </div>
    <?php else: ?>
        <!-- Update Form -->
        <div class="container">
            <div class="scan-line"></div>
            <h1>Update Resources for <?php echo htmlspecialchars($course_code); ?></h1>
            <form action="" method="POST">
                <input type="hidden" name="course_code" value="<?php echo htmlspecialchars($course_code); ?>">
                
                <div class="input-group">
                    <label for="video_link">Video Link:</label>
                    <input type="text" id="video_link" name="video_link" value="<?php echo htmlspecialchars($row['video_link']); ?>" placeholder="Enter video link">
                </div>
                
                <div class="input-group">
                    <label for="slide_link">Slide Link:</label>
                    <input type="text" id="slide_link" name="slide_link" value="<?php echo htmlspecialchars($row['slide_link']); ?>" placeholder="Enter slide link">
                </div>
                
                <div class="input-group">
                    <label for="notes_link">Notes Link:</label>
                    <input type="text" id="notes_link" name="notes_link" value="<?php echo htmlspecialchars($row['notes_link']); ?>" placeholder="Enter notes link">
                </div>
                
                <div class="input-group">
                    <label for="book_link">Book Link:</label>
                    <input type="text" id="book_link" name="book_link" value="<?php echo htmlspecialchars($row['book_link']); ?>" placeholder="Enter book link">
                </div>
                
                <div class="input-group">
                    <label for="number">Number:</label>
                    <input type="number" id="number" name="number" value="<?php echo htmlspecialchars($row['number']); ?>" placeholder="Enter resource number">
                </div>
                
                <button type="submit" name="update">Update Resource</button>
            </form>
        </div>
    <?php endif; ?>

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