<?php
session_start();

// Unset session variables for admin_user and login_user

// unset($_SESSION['login_user']);
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: student_login.php");
exit();
?>