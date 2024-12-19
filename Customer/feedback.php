<?php
// All-in-one PHP code for feedback form and database insertion

// Database connection details
$servername = "localhost";  // Change this if necessary
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "sample"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize a message variable
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data and sanitize
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // SQL query to insert data into feedback table
    $query = "INSERT INTO feedback (customer_name, email, feedback, created_at) 
              VALUES ('$customer_name', '$email', '$feedback', '$created_at')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        $message = "Feedback sent successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }

        /* Popup Message Styles */
        .popup-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            font-size: 16px;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customer Feedback</h2>

        <!-- Feedback Form -->
        <form action="feedback.php" method="POST">
            <label for="customer_name">Your Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="feedback">Your Feedback:</label>
            <textarea id="feedback" name="feedback" rows="5" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>

    <!-- Popup Message (Initial state is hidden) -->
    <div id="popup-message" class="popup-message">
        <?php if ($message != "") { echo $message; } ?>
    </div>

    <!-- JavaScript to Show the Popup -->
    <script>
        <?php if ($message != "") { ?>
            // Show the popup message after the form is submitted successfully
            window.onload = function() {
                var popup = document.getElementById("popup-message");
                popup.style.display = "block";

                // Hide the popup after 3 seconds
                setTimeout(function() {
                    popup.style.display = "none";
                }, 3000); // 3000ms = 3 seconds
            }
        <?php } ?>
    </script>
</body>
</html>
