<?php
// Include database connection
require_once 'config.php';

session_start();

// Check if user is logged in and is admin
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header("HTTP/1.1 403 Forbidden");
//     die("Access denied. You do not have permission to access this page.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $vehicleID = $_GET['id'];

    // Fetch vehicle details
    $sql = "SELECT * FROM Vehicles WHERE VehicleID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $vehicleID]);
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        die("Vehicle not found.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $vehicleID = $_POST['VehicleID'];
    $manufacturer = $_POST['Manufacturer'];
    $model = $_POST['Model'];
    $year = $_POST['Year'];
    $price = $_POST['Price'];
    $specifications = $_POST['Specifications'];

    // Update vehicle in the database
    $sql = "UPDATE Vehicles SET Manufacturer = :manufacturer, Model = :model, Year = :year, Price = :price, Specifications = :specifications WHERE VehicleID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':manufacturer' => $manufacturer,
        ':model' => $model,
        ':year' => $year,
        ':price' => $price,
        ':specifications' => $specifications,
        ':id' => $vehicleID
    ]);

    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vehicle</title>
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
            width: 50%;
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

        .form-container {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #218838;
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
            <li><a href="index.php">Home</a></li>
            <li><a href="view_vehicles.php">View Vehicles</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Update Vehicle</h1>
        <form action="update_vehicle.php" method="POST" class="form-container">
            <input type="hidden" name="VehicleID" value="<?= htmlspecialchars($vehicle['VehicleID']) ?>">

            <div class="form-group">
                <label for="Manufacturer">Manufacturer:</label>
                <input type="text" name="Manufacturer" id="Manufacturer" value="<?= htmlspecialchars($vehicle['Manufacturer']) ?>" required>
            </div>

            <div class="form-group">
                <label for="Model">Model:</label>
                <input type="text" name="Model" id="Model" value="<?= htmlspecialchars($vehicle['Model']) ?>" required>
            </div>

            <div class="form-group">
                <label for="Year">Year:</label>
                <input type="number" name="Year" id="Year" value="<?= htmlspecialchars($vehicle['Year']) ?>" required>
            </div>

            <div class="form-group">
                <label for="Price">Price:</label>
                <input type="number" name="Price" id="Price" value="<?= htmlspecialchars($vehicle['Price']) ?>" required>
            </div>

            <div class="form-group">
                <label for="Specifications">Specifications:</label>
                <textarea name="Specifications" id="Specifications" required><?= htmlspecialchars($vehicle['Specifications']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Update Vehicle</button>
            </div>
        </form>
        <div class="back-link">
            <a href="read.php">Back to Vehicle List</a>
        </div>
    </div>
</body>
</html>
