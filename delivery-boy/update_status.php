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
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Simple status update
    $update = $conn->query("UPDATE water_records SET status = 'delivered' WHERE id = $order_id");
    
    if ($update) {
        // Get order details
        $result = $conn->query("SELECT customer_name, email FROM water_records WHERE id = $order_id");
        $order = $result->fetch_assoc();
        
        // Add notifications
        $customer_msg = "Your order #$order_id has been delivered successfully!";
        $admin_msg = "Order #$order_id has been marked as delivered";
        
        // Insert notifications (ignore errors)
        $conn->query("INSERT INTO notifications (user_type, user_reference, message, order_id) 
                     VALUES ('customer', '{$order['email']}', '$customer_msg', $order_id)");
        
        $conn->query("INSERT INTO notifications (user_type, user_reference, message, order_id) 
                     VALUES ('admin', 'admin', '$admin_msg', $order_id)");
        
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?> 