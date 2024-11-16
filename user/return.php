<?php
session_start();
include '../includes/db.php';

if (isset($_GET['id'])) {
    $rental_id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE rentals SET returned = 1 WHERE id = ?");
    $stmt->bind_param('i', $rental_id);

    if ($stmt->execute()) {
        echo "<p>Video returned successfully!</p>";
    }
}
?>
<a href="rentals.php" class="btn">Back to Rentals</a>
