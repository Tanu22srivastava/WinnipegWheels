<?php
session_start();
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid or missing Vehicle ID.');
}
$vehicleId = $_GET['id'];

// Validate the VehicleID
$stmt = $pdo->prepare("SELECT * FROM Vehicles WHERE VehicleId = :id");
$stmt->execute(['id' => $vehicleId]);
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vehicle) {
    die('Invalid Vehicle ID.');
}

// CAPTCHA generation logic
if (!isset($_SESSION['captcha_answer'])) {
    // Generate random arithmetic question (e.g., 3 + 7)
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    $_SESSION['captcha_question'] = "What is $num1 + $num2?";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CAPTCHA
    if ($_POST['captcha'] != $_SESSION['captcha_answer']) {
        $error = 'Incorrect CAPTCHA answer. Please try again.';
    } else {
        // Insert comment into database
        $comment = $_POST['comment'];
        $stmt = $pdo->prepare("INSERT INTO Comments (VehicleID, CommentText) VALUES (:VehicleID, :comment)");
        $stmt->execute(['VehicleID' => $vehicleId, 'comment' => $comment]);
        $success = 'Comment added successfully!';
        unset($_SESSION['captcha_answer']); // Clear CAPTCHA after successful submission
    }
}

// Fetch comments for the vehicle
$stmt = $pdo->prepare("SELECT * FROM Comments WHERE VehicleID = :VehicleID ORDER BY CommentDate DESC");
$stmt->execute(['VehicleID' => $vehicleId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CAPTCHA image generation
if (isset($_GET['captcha_image']) && $_GET['captcha_image'] == 'true') {
    // Create image for CAPTCHA
    $width = 150;
    $height = 50;
    $image = imagecreate($width, $height);
    $bgColor = imagecolorallocate($image, 255, 255, 255); // White background
    $textColor = imagecolorallocate($image, 0, 0, 0); // Black text
    $lineColor = imagecolorallocate($image, 200, 200, 200); // Light grey lines

    // Draw some lines for distortion
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
    }

    // Add the CAPTCHA question text
    imagestring($image, 5, 50, 15, $_SESSION['captcha_question'], $textColor);

    // Output the image
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Comments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .comments-list {
            margin: 20px 0;
            padding: 0;
            list-style-type: none;
        }
        .comments-list li {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        .comments-list li:last-child {
            border-bottom: none;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-container textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container input[type="text"] {
            width: 100px;
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .form-container img {
            margin-top: 10px;
        }
        .error, .success {
            text-align: center;
            padding: 10px;
            margin: 10px 0;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="all_comments.php">All Comments</a>
        <a href="#">Contact</a>
    </div>

    <div class="container">
        <h2>Comments for Vehicle: <?= htmlspecialchars($vehicle['Manufacturer'] . ' ' . $vehicle['Model']) ?></h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <ul class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <li>
                    <p><?= htmlspecialchars($comment['CommentText']) ?></p>
                    <small>Posted on <?= htmlspecialchars($comment['CommentDate']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="form-container">
            <form method="POST">
                <textarea name="comment" required placeholder="Write your comment..."></textarea>
                <div>
                    <img src="?captcha_image=true" alt="CAPTCHA Image">
                </div>
                <label for="captcha">What is <?= htmlspecialchars($_SESSION['captcha_question']) ?>?</label>
                <input type="text" name="captcha" required>
                <button type="submit">Add Comment</button>
            </form>
        </div>

        <a class="back-link" href="index.php">Back to Dashboard</a>
    </div>
</body>
</html>
