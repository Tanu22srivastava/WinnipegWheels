<?php
require 'db.php';

// Validate and retrieve the page ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid or missing Page ID.');
}
$pageId = $_GET['id'];

// Fetch the page details from the database
$stmt = $pdo->prepare("SELECT * FROM Pages WHERE PageID = :id");
$stmt->execute(['id' => $pageId]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
    die('Page not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page['Title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($page['Title']) ?></h1>
    <p><strong>Description:</strong> <?= htmlspecialchars($page['Content']) ?></p>
    <div>
        <strong>Content:</strong>
        <p><?= nl2br(htmlspecialchars($page['Content'])) ?></p>
    </div>
    <a href="search.php">Back to Search</a>
</body>
</html>
