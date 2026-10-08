<?php
session_start();
include("../conn.php");

if(isset($_POST['reset_password'])){
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password !== $confirm_password){
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $query = "SELECT * FROM Registration WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            // Store the password in plain text (not recommended for security reasons)
            $update_query = "UPDATE Registration SET password='$new_password', cpassword='$new_password' WHERE email='$email'";
            $update_result = mysqli_query($conn, $update_query);

            if($update_result){
                echo "<script>alert('Password reset successful! Please login.');</script>";
                echo "<script>window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error updating password!');</script>";
            }
        } else {
            echo "<script>alert('Email not found!');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 40px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            width: 400px;
            text-align: center;
        }
        .title {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .input-field {
            margin-bottom: 20px;
            position: relative;
        }
        .input-field input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }
        .input-field input:focus {
            border-color: #007BFF;
            box-shadow: 0px 0px 6px rgba(0, 123, 255, 0.5);
        }
        .button input {
            width: 100%;
            background: #007BFF;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        .button input:hover {
            background: #0056b3;
        }
        .login-signup {
            margin-top: 15px;
            font-size: 14px;
        }
        .login-signup a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .login-signup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form forgot-password">
            <span class="title">Forgot Password</span>
            <form action="" method="POST">
                <div class="input-field">
                    <input type="email" name="email" placeholder="Enter your registered email" required>
                </div>
                <div class="input-field">
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="input-field">
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                <div class="input-field button">
                    <input type="submit" value="Reset Password" name="reset_password">
                </div>
            </form>
            <div class="login-signup">
                <span class="text">Back to <a href="login.php" class="text login-link">Login</a></span>
            </div>
        </div>
    </div>
</body>
</html>