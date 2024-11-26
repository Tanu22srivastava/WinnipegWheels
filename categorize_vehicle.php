<?php
// Database connection
require 'db.php'; // Include your database connection file here

// Initialize filter variables and query
$filterQuery = "1=1"; // Default: no filtering
$params = [];

// Apply filters if provided
if (isset($_GET['model']) && !empty($_GET['model'])) {
    $filterQuery .= " AND model LIKE :model";
    $params[':model'] = '%' . htmlspecialchars($_GET['model']) . '%';
}
if (isset($_GET['year']) && !empty($_GET['year'])) {
    $filterQuery .= " AND year = :year";
    $params[':year'] = htmlspecialchars($_GET['year']);
}
if (isset($_GET['specification']) && !empty($_GET['specification'])) {
    $filterQuery .= " AND Specifications LIKE :specification";  // Corrected column name
    $params[':specification'] = '%' . htmlspecialchars($_GET['specification']) . '%';
}

// Fetch filtered vehicles
$stmt = $pdo->prepare("SELECT * FROM Vehicles WHERE $filterQuery");
$stmt->execute($params);
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct values for dropdowns
$years = $pdo->query("SELECT DISTINCT year FROM Vehicles ORDER BY year DESC")->fetchAll(PDO::FETCH_ASSOC);
$models = $pdo->query("SELECT DISTINCT model FROM Vehicles ORDER BY model ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Categorization</title>
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
        div {
            color: black;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .filter-section {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .filter-section label {
            font-weight: bold;
            font-size: 14px;
        }
        .filter-section select,
        .filter-section input,
        .filter-section button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }
        .filter-section button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .filter-section button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #999;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            
            width: 100%;
            bottom: 0;
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
            <form action="search.php" method="GET" >
                <input type="text" name="search" placeholder="Search for pages..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>

<div>
    <h1>Vehicle Categorization</h1>
</div>

<div class="container">
    <!-- Filter Form -->
    <form method="GET" action="categorize_vehicle.php">
        <div class="filter-section">
            <!-- Model Filter -->
            <label for="model">Filter by Model:</label>
            <select name="model" id="model">
                <option value="">-- All Models --</option>
                <?php foreach ($models as $m): ?>
                    <option value="<?= htmlspecialchars($m['model']); ?>" <?= isset($_GET['model']) && $_GET['model'] == $m['model'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['model']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Year Filter -->
            <label for="year">Filter by Year:</label>
            <select name="year" id="year">
                <option value="">-- All Years --</option>
                <?php foreach ($years as $y): ?>
                    <option value="<?= htmlspecialchars($y['year']); ?>" <?= isset($_GET['year']) && $_GET['year'] == $y['year'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($y['year']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Specification Filter -->
            <label for="specification">Specification Contains:</label>
            <input type="text" name="specification" id="specification" value="<?= htmlspecialchars($_GET['specification'] ?? '') ?>" placeholder="Enter keyword">

            <button type="submit">Filter</button>
        </div>
    </form>

    <!-- Display Vehicles in a Table -->
    <?php if (count($vehicles) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Year</th>
                    <th>Specification</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehicle['Manufacturer'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($vehicle['Model'] ?? 'N/A'); ?></td>
                        <td>$<?= htmlspecialchars(number_format($vehicle['Price'] ?? 0, 2)); ?></td>
                        <td><?= htmlspecialchars($vehicle['Year'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($vehicle['Specifications'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-results">No vehicles found for the selected criteria.</div>
    <?php endif; ?>
</div>

<!-- <footer>
    <p>&copy; 2024 Vehicle Categorization System</p>
</footer> -->

</body>
</html>
