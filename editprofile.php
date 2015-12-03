<!DOCTYPE html>
<html>
<head>
	<title>MentorWeb</title>
	<link rel="icon" href="mentorweb_logo.png" type="image/x-icon">
	<link rel='stylesheet' type='text/css' href='css/styles.css'>
	<link rel='stylesheet' type='text/css' href='css/menu_styles.css' />
	<link rel='stylesheet' type='text/css' href='css/tabcontent.css'>
	<script type='text/javascript' src='js/tabcontent.js'></script>
</head>
<body>

<?php
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}

require_once("config/mentorwebdb.php");

require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************
?>
<!-- HEADER -->
	<div id="header">
		<div class="container">
			<!-- MentorWeb logo -->
			<?php include('mentorweblogo.php'); ?>
			<!-- Logout header -->
			<?php include('logout_header.php'); ?>
		</div>
	</div>
<!-- HEADER -->

<!-- MENU -->
<?php include('menu.php'); ?>
<!-- MENU -->

<!-- CONTENT -->
<?php include('userinfo.php'); ?>
	<div id="content">
		<div class="container">
			<div class="user_profile_edit">
				<div class="header">
				<form method="POST" action="updateprofile.php" name="profileform" enctype="multipart/form-data">
					<div class="basicinfo">
					<table>
					<tr style="vertical-align: top; height: 50px;">
						<td rowspan='2'>
						<img src="<?php echo $ProfilePic; ?>"/> <br>
						<input type="file" name="profile_pic_upload" id="profile_pic_upload"> <br>
						</td>
						<td style="padding-top: 10px;">
						<label>First Name</label><br>
						<input class="textbox1" type="text" name="user_first_name" value="<?php echo $FirstName; ?>" required/><br><br>
						<label>Email</label><br>
						<input class="textbox2" type="email" name="user_email" value="<?php echo $Email; ?>" required autocomplete="on" disabled/> <br><br>
						</td>
						<td style="padding-top: 10px;">
						<label>Last Name</label><br>
						<input class="textbox1" type="text" name="user_last_name" value="<?php echo $LastName; ?>" required/><br><br>
						<label>Zip code</label><br>
						<input class="textbox3" type="text" pattern="[0-9]{5}" name="user_zip_code" value="<?php echo $ZipCode; ?>" title="5-Digit Zip Code" 
								required autocomplete="on"/> <br><br>
						</td>
						<td style="vertical-align: top; width: 250px;">
						<h2 style="text-align: center; float: right; margin-right: 15px;">Edit Profile</h2>
						<input id="update_button" type="submit"  value="Update" />
						</td>
					</tr>
					<tr style="vertical-align: top;">
						<td colspan='3'>
						<label>Career Statement</label><br>
						<textarea style="width: 600px; height: 100px;" name="career_statement"><?php echo $CareerStatement; ?></textarea><br>
						</td>
					</tr>
					</table>
					</div>
				</div>
				<div class="infotable">
					<ul id="countrytabs" class="shadetabs">
					<li><a href="#" rel="country1" class="selected">Education</a></li>
					<li><a href="#" rel="country2">Experience</a></li>
					</ul>
					
					<div class="tabcontentstyle">
						<div id="country1" class="tabcontent"> 
						<b><text>Major Degrees</text></b> <br>
						<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
						<!-- Degree 1 -->
						<label>Degree 1</label><br>
						<select name="major_degree_ID1">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT DegreeID,DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees ORDER BY DegreePriority ASC, DegreeConc ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$DegreeID1 = $row['DegreeID'];
								$DegreeName1 = $row['DegreeType'] . " of " . $row['DegreeConc'];
								if($MajorDegreeID1 == $DegreeID1) {
									echo "<option value=" . $DegreeID1 . " selected>" . $DegreeName1 . "</option>";
								} else {
									echo "<option value=" . $DegreeID1 . ">" . $DegreeName1 . "</option>";
								}
							} ?>
						</select><br>
						<label>Industry 1</label><br>
						<select name="major_industry_ID1">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT * FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC, IndustryCategory2 ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$IndustryName1 = $row['IndustryCategory2'];
								$IndustryID1 = $row['IndustryID'];
								if($MajorIndustryID1 == $IndustryID1) {
									echo "<option value=" . $IndustryID1 . " selected>" . $IndustryName1 . "</option>";
								} else {
									echo "<option value=" . $IndustryID1 . ">" . $IndustryName1 . "</option>";
								}
							} ?>
						</select><br>
						<label>School 1</label><br>
						<select name="school_ID1">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools ORDER BY SchoolName ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$SchoolName1 = $row['SchoolName'];
								$SchoolID1 = $row['SchoolID'];
								if($MajorSchoolID1 == $SchoolID1) {
									echo "<option value=" . $SchoolID1 . " selected>" . $SchoolName1 . "</option>";
								} else {
									echo "<option value=" . $SchoolID1 . ">" . $SchoolName1 . "</option>";
								}
							} ?>
						</select><br>
						</div>
						
						<!-- Degree 2 -->
						<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
						<label>Degree 2</label><br>
						<select name="major_degree_ID2">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT DegreeID,DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees ORDER BY DegreePriority ASC, DegreeConc ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$DegreeID2 = $row['DegreeID'];
								$DegreeName2 = $row['DegreeType'] . " of " . $row['DegreeConc'];
								if($MajorDegreeID2 == $DegreeID2) {
									echo "<option value=" . $DegreeID2 . " selected>" . $DegreeName2 . "</option>";
								} else {
									echo "<option value=" . $DegreeID2 . ">" . $DegreeName2 . "</option>";
								}
							} ?>
						</select><br>
						<label>Industry 2</label><br>
						<select name="major_industry_ID2">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT * FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC, IndustryCategory2 ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$IndustryName2 = $row['IndustryCategory2'];
								$IndustryID2 = $row['IndustryID'];
								if($MajorIndustryID2 == $IndustryID2) {
									echo "<option value=" . $IndustryID2 . " selected>" . $IndustryName2 . "</option>";
								} else {
									echo "<option value=" . $IndustryID2 . ">" . $IndustryName2 . "</option>";
								}
							} ?>
						</select><br>
						<label>School 2</label><br>
						<select name="school_ID2">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools ORDER BY SchoolName ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$SchoolName2 = $row['SchoolName'];
								$SchoolID2 = $row['SchoolID'];
								if($MajorSchoolID2 == $SchoolID2) {
									echo "<option value=" . $SchoolID2 . " selected>" . $SchoolName2 . "</option>";
								} else {
									echo "<option value=" . $SchoolID2 . ">" . $SchoolName2 . "</option>";
								}
							} ?>
						</select><br>
						</div>
						
						<!-- Degree 3 -->
						<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
						<label>Degree 3</label><br>
						<select name="major_degree_ID3">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT DegreeID,DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees ORDER BY DegreePriority ASC, DegreeConc ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$DegreeID3 = $row['DegreeID'];
								$DegreeName3 = $row['DegreeType'] . " of " . $row['DegreeConc'];
								if($MajorDegreeID3 == $DegreeID3) {
									echo "<option value=" . $DegreeID3 . " selected>" . $DegreeName3 . "</option>";
								} else {
									echo "<option value=" . $DegreeID3 . ">" . $DegreeName3 . "</option>";
								}
							} ?>
						</select><br>
						<label>Industry 3</label><br>
						<select name="major_industry_ID3">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT * FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC, IndustryCategory2 ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$IndustryName3 = $row['IndustryCategory2'];
								$IndustryID3 = $row['IndustryID'];
								if($MajorIndustryID3 == $IndustryID3) {
									echo "<option value=" . $IndustryID3 . " selected>" . $IndustryName3 . "</option>";
								} else {
									echo "<option value=" . $IndustryID3 . ">" . $IndustryName3 . "</option>";
								}
							} ?>
						</select><br>
						<label>School 3</label><br>
						<select name="school_ID3">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools ORDER BY SchoolName ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$SchoolName3 = $row['SchoolName'];
								$SchoolID3 = $row['SchoolID'];
								if($MajorSchoolID3 == $SchoolID3) {
									echo "<option value=" . $SchoolID3 . " selected>" . $SchoolName3 . "</option>";
								} else {
									echo "<option value=" . $SchoolID3 . ">" . $SchoolName3 . "</option>";
								}
							} ?>
						</select><br>
						</div>
						
						<b><text>Minor Degrees</text></b> <br>
						<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
						<label>Industry 1</label><br>
						<select name="minor_industry_ID1">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT * FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC, IndustryCategory2 ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$IndustryName1 = $row['IndustryCategory2'];
								$IndustryID1 = $row['IndustryID'];
								if($MinorIndustryID1 == $IndustryID1) {
									echo "<option value=" . $IndustryID1 . " selected>" . $IndustryName1 . "</option>";
								} else {
									echo "<option value=" . $IndustryID1 . ">" . $IndustryName1 . "</option>";
								}
							} ?>
						</select><br>
						</div>
						<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
						<label>Industry 2</label><br>
						<select name="minor_industry_ID2">
							<option value="-1" >Select one:</option>
					<?php 	$sql = "SELECT * FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC, IndustryCategory2 ASC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { 
								$IndustryName2 = $row['IndustryCategory2'];
								$IndustryID2 = $row['IndustryID'];
								if($MinorIndustryID2 == $IndustryID2) {
									echo "<option value=" . $IndustryID2 . " selected>" . $IndustryName2 . "</option>";
								} else {
									echo "<option value=" . $IndustryID2 . ">" . $IndustryName2 . "</option>";
								}
							} ?>
						</select><br>
						</div>
						</div>

						<div id="country2" class="tabcontent"> 
						<b><text>Current Experience</text></b> <br>
							<div>
								<div style="float: right;">
								<label>Description</label><br>
								<textarea name="current_company_description"><?php echo $CurrentDescription; ?></textarea><br>
								</div>
								<label>Company</label><br>
								<input class="textbox1" type="text" name="current_company" value="<?php echo $CurrentCompany; ?>" /><br>
								<label>Position</label><br>
								<input class="textbox1" type="text" name="current_position" value="<?php echo $CurrentPosition; ?>" /><br>
								<label>Start Date</label><br>
								<input class="date" type="date" name="current_start_date" value="<?php echo $CurrentStartDate; ?>" /><br><br>
							</div>
						<b><text>Past Experience</text></b> <br>
							<div>
								<div style="float: right;">
								<label>Description</label><br>
								<textarea name="previous_company_description1"><?php echo $PreviousDescription1; ?></textarea><br>
								</div>
								<label>Company</label><br>
								<input class="textbox1" type="text" name="previous_company1" value="<?php echo $PreviousCompany1; ?>" /><br>
								<label>Position</label><br>
								<input class="textbox1" type="text" name="previous_position1" value="<?php echo $PreviousPosition1; ?>" /><br>
								<label>Start Date</label><br>
								<input class="date" type="date" name="previous_start_date1" value="<?php echo $PreviousStartDate1; ?>" /><br>
								<label>End Date</label><br>
								<input class="date" type="date" name="previous_end_date1" value="<?php echo $PreviousEndDate1; ?>" /><br><br>
							</div>
							<div>
								<div style="float: right;">
								<label>Description</label><br>
								<textarea name="previous_company_description2"><?php echo $PreviousDescription2; ?></textarea><br>
								</div>
								<label>Company</label><br>
								<input class="textbox1" type="text" name="previous_company2" value="<?php echo $PreviousCompany2; ?>" /><br>
								<label>Position</label><br>
								<input class="textbox1" type="text" name="previous_position2" value="<?php echo $PreviousPosition2; ?>" /><br>
								<label>Start Date</label><br>
								<input class="date" type="date" name="previous_start_date2" value="<?php echo $PreviousStartDate2; ?>" /><br>
								<label>End Date</label><br>
								<input class="date" type="date" name="previous_end_date2" value="<?php echo $PreviousEndDate2; ?>" /><br>
							</div>
						</div>
					</div>
					<script type="text/javascript">
					var countries=new ddtabcontent("countrytabs")
					countries.setpersist(true)
					countries.setselectedClassTarget("link") //"link" or "linkparent"
					countries.init()
					</script>
				</div>
				</form>
			</div>
		</div>
	</div>
<!-- CONTENT -->

<!-- FOOTER -->
<?php include('footer.php'); ?>
<!-- FOOTER -->
<?php } else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>
</body>
</html>