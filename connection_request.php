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
$subject = "Connection Request";
$email_message = mysql_real_escape_string("<p>A mentee would like to make a connection with you! Please 'ACCEPT' or 'DECLINE'.<br><br><a href=menteeprofile.php?id=".$_SESSION['user_id']." target='_blank'>CLICK HERE</a> 
to view the mentee's profile.<p>
<form align='center' method='POST' action='connection_approval.php'>
<input name='connection_request' type='submit' value='ACCEPT'/>
<input name='connection_request' type='submit' value='DECLINE'/>
<input name='recepientID' type='text' value='".$_SESSION['user_id']."' hidden/>
</form>");

$sql = "INSERT INTO mentorwebdb.email (SenderID,SenderAccountType,RecipientID,RecipientAccountType,Subject,Body) VALUES
(".$_SESSION['user_id'].",".$_SESSION['user_account_login'].",".$recepientID.",".$recepientAccountType.",'".$subject."','".$email_message."')";
$result = mysql_query($sql,$con);

header('Location: profile.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>