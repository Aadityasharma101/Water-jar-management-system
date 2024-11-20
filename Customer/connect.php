$conn = new mysqli('localhost', 'root', '', 'water_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
