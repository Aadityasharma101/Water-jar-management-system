<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('download.jpg') no-repeat center top;
      background-size: 1200px 800px; /* Fixed size for the image */
      background-color: #f0f0f0; /* Fallback color for areas not covered by the image */
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 300px;
      text-align: center;
    }
    .login-container h2 {
      margin-bottom: 20px;
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
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php
      $error = '';
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $username = $_POST['username'];
          $password = $_POST['password'];
          
          // Fixed username and password
          if ($username === 'Aayush stha' && $password === 'aayush123') {
              echo "<p>Login successful! Welcome, $username.</p>";
              exit;
          } else {
              $error = 'Invalid username or password.';
          }
      }
    ?>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
