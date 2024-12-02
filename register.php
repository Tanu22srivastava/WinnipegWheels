<?php
// Database connection setup
require 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Validate user input
    if (empty($username) || empty($password) || empty($email) || empty($role)) {
        echo "Username and password are required!";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE User_name = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->fetchColumn() > 0) {
        echo "Username already exists. Please choose a different one.";
        exit;
    }

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO Users (User_name, Password, Email, Role) VALUES (:username, :hashedPassword,:email,:role)");
    $stmt->execute(['username' => $username, 'hashedPassword' => $hashedPassword,'email'=> $email ,'role'=> $role]);

    // Redirect to the login page after successful registration
    header("Location: login.php");
    exit; // Make sure the script stops executing here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background1.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #00008B;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: white;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="rolee"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        #role{
            background-color: white;
            color: black;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #00FFFF;
            font-weight: bold;
            color: black;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0047AB;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            color: red;
        }

        .footer a {
            color: white;
            text-decoration: none;
            font-size: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="email">Email:</label>
            <input type="email" id="emal" name="email" required><br>

            <label for="Rolee">Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br>


            <button type="submit">Register</button>
        </form>
        <div class="footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
