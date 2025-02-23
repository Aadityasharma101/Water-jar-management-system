<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch total number of customers
$sql = "SELECT COUNT(*) as total_customers FROM users WHERE user_type = 'customer'";
$result = $conn->query($sql);
$total_customers = $result->fetch_assoc()['total_customers'];

// Fetch total earnings
$sql = "SELECT SUM(total_price) as total_earnings FROM orders WHERE status != 'cancelled'";
$result = $conn->query($sql);
$total_earnings = $result->fetch_assoc()['total_earnings'];

// Fetch total number of orders
$sql = "SELECT COUNT(*) as total_orders FROM orders";
$result = $conn->query($sql);
$total_orders = $result->fetch_assoc()['total_orders'];

// Fetch recent orders
$sql = "SELECT o.*, u.username, w.name AS jar_name FROM orders o
        JOIN users u ON o.customer_id = u.id
        JOIN water_jars w ON o.jar_id = w.id
        ORDER BY o.created_at DESC LIMIT 5";
$result = $conn->query($sql);
$recent_orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Water Jar Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="manage_orders.php"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Customers</h3>
                <p><?php echo $total_customers; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Earnings</h3>
                <p>$<?php echo number_format($total_earnings, 2); ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?></p>
            </div>
        </div>

        <h2>Recent Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Water Jar</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['jar_name']); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                        <td><?php echo ucfirst($order['status']); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="manage_orders.php" class="btn">View All Orders</a>
    </div>
</body>
</html>