<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plans</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            margin: 0;
            padding: 0;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 36px;
            color: #007bff;
        }
        nav {
            background: #007bff;
            padding: 15px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #d1ecf1;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 0 15px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 320px;
            text-align: center;
            padding: 30px 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }
        .card h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
        }
        .card .price {
            font-size: 40px;
            color: #007bff;
            margin: 10px 0 20px;
            font-weight: bold;
        }
        .card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .card ul li {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }
        .card button {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
        }
        .card button:hover {
            background: linear-gradient(to right, #0056b3, #003d80);
        }
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px 0;
            background: #f1f1f1;
            color: #777;
            font-size: 14px;
        }
        .description {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            line-height: 1.8;
            color: #555;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <nav>
        
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="#monthly">Monthly</a>
            <a href="#yearly">Yearly</a>
            <a href="#contact">Contact Us</a>
        </div>
    </nav>

    <h1>Choose Your Membership Plan</h1>

    <div class="description">
        <p>Welcome to our membership plans! We understand the importance of flexibility and value, which is why we have tailored our membership options to suit your needs. Whether you're looking for a short-term solution or a long-term commitment, we have the perfect plan for you. Enjoy full access to all our features, priority services, and 24/7 support with any of our plans. Take advantage of exclusive perks and let us help you make your experience exceptional. Choose the plan that works best for you and join our community today!</p>
    </div>

    <div class="container">
        <!-- Weekly Plan -->
        <div class="card" id="weekly">
            <h2>Weekly</h2>
            <p class="price">Rs.1000/week <br>
            4L/Per Day
        </p>
            <ul>
                <li>Full access to orders</li>
                <li>Priority delivery</li>
                <li>Support 24/7</li>
            </ul>
            <form method="POST" action="process_payment.php">
                <input type="hidden" name="plan" value="weekly">
                <button type="submit">Choose Weekly Plan</button>
            </form>
        </div>
        
        <!-- Monthly Plan -->
        <div class="card" id="monthly">
            <h2>Monthly</h2>
            <p class="price">Rs.3000/month<br>
                4L/per Day
            </p>
            <ul>
                <li>Full access to orders</li>
                <li>Priority delivery</li>
                <li>Support 24/7</li>
            </ul>
            <form method="POST" action="process_payment.php">
                <input type="hidden" name="plan" value="monthly">
              <a href="payment.php">"  <button type="submit">Choose Monthly Plan</button></a>
            </form>
        </div>
        
        <!-- Yearly Plan -->
        <div class="card" id="yearly">
            <h2>Yearly</h2>
            <p class="price">RS.30000/year<br>
            4L/per
        </p>
            <ul>
                <li>Full access to orders</li>
                <li>Priority delivery</li>
                <li>Support 24/7</li>
            </ul>
            <form method="POST" action="process_payment.php">
                <input type="hidden" name="plan" value="yearly">
                <button type="submit">Choose Yearly Plan</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2025 Your Company Name. All rights reserved.
    </footer>
</body>
</html>
