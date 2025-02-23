<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'delivery_boy') {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT o.*, u.username, u.email, w.name AS jar_name FROM orders o
        JOIN users u ON o.customer_id = u.id
        JOIN water_jars w ON o.jar_id = w.id
        WHERE o.status = 'processing'
        ORDER BY o.created_at ASC";
$result = $conn->query($sql);
$deliveries = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Deliveries - Water Jar Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Deliveries</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Water Jar</th>
                    <th>Quantity</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deliveries as $delivery): ?>
                    <tr>
                        <td><?php echo $delivery['id']; ?></td>
                        <td><?php echo $delivery['username']; ?></td>
                        <td><?php echo $delivery['jar_name']; ?></td>
                        <td><?php echo $delivery['quantity']; ?></td>
                        <td><?php echo $delivery['email']; ?></td>
                        <td>
                            <form action="update_delivery_status.php" method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $delivery['id']; ?>">
                                <button type="submit" name="status" value="delivered">Mark as Delivered</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>