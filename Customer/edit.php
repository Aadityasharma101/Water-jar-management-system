<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample1'); // Ensure the database name is correct

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Prepare the SELECT statement
    $sql = "SELECT * FROM water_records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
    } else {
        echo "No record found with ID: " . $id;
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid ID provided.";
    exit;
}

// HTML form for editing the record
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
</head>
<body>
    <h1>Edit Record</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($record['id']); ?>">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($record['customer_name']); ?>" required>
        <br>
        <label for="water_quantity">Water Quantity:</label>
        <input type="number" name="water_quantity" value="<?php echo htmlspecialchars($record['water_quantity']); ?>" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($record['phone']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($record['email']); ?>" required>
        <br>
        <label for="delivery_date">Delivery Date:</label>
        <input type="date" name="delivery_date" value="<?php echo htmlspecialchars($record['delivery_date']); ?>" required>
        <br>
        <button type="submit">Update Record</button>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
