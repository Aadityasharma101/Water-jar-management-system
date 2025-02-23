<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample'); // Ensure the database name is correct

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select messages
$sql = "SELECT customer_name, water_quantity, phone, email, delivery_date FROM water_record"; // Ensure the table name is correct
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

// Fetch and display results
while ($row = $result->fetch_assoc()) {
    echo "Customer Name: " . htmlspecialchars($row['customer_name']) . "<br>";
    echo "Water Quantity: " . htmlspecialchars($row['water_quantity']) . "<br>";
    echo "Phone: " . htmlspecialchars($row['phone']) . "<br>";
    echo "Email: " . htmlspecialchars($row['email']) . "<br>";
    echo "Delivery Date: " . htmlspecialchars($row['delivery_date']) . "<br><br>";
}

// Close the database connection
$conn->close();
?>
