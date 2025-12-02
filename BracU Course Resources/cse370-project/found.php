<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <nav>
                <ul>
                    <li><a href="search.php">Search Resources</a></li>
                    <li><a href="insert.php">Insert Resources</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="welcome-message">
            <h2>Dashboard</h2>
            <p>Use the navigation links above to access different features of the website.</p>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 BRACU Course Resources. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
/* Dashboard Styles */
.welcome-message {
    text-align: center;
    margin: 50px auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

.welcome-message h2 {
    color: #007BFF;
    font-size: 24px;
}

.welcome-message p {
    font-size: 16px;
    color: #555;
}

nav ul {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 20px;
}

nav ul li a {
    color: white;
    font-weight: bold;
    padding: 8px 15px;
    background-color: #007BFF;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #0056b3;
}
<?php
// Start session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bracu_course_resources";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User authenticated
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
