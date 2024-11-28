<?php
session_start();
require_once 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Do not hash the password here

    // Prepare the SQL statement to retrieve the user record by username
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE User_name = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user['Password'])) {
            // Password is correct, create session
            $_SESSION['username'] = $user['User_name'];
            $_SESSION['role'] = $user['Role'];

            // Redirect based on user role
            if ($user['Role'] === 'admin') {
                header("Location: admin.php");
            } elseif ($user['Role'] === 'user') {
                header("Location: index.php");
            }
        } else {
            // Invalid password
            $error = "Invalid password!";
        }
    } else {
        // User does not exist
        $error = "Invalid username!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        form {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555555;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: red;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    <form action="" method="POST">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
    </form>
    <div class="footer">
            <p>Doesn't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
    
</body>
</html>
