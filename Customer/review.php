<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id']; // Assuming customer is logged in
        $review_text = $_POST['review'];
        $rating = $_POST['rating'];

        $stmt = $conn->prepare("INSERT INTO reviews (customer_id, review_text, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $customer_id, $review_text, $rating);

        if ($stmt->execute()) {
            $message = "Review submitted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
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
    <title>Submit Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            margin-bottom: 15px;
            color: green;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .form-group .stars {
            display: flex;
            gap: 5px;
            cursor: pointer;
        }
        .form-group .stars input {
            display: none;
        }
        .form-group .stars label {
            font-size: 2rem;
            color: #ccc;
            transition: color 0.3s ease;
        }
        .form-group .stars input:checked ~ label,
        .form-group .stars input:hover ~ label {
            color: gold;
        }
        .form-group .stars label:hover,
        .form-group .stars label:hover ~ label {
            color: gold;
        }
        button {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit Your Review</h2>
        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label>Rating:</label>
                <div class="stars">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1">★</label>
                </div>
            </div>
            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>
