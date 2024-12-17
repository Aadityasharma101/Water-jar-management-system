<?php
$conn = new mysqli('localhost', 'root', '', 'water_jar_management');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
