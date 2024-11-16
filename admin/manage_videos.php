<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}

// Fetch videos
$result = $conn->query("SELECT * FROM videos");
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['title']} - {$row['genre']} - \$${row['price']}</p>";
    echo "<a href='edit_video.php?id={$row['id']}'>Edit</a>";
    echo "<a href='delete_video.php?id={$row['id']}'>Delete</a>";
}
?>

