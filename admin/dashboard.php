<?php
$conn = new mysqli('localhost', 'root', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM water_records");

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">

    <title>Water Management Dashboard</title>
</head>
<body>
    <div class="d-flex">
        <!-- SIDEBAR -->
        <nav class="bg-dark text-white p-3 vh-100 flex-column" style="width: 250px;">
            <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
                <i class='bx bxs-smile fs-3 me-2'></i> <span>CustomerHub</span>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="logout/dashboard/dashboard.php" class="nav-link text-white active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="logout/messeges/messege.php" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Messages
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="logout/settings/settings.php" class="nav-link text-white">
                        <i class='bx bxs-cog'></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout/logout.php" class="nav-link text-white">
                        <i class='bx bxs-log-out-circle'></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="w-100">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
                <a class="navbar-brand" href="#">CustomerHub</a>
                <div class="collapse navbar-collapse">
                    <form class="d-flex ms-auto">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>

            <!-- Dashboard Content -->
           




            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
