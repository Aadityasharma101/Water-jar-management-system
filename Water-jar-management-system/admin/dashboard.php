<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total customers (unique)
$customerQuery = "SELECT COUNT(DISTINCT customer_name) as total_customers FROM water_records";
$customerResult = $conn->query($customerQuery);
$totalCustomers = $customerResult->fetch_assoc()['total_customers'];

// Get total water quantity
$quantityQuery = "SELECT SUM(water_quantity) as total_quantity FROM water_records";
$quantityResult = $conn->query($quantityQuery);
$totalQuantity = $quantityResult->fetch_assoc()['total_quantity'];

// Original query for records
$stmt = $conn->prepare("SELECT * FROM water_records");
// ... rest of the database code ...
?>

<div class="container mt-4">
    <h1 class="mb-4">Water Management Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <p class="card-text h2"><?php echo $totalCustomers; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Water Jars</h5>
                    <p class="card-text h2"><?php echo $totalQuantity; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Record Button -->
    // ... rest of the code ...
</div>