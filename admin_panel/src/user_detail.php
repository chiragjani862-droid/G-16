<?php
session_start();
include("../../conn.php"); // Include database connection file

// Check if admin is logged in
if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch user details from the database
$query = "SELECT * FROM registration";
$result = mysqli_query($conn, $query);

// Handle delete request securely
if (isset($_GET['delete'])) {
    $email = $_GET['delete'];

    // First, delete associated orders (if ON DELETE CASCADE doesn't work)
    $stmt1 = $conn->prepare("DELETE FROM orders WHERE user_email = ?");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $stmt1->close();

    // Then delete user
    $stmt2 = $conn->prepare("DELETE FROM registration WHERE email = ?");
    $stmt2->bind_param("s", $email);

    if ($stmt2->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='user_detail.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete user.');</script>";
    }

    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .table-container:hover {
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: white;
            font-weight: bold;
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        thead {
            background-color: #343a40;
            color: white;
        }
        .btn-danger {
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            transform: scale(1.1);
            background-color: #c82333;
        }
        tr:hover {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">User Details</h2>
        <div class="table-container">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td><?php echo htmlspecialchars($row['mobile_number']); ?></td>
                            <td>
                                <a href="user_detail.php?delete=<?php echo urlencode($row['email']); ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
