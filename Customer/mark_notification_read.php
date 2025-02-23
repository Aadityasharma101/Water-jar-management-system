<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sample');

if (isset($_GET['id'])) {
    $notification_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 
                           WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $notification_id, $user_id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>
