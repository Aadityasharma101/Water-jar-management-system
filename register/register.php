<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'] ?? '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? 'customer';

    // Debug: Print registration details
    error_log("Registering user - Username: $username, Email: $email, Phone: $phone, Role: $role");

    // First, check if username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose another.";
    } else {
        // Insert new user with phone number
        $sql = "INSERT INTO users (username, password, email, phone, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $email, $phone, $role);
        
        if ($stmt->execute()) {
            // Debug: Print success message
            error_log("User registered successfully - Username: $username, Role: $role");
            session_start();
            $_SESSION['user_name'] = $username;
            header("Location: ../login/otherlogin.php?message=Registration+successful.+Please+login.");
            exit();
        } else {
            $error = "Registration failed: " . $stmt->error;
            error_log("Registration failed - Error: " . $stmt->error);
        }
        $stmt->close();
    }
    $check->close();

    // Clear the user name from the session after displaying it
    unset($_SESSION['user_name']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Register</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="customer">Customer</option>
                                    <option value="delivery_boy">Delivery Boy</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            Already have an account? <a href="../login/otherlogin.php">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
