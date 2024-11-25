<?php
$host = 'localhost';
$db = 'winnipeg_wheels';
$user = 'root'; // Use the provided username if different
$pass = ''; // Use the provided password if different

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
