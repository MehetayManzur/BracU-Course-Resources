<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resource</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(244, 248, 249);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Resource</h1>
        <form action="add_resource.php" method="POST">
            <label for="course_code">Course Code:</label>
            <input type="text" id="course_code" name="course_code" placeholder="Enter course code (e.g., CSE331)" required>

            <label for="resource_type">Resource Type:</label>
            <select id="resource_type" name="resource_type" required>
                <option value="video_link">Video Link</option>
                <option value="slide_link">Slide Link</option>
                <option value="notes_link">Notes Link</option>
                <option value="book_link">Book Link</option>
            </select>

            <label for="resource_link">Resource Link:</label>
            <input type="text" id="resource_link" name="resource_link" placeholder="Enter resource link (e.g., https://example.com)" required>

            <button type="submit">Add Resource</button>
        </form>
    </div>
</body>
</html>
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = $_POST['course_code'];
    $resource_type = $_POST['resource_type'];
    $resource_link = $_POST['resource_link'];

    // Insert the new resource into the database
    $sql = "INSERT INTO resources (course_code, resource_type, resource_link)
            VALUES ('$course_code', '$resource_type', '$resource_link')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Resource added successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

// Close connection
$conn->close();
?>

