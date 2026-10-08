<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!-- Profile Section -->
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">
            <?php 
            if(isset($_SESSION['adminname'])){
                echo $_SESSION['adminname']; // Display admin name
            } else {
                echo "Guest";
            }
            ?>
          </span>
          <span class="text-secondary text-small">Project Manager</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="../src/index.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <!-- Hero Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#heroSection" aria-expanded="false" aria-controls="heroSection">
        <span class="menu-title">Hero Section</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
      <div class="collapse" id="heroSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/hero_section_add.php">Add</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/hero_section_show.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- Menu Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#menuSection" aria-expanded="false" aria-controls="menuSection">
        <span class="menu-title">Menu</span>
        <i class="mdi mdi-chart-bar menu-icon"></i>
      </a>
      <div class="collapse" id="menuSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/menu_add.php">Add</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/menu_show.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- Gallery Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#gallerySection" aria-expanded="false" aria-controls="gallerySection">
        <span class="menu-title">Gallery</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="gallerySection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/gallery_add.php">Add</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/gallery_show.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- Contact Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#contactSection" aria-expanded="false" aria-controls="contactSection">
        <span class="menu-title">Contact Us</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="contactSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/contactas_show.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- Order Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#orderSection" aria-expanded="false" aria-controls="orderSection">
        <span class="menu-title">Orders</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="orderSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/admin_orders.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- Admin Profile Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#adminProfileSection" aria-expanded="false" aria-controls="adminProfileSection">
        <span class="menu-title">Admin Profile</span>
        <i class="mdi mdi-account-circle menu-icon"></i>
      </a>
      <div class="collapse" id="adminProfileSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/admin_profile.php">Show</a></li>
        </ul>
      </div>
    </li>

    <!-- User Detail Section -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#userDetailSection" aria-expanded="false" aria-controls="userDetailSection">
        <span class="menu-title">User Details</span>
        <i class="mdi mdi-account-circle menu-icon"></i>
      </a>
      <div class="collapse" id="userDetailSection">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="../src/user_detail.php">Show</a></li>
        </ul>
      </div>
    </li>

  </ul>
</nav>
