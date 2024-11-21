<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
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
</head>
<body>
    <div class="d-flex">
        <!-- SIDEBAR -->
        <nav class="bg-dark text-white p-3 vh-100 flex-column" style="width: 250px;">
            <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
                <i class='bx bxs-smile fs-3 me-2'></i> <span>AdminHub</span>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Messages
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        <i class='bx bxs-cog'></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class='bx bxs-log-out-circle'></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="w-100">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
                <a class="navbar-brand" href="#">AdminHub</a>
                <div class="collapse navbar-collapse">
                    <form class="d-flex ms-auto">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <div class="container mt-4">
                <h1 class="mb-4">Water Management Dashboard</h1>
                <!-- Add New Record Button -->
                <a href="add.php" class="btn btn-primary mb-3">Add New Record</a>

                <!-- Records Table -->
                <div class="card">
                    <div class="card-header">
                        <h3>Records</h3>
                    </div>
                    <div class="card-body">
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
                                    echo "<tr><td colspan='6' class='text-center'>No records found. Add a new record to get started!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
