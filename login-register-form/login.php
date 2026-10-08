<?php
session_start();
include("../conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="style.css" />
  <title>Login & Registration Form</title>

  <style>
    /* Admin Header */
    .admin-header{
        width:100%;
        display:flex;
        justify-content:flex-end;
        padding:15px 30px;
        position:absolute;
        top:0;
        right:0;
    }

    .admin-icon{
        width:45px;
        height:45px;
        border-radius:50%;
        cursor:pointer;
        transition:0.3s;
    }

    .admin-icon:hover{
        transform:scale(1.1);
    }
  </style>

</head>

<body>

  <!-- ✅ Admin Header -->
  <div class="admin-header">
    <a href="..\admin_panel\src\pages\samples\login.php">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
           alt="Admin" class="admin-icon">
    </a>
  </div>

  <div class="container">
    <div class="forms">

      <!-- Login Form -->
      <div class="form login">
        <span class="title">Login</span>
        <form action="#" method="post">
          <div class="input-field">
            <input type="text" placeholder="Enter your email" name="email" required />
            <i class="uil uil-envelope icon"></i>
          </div>

          <div class="input-field">
            <input type="password" class="password" placeholder="Enter your password" name="password" required />
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
          </div>

          <div class="checkbox-text">
            <div class="checkbox-content">
              <input type="checkbox" id="logCheck" />
              <label for="logCheck" class="text">Remember me</label>
            </div>
            <a href="forgotpassword.php" class="text">Forgot Password?</a>
          </div>

          <div class="input-field button">
            <input type="submit" value="Login" name="login" />
          </div>
        </form>

        <div class="login-signup">
          <span class="text">
            Not a member?
            <a href="#" class="text signup-link">Signup Now</a>
          </span>
        </div>
      </div>

      <!-- Registration Form -->
      <div class="form signup">
        <span class="title">Registration</span>
        <form action="#" method="POST">

          <div class="input-field">
            <input type="text" placeholder="Enter your username" name="username" required />
            <i class="uil uil-user"></i>
          </div>

          <div class="input-field">
            <input type="text" placeholder="Enter your email" name="email" required />
            <i class="uil uil-envelope icon"></i>
          </div>

          <div class="input-field">
            <input type="text" placeholder="Enter your address" name="Address" required />
            <i class="uil uil-map-marker"></i>
          </div>

          <div class="input-field">
            <input type="text" placeholder="Enter your mobile no" name="mobile_number" required />
            <i class="uil uil-phone"></i>
          </div>

          <div class="input-field">
            <input type="password" class="password" placeholder="Create a password" name="password" required />
            <i class="uil uil-lock icon"></i>
          </div>

          <div class="input-field">
            <input type="password" class="password" placeholder="Confirm password" name="cpassword" required />
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
          </div>

          <div class="input-field button">
            <input type="submit" value="Signup" name="signup" />
          </div>

        </form>

        <div class="login-signup">
          <span class="text">
            Already a member?
            <a href="#" class="text login-link">Login Now</a>
          </span>
        </div>
      </div>

    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>

<?php

// ✅ Signup Logic
if(isset($_POST['signup'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $Address = $_POST['Address'];
  $mobile_number = $_POST['mobile_number'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  if($password !== $cpassword) {
    echo "<script>alert('Passwords do not match');</script>";
  } else {
    $query = "INSERT INTO Registration(username, email, Address, mobile_number, password, cpassword) 
              VALUES ('$username', '$email', '$Address', '$mobile_number', '$password', '$cpassword')";
    $r = mysqli_query($conn, $query);

    if($r) {
      echo "<script>alert('Registration Successfully');</script>";
    } else {
      echo "<script>alert('ERROR: Registration Failed');</script>";
    }
  }
}

// ✅ Login Logic
if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM Registration WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);

    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];

    echo "<script>alert('User login successful!');</script>";
    echo "<script>window.location.href='../index.php';</script>";
  } else {
    echo "<script>alert('Invalid Email or Password');</script>";
  }
}
?>
