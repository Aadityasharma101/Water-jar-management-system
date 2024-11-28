<?php
$conn = new mysqli('localhost', 'root', '', 'water_management');
$result = $conn->query("SELECT * FROM water_records");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['water_quantity']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['email']}</td>
        <td>{$row['delivery_date']}</td>
        <td>{$row['status']}</td>
        <td>
            <a href='edit.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
            <a href='delete.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
        </td>
    </tr>";
}
$conn->close();
?>
