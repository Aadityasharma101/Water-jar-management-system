<?php
session_start();
$conn = new mysqli('localhost', 'admin12', '', 'sample');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    
    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $uploadDir = '../uploads/profile_pictures/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $fileExtension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $fileName = $userId . '_' . time() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $fileName;
        
        // Check if file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                // Update profile picture in database
                $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $profilePicPath = 'uploads/profile_pictures/' . $fileName;
                $stmt->bind_param("si", $profilePicPath, $userId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    
    // Update user information
    $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $userId);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating profile: " . $conn->error;
    }
    
    $stmt->close();
    header("Location: profile.php");
    exit;
}

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

// Set default profile picture if none exists
if (empty($userData['profile_picture'])) {
    $userData['profile_picture'] = '../assets/default-avatar.jpg';
}
?>

<!-- Add this right after the navbar for displaying messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <?php 
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <?php 
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    
    <style>
        .modal-header .btn-link {
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin: -0.5rem 0 -0.5rem auto;
        }

        .profile-picture-container {
            position: relative;
            display: inline-block;
        }

        .profile-picture-container .camera-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #007bff;
            color: white;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .main-content {
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- SIDEBAR -->
        <nav class="sidebar bg-dark text-white p-3">
            <a href="#" class="text-decoration-none text-white mb-4 fs-4 d-flex align-items-center">
                <i class='bx bxs-smile fs-3 me-2'></i> <span>DeliveryHub</span>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="../dashboard/dashboard.php" class="nav-link text-white">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="../messages/message.php" class="nav-link text-white">
                        <i class='bx bxs-message-dots'></i> Messages
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="profile.php" class="nav-link text-white active">
                        <i class='bx bxs-user'></i> Profile
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="../settings/settings.php" class="nav-link text-white">
                        <i class='bx bxs-cog'></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../logout/logout.php" class="nav-link text-white">
                        <i class='bx bxs-log-out-circle'></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="main-content w-100">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
                <a class="navbar-brand" href="#">DeliveryHub</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto me-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile" class="rounded-circle" width="32" height="32">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">View Profile</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Profile Information</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">
                                    Edit Profile
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" class="rounded-circle" width="150" height="150">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <p><?php echo $userData['name']; ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p><?php echo $userData['email']; ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Phone Number</label>
                                        <p><?php echo $userData['phone']; ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Address</label>
                                        <p><?php echo $userData['address']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileForm" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" class="rounded-circle" width="150" height="150">
                                <label for="profilePicture" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="cursor: pointer;">
                                    <i class='bx bxs-camera'></i>
                                    <input type="file" id="profilePicture" name="profile_picture" class="d-none" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $userData['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $userData['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" value="<?php echo $userData['phone']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3" required><?php echo $userData['address']; ?></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle profile picture preview
        document.getElementById('profilePicture').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelectorAll('#profileForm img, .navbar-nav img').forEach(img => {
                        img.src = e.target.result;
                    });
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Handle form submission
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your AJAX form submission logic here
            // After successful submission:
            // 1. Update the profile information on the page
            // 2. Close the modal
            // 3. Show success message
            const modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
            modal.hide();
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>