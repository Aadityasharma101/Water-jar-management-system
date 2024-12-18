<?php
$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerQuery = "SELECT COUNT(DISTINCT customer_name) as total_customers FROM water_records";
$customerResult = $conn->query($customerQuery);
$totalCustomers = $customerResult->fetch_assoc()['total_customers'];

$quantityQuery = "SELECT SUM(water_quantity) as total_quantity FROM water_records";
$quantityResult = $conn->query($quantityQuery);
$totalQuantity = $quantityResult->fetch_assoc()['total_quantity'] ?? 0; // Default to 0 if null

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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">

    <title>Water Management Dashboard</title>
    <style>
        
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: #fff;
        }
        .card {
            border-radius: 10px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .table thead {
            background-color: #f1f1f1;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
        }
        .sidebar a:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- SIDEBAR -->
        <nav class="sidebar p-3 flex-column">
            <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
                <i class='bx bxs-smile fs-3 me-2'></i> <span>AdminHub</span>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="logout/dashboard/dashboard.php" class="nav-link text-white active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="messege.php" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Messages
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="logout/settings/settings.php" class="nav-link text-white">
                        <i class='bx bxs-cog'></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout/logout.php" class="nav-link text-white">
                        <i class='bx bxs-log-out-circle'></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="w-100">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light px-4 shadow-sm">
                <a class="navbar-brand text-white" href="#">AdminHub</a>
                <div class="collapse navbar-collapse">
                    <form class="d-flex ms-auto">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <div class="container mt-4">
                <h1 class="mb-4">Water Management Dashboard</h1>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Total Customers</h5>
                            </div>
                            <div class="card-body text-center">
                                <h2 class="display-4 mb-0"><?php echo $totalCustomers; ?></h2>
                                <p class="text-muted mt-2">Total Customers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Total Water Jars</h5>
                            </div>
                            <div class="card-body text-center">
                                <h2 class="display-4 mb-0"><?php echo $totalQuantity; ?></h2>
                                <p class="text-muted mt-2">Jars Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>

              

                <!-- Records Table -->
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
                                <?php
                                if ($result->num_rows > 0) {
                                    // Display records
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>" . htmlspecialchars($row['customer_name']) . "</td>
                                            <td>" . htmlspecialchars($row['water_quantity']) . "</td>
                                            <td>" . htmlspecialchars($row['phone']) . "</td>
                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                            <td>" . htmlspecialchars($row['delivery_date']) . "</td>
                                            <td>" . htmlspecialchars(isset($row['status']) ? $row['status'] : 'Pending') . "</td>
                                            <td>
                                                <a href='edit.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Edit</a>
                                                <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to Add New Record -->
    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">Add New Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_record.php" method="POST">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="waterQuantity" class="form-label">Water Quantity</label>
                            <input type="number" class="form-control" id="waterQuantity" name="water_quantity" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="deliveryDate" class="form-label">Delivery Date</label>
                            <input type="date" class="form-control" id="deliveryDate" name="delivery_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS  This is the bootstrap js  it is very important-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
