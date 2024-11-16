<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $video_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM videos WHERE id = $video_id");
    $video = $result->fetch_assoc();

    if ($video) {
        echo "
            <h1>{$video['title']}</h1>
            <video width='800' controls>
                <source src='{$video['file_path']}' type='video/mp4'>
                Your browser does not support the video tag.
            </video>
            <p>{$video['description']}</p>
            <p>Genre: {$video['genre']}</p>
            <p>Price: \${$video['price']}</p>
        ";
    } else {
        echo "<p>Video not found.</p>";
    }
}
?>
