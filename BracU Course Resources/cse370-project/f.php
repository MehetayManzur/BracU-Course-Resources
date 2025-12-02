<?php
require 'DBconnect.php'; // Ensure this file exists and the path is correct

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
