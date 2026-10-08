<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  
                </div>
                <h4></h4>
                <h6 class="font-weight-light"></h6>
                <form class="pt-3" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="adminname" name="adminname">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="submit" name="Signin" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" value="Sign IN">
                   
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        
                    </div>
                   
                  </div>
                  <div class="mb-2 d-grid gap-2">
                  
                     
                  </div>
                  <div class="text-center mt-4 font-weight-light"> 
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="../../assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>
</html>
<?php
session_start();
include("../../../../conn.php"); // Ensure this path is correct

if(isset($_POST['Signin'])){
  $adminname = mysqli_real_escape_string($conn, $_POST['adminname']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $query = "SELECT * FROM admin_login WHERE adminname='$adminname'";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result); // Fetch user data

    // If passwords are hashed in the database, use password_verify
    if (password_verify($password, $user['password'])) { 
      $_SESSION['adminname'] = $user['adminname']; 
      echo "<script>alert('Admin login successful!');</script>";
      echo "<script>window.location.href='../../index.php';</script>";
      exit();
    } 
    // If passwords are stored in plain text (not recommended)
    elseif ($password === $user['password']) { 
      $_SESSION['adminname'] = $user['adminname'];
      echo "<script>alert('Admin login successful!');</script>";
      echo "<script>window.location.href='../../index.php';</script>";
      exit();
    } 
    else {
      echo "<script>alert('Invalid Password');</script>";
    }
  } else {
    echo "<script>alert('Invalid Admin Name');</script>";
  }
}
?>

