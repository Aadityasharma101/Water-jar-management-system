<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT * FROM water_jars";
$result = $conn->query($sql);
$water_jars = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jar_id = $_POST['jar_id'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT price FROM water_jars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jar_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jar = $result->fetch_assoc();

    $total_price = $jar['price'] * $quantity;

    $sql = "INSERT INTO orders (customer_id, jar_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $_SESSION['user_id'], $jar_id, $quantity, $total_price);

    if ($stmt->execute()) {
        $success = "Order placed successfully!";
    } else {
        $error = "Failed to place order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order - Water Jar Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Place Order</h1>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="" method="POST">
            <select name="jar_id" required>
                <?php foreach ($water_jars as $jar): ?>
                    <option value="<?php echo $jar['id']; ?>">
                        <?php echo $jar['name']; ?> (<?php echo $jar['capacity']; ?> L) - $<?php echo $jar['price']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="quantity" min="1" placeholder="Quantity" required>
            <button type="submit">Place Order</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>