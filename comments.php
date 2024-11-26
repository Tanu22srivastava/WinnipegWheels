<?php
require 'db.php';

// Define the number of comments per page
$commentsPerPage = 10;

// Get the current page number, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $commentsPerPage;

// Query to fetch comments with pagination
$stmt = $pdo->prepare("
    SELECT 
        v.VehicleId, 
        v.Manufacturer, 
        v.Model, 
        c.CommentText, 
        c.CommentDate
    FROM Comments c
    JOIN Vehicles v ON c.VehicleID = v.VehicleId
    ORDER BY c.CommentDate DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindParam(':limit', $commentsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of comments for pagination
$totalCommentsStmt = $pdo->prepare("SELECT COUNT(*) FROM Comments");
$totalCommentsStmt->execute();
$totalComments = $totalCommentsStmt->fetchColumn();
$totalPages = ceil($totalComments / $commentsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Vehicle Comments</title>
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
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 250px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
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

        main {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        .pagination span {
            font-size: 16px;
            color: #333;
            padding: 10px 20px;
        }

        .pagination a:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Footer styling */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Header -->
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
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search for pages..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>
    <!-- Main Content Area -->
    <main>
        <h2>All Vehicle Comments</h2>

        <?php if (count($comments) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Comment</th>
                        <th>Comment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($comment['Manufacturer']) . ' ' . htmlspecialchars($comment['Model']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($comment['CommentText']) ?></td>
                            <td><?= htmlspecialchars($comment['CommentDate']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No comments found.</p>
        <?php endif; ?>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="all_comments.php?page=<?= $page - 1 ?>">Previous</a>
            <?php else: ?>
                <span>Previous</span>
            <?php endif; ?>

            <span>Page <?= $page ?> of <?= $totalPages ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="all_comments.php?page=<?= $page + 1 ?>">Next</a>
            <?php else: ?>
                <span>Next</span>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Winnipeg Wheels | All Rights Reserved</p>
    </footer>

</body>
</html>
