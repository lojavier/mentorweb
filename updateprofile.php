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

/********** Upload profile pic ***********/
$tempID = sprintf("%06s", $_SESSION['user_id']);
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["profile_pic_upload"]["name"]);
$extension = end($temp);
$profilepicdirectory = "images/profile_pic/user_ID_" . $tempID;
$profilepicURL = $profilepicdirectory . "/" . $tempID . "_profile_pic." . $extension;
//echo $tempID . "<br>" . $_FILES["profile_pic_upload"]["type"] . "<br>" . $profilepicURL . "<br>";
if ((($_FILES["profile_pic_upload"]["type"] == "image/gif")
|| ($_FILES["profile_pic_upload"]["type"] == "image/jpeg")
|| ($_FILES["profile_pic_upload"]["type"] == "image/jpg")
|| ($_FILES["profile_pic_upload"]["type"] == "image/pjpeg")
|| ($_FILES["profile_pic_upload"]["type"] == "image/x-png")
|| ($_FILES["profile_pic_upload"]["type"] == "image/png"))
&& ($_FILES["profile_pic_upload"]["size"] <= 4000000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["profile_pic_upload"]["error"] > 0) {
    //echo "Return Code: " . $_FILES["profile_pic_upload"]["error"] . "<br>";
  } else {
    //echo "Upload: " . $_FILES["profile_pic_upload"]["name"] . "<br>";
    //echo "Type: " . $_FILES["profile_pic_upload"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["profile_pic_upload"]["size"] / 1024) . " kB<br>";
    //echo "Temp file: " . $_FILES["profile_pic_upload"]["tmp_name"] . "<br>";

	mkdir($profilepicdirectory, 0777);
    move_uploaded_file($_FILES["profile_pic_upload"]["tmp_name"],$profilepicURL);
    //echo "Stored in: " . $profilepicURL;
  }
} else {
  //echo "Invalid file";
  $profilepicURL = NULL;
}
/*****************************************/

$profilepicURL = mysql_real_escape_string($profilepicURL);
$user_first_name = mysql_real_escape_string($_POST['user_first_name']);
$user_last_name = mysql_real_escape_string($_POST['user_last_name']);
$career_statement = mysql_real_escape_string($_POST['career_statement']);
$current_company = mysql_real_escape_string($_POST['current_company']);
$current_position = mysql_real_escape_string($_POST['current_position']);
$current_start_date = mysql_real_escape_string($_POST['current_start_date']);
$current_company_description = mysql_real_escape_string($_POST['current_company_description']);
$previous_company1 = mysql_real_escape_string($_POST['previous_company1']);
$previous_position1 = mysql_real_escape_string($_POST['previous_position1']);
$previous_start_date1 = mysql_real_escape_string($_POST['previous_start_date1']);
$previous_end_date1 = mysql_real_escape_string($_POST['previous_end_date1']);
$previous_company_description1 = mysql_real_escape_string($_POST['previous_company_description1']);
$previous_company2 = mysql_real_escape_string($_POST['previous_company2']);
$previous_position2 = mysql_real_escape_string($_POST['previous_position2']);
$previous_start_date2 = mysql_real_escape_string($_POST['previous_start_date2']);
$previous_end_date2 = mysql_real_escape_string($_POST['previous_end_date2']);
$previous_company_description2 = mysql_real_escape_string($_POST['previous_company_description2']);
if($_POST['major_degree_ID1'] == '-1') {
	$major_degree_ID1 = 'NULL';
	$major_industry_ID1 = 'NULL';
	$school_ID1 = 'NULL';
} else {
	$major_degree_ID1 = $_POST['major_degree_ID1'];
	$major_industry_ID1 = $_POST['major_industry_ID1'];
	$school_ID1 = $_POST['school_ID1'];
}
if($_POST['major_degree_ID2'] == '-1') {
	$major_degree_ID2 = 'NULL';
	$major_industry_ID2 = 'NULL';
	$school_ID2 = 'NULL';
} else {
	$major_degree_ID2 = $_POST['major_degree_ID2'];
	$major_industry_ID2 = $_POST['major_industry_ID2'];
	$school_ID2 = $_POST['school_ID2'];
}
if($_POST['major_degree_ID3'] == '-1') {
	$major_degree_ID3 = 'NULL';
	$major_industry_ID3 = 'NULL';
	$school_ID3 = 'NULL';
} else {
	$major_degree_ID3 = $_POST['major_degree_ID3'];
	$major_industry_ID3 = $_POST['major_industry_ID3'];
	$school_ID3 = $_POST['school_ID3'];
}
if($_POST['minor_industry_ID1'] == '-1') {
	$minor_industry_ID1 = 'NULL';
} else {
	$minor_industry_ID1 = $_POST['minor_industry_ID1'];
}
if($_POST['minor_industry_ID2'] == '-1') {
	$minor_industry_ID2 = 'NULL';
} else {
	$minor_industry_ID2 = $_POST['minor_industry_ID2'];
}

