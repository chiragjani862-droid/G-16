<?php
session_start();
include("../../conn.php"); // Include your database connection

if (!isset($_SESSION['adminname'])) {
    header("Location: ../src/pages/samples/login.php"); // Redirect if not logged in
    exit();
}

$adminname = $_SESSION['adminname'];

// Fetch admin details
$query = $conn->prepare("SELECT * FROM admin_login WHERE adminname = ?");
$query->bind_param("s", $adminname);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

// Handle password update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            $update_query = $conn->prepare("UPDATE admin_login SET password = ? WHERE adminname = ?");
            $update_query->bind_param("ss", $new_password, $adminname);
            if ($update_query->execute()) {
                echo "<script>alert('Password updated successfully!');</script>";
            } else {
                echo "<script>alert('Failed to update password!');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Please fill in both fields!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(to right, #8360c3, #2ebf91); 
            color: white; 
            font-family: 'Poppins', sans-serif; 
        }
        .container { 
            max-width: 500px; 
            margin-top: 100px; 
        }
        .card { 
            background: #fff; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            padding: 30px; 
        }
        .btn-custom { 
            background: #2ebf91; 
            color: white; 
        }
        .btn-custom:hover { 
            background: #27a380; 
        }
        .profile-img {
            width: 100px; 
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto; /* Center the image */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card text-center">
        <h2 class="mb-3 text-dark">Admin Profile</h2>
        <div class="text-center">
            <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Admin" class="profile-img">
        </div>
        <h4 class="mt-3 text-dark"><?php echo htmlspecialchars($admin['adminname']); ?></h4>

        <hr>

        <h5 class="text-dark">Change Password</h5>
        <form method="POST">
            <input type="password" name="new_password" class="form-control mt-2" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="form-control mt-2" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-custom mt-3">Update Password</button>
        </form>

        <hr>

        <a href="logout.php" class="btn btn-danger mt-2">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
