<!-- <?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'Aayush stha' && $password === 'aayush12345') {
      // header('Location: ./admin/dashboard.php');
      header('Location : ../admin/dashbord.php');
        exit(); 
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Arial', sans-serif;
      background: linear-gradient(to right, #007bff, #00c6ff);
      color: #fff;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      width: 100%;
      max-width: 400px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
      text-align: center;
    }
    .login-container h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }
    .login-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .login-container input {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
      transition: all 0.3s;
    }
    .login-container input:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .login-container button {
      padding: 10px;
      font-size: 16px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s;
    }
    .login-container button:hover {
      background: #0056b3;
    }
    .error {
      color: red;
      font-size: 0.9em;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Enter your username" required>
      <input type="password" name="password" placeholder="Enter your password" required>
      <button type="submit">Login</button>
    </form>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </div>
</body>
</html> -->
