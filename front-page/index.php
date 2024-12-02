<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Water-Jar Management System</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('login/download.jpg') no-repeat center center/cover;
    }
    header {
      background: rgba(0, 0, 255, 0.8);
      color: white;
      padding: 15px;
      text-align: center;
    }
    nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 10px;
      background: rgba(0, 0, 0, 0.7);
    }
    nav a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      background: rgba(0, 255, 255, 0.8);
      border-radius: 5px;
    }
    nav a:hover {
      background: rgba(0, 255, 255, 1);
    }
    section {
      padding: 20px;
      text-align: center;
    }
    footer {
      background: rgba(0, 0, 255, 0.8);
      color: white;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 10px;
      background: blue;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn:hover {
      background: darkblue;
    }
  </style>
</head>
<body>
  <header>
    <h1>Welcome to the Water-Jar Management System</h1>
    <p>Manage water jars efficiently for customers, delivery boys, and admin.</p>
  </header>
  <nav>
    <a href="login_admin.php">Admin Login</a>
    <a href="login_customer.php">Customer Login</a>
    <a href="login_delivery.php">Delivery Boy Login</a>
    <a href="contact.php">Contact Us</a>
  </nav>
  <section>
    <h2>Why Choose Our System?</h2>
    <p>Efficient water jar tracking, customer management, and delivery handling all in one place.</p>
    <a href="services.php" class="btn">Explore Services</a>
    <a href="about.php" class="btn">Learn More</a>
  </section>
  <footer>
    <p> Water-Jar Management System. All rights reserved.</p>
  </footer>
</body>
</html>
