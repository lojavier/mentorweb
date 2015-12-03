<?php

require_once("config/mentorwebdb.php");
require_once("classes/Login.php");
$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************

if($_SESSION['user_account_login'] == 2) {
		$account_personal_info1 = "mentor_personal_info";
		$account_career_info1 = "mentor_career_info";
		$account_personal_info2 = "mentee_personal_info";
		$account_career_info2 = "mentee_career_info";
	} elseif($_SESSION['user_account_login'] == 1) {
		$account_personal_info1 = "mentee_personal_info";
		$account_career_info1 = "mentee_career_info";
		$account_personal_info2 = "mentor_personal_info";
		$account_career_info2 = "mentor_career_info";
	}
$sql1 = "INSERT INTO mentorwebdb.".$account_personal_info1." 
       (ID,FirstName,LastName,ZipCode,Phone,Email,Birthday,ProfilePic)
	   SELECT ID,FirstName,LastName,ZipCode,Phone,Email,Birthday,ProfilePic FROM mentorwebdb.".$account_personal_info2." WHERE ID=".$_SESSION['user_id'].";";
$result = mysql_query($sql1,$con);
$sql2 = "INSERT INTO mentorwebdb.".$account_career_info1." 
       (ID,CareerStatement,MajorDegreeType1,MajorIndustry1,School1,MajorDegreeType2,MajorIndustry2,School2,
		MajorDegreeType3,MajorIndustry3,School3,MinorIndustry1,MinorIndustry2,CurrentCompany,CurrentPosition,
		CurrentStartDate,CurrentDescription,PreviousCompany1,PreviousPosition1,PreviousStartDate1,PreviousEndDate1,
		PreviousDescription1,PreviousCompany2,PreviousPosition2,PreviousStartDate2,PreviousEndDate2,PreviousDescription2)
	   SELECT ID,CareerStatement,MajorDegreeType1,MajorIndustry1,School1,MajorDegreeType2,MajorIndustry2,School2,
		MajorDegreeType3,MajorIndustry3,School3,MinorIndustry1,MinorIndustry2,CurrentCompany,CurrentPosition,
		CurrentStartDate,CurrentDescription,PreviousCompany1,PreviousPosition1,PreviousStartDate1,PreviousEndDate1,
		PreviousDescription1,PreviousCompany2,PreviousPosition2,PreviousStartDate2,PreviousEndDate2,PreviousDescription2
		FROM mentorwebdb.".$account_career_info2." WHERE ID=".$_SESSION['user_id'].";";
$result = mysql_query($sql2,$con);
$sql3 = "UPDATE mentorwebdb.login SET user_account_type=3 WHERE user_id=".$_SESSION['user_id'].";";
$result = mysql_query($sql3,$con);
$_SESSION['user_account_type'] = 3;

sleep(4);
if($_SESSION['user_account_login'] == 2) {
		header('Location: menteesearch.php');
	} elseif($_SESSION['user_account_login'] == 1) {
		header('Location: mentorsearch.php');
	}

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>