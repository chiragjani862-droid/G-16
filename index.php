<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location:login-register-form/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Furniture website</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <?php include 'header.php';?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
   <?php include 'hero_section.php'; ?>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
   <?php
    include 'banner.php' ;
     ?>
    <!-- Banner Section End -->

    
    <!-- Instagram Section Begin -->
   <?php include 'galllery.php';?>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
   <?php include 'latestblog.php';?>
    <!-- Latest Blog Section End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php';?>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <?php include 'search.php';?>
   
    <!-- Search End -->

    <!-- Js Plugins -->
    <?php include 'js_link.php';?>
</body>

</html>