<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'water_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
$sql = "SELECT * FROM water_records";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Customer Name: " . $row['customer_name'] . " - Status: " . ($row['status'] ?? 'Pending') . "<br>";
        echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a><br>";
    }
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>
