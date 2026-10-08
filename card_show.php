<?php
session_start(); // Start session at the top
include("conn.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    die("Error: User not logged in.");
}

$user_email = $_SESSION['email'];

// Fetch user details from registration table
$user_query = "SELECT address, mobile_number FROM registration WHERE email = ?";
$stmt_user = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt_user, "s", $user_email);
mysqli_stmt_execute($stmt_user);
$user_result = mysqli_stmt_get_result($stmt_user);
$user_data = mysqli_fetch_assoc($user_result);

$address = $user_data['address'] ?? '';
$mobile_number = $user_data['mobile_number'] ?? '';

// Update quantity when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'], $_POST['cart_id'], $_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['quantity'];
    $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "ii", $new_quantity, $cart_id);
    mysqli_stmt_execute($stmt);
}

// Fetch updated cart data
$select = "SELECT cart.id, cart.menu_name, cart.price, cart.quantity, cart.img, menu.menu 
           FROM cart 
           JOIN menu ON cart.menu_id = menu.id 
           WHERE cart.user_email = ?";
$stmt = mysqli_prepare($conn, $select);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$grand_total = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy_now'])) {
    $cart_query = "SELECT * FROM cart WHERE user_email = ?";
    $stmt = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($cart_result) == 0) {
        echo "<script>alert('Your cart is empty!'); window.location.href='sofas.php';</script>";
        exit();
    }

    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $total_price = $cart_row['price'] * $cart_row['quantity'];

        $insert_order = "INSERT INTO orders (user_email, menu_id, menu_name, price, quantity, total_price, img, address, mobile_number, order_status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt_order = mysqli_prepare($conn, $insert_order);
        mysqli_stmt_bind_param($stmt_order, "sisdissss", $user_email, $cart_row['menu_id'], $cart_row['menu_name'], 
                               $cart_row['price'], $cart_row['quantity'], $total_price, $cart_row['img'], $address, $mobile_number);
        mysqli_stmt_execute($stmt_order);
    }

    $clear_cart = "DELETE FROM cart WHERE user_email = ?";
    $stmt_clear = mysqli_prepare($conn, $clear_cart);
    mysqli_stmt_bind_param($stmt_clear, "s", $user_email);
    mysqli_stmt_execute($stmt_clear);

    echo "<script>alert('Order placed successfully! Cash on Delivery selected.'); window.location.href='orders.php';</script>";
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Furniture Cart">
    <meta name="keywords" content="Furniture, Cart, Ecommerce">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .table-container {
            margin: 50px auto;
            max-width: 1200px;
            width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Nunito Sans', sans-serif;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
            font-weight: 700;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s ease-in-out;
        }

        .img-thumbnail {
            height: 80px;
            width: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
        }

        .btn-remove, .btn-update {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
        }

        .btn-remove:hover {
            background-color: #c82333;
        }

        .btn-update {
            background-color: #28a745;
            color: white;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .grand-total {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .buy-now-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .buy-now-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            min-width: 200px;
        }

        .buy-now-form input[type="submit"] {
            background-color: #ff9800;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            transition: 0.3s ease-in-out;
            flex: 1;
            max-width: 150px;
        }

        .buy-now-form input[type="submit"]:hover {
            background-color: #e68900;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 10px;
            }

            .table th, .table td {
                padding: 10px;
            }

            .img-thumbnail {
                height: 60px;
                width: 60px;
            }

            .quantity-input {
                width: 50px;
            }

            .btn-remove, .btn-update {
                padding: 6px 10px;
                font-size: 14px;
            }

            .buy-now-form {
                flex-direction: column;
            }

            .buy-now-form input[type="text"] {
                width: 100%;
                min-width: unset;
            }

            .buy-now-form input[type="submit"] {
                width: 100%;
                max-width: unset;
            }
        }
    </style>

</head>

<body>
    <div class="table-container">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($result as $row) {
                $total_price = $row['price'] * $row['quantity'];
                $grand_total += $total_price;
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['menu']; ?></td>
                    <td><?php echo $row['menu_name']; ?></td>
                    <td>₹ <?php echo $row['price']; ?></td>
                    <td><img src="./admin_panel/images/<?php echo $row['img']; ?>" class="img-thumbnail" alt="image not found"></td>
                    <td>
                        <form method="POST" style="display: flex; align-items: center; gap: 5px;">
                            <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" class="quantity-input">
                            <button type="submit" name="update_quantity" class="btn-update">Update</button>
                        </form>
                    </td>
                    <td>₹ <?php echo $total_price; ?></td>
                    <td><a href="remove_card.php?id=<?php echo $row['id']; ?>" class="btn-remove">Remove</a></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="7" class="grand-total">Grand Total: ₹ <?php echo $grand_total; ?></td>
                <td></td>
            </tr>
        </table>

        <form method="POST" class="buy-now-form">
            <input type="submit" name="buy_now" value="Buy Now">
        </form>
    </div>
</body>

</html>
