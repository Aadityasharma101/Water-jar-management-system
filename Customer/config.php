<?php
$conn = new mysqli('localhost', 'root', '', 'sample');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
