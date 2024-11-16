<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    // Handle thumbnail upload
    $thumbnail = $_FILES['thumbnail'];
    $thumbnailPath = 'images/thumbnails/' . basename($thumbnail['name']);
    move_uploaded_file($thumbnail['tmp_name'], '../' . $thumbnailPath);

    // Handle video upload
    $video = $_FILES['video'];
    $videoPath = 'videos/' . basename($video['name']);
    move_uploaded_file($video['tmp_name'], '../' . $videoPath);

    // Insert video details into the database
    $stmt = $conn->prepare("INSERT INTO videos (title, description, genre, thumbnail, file_path, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssd', $title, $description, $genre, $thumbnailPath, $videoPath, $price);

    if ($stmt->execute()) {
        echo "<p>Video uploaded successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <h1>Add Video</h1>
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    
    <label for="description">Description:</label>
    <textarea name="description" required></textarea>
    
    <label for="genre">Genre:</label>
    <input type="text" name="genre" required>
    
    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" required>
    
    <label for="thumbnail">Thumbnail:</label>
    <input type="file" name="thumbnail" accept="image/*" required>
    
    <label for="video">Video File:</label>
    <input type="file" name="video" accept="video/*" required>
    
    <button type="submit">Upload Video</button>
</form>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const video = document.querySelector('input[name="video"]').files[0];
        const thumbnail = document.querySelector('input[name="thumbnail"]').files[0];

        if (!in_array($video['type'], ['video/mp4', 'video/webm', 'video/ogg'])) {
    die('Invalid video file type.');
}

if (!in_array($thumbnail['type'], ['image/jpeg', 'image/png'])) {
    die('Invalid thumbnail file type.');
}


        if (!video || !thumbnail) {
            e.preventDefault();
            alert('Please upload both a video file and a thumbnail.');
        } else if (video.size > 100 * 1024 * 1024) { // Limit video size to 100MB
            e.preventDefault();
            alert('The video file is too large. Please upload a file smaller than 100MB.');
        }

    });
</script>
