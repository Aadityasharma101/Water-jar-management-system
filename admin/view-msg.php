<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample'); // Ensure the database name is correct

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select feedback messages
$sql = "SELECT customer_name, email, feedback, created_at FROM feedback"; // Adjust the fields as necessary
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .feedback-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .feedback-card h5 {
            color: #007bff;
        }
        .feedback-card p {
            margin: 0;
            color: #495057;
        }
        .submitted-on {
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Feedback Messages</h1>

        <?php
        // Fetch and display results
        while ($row = $result->fetch_assoc()) {
            echo '<div class="feedback-card">';
            echo '<h5>Customer Name: ' . htmlspecialchars($row['customer_name']) . '</h5>';
            echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p>Feedback: ' . nl2br(htmlspecialchars($row['feedback'])) . '</p>';
            echo '<p class="submitted-on">Submitted On: ' . htmlspecialchars($row['created_at']) . '</p>';
            echo '</div>';
        }
        ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
