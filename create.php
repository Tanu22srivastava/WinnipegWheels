<?php
// Include database connection (config.php)
include('config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form data
    $manufacturer = htmlspecialchars($_POST['Manufacturer']);
    $model = htmlspecialchars($_POST['Model']);
    $year = htmlspecialchars($_POST['Year']);
    $price = htmlspecialchars($_POST['Price']);
    $specifications = htmlspecialchars($_POST['Specifications']);
    
    // SQL query to insert new vehicle
    $sql = "INSERT INTO Vehicles (Manufacturer, Model, Year, Price, Specifications) 
            VALUES (:manufacturer, :model, :year, :price, :specifications)";
    
    // Prepare the SQL query
    $stmt = $pdo->prepare($sql);
    
    // Bind the parameters
    $stmt->bindParam(':manufacturer', $manufacturer);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':specifications', $specifications);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "<div class='success-message'>Vehicle added successfully!</div>";
    } else {
        echo "<div class='error-message'>Error: Could not add vehicle.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Vehicle</title>
    <style>
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

        .vehicle-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .vehicle-form label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            font-weight: bold;
        }

        .vehicle-form input,
        .vehicle-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .vehicle-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .vehicle-form button:hover {
            background-color: #45a049;
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

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="add_vehicle.php">Add New Vehicle</a></li>
            <li><a href="read.php">View Vehicles</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <header>
        <h1>Add New Vehicle</h1>
    </header>
    
    <main>
        <form method="POST" class="vehicle-form">
            <label>Manufacturer:</label>
            <input type="text" name="Manufacturer" required>
            
            <label>Model:</label>
            <input type="text" name="Model" required>
            
            <label>Year:</label>
            <input type="number" name="Year" required>
            
            <label>Price:</label>
            <input type="number" step="0.01" name="Price" required>
            
            <label>Specifications:</label>
            <textarea name="Specifications" required></textarea>
            
            <button type="submit" class="submit-btn">Add Vehicle</button>
        </form>
        <div class="back-link">
            <a href="admin.php">Back to Dashboard</a>
        </div>
    </main>

    <footer>
        &copy; 2024 Winnipeg Wheels
    </footer>

    <!-- CSS Styling -->
    
</body>
</html>
