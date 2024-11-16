<?php include 'includes/header.php';
require_once('includes/db.php') ?>
<div class="container">
    <h1>Available Videos</h1>
    <div class="videos-grid">
    <?php
$result = $conn->query("SELECT * FROM videos WHERE is_available = 1");
while ($row = $result->fetch_assoc()) {
    echo "
        <div class='video-card'>
            <img src='{$row['thumbnail']}' alt='{$row['title']}'>
            <h3>{$row['title']}</h3>
            <p>Genre: {$row['genre']}</p>
            <p>Price: \${$row['price']}</p>
            <a href='watch.php?id={$row['id']}' class='btn'>Watch Now</a>
        </div>
    ";
}
?>

    </div>
</div>
<?php include 'includes/footer.php'; ?>
