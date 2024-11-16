<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'video_lending';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
