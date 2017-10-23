<?php  

	session_start();
	unset($_SESSION['user_inf']);
	header('Location: /admin/login.php');
