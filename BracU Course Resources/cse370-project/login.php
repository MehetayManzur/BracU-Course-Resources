<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bracu_course_resources";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling signup
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];
	// Validate phone number
    if (!preg_match('/^\d{11}$/', $phone_number)) {
        $error_message = "Phone number must be exactly 11 digits.";
    } else {
        $sql = "INSERT INTO user (phone_number, mail, password, name, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $phone_number, $mail, $password, $name, $user_type);
        
        if ($stmt->execute()) {
            $success_message = "Signup successful! You can now log in.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
        $stmt->close();
    }
    
    $sql = "INSERT INTO user (phone_number, mail, password, name, user_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $phone_number, $mail, $password, $name, $user_type);
    
    if ($stmt->execute()) {
        $success_message = "Signup successful! You can now log in.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Handling login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user WHERE mail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $success_message = "Login successful! Welcome, " . $row['name'] . "!";
            // Here you can add session handling if needed
            // session_start();
			// At the very top of the file, add:
			session_start();

			// Modify the login success section to include session variables:
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				if (password_verify($password, $row['password'])) {
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['user_name'] = $row['name'];
					$_SESSION['user_type'] = $row['user_type'];
					$success_message = "Login successful! Welcome, " . $row['name'] . "!";
					header("Location: signup.php"); // Redirect to the interface page
					exit();
				} else {
					$error_message = "Invalid password.";
				}
}
            // $_SESSION['user_id'] = $row['id'];
            // $_SESSION['user_name'] = $row['name'];
            // header("Location: dashboard.php");
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Cyber Login System</title>
    
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

        .container {
            position: relative;
            width: 900px;
            height: 600px;
            perspective: 1000px;
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

        .form-box {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 25, 0.9);
            border: 2px solid transparent;
            border-radius: 20px;
            transform-style: preserve-3d;
            transition: transform 0.8s;
            animation: borderColor 8s linear infinite;
        }

        @keyframes borderColor {
            0% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff, inset 0 0 20px rgba(255, 0, 255, 0.5); }
            33% { border-color: #00ffff; box-shadow: 0 0 20px #00ffff, inset 0 0 20px rgba(0, 255, 255, 0.5); }
            66% { border-color: #ff0000; box-shadow: 0 0 20px #ff0000, inset 0 0 20px rgba(255, 0, 0, 0.5); }
            100% { border-color: #ff00ff; box-shadow: 0 0 20px #ff00ff, inset 0 0 20px rgba(255, 0, 255, 0.5); }
        }

        .form-box.flipped {
            transform: rotateY(180deg);
        }

        .login-form,
        .signup-form {
            position: absolute;
            width: 100%;
            height: 100%;
            padding: 40px;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .signup-form {
            transform: rotateY(180deg);
        }

        h2 {
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

        .input-group {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 15px 0;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
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

        .input-group select {
            appearance: none;
        }

        .input-group select option {
            background: #1a0033;
            color: #fff;
        }

        .input-group input:focus,
        .input-group select:focus {
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .submit-btn {
            width: 200px;
            padding: 15px;
            margin-top: 20px;
            background: transparent;
            border: 2px solid;
            border-radius: 10px;
            font-size: 1.1em;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            animation: buttonColor 8s linear infinite;
        }

        @keyframes buttonColor {
            0% { border-color: #ff00ff; color: #ff00ff; }
            33% { border-color: #00ffff; color: #00ffff; }
            66% { border-color: #ff0000; color: #ff0000; }
            100% { border-color: #ff00ff; color: #ff00ff; }
        }

        .submit-btn:hover {
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

        .toggle-form {
            position: down_center;
            bottom: 100px;
			width: 200px;
            padding: 15px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 0.9em;
            text-decoration: underline;
            animation: toggleColor 8s linear infinite;
        }
		
        @keyframes toggleColor {
            0% { color: #ff00ff; text-shadow: 0 0 10px rgba(255, 0, 255, 0.5); }
            33% { color: #00ffff; text-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
            66% { color: #ff0000; text-shadow: 0 0 10px rgba(255, 0, 0, 0.5); }
            100% { color: #ff00ff; text-shadow: 0 0 10px rgba(255, 0, 255, 0.5); }
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #ff00ff, #00ffff, #ff0000);
            animation: scan 2s linear infinite;
            opacity: 0.5;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
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
    <?php if (isset($success_message)): ?>
        <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="cyber-grid"></div>
    <div class="container">
        <div class="form-box">
            <div class="scan-line"></div>
            <!-- Login Form -->
            <div class="login-form">
                <h2>System Login</h2>
                <form action="" method="POST">
                    <div class="input-group">
                        <input type="email" name="mail" placeholder="Enter Email ID" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" name="login" class="submit-btn">Initialize Login</button>
                </form>
                <div class="toggle-form" onclick="toggleForm()">Register New User</div>
            </div>

            <!-- Signup Form -->
            <div class="signup-form">
                <h2>New User Registration</h2>
                <form action="" method="POST">
                    <div class="input-group">
                        <input type="text" name="name" placeholder="Enter Full Name" required>
                    </div>
                    <div class="input-group">
                        <input type="tel" name="phone_number" placeholder="Enter Phone Number" pattern="\d{11}" title="Phone number must be exactly 11 digits" required >
                    </div>
					<div class="input-group">

                    <div class="input-group">
                        <input type="email" name="mail" placeholder="Enter Email ID" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Create Password" required>
                    </div>
                    <div class="input-group">
						<select name="user_type" required>
							<option value="">Select User Type</option>
							<option value="Student">Student</option>
							<option value="Teacher">Teacher</option>
						</select>
					</div>

                    <button type="submit" name="signup" class="submit-btn">Initialize Registration</button>
                
				
				</form>
				<div class="toggle-form" onclick="toggleForm()">Access Existing Account</div>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            const formBox = document.querySelector('.form-box');
            formBox.classList.toggle('flipped');
        }

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
<?php $conn->close(); ?>