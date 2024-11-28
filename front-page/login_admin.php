<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example credentials (replace with database validation)
    if ($username == 'admin' && $password == 'admin123') {
        echo "<p>Login successful! Welcome, Admin.</p>";
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
  <title>Admin Login</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: url('background.jpg') no-repeat center center/cover;
      margin: 0;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 300px;
    }
    .login-container h2 {
      margin-bottom: 20px;
      text-align: center;
    }
    .login-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .login-container button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .login-container button:hover {
      background-color: #0056b3;
    }
    .error {
      color: red;
      font-size: 0.9em;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <?php if (isset($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
