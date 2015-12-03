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

$senderName = $_POST['senderName'];
$senderID = $_POST['senderID'];
$senderAccountType = $_POST['senderAccountType'];
$original_message = $_POST['original_message'];
$reply_message = $_POST['reply_message'];

if(substr($_POST['subject'],0,3) == 'Re: ')
 {
  $subject = $_POST['subject'];
 } else {
 $subject = "Re: " . $_POST['subject'];
 }

$body = $reply_message."<br><br>-----------------------------------------------------------------------------------------------------------------------------------------------------------------<br><br>".$original_message;
echo $senderName . " <br>" . $original_message. "<br>------------------------------------------------------------<br>" .$reply_message . "<br> ";

$sql = "INSERT INTO mentorwebdb.email (SenderID,SenderAccountType,RecipientID,RecipientAccountType,Subject,Body) VALUES
(".$_SESSION['user_id'].",".$_SESSION['user_account_login'].",".$senderID.",".$senderAccountType.",'".$subject."','".$body."')";

echo $sql . "<br>";
$result = mysql_query($sql,$con);

header('Location: profile.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>