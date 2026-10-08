<?php session_start();
if (!isset($_SESSION['adminname'])) {
    header("Location: ../src/pages/samples/login.php"); // Redirect to login page
    exit();
}
?>

<?php
include("../../conn.php"); // Ensure this file contains your database connection

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch user count
$query = "SELECT COUNT(*) as user_count FROM registration";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$user_count = $row['user_count'];

// Fetch total orders count
$order_query = "SELECT COUNT(*) as order_count FROM orders"; // Change 'cart' to 'orders' if applicable
$order_result = mysqli_query($conn, $order_query);

if (!$order_result) {
    die("Query failed: " . mysqli_error($conn));
}

$order_row = mysqli_fetch_assoc($order_result);
$order_count = $order_row['order_count'];

// Fetch total weekly sales (last 7 days)
$sales_query = "SELECT SUM(total_price) as weekly_sales FROM orders WHERE order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
$sales_result = mysqli_query($conn, $sales_query);

if (!$sales_result) {
    die("Query failed: " . mysqli_error($conn));
}

$sales_row = mysqli_fetch_assoc($sales_result);
$weekly_sales = $sales_row['weekly_sales'] ?? 0; // If no sales, default to 0
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>
<body>
    <div class="container-scroller">
        <?php include("partials/navbar.php"); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include("partials/sidebar.php"); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span> Dashboard
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- START: Statistics Cards -->
                    <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-warning card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Total Registered Users <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"><?php echo $user_count; ?></h2>
                                    <h6 class="card-text">Active Users</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"> <?php echo number_format($weekly_sales, 2); ?></h2>
                                    <h6 class="card-text">Total Sales (Last 7 Days)</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Total Orders <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"><?php echo $order_count; ?></h2>
                                    <h6 class="card-text">Orders Processed</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include("partials/footer.php"); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
