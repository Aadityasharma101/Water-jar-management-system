<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Customer Messages</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #444;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #555;
        }

        /* Message if no data */
        .no-data {
            text-align: center;
            color: #555;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sample";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch messages from the database
    $sql = "SELECT id, name, email, message, created_at FROM messages";
    $result = $conn->query($sql);

    if (!$result) {
        die("<p style='color: red;'>Error executing query: " . $conn->error . "</p>");
    }

    // Display messages if the query is successful
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th> Customer Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['message']) . "</td>
                    <td>" . $row['created_at'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-data'>No messages found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
