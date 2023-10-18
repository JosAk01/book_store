<?php
session_start();
if(!isset($_SESSION['admin_id']) &&!isset($_SESSION['admin_name'])){
	header("Location:admin_login.php?error=The page you visted requires login");
exit();

}