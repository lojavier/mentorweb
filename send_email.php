<?php

require_once("config/mentorwebdb.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************

if($_SESSION['user_account_login'] == 1) {
		$account_personal_info = "mentor_personal_info";
		$account_career_info = "mentor_career_info";
	} elseif($_SESSION['user_account_login'] == 2) {
		$account_personal_info = "mentee_personal_info";
		$account_career_info = "mentee_career_info";
	}

$recepientName = $_POST['recepientName'];
$recepientID = $_POST['recepientID'];
$recepientAccountType = $_POST['recepientAccountType'];
$subject = $_POST['subject'];
$email_message = $_POST['email_message'];

$sql = "INSERT INTO mentorwebdb.email (SenderID,SenderAccountType,RecipientID,RecipientAccountType,Subject,Body) VALUES
(".$_SESSION['user_id'].",".$_SESSION['user_account_login'].",".$recepientID.",".$recepientAccountType.",'".$subject."','".$email_message."')";

$result = mysql_query($sql,$con);

//sleep(4);
header('Location: profile.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>