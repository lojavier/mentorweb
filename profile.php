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
			<div class="user_profile">
				<div class="header">
					<img src="<?php echo $ProfilePic; ?>"/>
					<div id="basicinfo">
						<div style="float:left;">
						<text><?php echo $FirstName . " " . $LastName; ?></text><br>
						<text><?php echo $CurrentPosition; ?></text><br>
						<text><?php echo $CurrentCompany; ?></text><br>
						</div>
					<?php if($CareerStatement) { ?>
						<div style="float: right; margin-left: 25px; width: 450px;">
						<text style="font-size: 18px; font-style: italic;">"<?php echo $CareerStatement; ?>"</text><br>
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="infotable">
					<ul id="countrytabs" class="shadetabs">
					<li><a href="#" rel="country1" class="selected">Education</a></li>
					<li><a href="#" rel="country2">Experience</a></li>
					<li><a href="#" rel="country3">Endorsements</a></li>
					<li><a href="#" rel="country4">Connections</a></li>
					</ul>
					
					<div class="tabcontentstyle">
						<div id="country1" class="tabcontent"> 
						<b><text>Major Degrees</text></b> <br>
						<?php if($MajorDegreeType1) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
							<?php echo $MajorDegreeType1; ?><br>
							<?php echo $MajorIndustry1; ?><br>
							<?php echo $School1; ?> <br>
							</div>
						<?php } ?>
						<?php if($MajorDegreeType2) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
							<?php echo $MajorDegreeType2; ?><br>
							<?php echo $MajorIndustry2; ?><br>
							<?php echo $School2; ?> <br>
							</div>
						<?php } ?>
						<?php if($MajorDegreeType3) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
							<?php echo $MajorDegreeType3; ?><br>
							<?php echo $MajorIndustry3; ?><br>
							<?php echo $School3; ?> <br>
							</div>
						<?php } ?>
							<br>
						<b><text>Minor Degrees</text></b> <br>
						<?php if($MinorIndustry1) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
							<?php echo $MinorIndustry1; ?><br>
							</div>
						<?php } ?>
						<?php if($MinorIndustry2) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
							<?php echo $MinorIndustry2; ?><br>
							</div>
						<?php } ?>
							<br>
						</div>

						<div id="country2" class="tabcontent"> 
						<b><text>Current Experience</text></b> <br>
						<?php if($CurrentCompany) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
								<div style="float: right; width: 70%;">
								<?php echo "\"" . $CurrentDescription .  "\""; ?><br>
								</div>
							<?php echo $CurrentCompany; ?><br>
							<?php echo $CurrentPosition; ?><br>
							<?php echo $CurrentStartDateFormat . "  ==>  PRESENT"; ?> <br>
							</div>
						<?php } ?>
							<br>
						<b><text>Past Experience</text></b> <br>
						<?php if($PreviousCompany1) { ?>
							<div style="margin-left: 20px; margin-right: 20px; padding: 20px;">
								<div style="float: right; width: 70%;">
								<?php echo "\"" . $PreviousDescription1 .  "\""; ?><br>
								</div>
							<?php echo $PreviousCompany1; ?><br>
							<?php echo $PreviousPosition1; ?><br>
							<?php echo $PreviousStartDate1Format . "  ==>  " . $PreviousEndDate1Format; ?> <br>
							</div>
						<?php } ?>
						<?php if($PreviousCompany2) { ?>
							<div style="margin-left: 20px; margin-right: 20px; border-top: 1px dotted black; padding: 20px;">
								<div style="float: right; width: 70%;">
								<?php echo "\"" . $PreviousDescription2 .  "\""; ?><br>
								</div>
							<?php echo $PreviousCompany2; ?><br>
							<?php echo $PreviousPosition2; ?><br>
							<?php echo $PreviousStartDate2Format . "  ==>  " . $PreviousEndDate2Format; ?> <br>
							</div>
						<?php } ?>
							<br>
						</div>
	
						<div id="country3" class="tabcontent"> <!-- ratings -->
						<br>
						<?php $sql = "SELECT * FROM mentorwebdb.endorsements WHERE EndorsedID=".$_SESSION['user_id']." AND EndorsedAccountType=".$_SESSION['user_account_login']." ORDER BY EndorsementTimeStamp DESC;";
							$result = mysql_query($sql,$con);
							while($row = mysql_fetch_array($result)) { ?>
						<table align='center' width='95%' cellpadding='10px' border='1' style='border-collapse:collapse; border: dotted;'>
						<?php	$sql2 = "SELECT AVG(Rating) as AvgRating FROM mentorwebdb.endorsements WHERE EndorsedID=".$_SESSION['user_id']." AND EndorsedAccountType=".$_SESSION['user_account_login'].";";
								$result2 = mysql_query($sql2,$con);
								while($row2 = mysql_fetch_array($result2)) {
									$AvgRating = round($row2['AvgRating'],1);
								}
								$RatingDate = $row['EndorsementTimeStamp'];
								$EndorsementComment = $row['EndorsementComment'];
								$Rating = $row['Rating'];
								$sql1 = "SELECT user_first_name,user_last_name FROM mentorwebdb.login WHERE user_id=".$row['EndorserID'].";";
								$result1 = mysql_query($sql1,$con);
								while($row1 = mysql_fetch_array($result1)) {
									$EndorserName = $row1['user_first_name']." ".$row1['user_last_name'];
								}
								echo "<tr>
									<td>
									<div style='float: left;'><b>".$EndorserName."</b></div>
									<div style='float: right;'>".$RatingDate."</div>
									<div style='float: right; margin-right: 225px;'>
									<form><div class='rating2'>"; ?>
					<?php if($Rating >= 5) {?>
							<input type="radio" id="star5" name="rating" value="5" checked="true" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($Rating < 5 && $Rating >= 4) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" checked="true" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($Rating < 4 && $Rating >= 3) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" checked="true" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($Rating < 3 && $Rating >= 2) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" checked="true" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($Rating < 2 && $Rating >= 1) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" checked="true" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($Rating < 1) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } ?>
							</div>
								<?php echo "</div></form>
									</td>
								</tr>
								<tr>
									<td align='left'><i>".$EndorsementComment."</i></td>
								</tr>
								</table><br><br>";
							}
						?>
						</div>
	
						<div id="country4" class="tabcontent"> <!-- Connections -->
						<h4>Current connections</h4> <!-- Current Connections -->
						<?php 
						if($_SESSION['user_account_login'] == 1) {
							$sql = "SELECT * FROM mentorwebdb.connections WHERE MentorID=".$_SESSION['user_id']." AND ConnectionActive=1 ORDER BY ConnectionTimeStamp DESC;";
							$result = mysql_query($sql,$con);
							echo "<table frame='box' rules='rows' width='90%' align='center'>";
							while($row = mysql_fetch_array($result)) { 
								echo "<tr>";
								$sql1 = "SELECT * FROM mentorwebdb.mentee_personal_info WHERE ID=".$row['MenteeID'].";";
								$result1 = mysql_query($sql1,$con);
								while($row1 = mysql_fetch_array($result1)) { 
									$menteeName = $row1['FirstName']." ".$row1['LastName'];
									$sql2 = "SELECT * FROM mentorwebdb.mentee_career_info WHERE ID=".$row['MenteeID'].";";
									$result2 = mysql_query($sql2,$con);
									while($row2 = mysql_fetch_array($result2)) { 
										$CurrentCompany = $row2['CurrentCompany'];
										$CurrentPosition = $row2['CurrentPosition'];
									}
									echo "<td width='20%'><a href='menteeprofile.php?id=".$row['MenteeID']."'><img style='max-width:100px;' src='".$row1['ProfilePic']."'/></a></td>";
									echo "<td style='vertical-align:top;'><b><p>".$menteeName."</p></b></td>";
									echo "<td style='vertical-align:center;'>
											<form align='right' method='POST' action='menteeprofile.php?id=".$row['MenteeID']."'>
												<input id='view_profile' type='submit' value='View Profile' /></form><br>
											<form align='right' method='POST' action='videochat.php' target='_blank'>
												<input id='view_profile' type='submit' value='Video Chat' />
												<input name='menteeID' type='text' value='".$row['MenteeID']."' hidden/>
												<input name='videoChatActive' type='text' value='1' hidden/></form><br>
											<form align='right' method='POST' action='disconnectconnection.php'>
												<input id='disconnect_user' type='submit' value='Disconnect' />
												<input name='userID' type='text' value='".$row['MenteeID']."' hidden/>
												<input name='userName' type='text' value='".$menteeName."' hidden/>
												<input name='disconnectActive' type='text' value='1' hidden/></form><br>
										</td>";
								}
								echo "</tr>";
							}
							echo "</table>";
						} elseif($_SESSION['user_account_login'] == 2) {
							$sql = "SELECT * FROM mentorwebdb.connections WHERE MenteeID=".$_SESSION['user_id']." AND ConnectionActive=1 ORDER BY ConnectionTimeStamp DESC;";
							$result = mysql_query($sql,$con);
							echo "<table frame='box' rules='rows' width='90%' align='center'>";
							while($row = mysql_fetch_array($result)) { 
								echo "<tr>";
								$sql1 = "SELECT * FROM mentorwebdb.mentor_personal_info WHERE ID=".$row['MentorID'].";";
								$result1 = mysql_query($sql1,$con);
								while($row1 = mysql_fetch_array($result1)) { 
									$mentorName = $row1['FirstName']." ".$row1['LastName'];
									$sql2 = "SELECT * FROM mentorwebdb.mentor_career_info WHERE ID=".$row['MentorID'].";";
									$result2 = mysql_query($sql2,$con);
									while($row2 = mysql_fetch_array($result2)) { 
										$CurrentCompany = $row2['CurrentCompany'];
										$CurrentPosition = $row2['CurrentPosition'];
									}
									echo "<td width='20%'><a href='mentorprofile.php?id=".$row['MentorID']."'><img style='max-width:100px;' src='".$row1['ProfilePic']."'/></a></td>";
									echo "<td style='vertical-align:top;'><b><p>".$mentorName."</p></b></td>";
									echo "<td style='vertical-align:center;'>
											<form align='right' method='POST' action='mentorprofile.php?id=".$row['MentorID']."'>
												<input id='view_profile' type='submit' value='View Profile' /></form><br>
											<form align='right' method='POST' action='videochat.php' target='_blank'>
												<input id='view_profile' type='submit' value='Video Chat' />
												<input name='mentorID' type='text' value='".$row['MentorID']."' hidden/>
												<input name='videoChatActive' type='text' value='1' hidden/></form><br>
											<form align='right' method='POST' action='disconnectconnection.php'>
												<input id='disconnect_user' type='submit' value='Disconnect' />
												<input name='userID' type='text' value='".$row['MentorID']."' hidden/>
												<input name='userName' type='text' value='".$mentorName."' hidden/>
												<input name='disconnectActive' type='text' value='1' hidden/></form><br>
										</td>";
								}
								echo "</tr>";
							}
							echo "</table>";
						}
						?>
						<h4>Past connections</h4> <!-- Past connections -->
						<?php 
						if($_SESSION['user_account_login'] == 1) {
							$sql = "SELECT * FROM mentorwebdb.connections WHERE MentorID=".$_SESSION['user_id']." AND ConnectionActive=0 ORDER BY ConnectionTimeStamp DESC;";
							$result = mysql_query($sql,$con);
							echo "<table frame='box' rules='rows' width='90%' align='center'>";
							while($row = mysql_fetch_array($result)) { 
								echo "<tr>";
								$sql1 = "SELECT * FROM mentorwebdb.mentee_personal_info WHERE ID=".$row['MenteeID'].";";
								$result1 = mysql_query($sql1,$con);
								while($row1 = mysql_fetch_array($result1)) { 
									$menteeName = $row1['FirstName']." ".$row1['LastName'];
									$sql2 = "SELECT * FROM mentorwebdb.mentee_career_info WHERE ID=".$row['MenteeID'].";";
									$result2 = mysql_query($sql2,$con);
									while($row2 = mysql_fetch_array($result2)) { 
										$CurrentCompany = $row2['CurrentCompany'];
										$CurrentPosition = $row2['CurrentPosition'];
									}
									echo "<td width='20%'><a href='menteeprofile.php?id=".$row['MenteeID']."'><img style='max-width:100px;' src='".$row1['ProfilePic']."'/></a></td>";
									echo "<td style='vertical-align:top;'><b><p>".$menteeName."</p></b></td>";
									echo "<td style='vertical-align:center;'>
											<form align='right' method='POST' action='menteeprofile.php?id=".$row['MenteeID']."'>
												<input id='view_profile' type='submit' value='View Profile' /></form><br>
											<form align='right' method='POST' action='rateuser.php'>
												<input id='rate_user' type='submit' value='Endorse' />
												<input name='userID' type='text' value='".$row['MenteeID']."' hidden/>
												<input name='userAccountType' type='text' value='1' hidden/>
												<input name='userName' type='text' value='".$menteeName."' hidden/>
												<input name='profilepic' type='text' value='".$row1['ProfilePic']."' hidden/>
												<input name='CurrentCompany' type='text' value='".$CurrentCompany."' hidden/>
												<input name='CurrentPosition' type='text' value='".$CurrentPosition."' hidden/>
												<input name='ratingActive' type='text' value='1' hidden/></form><br>
										</td>";
								}
								echo "</tr>";
							}
							echo "</table>";
						} elseif($_SESSION['user_account_login'] == 2) {
							$sql = "SELECT * FROM mentorwebdb.connections WHERE MenteeID=".$_SESSION['user_id']." AND ConnectionActive=0 ORDER BY ConnectionTimeStamp DESC;";
							$result = mysql_query($sql,$con);
							echo "<table frame='box' rules='rows' width='90%' align='center'>";
							while($row = mysql_fetch_array($result)) { 
								echo "<tr>";
								$sql1 = "SELECT * FROM mentorwebdb.mentor_personal_info WHERE ID=".$row['MentorID'].";";
								$result1 = mysql_query($sql1,$con);
								while($row1 = mysql_fetch_array($result1)) { 
									$mentorName = $row1['FirstName']." ".$row1['LastName'];
									$sql2 = "SELECT * FROM mentorwebdb.mentor_career_info WHERE ID=".$row['MentorID'].";";
									$result2 = mysql_query($sql2,$con);
									while($row2 = mysql_fetch_array($result2)) { 
										$CurrentCompany = $row2['CurrentCompany'];
										$CurrentPosition = $row2['CurrentPosition'];
									}
									echo "<td width='20%'><a href='mentorprofile.php?id=".$row['MentorID']."'><img style='max-width:100px;' src='".$row1['ProfilePic']."'/></a></td>";
									echo "<td style='vertical-align:top;'><b><p>".$mentorName."</p></b></td>";
									echo "<td style='vertical-align:center;'>
											<form align='right' method='POST' action='mentorprofile.php?id=".$row['MentorID']."'>
												<input id='view_profile' type='submit' value='View Profile' /></form><br>
											<form align='right' method='POST' action='rateuser.php'>
												<input id='rate_user' type='submit' value='Endorse' />
												<input name='userID' type='text' value='".$row['MentorID']."' hidden/>
												<input name='userAccountType' type='text' value='1' hidden/>
												<input name='userName' type='text' value='".$mentorName."' hidden/>
												<input name='profilepic' type='text' value='".$row1['ProfilePic']."' hidden/>
												<input name='CurrentCompany' type='text' value='".$CurrentCompany."' hidden/>
												<input name='CurrentPosition' type='text' value='".$CurrentPosition."' hidden/>
												<input name='ratingActive' type='text' value='1' hidden/></form><br>
										</td>";
								}
								echo "</tr>";
							}
							echo "</table>";
						}
						?>
						</div>
					</div>
					<script type="text/javascript">
					var countries=new ddtabcontent("countrytabs")
					countries.setpersist(true)
					countries.setselectedClassTarget("link") //"link" or "linkparent"
					countries.init()
					</script>
				</div>
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