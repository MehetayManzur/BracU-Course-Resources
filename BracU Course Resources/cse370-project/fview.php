<?php
session_start();
require 'DBconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM user WHERE mail = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Store user_id in session
        header("Location: feedback.php");
        exit;
    } else {
        echo "Invalid email or password.";
    }
}
?>
<?php
session_start();
require 'DBconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must log in to view your feedback.";
    exit;
}

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

// Get the logged-in user's feedback
$user_id = $_SESSION['user_id'];
$sql = "SELECT feedback.no, feedback.rating, feedback.comment, feedback.data, user.name 
        FROM feedback 
        JOIN user ON feedback.U_id = user.id
        WHERE feedback.U_id = :user_id
        ORDER BY feedback.no ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Your Feedback</title>
</head>
<body>
    <h2>Your Feedback</h2>
    <?php if (empty($feedbacks)): ?>
        <p>No feedback found for your account.</p>
    <?php else: ?>
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
    <?php endif; ?>

    <br>
    <a href="feedback.php">Back to Submit Feedback</a>
</body>
</html>
