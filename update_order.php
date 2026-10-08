<?php
session_start();
include("conn.php");

if (!isset($_SESSION['email'])) {
    die("Error: User not logged in.");
}

if (!isset($_GET['order_id'])) {
    die("Error: Order ID not provided.");
}

$order_id = $_GET['order_id'];
$user_email = $_SESSION['email'];

// Fetch order details
$order_query = "SELECT * FROM orders WHERE id = ? AND user_email = ?";
$stmt = mysqli_prepare($conn, $order_query);
mysqli_stmt_bind_param($stmt, "is", $order_id, $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Error: Order not found.");
}

$order = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_quantity = intval($_POST['quantity']);
    $new_address = trim($_POST['address']);
    $new_mobile_number = trim($_POST['mobile_number']);

    if ($new_quantity <= 0) {
        echo "<script>alert('Quantity must be at least 1');</script>";
    } elseif (empty($new_address)) {
        echo "<script>alert('Address cannot be empty');</script>";
    } elseif (!preg_match('/^[0-9]{10}$/', $new_mobile_number)) {
        echo "<script>alert('Invalid mobile number. It should be 10 digits.');</script>";
    } else {
        $new_total_price = $order['price'] * $new_quantity;

        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Update the specific order
            $update_order_query = "UPDATE orders SET quantity = ?, total_price = ?, address = ?, mobile_number = ? WHERE id = ? AND user_email = ?";
            $stmt = mysqli_prepare($conn, $update_order_query);
            mysqli_stmt_bind_param($stmt, "idssis", $new_quantity, $new_total_price, $new_address, $new_mobile_number, $order_id, $user_email);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update order.");
            }

            // Update all orders for this user
            $update_all_orders_query = "UPDATE orders SET address = ?, mobile_number = ? WHERE user_email = ?";
            $stmt = mysqli_prepare($conn, $update_all_orders_query);
            mysqli_stmt_bind_param($stmt, "sss", $new_address, $new_mobile_number, $user_email);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update all orders.");
            }

            // Update registration details
            $update_registration_query = "UPDATE registration SET address = ?, mobile_number = ? WHERE email = ?";
            $stmt = mysqli_prepare($conn, $update_registration_query);
            mysqli_stmt_bind_param($stmt, "sss", $new_address, $new_mobile_number, $user_email);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update user details.");
            }

            // Commit transaction
            mysqli_commit($conn);
            echo "<script>alert('Order updated successfully!'); window.location.href='orders.php';</script>";
        } catch (Exception $e) {
            // Rollback transaction on failure
            mysqli_rollback($conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Update Order</h2>
        <form method="POST">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($order['menu_name']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="text" class="form-control" value="₹ <?php echo htmlspecialchars($order['price']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Quantity:</label>
                <input type="number" name="quantity" class="form-control" value="<?php echo htmlspecialchars($order['quantity']); ?>" required>
            </div>
            <div class="form-group">
                <label>Total Price:</label>
                <input type="text" class="form-control" value="₹ <?php echo htmlspecialchars($order['total_price']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" class="form-control" required><?php echo htmlspecialchars($order['Address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Mobile Number:</label>
                <input type="text" name="mobile_number" class="form-control" value="<?php echo htmlspecialchars($order['mobile_number']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="orders.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>