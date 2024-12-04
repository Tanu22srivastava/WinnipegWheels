<?php
session_start();
require 'db.php';

// // Check if the user is logged in and has the correct role
// if (!isset($_SESSION['Role_name']) || $_SESSION['Role_name'] !== 'Admin') {
//     die('You do not have permission to add a vehicle.');
// }

$errorMessages = [];
$successMessage = "";

// Process the form submission for adding a vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs (as in your original code)
    $manufacturer = filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $specifications = filter_input(INPUT_POST, 'specifications', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($manufacturer) || strlen($manufacturer) > 50) {
        $errorMessages[] = "Manufacturer name must not be empty or exceed 50 characters.";
    }

    if (empty($model) || strlen($model) > 50) {
        $errorMessages[] = "Model name must not be empty or exceed 50 characters.";
    }

    if (empty($year) || !is_numeric($year) || $year < 1900 || $year > intval(date('Y'))) {
        $errorMessages[] = "Year must be a valid number between 1900 and the current year.";
    }

    if (empty($price) || !is_numeric($price) || $price <= 0) {
        $errorMessages[] = "Price must be a positive number.";
    }

    if (empty($specifications) || strlen($specifications) > 500) {
        $errorMessages[] = "Specifications must not be empty or exceed 500 characters.";
    }

    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        // Handle image upload and resizing
        $targetDir = "upload/images/";
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . uniqid() . "_" . $fileName;

        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Resize the image
                $resizedFilePath = $targetDir . "resized_" . uniqid() . ".jpg";
                resizeImage($targetFilePath, $resizedFilePath, 800, 600);
                $imagePath = $resizedFilePath;
                unlink($targetFilePath); // Remove original image
            } else {
                $errorMessages[] = "Failed to upload the image.";
            }
        } else {
            $errorMessages[] = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }

    // If no validation errors, proceed to insert into the database
    if (empty($errorMessages)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Vehicles (Manufacturer, Model, Year, Price, Specifications, Image) 
                                   VALUES (:manufacturer, :model, :year, :price, :specifications, :image)");
            $stmt->execute([
                'manufacturer' => $manufacturer,
                'model' => $model,
                'year' => $year,
                'price' => $price,
                'specifications' => $specifications,
                'image' => $imagePath
            ]);
            $successMessage = "Vehicle added successfully!";
        } catch (PDOException $e) {
            $errorMessages[] = "Error adding vehicle: " . $e->getMessage();
        }
    }
}

/**
 * Resize an image to specified dimensions.
 *
 * @param string $sourcePath The path to the original image.
 * @param string $destPath The path to save the resized image.
 * @param int $width The target width.
 * @param int $height The target height.
 */
function resizeImage($sourcePath, $destPath, $width, $height) {
    list($srcWidth, $srcHeight, $type) = getimagesize($sourcePath);

    // Create a new blank image
    $destImage = imagecreatetruecolor($width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $srcImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $srcImage = imagecreatefrompng($sourcePath);
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            break;
        case IMAGETYPE_GIF:
            $srcImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    // Resize the image
    imagecopyresampled(
        $destImage, $srcImage,
        0, 0, 0, 0,
        $width, $height,
        $srcWidth, $srcHeight
    );

    // Save the resized image
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($destImage, $destPath, 85);
            break;
        case IMAGETYPE_PNG:
            imagepng($destImage, $destPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($destImage, $destPath);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($destImage);

    return true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <!-- CSS Styling -->
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

        div h1 {
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

        .vehicle-form input {
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
        .error-messages {
            color: #d9534f;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success-message {
            color: #28a745;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .required {
    color: red; /* Sets the color of the * symbol to red */
    font-weight: bold; /* Makes the * bold */
    margin-left: 5px; /* Adds a little space between the label and * */
}

    </style>
</head>
<body>

    <header>
        <h1>Winnipeg Wheels</h1>
    </header>
    <nav>
        <ul>
            <li><a href="read.php">View All Vehicles</a></li>
            <li><a href="comments.php">Comments</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <div class="search-container">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search for pages..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div>
        <h1>Add Vehicles</h1>
    </div>

    <main>
        <!-- Display error messages -->
        <?php if (!empty($errorMessages)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errorMessages as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (!empty($successMessage)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Form for adding vehicles -->
        <form method="POST" class="vehicle-form" enctype="multipart/form-data">
    <label for="manufacturer">Manufacturer: <span class="required">*</span></label>
    <input type="text" name="manufacturer" id="manufacturer" required>
    
    <label for="model">Model: <span class="required">*</span></label>
    <input type="text" name="model" id="model" required>
    
    <label for="year">Year: <span class="required">*</span></label>
    <input type="number" name="year" id="year" required>
    
    <label for="price">Price: <span class="required">*</span></label>
    <input type="number" step="0.01" name="price" id="price" required>

    <label for="specifications">Specifications: <span class="required">*</span></label>
    <input type="text" name="specifications" id="specifications" required>

    <label for="image">Vehicle Image (optional):</label>
    <input type="file" name="image" id="image" accept="image/*">
    
    <button type="submit" class="submit-btn">Add Vehicle</button>
</form>


        <div class="back-link">
            <a href="admin.php">Back to Dashboard</a>
        </div>
    </main>

    <footer>
        &copy; 2024 Winnipeg Wheels
    </footer>

    
</body>
</html>
