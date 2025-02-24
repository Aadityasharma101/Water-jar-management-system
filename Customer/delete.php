<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL and is a valid number
if (isset($_GET['$id']) && is_numeric($_GET['$id'])) {
    $id = intval(value: $_GET['$id']); // Convert to integer to prevent SQL injection

    // Prepare the DELETE statement
    $sql = "DELETE FROM water_records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: success.php"); // Redirect to a success page
        exit;
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
