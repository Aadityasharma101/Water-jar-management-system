<?php

session_start();

// Check if user is logged in and has delivery_boy role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/otherlogin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerQuery = "SELECT COUNT(DISTINCT customer_name) as total_customers FROM water_records";
$customerResult = $conn->query($customerQuery);
$totalCustomers = $customerResult->fetch_assoc()['total_customers'];

$quantityQuery = "SELECT SUM(water_quantity) as total_quantity FROM water_records";
$quantityResult = $conn->query($quantityQuery);
$totalQuantity = $quantityResult->fetch_assoc()['total_quantity'] ?? 0;

$result = $conn->query("SELECT * FROM water_records");

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>
        .navbar { background-color: #007bff; }
        .navbar a { color: #fff; }
        .card { border-radius: 10px; }
        .card-header { background-color: #007bff; color: white; }
        .table thead { background-color: #f1f1f1; }
        .table-hover tbody tr:hover { background-color: #f1f1f1; }
        .btn-primary { background-color: #007bff; }
        .sidebar { background-color: #343a40; height: 100vh; padding-top: 20px; }
        .sidebar a { color: white; }
        .sidebar a:hover { background-color: #007bff; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar p-3 flex-column">
            <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
                <i class='bx bxs-smile fs-3 me-2'></i> <span>AdminHub</span>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link text-white active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="view-msg.php" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Message
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="review.php" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Review
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white">
                        <i class='bx bxs-log-out-circle'></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="w-100">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">AdminHub</a>
                    <div class="collapse navbar-collapse">
                       
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                <h1 class="mb-4">Water Management Dashboard</h1>

                <!-- Add this right after your navbar -->
                <div class="container mt-3">
                    <?php
                    // Check for new notifications
                    $notify_query = "SELECT * FROM notifications WHERE user_type='admin' AND is_read=0 ORDER BY created_at DESC";
                    $notifications = $conn->query($notify_query);
                    
                    if ($notifications && $notifications->num_rows > 0) {
                        while($notify = $notifications->fetch_assoc()) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($notify['message']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                        
                        // Mark notifications as read
                        $conn->query("UPDATE notifications SET is_read=1 WHERE user_type='admin'");
                    }
                    ?>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Total Customers</h5>
                            </div>
                            <div class="card-body text-center">
                                <h2 class="display-4"><?php echo $totalCustomers; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Total Water Jars</h5>
                            </div>
                            <div class="card-body text-center">
                                <h2 class="display-4"><?php echo $totalQuantity; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-header">
                        <h3>Order Records</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Water Quantity</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['water_quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
                                        <td>
                                            <form action="update_order_status.php" method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                                <select name="status" class="form-select form-select-sm">
                                                    <option value="pending" <?php echo ($row['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="processing" <?php echo ($row['status'] === 'processing') ? 'selected' : ''; ?>>Processing</option>
                                                    <option value="shipping" <?php echo ($row['status'] === 'shipping') ? 'selected' : ''; ?>>Shipping</option>
                                                    <option value="delivered" <?php echo ($row['status'] === 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm mt-1">Update Status</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?php echo htmlspecialchars($_GET['message'] ?? 'Operation successful!'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?php echo htmlspecialchars($_GET['message'] ?? 'An error occurred!'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
