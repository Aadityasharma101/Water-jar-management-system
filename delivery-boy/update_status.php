<?php
session_start();

// Check if user is logged in and has delivery_boy role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_boy') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    http_response_code(500);
    echo "Connection failed";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE water_records SET status = 'Delivered' WHERE id = ? AND status = 'Pending'");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        http_response_code(500);
        echo "Failed to update status";
    }
    
    $stmt->close();
} else {
    http_response_code(400);
    echo "Invalid request";
}

$conn->close();
?> 