<?php

require_once("config/mentorwebdb.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************
	if($_POST['ratingActive'] == 1) {
if($_SESSION['user_account_login'] == 1) {
		$account_personal_info = "mentor_personal_info";
		$account_career_info = "mentor_career_info";
	} elseif($_SESSION['user_account_login'] == 2) {
		$account_personal_info = "mentee_personal_info";
		$account_career_info = "mentee_career_info";
	}
	
$endorserID = $_SESSION['user_id'];
$endorserAccountType = $_SESSION['user_account_login'];
$endorsedID = $_POST['EndorsedID'];
$endorsedAccountType = $_POST['EndorsedAccountType'];
$rating = $_POST['rating'];
$endorsementComments = $_POST['endorsement_comments'];

$sql = "INSERT INTO mentorwebdb.endorsements (EndorserID,EndorserAccountType,EndorsedID,EndorsedAccountType,Rating,EndorsementComment)
VALUES (".$endorserID.",".$endorserAccountType.",".$endorsedID.",".$endorsedAccountType.",".$rating.",'".$endorsementComments."')";
$result = mysql_query($sql,$con);

header('Location: profile.php');

	} else { header('Location: index.php'); }
} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>