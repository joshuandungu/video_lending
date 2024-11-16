<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}

// Fetch all late fees
$result = $conn->query("
    SELECT r.*, u.name AS user_name, v.title AS video_title, 
           DATEDIFF(CURDATE(), r.due_date) * 2 AS late_fee
    FROM rentals r
    JOIN users u ON r.user_id = u.id
    JOIN videos v ON r.video_id = v.id
    WHERE r.returned = 0 AND CURDATE() > r.due_date
");

echo "<table>
        <tr>
            <th>User</th>
            <th>Video</th>
            <th>Due Date</th>
            <th>Days Late</th>
            <th>Late Fee</th>
        </tr>";
while ($row = $result->fetch_assoc()) {
    $daysLate = max(0, (new DateTime())->diff(new DateTime($row['due_date']))->days);
    $lateFee = $daysLate * 2;

    echo "
        <tr>
            <td>{$row['user_name']}</td>
            <td>{$row['video_title']}</td>
            <td>{$row['due_date']}</td>
            <td>{$daysLate}</td>
            <td>\$$lateFee</td>
        </tr>
    ";
}
echo "</table>";
?>
