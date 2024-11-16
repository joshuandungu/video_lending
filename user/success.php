<?php
include '../includes/db.php';

if (isset($_GET['paymentId'])) {
    $rental_id = $_SESSION['rental_id'];
    $user_id = $_SESSION['user_id'];
    $amount = $_SESSION['late_fee'];

    // Store payment details in the database
    $stmt = $conn->prepare("INSERT INTO payments (rental_id, user_id, amount, payment_status) VALUES (?, ?, ?, 'success')");
    $stmt->bind_param('iid', $rental_id, $user_id, $amount);
    $stmt->execute();

    echo "<p>Payment successful! Thank you!</p>";
}
?>
