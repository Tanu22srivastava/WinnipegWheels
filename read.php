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

// Pagination variables
$limit = 8; // Number of vehicles per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality variables
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Check if sorting criteria is provided
if (isset($_POST['sort_by'])) {
    $orderBy = $_POST['sort_by'];
    $orderDir = ($_POST['sort_dir'] == 'desc') ? 'DESC' : 'ASC';
}

try {
    // Prepare the query for fetching vehicles with optional search
    $searchCondition = $searchTerm ? "WHERE Manufacturer LIKE :search OR Model LIKE :search" : '';
    $totalQuery = "SELECT COUNT(*) as total FROM Vehicles $searchCondition";
    $totalStmt = $pdo->prepare($totalQuery);

    if ($searchTerm) {
        $totalStmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
    }
    $totalStmt->execute();
    $totalVehicles = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Fetch vehicles for the current page with sorting and pagination
    $sql = "SELECT * FROM Vehicles $searchCondition ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    if ($searchTerm) {
        $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch as associative array
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $vehicles = []; // Set an empty array if there's an error
}

// Calculate total pages
$totalPages = ceil($totalVehicles / $limit);

// Check user role
$isUser = ($_SESSION['role'] === 'user');
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
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
        /* Add styles for pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        .pagination a.disabled {
            background-color: #ccc;
            pointer-events: none;
            color: #777;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Winnipeg Wheels</h1>
    </header>

    <!-- Navigation Bar with Search -->
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
            <form action="read.php" method="GET">
                <input type="text" name="search" placeholder="Search by Manufacturer or Model..." value="<?= htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>

    <main>
        <!-- Sort Form -->
        <div class="right-corner">
            <form action="read.php" method="POST">
                <label for="sort_by">Sort By:</label>
                <select name="sort_by" id="sort_by">
                    <option value="Manufacturer" <?= $orderBy === 'Manufacturer' ? 'selected' : ''; ?>>Manufacturer</option>
                    <option value="Model" <?= $orderBy === 'Model' ? 'selected' : ''; ?>>Model</option>
                    <option value="Year" <?= $orderBy === 'Year' ? 'selected' : ''; ?>>Year</option>
                    <option value="Price" <?= $orderBy === 'Price' ? 'selected' : ''; ?>>Price</option>
                </select>
                <label for="sort_dir">Order:</label>
                <select name="sort_dir" id="sort_dir">
                    <option value="asc" <?= $orderDir === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                    <option value="desc" <?= $orderDir === 'DESC' ? 'selected' : ''; ?>>Descending</option>
                </select>
                <button type="submit">Sort</button>
            </form>
        </div>

        <!-- Vehicles Table -->
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
                    <td colspan="6">No vehicles found matching your search.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= htmlspecialchars($searchTerm); ?>">Previous</a>
            <?php else: ?>
                <a class="disabled">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>&search=<?= htmlspecialchars($searchTerm); ?>" class="<?= ($i == $page) ? 'disabled' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= htmlspecialchars($searchTerm); ?>">Next</a>
            <?php else: ?>
                <a class="disabled">Next</a>
            <?php endif; ?>
        </div>

        <!-- Back to Dashboard button -->
        <a href="<?= $isAdmin ? 'admin.php' : 'index.php'; ?>">Back to Dashboard</a>
    </main>
</body>
</html>

















