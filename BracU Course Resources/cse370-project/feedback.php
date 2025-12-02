<?php
// Include database connection
require 'DBconnect.php';

$host = "localhost";
$username = "root";
$password = "";
$dbname = "bracu_course_resources";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    $course_name = $_POST['course_name']; // New field for course name

    // Check if all fields are filled
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
            echo "Feedback submitted successfully!";
        } catch (PDOException $e) {
            echo "Error submitting feedback: " . $e->getMessage();
        }
    } else {
        echo "All fields are required!";
    }
}
?>
<form method="POST" action="feedback.php">
    <div class="form-group">
        <label for="rating">Rating (1-5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5" placeholder="Rate us from 1 to 5" required>
    </div>
    <div class="form-group">
        <label for="comment">Your Comments:</label>
        <textarea name="comment" id="comment" placeholder="Write your feedback here..." required></textarea>
    </div>
    <div class="form-group">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" id="user_id" placeholder="Enter your user ID" required>
    </div>
    <div class="form-group">
        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" id="course_name" placeholder="Enter the course name" required>
    </div>
    <button type="submit" class="submit-btn">Submit Feedback</button>
</form>
