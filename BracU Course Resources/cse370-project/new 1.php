<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];

    if (!empty($rating) && !empty($comment) && !empty($user_id)) {
        $sql = "INSERT INTO feedback (rating, comment, U_id) VALUES (:rating, :comment, :user_id)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':rating' => $rating,
                ':comment' => $comment,
                ':user_id' => $user_id
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

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
</head>
<body>
    <h2>Submit Your Feedback</h2>
    <form method="POST" action="">
        <label for="rating">Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required><br><br>

        <label for="comment">Comment:</label>
        <textarea name="comment" required></textarea><br><br>

        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" required><br><br>

        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
<?php
require 'db_connection.php';

$sql = "SELECT feedback.no, feedback.rating, feedback.comment, feedback.data, user.name 
        FROM feedback 
        JOIN user ON feedback.U_id = user.id
        ORDER BY feedback.no ASC";
$stmt = $pdo->query($sql);

$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Feedback</title>
</head>
<body>
    <h2>Feedback List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>User Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbacks as $feedback): ?>
                <tr>
                    <td><?php echo htmlspecialchars($feedback['no']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['rating']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['comment']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['data']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
