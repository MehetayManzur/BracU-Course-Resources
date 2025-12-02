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

// Retrieve all feedback from the database
$sql = "SELECT * FROM feedback";
try {
    $stmt = $pdo->query($sql);
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving feedback: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="container">
        <h1>User Feedback</h1>
        <?php if (count($feedbacks) > 0): ?>
            <table>
                <thead>
                    <tr>
                       
                        <th>Rating</th>
                        <th>Comment</th>
						
						
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            
                            <td><?php echo htmlspecialchars($feedback['rating']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['comment']); ?></td>
						
                            
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No feedback available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
