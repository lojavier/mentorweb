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

$acceptedMessage = "Yay! You have made a connection! You can now video chat and instant message your mentor!";
$declinedMesssage = "Sorry, but at this time, the mentor is not accepting any connections. Please try messaging the mentor directly or trying again later.";	
$subject = "Re: Connection Request";
$menteeID = $_POST['recepientID'];
$sql = "SELECT * FROM mentorwebdb.email WHERE SenderID=".$menteeID." AND SenderAccountType=2 AND RecipientID=".$_SESSION['user_id']." AND RecipientAccountType=1 AND Subject='Connection Request' ;";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$emailID = $row['EmailID'];
}

if($_POST['connection_request'] == 'ACCEPT') {
	$activate_connection = 1;
	$ConnectionName = "mentorweb_".substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" , mt_rand( 0 ,50 ) ,1 ).substr( md5( time() ), 1);
	$sql = "INSERT INTO mentorwebdb.connections (MentorID,MenteeID,ConnectionActive,ConnectionName) VALUES (".$_SESSION['user_id'].",".$menteeID.",".$activate_connection.",'".$ConnectionName."')";
	$result = mysql_query($sql,$con);
	$sql = "DELETE FROM mentorwebdb.email WHERE EmailID=".$emailID.";";
	$result = mysql_query($sql,$con);
	$sql = "INSERT INTO mentorwebdb.email (SenderID,SenderAccountType,RecipientID,RecipientAccountType,Subject,Body) VALUES
	(".$_SESSION['user_id'].",".$_SESSION['user_account_login'].",".$menteeID.",2,'".$subject."','".$acceptedMessage."')";
	$result = mysql_query($sql,$con);
} elseif ($_POST['connection_request'] == 'DECLINE') {
	$activate_connection = 0;
	$sql = "DELETE FROM mentorwebdb.email WHERE EmailID=".$emailID.";";
	$result = mysql_query($sql,$con);
	$sql = "INSERT INTO mentorwebdb.email (SenderID,SenderAccountType,RecipientID,RecipientAccountType,Subject,Body) VALUES
	(".$_SESSION['user_id'].",".$_SESSION['user_account_login'].",".$menteeID.",2,'".$subject."','".$declinedMesssage."')";
	$result = mysql_query($sql,$con);
}

header('Location: profile.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>