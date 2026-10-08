<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location:login-register-form/login.php');
    exit();
}

include("conn.php");

// Fetch menu items
$select = "SELECT * FROM menu WHERE menu = 'Wardrobes'";
$query = mysqli_query($conn, $select);
$count = mysqli_num_rows($query);

$found_sofas = ($count > 0);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'] ?? null;
    $menu_name = $_POST['menu_name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $img = $_POST['img'] ?? '';
    $quantity = 1;
    $user_email = $_SESSION['email'];

    if ($menu_id !== null) {
        // Check if the item is already in the cart
        $check_query = "SELECT * FROM cart WHERE menu_id = '$menu_id' AND user_email = '$user_email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Item is already in the cart!');</script>";
        } else {
            // Insert the new item
            $insert_query = "INSERT INTO cart (menu_id, menu_name, price, img, quantity, user_email) 
                             VALUES ('$menu_id', '$menu_name', '$price', '$img', '$quantity', '$user_email')";
            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Item added to cart successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Error: menu_id is not set.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Furniture Website">
    <meta name="keywords" content="Furniture, Sofas, Home Decor">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Furniture Website - Sofas</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/elegant-icons.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/slicknav.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header -->
    <?php include 'header.php'; ?>

    <section class="product spad mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active"><a href="sofas.php">Sofas</a></li>
                        <li><a href="dining_tables.php">Dining Tables</a></li>
                        <li><a href="wardrobes.php">Wardrobes</a></li>
                        <li><a href="tv_unit.php">TV Unit</a></li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                <?php
                if (!$found_sofas) {
                    echo "<h2 class='text-center' style='margin: 50px auto;'>No Sofas Available</h2>";
                } else {
                    while ($value = mysqli_fetch_assoc($query)) {
                        echo '
                            <div class="col-lg-3 col-md-6 col-sm-6 mix new-arrivals">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg">
                                        <img src="./admin_panel/images/' . htmlspecialchars($value['img']) . '" alt="Image not found" height="200" width="200">
                                    </div>
                                    <div style="margin-top: -30px;">
                                        <h6>' . htmlspecialchars($value['menu_name']) . '</h6>
                                        <h5 class="mt-3">₹ ' . htmlspecialchars($value['price']) . '</h5>
                                        <div class="mt-2">
                                            <form method="post" action="">
                                                <input type="hidden" name="menu_id" value="' . htmlspecialchars($value['id']) . '">
                                                <input type="hidden" name="menu_name" value="' . htmlspecialchars($value['menu_name']) . '">
                                                <input type="hidden" name="price" value="' . htmlspecialchars($value['price']) . '">
                                                <input type="hidden" name="img" value="' . htmlspecialchars($value['img']) . '">
                                                <button type="submit" class="btn btn-dark">Add to Cart</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Search -->
    <?php include 'search.php'; ?>

    <!-- JS Plugins -->
    <?php include 'js_link.php'; ?>
</body>

</html>
