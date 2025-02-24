<?php
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE orders SET status = 'delivered' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        // Redirect to the delivery boy dashboard after updating
        header("Location: ../delivery/dashboard.php?message=Order+marked+as+delivered");
        exit();
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
