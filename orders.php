<?php
session_start();
include("conn.php");

if (!isset($_SESSION['email'])) {
    die("Error: User not logged in.");
}

$user_email = $_SESSION['email'];

// Fetch user's orders along with username from the registration table
$order_query = "SELECT o.*, r.username FROM orders o 
                    JOIN registration r ON o.user_email = r.email 
                    WHERE o.user_email = ?";

$stmt = mysqli_prepare($conn, $order_query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th:nth-child(4), 
        .table th:nth-child(6),
        .table td:nth-child(4),
        .table td:nth-child(6) {
            width: 120px; 
            text-align: right;
            white-space: nowrap;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }
        .status-completed {
            background-color: #28a745;
            color: white;
        }
        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }
        .img-thumbnail {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
        .grand-total {
            font-weight: bold;
            font-size: 1.2rem;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">My Orders</h2>

        <?php if (mysqli_num_rows($result) > 0) { 
            $grand_total = 0; // Initialize grand total
        ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Image</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { 
                    $total_price = $row['price'] * $row['quantity'];
                    $grand_total += $total_price;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['menu_name']); ?></td>
                    <td>₹ <?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo (int)$row['quantity']; ?></td>
                    <td>₹ <?php echo number_format($total_price, 2); ?></td>
                    <td><img src="./admin_panel/images/<?php echo htmlspecialchars($row['img']); ?>" class="img-thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['Address']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile_number']); ?></td>
                    <td>
                        <span class="status-badge 
                            <?php 
                                if ($row['order_status'] == 'Pending') echo 'status-pending'; 
                                elseif ($row['order_status'] == 'Completed') echo 'status-completed'; 
                                elseif ($row['order_status'] == 'Cancelled') echo 'status-cancelled'; 
                            ?>">
                            <?php echo htmlspecialchars($row['order_status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['order_status'] == 'Pending') { ?>
                            <form method="POST" action="cancel_order.php" style="display:inline-block;">
                                <input type="hidden" name="order_id" value="<?php echo (int)$row['id']; ?>">
                                <button type="submit" name="cancel_order" class="btn btn-cancel">Cancel</button>
                            </form>
                            <a href="update_order.php?order_id=<?php echo (int)$row['id']; ?>" class="btn btn-primary">Update</a>
                        <?php } else {
                            echo "Not Available";
                        } ?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="grand-total">
                    <td colspan="5" class="text-right">Grand Total:</td>
                    <td colspan="6" class="text-left">₹ <?php echo number_format($grand_total, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <?php } else { ?>
            <p class="text-center">No orders found.</p>
        <?php } ?>
    </div>
</body>
</html>
