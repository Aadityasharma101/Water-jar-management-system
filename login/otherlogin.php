<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    // print_r($_POST);die;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($username == "admin" && $password == "admin123" && $role == "admin") {
        header("Location: admin_dashboard.php"); 
        exit();
    } elseif ($username == "delivery" && $password == "delivery123" && $role == "delivery-boy") {
        header("Location: delivery_dashboard.php"); 
        exit();
    } elseif ($username == "customer" && $password == "123" && $role == "customer") {
        header("Location: ../Customer/dashboard.php");
        exit();
    } else {
        $error_message = "Invalid credentials or role. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .card {
            width: 420px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            font-size: 16px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #45a049;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }
        h3 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h3 class="text-center">Login</h3>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Select Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="delivery-boy">Delivery Boy</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom">Login</button>
            </form>
            <div class="register-link">
                <p>Don't have an account? <a href="../register/finalindex.html">Register here</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

