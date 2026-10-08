<?php
session_start();
include("../../conn.php");

// Search Query
$search = "";
$where = "";

if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE registration.username LIKE '%$search%' 
              OR orders.user_email LIKE '%$search%' 
              OR orders.menu_name LIKE '%$search%' 
              OR orders.order_status LIKE '%$search%'";
}

// Fetch Orders
$select_orders = "SELECT orders.id, registration.username, orders.menu_name, orders.user_email, 
                    orders.price, orders.quantity, orders.address, orders.mobile_number, orders.order_status 
                    FROM orders 
                    JOIN registration ON orders.user_email = registration.email
                    $where
                    ORDER BY registration.username ASC";

$result = mysqli_query($conn, $select_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .table-container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-box input {
            width: 300px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .search-box button {
            padding: 8px 15px;
            border: none;
            background: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-box button:hover {
            background: #0056b3;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-update {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-update:hover {
            background-color: #218838;
        }
        select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .no-data {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2 style="text-align: center;">Manage Orders (Username A to Z)</h2>

        <!-- Search Bar -->
        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by Username, Email, Product, Status" value="<?php echo $search; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Product Name</th>
                    <th>Email</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Total Price (₹)</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0){
                    while ($order = mysqli_fetch_assoc($result)) { 
                ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['username']; ?></td>
                        <td><?php echo $order['menu_name']; ?></td>
                        <td><?php echo $order['user_email']; ?></td>
                        <td><?php echo number_format($order['price'], 2); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo number_format($order['price'] * $order['quantity'], 2); ?></td>
                        <td><?php echo $order['address']; ?></td>
                        <td><?php echo $order['mobile_number']; ?></td>
                        <td><?php echo $order['order_status']; ?></td>
                        <td>
                            <form method="POST" action="update_order_status.php">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="order_status">
                                    <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Shipped" <?php if ($order['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Delivered" <?php if ($order['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                    <option value="Complete" <?php if ($order['order_status'] == 'Complete') echo 'selected'; ?>>Complete</option>
                                </select>
                                <button type="submit" class="btn-update">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='11' class='no-data'>No Orders Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>