<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample1');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the price per jar
$price_per_jar = 5; // Adjust this value as needed

// Query to calculate total bill for each customer
$sql = "SELECT customer_name, SUM(water_quantity) AS total_jars 
        FROM water_records 
        GROUP BY customer_name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Total Bill Summary</h1>";
    echo "<table border='1'>
            <tr>
                <th>Customer Name</th>
                <th>Total Water Jars Taken</th>
                <th>Total Bill ($)</th>
            </tr>";
    
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $total_jars = $row['total_jars'];
        $total_bill = $total_jars * $price_per_jar; // Calculate total bill

        echo "<tr>
                <td>" . htmlspecialchars($row['customer_name']) . "</td>
                <td>" . htmlspecialchars($total_jars) . "</td>
                <td>" . htmlspecialchars($total_bill) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>
