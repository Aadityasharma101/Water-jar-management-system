<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Visitor counter logic
if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    $conn->query("UPDATE visitors SET count = count + 1 WHERE id = 1");
}

// Fetch total visitors
$visitorResult = $conn->query("SELECT count FROM visitors WHERE id = 1");
$visitorCount = ($visitorResult && $visitorResult->num_rows > 0) 
    ? $visitorResult->fetch_assoc()['count'] 
    : 0;

// Fetch water records
$waterRecords = $conn->query("SELECT * FROM water_records");

// Handle feedback form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedback = $conn->real_escape_string($_POST['feedback']);

    if ($conn->query("INSERT INTO feedback (customer_name, email, feedback) VALUES ('$customer_name', '$email', '$feedback')")) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch feedback records
$feedbackRecords = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Water Management Dashboard</title>
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
        }
        .sidebar {
            background-color: #343a40;
            min-width: 250px;
        }
        .card {
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .badge-info {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar text-white p-3 vh-100">
        <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
            <i class='bx bxs-smile fs-3 me-2'></i> <span>CustomerHub</span>
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

    <!-- Main Content -->
    <div class="w-100">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
            <a class="navbar-brand" href="#">CustomerHub</a>
        </nav>

        <!-- Content -->
        <div class="container mt-4">
            <h1 class="mb-4">Water Management Dashboard</h1>

            <!-- Add New Record Button -->
            <a href="add.php" class="btn btn-primary mb-3">Add New Orders</a>

            <!-- Records Table -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Water Records</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Water Quantity</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($waterRecords->num_rows > 0): ?>
                                <?php while ($row = $waterRecords->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['customer_name'] ?></td>
                                        <td><?= $row['water_quantity'] ?></td>
                                        <td><?= $row['phone'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['delivery_date'] ?></td>
                                        <td><?= $row['status'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Submit Feedback</div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info"><?= $message ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>

            <!-- Feedback Records -->
            <div class="card">
                <div class="card-header bg-dark text-white">Customer Feedback</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Feedback</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($feedbackRecords->num_rows > 0): ?>
                                <?php while ($row = $feedbackRecords->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['customer_name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['feedback'] ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No feedback submitted.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