if($major_degree_ID1 != 'NULL' && $major_degree_ID2 != 'NULL' && $major_degree_ID3 != 'NULL') {
/* sorting algorithm to order the priority of a degree type */
$sql = "SELECT DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=".$_POST['major_degree_ID1'].";";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$major_degree_priority1 = $row['DegreePriority'];
}
$sql = "SELECT DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=".$_POST['major_degree_ID2'].";";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$major_degree_priority2 = $row['DegreePriority'];
}
$sql = "SELECT DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=".$_POST['major_degree_ID3'].";";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$major_degree_priority3 = $row['DegreePriority'];
}
	if($major_degree_priority3 < $major_degree_priority1) {
		$tempDegreeID = $major_degree_ID1;
		$tempIndustryID = $major_industry_ID1;
		$tempSchoolID = $school_ID1;
		
		$major_degree_ID1 = $major_degree_ID3;
		$major_industry_ID1 = $major_industry_ID3;
		$school_ID1 = $school_ID3;
		
		$major_degree_ID3 = $tempDegreeID;
		$major_industry_ID3 = $tempIndustryID;
		$school_ID3 = $tempSchoolID;
	}
	if($major_degree_priority2 < $major_degree_priority1) {
		$tempDegreeID = $major_degree_ID1;
		$tempIndustryID = $major_industry_ID1;
		$tempSchoolID = $school_ID1;
		
		$major_degree_ID1 = $major_degree_ID2;
		$major_industry_ID1 = $major_industry_ID2;
		$school_ID1 = $school_ID2;
		
		$major_degree_ID2 = $tempDegreeID;
		$major_industry_ID2 = $tempIndustryID;
		$school_ID2 = $tempSchoolID;
	}
	if($major_degree_priority3 < $major_degree_priority2) {
		$tempDegreeID = $major_degree_ID3;
		$tempIndustryID = $major_industry_ID3;
		$tempSchoolID = $school_ID3;
		
		$major_degree_ID3 = $major_degree_ID2;
		$major_industry_ID3 = $major_industry_ID2;
		$school_ID3 = $school_ID2;
		
		$major_degree_ID2 = $tempDegreeID;
		$major_industry_ID2 = $tempIndustryID;
		$school_ID2 = $tempSchoolID;
	}
} elseif($major_degree_ID1 != 'NULL' && $major_degree_ID2 != 'NULL') {
/* sorting algorithm to order the priority of a degree type */
$sql = "SELECT DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=".$_POST['major_degree_ID1'].";";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$major_degree_priority1 = $row['DegreePriority'];
}
$sql = "SELECT DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=".$_POST['major_degree_ID2'].";";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)) {
	$major_degree_priority2 = $row['DegreePriority'];
}
	if($major_degree_priority2 < $major_degree_priority1) {
		$tempDegreeID = $major_degree_ID1;
		$tempIndustryID = $major_industry_ID1;
		$tempSchoolID = $school_ID1;
		
		$major_degree_ID1 = $major_degree_ID2;
		$major_industry_ID1 = $major_industry_ID2;
		$school_ID1 = $school_ID2;
		
		$major_degree_ID2 = $tempDegreeID;
		$major_industry_ID2 = $tempIndustryID;
		$school_ID2 = $tempSchoolID;
	}
}

$sql = "UPDATE mentorwebdb." . $account_career_info . " SET 
CareerStatement='" . $career_statement . "',
MajorDegreeType1=" . $major_degree_ID1 . ", 
MajorIndustry1=" . $major_industry_ID1 . ",
School1=" . $school_ID1 . ",
MajorDegreeType2=" . $major_degree_ID2 . ",
MajorIndustry2=" . $major_industry_ID2 . ",
School2=" . $school_ID2 . ",
MajorDegreeType3=" . $major_degree_ID3 . ",
MajorIndustry3=" . $major_industry_ID3 . ",
School3=" . $school_ID3 . ",
MinorIndustry1=" . $minor_industry_ID1 . ",
MinorIndustry2=" . $minor_industry_ID2 . ",
CurrentCompany='" . $current_company . "',
CurrentPosition='" . $current_position . "',
CurrentStartDate='" . $current_start_date . "',
CurrentDescription='" . $current_company_description . "',
PreviousCompany1='" . $previous_company1 . "',
PreviousPosition1='" . $previous_position1 . "',
PreviousStartDate1='" . $previous_start_date1 . "',
PreviousEndDate1='" . $previous_end_date1 . "',
PreviousDescription1='" . $previous_company_description1 . "',
PreviousCompany2='" . $previous_company2 . "',
PreviousPosition2='" . $previous_position2 . "',
PreviousStartDate2='" . $previous_start_date2 . "',
PreviousEndDate2='" . $previous_end_date2 . "',
PreviousDescription2='" . $previous_company_description2 . "'
WHERE ID=" . $_SESSION['user_id'] . ";";
$result = mysql_query($sql,$con);

if($profilepicURL) {
$sql = "UPDATE mentorwebdb." . $account_personal_info . " SET 
FirstName='" . $user_first_name . "',
LastName='" . $user_last_name . "',
ZipCode=" . $_POST['user_zip_code'] . ",
ProfilePic='" . $profilepicURL . "'
WHERE ID=" . $_SESSION['user_id'] . ";";
} else {
$sql = "UPDATE mentorwebdb." . $account_personal_info . " SET 
FirstName='" . $user_first_name . "',
LastName='" . $user_last_name . "',
ZipCode=" . $_POST['user_zip_code'] . "
WHERE ID=" . $_SESSION['user_id'] . ";";
}
$result = mysql_query($sql,$con);

$sql = "UPDATE mentorwebdb.login SET 
user_first_name='" . $user_first_name . "',
user_last_name='" . $user_last_name . "'
WHERE user_id=" . $_SESSION['user_id'] . ";";
$result = mysql_query($sql,$con);

header('Location: profile.php');

} else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>