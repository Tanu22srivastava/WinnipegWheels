<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];

    // Insert comment into database
    $stmt = $pdo->prepare("INSERT INTO Comments (VehicleID, CommentText) VALUES (:VehicleID, :comment)");
    $stmt->execute(['VehicleID' => $vehicleId, 'comment' => $comment]);
}

// Fetch comments for the vehicle
$stmt = $pdo->prepare("SELECT * FROM Comments WHERE VehicleID = :VehicleID ORDER BY CommentDate DESC");
$stmt->execute(['VehicleID' => $vehicleId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Comments</title>
</head>
<body>
    <h2>Comments for Vehicle: <?= htmlspecialchars($vehicle['Manufacturer'] . ' ' . $vehicle['Model']) ?></h2>
    <ul>
        <?php foreach ($comments as $comment): ?>
        <li><?= htmlspecialchars($comment['CommentText']) ?> (<?= htmlspecialchars($comment['CommentDate']) ?>)</li>
        <?php endforeach; ?>
    </ul>
    <form method="POST">
        <textarea name="comment" required></textarea>
        <input type="hidden" name="VehicleID" value="<?= htmlspecialchars($vehicleId) ?>">
        <button type="submit">Add Comment</button>
    </form>
</body>
</html>
