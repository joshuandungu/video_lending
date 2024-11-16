<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video_id = $_POST['video_id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO reviews (video_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiis', $video_id, $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo "<p>Review submitted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}
?>
<form method="post">
    <input type="hidden" name="video_id" value="<?php echo $_GET['video_id']; ?>">
    <label>Rating (1-5):</label>
    <input type="number" name="rating" min="1" max="5" required>
    <label>Comment:</label>
    <textarea name="comment" required></textarea>
    <button type="submit">Submit Review</button>
</form>
