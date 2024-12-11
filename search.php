<?php

session_start(); // Start session
require 'db.php';


// Get the search keyword
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

if (empty($searchKeyword)) {
    echo "Please enter a search term.";
    exit;
}

// Sanitize the input
$searchKeyword = htmlspecialchars($searchKeyword);

// Search the database for matching pages
$stmt = $pdo->prepare("
    SELECT PageName, PageURL 
    FROM Pages 
    WHERE PageName LIKE :keyword OR PageContent LIKE :keyword OR keywords LIKE :keyword
");
$stmt->execute(['keyword' => '%' . $searchKeyword . '%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check user role
$isUser = ($_SESSION['role'] === 'user');
$isAdmin = ($_SESSION['role'] === 'admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
    <ul>
            <li><a href="read.php">View All Vehicles</a></li>
            <?php if ($isAdmin): // Only show update and delete for admins ?>
                <li><a href="add_vehicle.php">Add Vehicle</a></li>
                            <?php endif; ?>
            <li><a href="comments.php">Comments</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <header>
        <h1>Search Results</h1>
        <p>Your search term: <strong><?= htmlspecialchars($searchKeyword) ?></strong></p>
    </header>

    <main>
        <?php if (count($results) > 0): ?>
            <ul class="results-list">
                <?php foreach ($results as $result): ?>
                    <li>
                        <a href="<?= htmlspecialchars($result['PageURL']) ?>" class="result-item">
                            <?= htmlspecialchars($result['PageName']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-results">No pages found matching your search.</p>
        <?php endif; ?>
    </main>

    <footer>
        &copy; 2024 Your Website
    </footer>

    <!-- CSS Styling -->
    <style>
        

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
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

        header h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        header p {
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        .results-list {
            list-style: none;
            padding: 0;
        }

        .results-list li {
            margin-bottom: 10px;
        }

        .result-item {
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
        }

        .result-item:hover {
            text-decoration: underline;
        }

        .no-results {
            text-align: center;
            font-size: 16px;
            color: #ff5733;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }
    </style>
</body>
</html>
