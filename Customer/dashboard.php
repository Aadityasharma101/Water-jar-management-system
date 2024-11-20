<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
$result = $conn->query("SELECT * FROM water_records");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Management Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Water Management Dashboard</h1>
        <!-- Add New Record Button -->
        <a href="add.php" class="btn btn-primary mb-3">Add New Record</a>

        <!-- Records Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Water Quantity</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Display records
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['water_quantity']}</td>
                            <td>{$row['delivery_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    // No records found
                    echo "<tr><td colspan='6' class='text-center'>No records found. Add a new record to get started!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
