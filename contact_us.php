<?php
require 'db.php'; // Include your DB connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and sanitize it
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);
    $email = htmlspecialchars($_POST['email']);
    $query = htmlspecialchars($_POST['query']);

    // Validate the inputs
    if (empty($firstName) || empty($lastName) || empty($mobileNumber) || empty($email) || empty($query)) {
        $errorMessage = "All fields are required!";
    } else {
        // Prepare SQL query to insert data into the database
        $stmt = $pdo->prepare("INSERT INTO ContactUs (FirstName, LastName, MobileNumber, Email, Query) 
                               VALUES (:firstName, :lastName, :mobileNumber, :email, :query)");
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':mobileNumber' => $mobileNumber,
            ':email' => $email,
            ':query' => $query
        ]);

        // Success message
        $successMessage = "Your query has been submitted successfully. We will get back to you soon.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }

        /* Navigation Bar */
        nav {
            background-color: #333;
            padding: 10px 20px;
            text-align: left;
            display: flex;
            justify-content: space-between; /* Distributes items in navbar */
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Search Form in the Navbar */
        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 250px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 0; /* Ensures no additional spacing issues */
        }

        .search-container button {
            padding: 8px 16px;
            margin-left: 10px;
            font-size: 14px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            
        }

        .search-container button:hover {
            background-color: #45a049;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
            height: 120px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            font-size: 16px;
            color: green;
            margin-bottom: 20px;
        }
        .error {
            text-align: center;
            font-size: 16px;
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Winnipeg Wheels</h1>
    </header>

    <!-- Navigation Bar with Search in the Right Corner -->
    <nav>
        <ul>
            <li><a href="read.php">View All Vehicles</a></li>
            <li><a href="comments.php">Comments</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <!-- Search Form on the Right -->
        <div class="search-container">
            <form action="search.php" method="GET" style="display: flex;flex-direction: row; align-items: center;">
                <input type="text" name="search" placeholder="Search for pages..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Contact Us</h2>

        <!-- Show success or error messages -->
        <?php if (isset($successMessage)): ?>
            <div class="message"><?= $successMessage ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="error"><?= $errorMessage ?></div>
        <?php endif; ?>

        <!-- Contact Us Form -->
        <form method="POST" action="contact_us.php">
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="text" name="mobileNumber" placeholder="Mobile Number" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="query" placeholder="Your Query" required></textarea>
            <button type="submit">Submit Query</button>
        </form>

        <a href="index.php">Back to Dashboard</a>
    </div>

</body>
</html>
