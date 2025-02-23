<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'sample');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== session_id()) {
        die("CSRF token validation failed");
    }
    
    $id = $_POST['id'];
    $name = $_POST['customer_name'];
    $quantity = $_POST['water_quantity'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['delivery_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE water_records SET customer_name=?, water_quantity=?, phone=?, email=?, delivery_date=?, status=? WHERE id=?");
    $stmt->bind_param("sissssi", $name, $quantity, $phone, $email, $date, $status, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch existing record
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM water_records WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

// Debugging output
// var_dump($record); // This will show the contents of $record

// Add this check for status
$currentStatus = isset($record['status']) ? $record['status'] : 'Pending';

if (isset($record) && is_array($record)) {
    $customer_name = $record['customer_name'] ?? 'Default Name';
    $water_quantity = $record['water_quantity'] ?? 0; // Default to 0 if not set
    $phone = $record['phone'] ?? 'No phone provided';
    $email = $record['email'] ?? 'No email provided';
    $delivery_date = $record['delivery_date'] ?? 'No delivery date provided';
} else {
    echo "No record found or record is not an array.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Edit Customer Record</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(session_id()); ?>">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($record['id']); ?>">
                    
                    <div class="mb-3">
                        <label for="customerName" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customerName" name="customer_name" 
                               value="<?php echo htmlspecialchars($customer_name); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="waterQuantity" class="form-label">Water Quantity</label>
                        <input type="number" class="form-control" id="waterQuantity" name="water_quantity" 
                               value="<?php echo htmlspecialchars($water_quantity); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="deliveryDate" class="form-label">Delivery Date</label>
                        <input type="date" class="form-control" id="deliveryDate" name="delivery_date" 
                               value="<?php echo htmlspecialchars($delivery_date); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending" <?php echo ($currentStatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Delivered" <?php echo ($currentStatus == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Record</button>
                        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

