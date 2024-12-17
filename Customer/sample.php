<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Increment Total Visitors
$conn->query("UPDATE visitor_count SET total_visitors = total_visitors + 1 WHERE id = 1");

// Fetch Total Visitors
$visitorResult = $conn->query("SELECT total_visitors FROM visitor_count WHERE id = 1");
$totalVisitors = $visitorResult->fetch_assoc()['total_visitors'];

// Fetch records from the database
$result = $conn->query("SELECT * FROM water_records");

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Count new orders with 'Pending' status
$orderCountResult = $conn->query("SELECT COUNT(*) AS new_orders FROM water_records WHERE status = 'Pending'");
$newOrders = $orderCountResult->fetch_assoc()['new_orders'];

// Calculate Total Sales
$totalSalesResult = $conn->query("SELECT SUM(price) AS total_sales FROM water_records");
// $totalSales = $totalSalesResult->fetch_assoc()['total_sales'] ?? 0; // Default to 0 if no records exist
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .status {
            padding: 0.5em 1em;
            border-radius: 0.5em;
            color: #fff;
        }
        .status.completed {
            background-color: #198754;
        }
        .status.pending {
            background-color: #ffc107;
        }
        .status.process {
            background-color: #0d6efd;
        }
    </style>
    <title>Water Management Dashboard</title>
</head>
<body>
    <div class="container p-4">
        <!-- Dashboard Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">New Orders</h5>
                        <h2><?= $newOrders ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Visitors</h5>
                        <h2><?= $totalVisitors ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <!-- <h2>$<?= number_format($totalSales, 2) ?></h2> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="card shadow">
            <div class="card-header">
                <h3>Water Records</h3>
            </div>
            <div class="card-body">
                <a href="add.php" class="btn btn-primary mb-3">Add New Record</a>
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Water Quantity</th>
                            <th>Price</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = strtolower($row['status']);
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['customer_name']}</td>
                                    <td>{$row['water_quantity']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['delivery_date']}</td>
                                    <td><span class='status $statusClass'>{$row['status']}</span></td>
                                    <td>
                                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
