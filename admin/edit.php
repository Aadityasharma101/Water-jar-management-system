<?php
$conn = new mysqli('localhost', 'root', '', 'sample');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['customer_name'];
    $quantity = $_POST['water_quantity'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['delivery_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE water_records SET customer_name = ?, water_quantity = ?, phone = ?, email = ? ,delivery_date = ?, status = ? WHERE id = ?");
    $stmt->bind_param('sissi', $name, $quantity,  $phone, $date, $email, $status, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
}
// Fetch record for editing
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM water_records WHERE id = $id");
$record = $result->fetch_assoc();
$conn->close();
?>
<!-- HTML form pre-filled with $record data -->
