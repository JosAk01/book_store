<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: user_login.php");
exit(); // Ensure that no further code is executed after the redirect
?>