<?php

require 'DBconnect.php';
$host = "localhost";
$username = "root";
$password = "";
$dbname = "bracu_course_resources";


$successMsg = '';
$errorMsg = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $errorMsg = "Database connection failed: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    $course_name = $_POST['course_name'];

    if (!empty($rating) && !empty($comment) && !empty($user_id) && !empty($course_name)) {
        $sql = "INSERT INTO feedback (rating, comment, U_id, course_name) 
                VALUES (:rating, :comment, :user_id, :course_name)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':rating' => $rating,
                ':comment' => $comment,
                ':user_id' => $user_id,
                ':course_name' => $course_name
            ]);
            $successMsg = "Feedback submitted successfully!";
        } catch (PDOException $e) {
            $errorMsg = "Error submitting feedback: " . $e->getMessage();
        }
    } else {
        $errorMsg = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
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
            overflow-x: hidden;
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
            margin: 20px;
        }

        @keyframes borderColor {
            0% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff; }
            33% { border-color: #00ffff; box-shadow: 0 0 20px #00ffff; }
            66% { border-color: #ff0000; box-shadow: 0 0 20px #ff0000; }
            100% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff; }
        }

        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #00ff00;
        }

        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff0000;
            color: #ff0000;
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

        .feedback-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: left;
        }

        .form-group label {
            font-size: 1.1em;
            letter-spacing: 1px;
            color: #00ffff;
            text-shadow: 0 0 5px #00ffff;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid #00ffff;
            color: #fff;
            font-size: 1em;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff00ff;
            box-shadow: 0 0 10px #ff00ff;
        }

        .cyber-button {
            padding: 15px 30px;
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
            cursor: pointer;
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

        .back-button {
			position: absolute;
			top: 20px;
			right: 20px;
			padding: 10px 20px;
			font-size: 1em;
			text-decoration: none;
			color: #fff;
			background: transparent;
			border: 2px solid #fff;
			border-radius: 10px;
			transition: 0.3s;
		}
        }

        .star-rating {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 10px 0;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2em;
            color: #666;
            cursor: pointer;
            transition: 0.3s;
        }
		.star-rating label:hover ~ label,
        .star-rating label:hover,
        
        .star-rating input[type="radio"]:checked ~ label {
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
        }
    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    <div class="container">
        <a href="gsf.php" class="cyber-button back-button">Back</a>
        <div class="scan-line"></div>
        
        
        <?php if ($successMsg): ?>
            <div class="message success"><?php echo htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>
        
        <?php if ($errorMsg): ?>
            <div class="message error"><?php echo htmlspecialchars($errorMsg); ?></div>
        <?php endif; ?>

        <form class="feedback-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" required>
            </div>

            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" required>
            </div>

            <div class="form-group">
				<label>Rating:</label>
				<div class="star-rating">
					<input type="radio" id="star5" name="rating" value="1" required>
					<label for="star5">★</label>
					<input type="radio" id="star4" name="rating" value="2">
					<label for="star4">★</label>
					<input type="radio" id="star3" name="rating" value="3">
					<label for="star3">★</label>
					<input type="radio" id="star2" name="rating" value="4">
					<label for="star2">★</label>
					<input type="radio" id="star1" name="rating" value="5">
					<label for="star1">★</label>
				</div>
			</div>


            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="5" required></textarea>
            </div>

            <button type="submit" class="cyber-button">Submit Feedback</button>
        </form>
    </div>
</body>
</html>