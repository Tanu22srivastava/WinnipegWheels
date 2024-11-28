<?php
// Include database connection
require_once 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Sanitize and validate the vehicle ID
    $vehicleID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$vehicleID) {
        die("Invalid vehicle ID.");
    }

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
    $vehicleID = filter_input(INPUT_POST, 'VehicleID', FILTER_VALIDATE_INT);
    $manufacturer = trim(filter_input(INPUT_POST, 'Manufacturer', FILTER_SANITIZE_STRING));
    $model = trim(filter_input(INPUT_POST, 'Model', FILTER_SANITIZE_STRING));
    $year = filter_input(INPUT_POST, 'Year', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_POST, 'Price', FILTER_VALIDATE_FLOAT);
    $specifications = trim(filter_input(INPUT_POST, 'Specifications', FILTER_SANITIZE_STRING));

    // Validate required fields
    $errors = [];
    if (!$vehicleID) {
        $errors[] = "Vehicle ID is invalid.";
    }
    if (empty($manufacturer)) {
        $errors[] = "Manufacturer is required.";
    }
    if (empty($model)) {
        $errors[] = "Model is required.";
    }
    if (!$year || $year < 1886 || $year > date("Y")) { // Validate year (earliest cars were invented in 1886)
        $errors[] = "Year must be valid and between 1886 and " . date("Y") . ".";
    }
    if (!$price || $price <= 0) {
        $errors[] = "Price must be a positive number.";
    }
    if (empty($specifications)) {
        $errors[] = "Specifications are required.";
    }

    if (!empty($errors)) {
        // Display errors and stop execution
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
        exit;
    }

    // Update vehicle in the database
    $sql = "UPDATE Vehicles 
            SET Manufacturer = :manufacturer, Model = :model, Year = :year, Price = :price, Specifications = :specifications 
            WHERE VehicleID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':manufacturer' => $manufacturer,
        ':model' => $model,
        ':year' => $year,
        ':price' => $price,
        ':specifications' => $specifications,
        ':id' => $vehicleID
    ]);

    if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'upload/images/';
        $fileName = basename($_FILES['Image']['name']);
        $fileTmpPath = $_FILES['Image']['tmp_name'];
        $filePath = $uploadDir . time() . '_' . $fileName; // Unique file name
    
        // Move the uploaded file
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // Update the database with the file name
            $sql = "UPDATE Vehicles SET Image = :image WHERE VehicleID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':image' => $filePath, ':id' => $vehicleID]);
        }
    }

    if (isset($_POST['RemoveImage']) && $_POST['RemoveImage'] == '1') {
        // Get current image path
        $sql = "SELECT Image FROM Vehicles WHERE VehicleID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $vehicleID]);
        $image = $stmt->fetchColumn();
    
        if ($image && file_exists($image)) {
            unlink($image); // Delete image file
        }
    
        // Update the database to nullify the image
        $sql = "UPDATE Vehicles SET Image = NULL WHERE VehicleID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $vehicleID]);
    }
    
    

    // Success message
    $_SESSION['success_message'] = "Vehicle updated successfully!";
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
        <form action="update_vehicle.php" method="POST" class="form-container" enctype="multipart/form-data">
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
            <div class="form-group">
                <label for="Image">Vehicle Image (optional):</label>
                <input type="file" name="Image" id="Image" accept="image/*">
            </div>

            <div class="form-group">
    <label for="RemoveImage">Remove Current Image:</label>
    <input type="checkbox" name="RemoveImage" id="RemoveImage" value="1">
</div>



            <div class="form-actions">
                <button type="submit" class="submit-btn">Update Vehicle</button>
            </div>
        </form>
        <div class="back-link">
            <a href="read.php">Back to Vehicle List</a>
        </div>
    </div>
    <script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const year = document.getElementById('Year').value;
        const price = document.getElementById('Price').value;

        if (year < 1886 || year > new Date().getFullYear()) {
            alert("Year must be between 1886 and " + new Date().getFullYear() + ".");
            e.preventDefault();
        }
        if (price <= 0) {
            alert("Price must be a positive number.");
            e.preventDefault();
        }
    });
</script>

</body>
</html>
