<?php
session_start();
session_unset();
session_destroy();
header("Location: ../src/pages/samples/login.php"); // Redirect to login page
exit();
?>
