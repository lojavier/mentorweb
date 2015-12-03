<?php

require_once("config/mentorwebdb.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************
	if(($_POST['disconnectActive'] == 1) && ($_POST['disconnection'] == "YES")) {

$MentorID = $_POST['MentorID'];
$MenteeID = $_POST['MenteeID'];

$sql = "UPDATE mentorwebdb.connections SET ConnectionActive=0 WHERE MentorID=".$MentorID." AND MenteeID=".$MenteeID.";";
$result = mysql_query($sql,$con);

header('Location: profile.php');

	} else { header('Location: profile.php'); }
} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>