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
    $sql = "SELECT id, customer_name, email, feedback, created_at FROM feedback";
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
                    <td>" . htmlspecialchars($row['customer_name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['feedback']) . "</td>
                    <td>" . $row['created_at'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-data'>No messages found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
