<?php
session_start(); // Start session
require_once 'config.php'; // Include database connection

// Redirect if no user is logged in
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Default sort by Manufacturer if nothing is selected
$orderBy = 'Manufacturer'; 
$orderDir = 'ASC'; // Default ascending order

// Check if sorting criteria is provided
if (isset($_POST['sort_by'])) {
    $orderBy = $_POST['sort_by'];
    $orderDir = ($_POST['sort_dir'] == 'desc') ? 'DESC' : 'ASC';
}

try {
    // Fetch all vehicles from the database with sorting
    $sql = "SELECT * FROM Vehicles ORDER BY $orderBy $orderDir";
    $stmt = $pdo->query($sql);

    // Fetch as associative array
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $vehicles = []; // Set an empty array if there's an error
}

// Check user role
$isUser=($_SESSION['role'] === 'user');
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <link rel="stylesheet" href="style.css">
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
            color: white;
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

        /* Right Corner Section for Search and Sort */
        .right-corner {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 10px;
            align-items: center;
        }

        .right-corner form {
            display: flex;
            gap: 10px;
        }

        .right-corner select, .right-corner button {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .right-corner button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .right-corner button:hover {
            background-color: #45a049;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 10px;
        }

        table th {
            background-color: #f2f2f2;
            color: black;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #4CAF50;
            text-decoration: none;
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

            <?php if ($isUser): // Only show update and delete for admins ?>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            <?php endif; ?>
            
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <!-- Search Form on the Right -->
        
    </nav>
    <!-- Right Corner Section for Sort and Search -->
    <div class="right-corner">
        <!-- Sorting Form -->
        <form method="post" action="">
            <label for="sort_by">Sort by:</label>
            <select name="sort_by" id="sort_by">
                <option value="Manufacturer" <?= ($orderBy == 'Manufacturer') ? 'selected' : ''; ?>>Manufacturer</option>
                <option value="Year" <?= ($orderBy == 'Year') ? 'selected' : ''; ?>>Year</option>
                <option value="Price" <?= ($orderBy == 'Price') ? 'selected' : ''; ?>>Price</option>
            </select>

            <label for="sort_dir">Order:</label>
            <select name="sort_dir" id="sort_dir">
                <option value="asc" <?= ($orderDir == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
                <option value="desc" <?= ($orderDir == 'DESC') ? 'selected' : ''; ?>>Descending</option>
            </select>

            <button type="submit">Sort</button>
        </form>
    </div>

    <!-- Main Content with Vehicles Table -->
    <main>
        <table>
            <thead>
                <tr>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th>Specifications</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($vehicles)): ?>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehicle['Manufacturer']); ?></td>
                        <td><?= htmlspecialchars($vehicle['Model']); ?></td>
                        <td><?= htmlspecialchars($vehicle['Year']); ?></td>
                        <td><?= htmlspecialchars($vehicle['Price']); ?></td>
                        <td><?= htmlspecialchars($vehicle['Specifications']); ?></td>
                        <td>
                            <a href="category.php?id=<?= htmlspecialchars($vehicle['VehicleID']) ?>">View Details</a>
                            <?php if ($isAdmin): // Only show update and delete for admins ?>
                                <a href="update_vehicle.php?id=<?= htmlspecialchars($vehicle['VehicleID']) ?>">Update</a>
                                <a href="delete_vehicle.php?id=<?= htmlspecialchars($vehicle['VehicleID']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No vehicles found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <!-- Go to Dashboard button -->
        <a href="<?= $isAdmin ? 'admin.php' : 'index.php'; ?>">Back to Dashboard</a>
    </main>

    <!-- Footer -->
    <footer>
        &copy; 2024 Winnipeg Wheels | All Rights Reserved
    </footer>

</body>
</html>
