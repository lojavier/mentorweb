<?php

require_once("config/mentorwebdb.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************

if($_SESSION['user_account_type'] == 3) {
	if($_SESSION['user_account_login'] == 1) {
		$_SESSION['user_account_login'] = 2;
	} elseif($_SESSION['user_account_login'] == 2) {
		$_SESSION['user_account_login'] = 1;
	}
}

header('Location: home.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>