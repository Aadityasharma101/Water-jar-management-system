<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete review if requested
if (isset($_GET['delete'])) {
    $review_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    if ($stmt->execute()) {
        $message = "Review deleted successfully!";
    } else {
        $message = "Error deleting review: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch reviews with customer information
$query = "SELECT r.*, u.username as name 
          FROM reviews r 
          JOIN users u ON r.customer_id = u.id 
          ORDER BY r.created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching reviews: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
        $review_text = trim($_POST['review']);
        $rating = intval($_POST['rating']);
        
        // Validate rating
        if ($rating < 1 || $rating > 5) {
            $message = "Invalid rating value";
        } else {
            $stmt = $conn->prepare("INSERT INTO reviews (customer_id, review_text, rating) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $customer_id, $review_text, $rating);

            if ($stmt->execute()) {
                $message = "Review submitted successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $message = "Please log in to submit a review.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Review Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .message {
            color: green;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: #fff;
        }
        .delete-btn {
            background: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background: darkred;
        }
        .rating {
            color: gold;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Customer Reviews</h2>
    
    <?php if (isset($message)) : ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['review_text']); ?></td>
                <td class="rating">
                    <?php 
                        $rating = intval($row['rating']);
                        echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
                    ?>
                </td>
                <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                <td>
                    <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
