<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

     <!-- Header Section Begin -->
     <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="./index.php"><img src="img/logof.png" alt=""></a>
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                            <li><a href="./sofas.php">Menu</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="./contact.php">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img src="img/icon/search1.png" alt="image not found"  height="24"></a>
                       
                    
                        
                        
                        <a href="card_show.php"><img src="img/icon/card.png" alt="image not found" height="37"></a>
                        <a href="orders.php"><img src="img/icon/sorder.png" alt="image not found" height="37" title="orders show"></a>
                      
                        <?php if (!empty($_SESSION['username'])): ?>
                            <span>Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
                            <a href="logout.php"><img src="img/icon/logout.png" alt="Logout" height="30"></a>
                        <?php else: ?>
                            <a href="login-register-form/login.php"><img src="img/icon/user.png" alt="Login" height="25"></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

</body>
</html>
