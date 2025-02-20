<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $water_quantity = $_POST['water_quantity'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $delivery_date = $_POST['delivery_date'];

    // Prepare update statement
    $sql = "UPDATE water_records SET 
            customer_name = ?, 
            water_quantity = ?, 
            phone = ?, 
            email = ?, 
            delivery_date = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sisssi", 
        $customer_name, 
        $water_quantity, 
        $phone, 
        $email, 
        $delivery_date, 
        $id
    );

    // Execute the update
    if ($stmt->execute()) {
        // Redirect back to dashboard with success message
        header("Location: dashboard.php?message=Order+updated+successfully");
        exit();
    } else {
        // Redirect back to edit page with error message
        header("Location: edit.php?id=$id&error=Failed+to+update+order");
        exit();
    }

    $stmt->close();
} else {
    // If someone tries to access this file directly without POST data
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?> 