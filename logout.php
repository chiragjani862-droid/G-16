<?php
session_start();
session_unset();
session_destroy();
header("Location: login-register-form/login.php"); // Redirect to login page
exit();
?>
