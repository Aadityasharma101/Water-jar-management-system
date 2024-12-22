<?php
require 'db_connection.php';

$sql = "SELECT r.id, r.review_text, r.rating, r.timestamp, c.name AS customer_name 
        FROM reviews r 
        JOIN customers c ON r.customer_id = c.id 
        ORDER BY r.timestamp DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Customer</th>
                <th>Review</th>
                <th>Rating</th>
                <th>Timestamp</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['customer_name']}</td>
                <td>{$row['review_text']}</td>
                <td>{$row['rating']}</td>
                <td>{$row['timestamp']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No reviews found.";
}
$conn->close();
?>
