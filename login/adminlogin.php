<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Check user credentials from database
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password (assuming passwords are hashed)
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                    exit();
                } else {
                    $error_message = "Access denied. Admin privileges required.";
                }
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "User not found.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            color: #007bff;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.6rem 0;
            font-size: 1.1rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p class="text-muted">Enter your credentials to access the admin panel</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" 
                       class="form-control" 
                       id="username" 
                       name="username" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <div class="back-link">
            <a href="../index.php" class="text-decoration-none">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
