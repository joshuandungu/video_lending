<?php
session_start();
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT r.*, v.title, v.thumbnail FROM rentals r JOIN videos v ON r.video_id = v.id WHERE r.user_id = $user_id");

while ($rental = $result->fetch_assoc()) {
    $isLate = (new DateTime() > new DateTime($rental['due_date']));
    $lateFee = $isLate ? round((new DateTime()->diff(new DateTime($rental['due_date']))->days) * 2, 2) : 0;

    echo "
        <div class='rental'>
            <img src='../{$rental['thumbnail']}' alt='{$rental['title']}'>
            <h3>{$rental['title']}</h3>
            <p>Due Date: {$rental['due_date']}</p>
            <p>Status: " . ($rental['returned'] ? "Returned" : "Not Returned") . "</p>
            <p>Late Fee: \$$lateFee</p>
            " . (!$rental['returned'] ? "<a href='return.php?id={$rental['id']}' class='btn'>Return Video</a>" : "") . "
        </div>
    ";
}
?>
