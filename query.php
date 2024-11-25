<?php
// Include database connection
require_once 'config.php';

session_start();

// Check if user is logged in and is admin
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header("HTTP/1.1 403 Forbidden");
//     die("Access denied. You do not have permission to access this page.");
// }

// Fetch all queries from the 'contact_us' table
$sql = "SELECT * FROM contactus ORDER BY SubmissionDate DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$queries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Queries</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
        }

        .navbar ul li {
            display: inline;
            margin: 0 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar ul li a:hover {
            color: #f39c12;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>User Queries</h1>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>Query</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($queries) > 0): ?>
                    <?php foreach ($queries as $query): ?>
                        <tr>
                            <td><?= htmlspecialchars($query['FirstName']) ?></td>
                            <td><?= htmlspecialchars($query['LastName']) ?></td>
                            <td><?= htmlspecialchars($query['MobileNumber']) ?></td>
                            <td><?= htmlspecialchars($query['Email']) ?></td>
                            <td><?= htmlspecialchars($query['Query']) ?></td>
                            <td><?= htmlspecialchars($query['SubmissionDate']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No queries found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="back-link">
            <a href="admin.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
