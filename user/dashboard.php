<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../admin/login.php');
}

if (isset($_GET['id'])) {
    $video_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Rent video logic
    $due_date = date('Y-m-d', strtotime('+7 days'));
    $conn->query("INSERT INTO rentals (user_id, video_id, due_date) VALUES ($user_id, $video_id, '$due_date')");
    $conn->query("UPDATE videos SET is_available = 0 WHERE id = $video_id");

    echo "<p>Video rented successfully! Due date: $due_date</p>";
}
?>
<a href="rentals.php" class="btn">View My Rentals</a>
<?php
$reviews = $conn->query("SELECT r.rating, r.comment, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.video_id = $video_id");
while ($review = $reviews->fetch_assoc()) {
    echo "
        <div class='review'>
            <h4>{$review['name']} (Rating: {$review['rating']}/5)</h4>
            <p>{$review['comment']}</p>
        </div>
    ";
}
?>

