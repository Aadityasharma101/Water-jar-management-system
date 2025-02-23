<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM water_records WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header("Location: dashboard.php?message=Record+deleted+successfully");
        exit();
    } else {
        // Redirect back to the dashboard with an error message
        header("Location: dashboard.php?message=Error+deleting+record");
        exit();
    }

    $stmt->close();
} else {
    // Redirect back to the dashboard if no ID is provided
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>
