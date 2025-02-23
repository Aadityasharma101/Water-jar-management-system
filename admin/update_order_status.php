<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    // Simple update query
    $stmt = $conn->prepare("UPDATE water_records SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Status updated to " . ucfirst($status) . "');
            window.location.href='dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to update status');
            window.location.href='dashboard.php';
        </script>";
    }
    exit();
}

$conn->close();
?>
