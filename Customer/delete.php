<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample1');

// Check connection
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

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: success.php"); // Redirect to a success page
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Handle the case where 'id' is not set or invalid
    echo "Invalid ID provided.";
}

// Close the database connection
$conn->close();
?>
