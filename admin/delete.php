<?php
$conn = new mysqli('localhost', 'root', '', 'sample');
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM water_records WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$stmt->close();
$conn->close();
header("Location: dashboard.php");
exit();
?>

