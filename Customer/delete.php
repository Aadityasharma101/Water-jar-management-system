<?php
$conn = new mysqli('localhost', 'root', '', 'sample');
$id = $_GET['id'];
$conn->query("DELETE FROM water_records WHERE id = $id");
$conn->close();
header("Location: dashboard.php");
?>
