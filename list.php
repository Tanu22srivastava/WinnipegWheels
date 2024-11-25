<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM Vehicles");
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vehicle List</h1>
    <table>
        <thead>
            <tr>
                <th>Manufacturer</th>
                <th>Model</th>
                <th>Year</th>
                <th>Price</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?= htmlspecialchars($vehicle['Manufacturer']) ?></td>
                <td><?= htmlspecialchars($vehicle['Model']) ?></td>
                <td><?= htmlspecialchars($vehicle['Year']) ?></td>
                <td><?= htmlspecialchars($vehicle['Price']) ?></td>
                <td><a href="details.php?id=<?= $vehicle['VehicleID'] ?>">View</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
