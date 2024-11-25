<?php
// Include database connection
require_once 'config.php';

if (isset($_GET['id'])) {
    $vehicleID = $_GET['id'];

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Delete related rows from `comments`
        $sql = "DELETE FROM comments WHERE VehicleID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $vehicleID]);

        // Delete the vehicle
        $sql = "DELETE FROM Vehicles WHERE VehicleID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $vehicleID]);

        // Commit transaction
        $pdo->commit();

        header("Location: read.php");
        exit;
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
