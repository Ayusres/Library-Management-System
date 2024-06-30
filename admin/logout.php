<?php
session_start();

// Unset session variables for admin_user and login_user
// unset($_SESSION['admin_user']);
session_unset();


// Destroy the session
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit();
?>