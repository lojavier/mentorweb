<!DOCTYPE html>
<html>
<head>
	<title>MentorWeb</title>
	<link rel="icon" href="mentorweb_logo.png" type="image/x-icon">
	<link rel='stylesheet' type='text/css' href='css/styles.css'>
	<link rel='stylesheet' type='text/css' href='css/menu_styles.css' />
	<script>
	function sortby(str) {
	  var url = "menteesearch.php?sortby="+str;
	  window.location = url;
	}
	</script>
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
include('get_zipcode.php');
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
	<div id="content">
		<div class="container">
		<?php if($_SESSION['user_account_login'] == 1) { ?> <!-- If user is logged in as a mentor -->
			<!-- search box -->
			<?php include('searchbox.php'); ?>
			<!-- mentee results -->
			<div class="search_results">
				<div class="header">
				<?php include('usersearchresults.php'); ?>
					<text><?php echo $resultsCount; ?> mentees</text>
					<select onchange="sortby(this.value)">
						<?php if($sortby == "distance") { ?>
						<option value="bestmatch">Best Match</option>
						<option value="distance" selected>Distance</option>
						<option value="rating">Rating</option>
					<?php } elseif($sortby == "rating") { ?>
						<option value="bestmatch">Best Match</option>
						<option value="distance">Distance</option>
						<option value="rating" selected>Rating</option>
					<?php } else { ?>
						<option value="bestmatch" selected>Best Match</option>
						<option value="distance">Distance</option>
						<option value="rating">Rating</option>
					<?php } ?>
					</select>
					<br><br>
					<hr>
				</div>
				<div class="result_table">
					<?php 
					$startDisplay = 1 + (($page-1)*10);
					if( (ceil($resultsCount/10)) <= $page) {
						if($resultsCount%10 == 0) {
							$maxDisplayPerPage = ($page*10);
						}else {
							$maxDisplayPerPage = ($resultsCount%10) + (($page-1)*10);
						}
					} else { 
						$maxDisplayPerPage = ($page*10);
					}
					for($i=$startDisplay; $i <= $maxDisplayPerPage; $i++) {
					$UserID = $resultsArray[$i][1];
					$FirstName = $resultsArray[$i][2];
					$LastName = $resultsArray[$i][3];
					$Location = $resultsArray[$i][4];
					$ProfilePic = $resultsArray[$i][5];
					$MajorDegree1 = $resultsArray[$i][6];
					$MajorIndustry1 = $resultsArray[$i][7];
					$School1 = $resultsArray[$i][8];
					$CareerStatement = $resultsArray[$i][9];
					$EndorsementCount = $resultsArray[$i][10];
					$AvgRating = $resultsArray[$i][11];
					$Distance = $resultsArray[$i][12];
					?>
					<div id="profilepic">
						<a href="menteeprofile.php?id=<?php echo $UserID;?>"><img src="<?php echo $ProfilePic;?>"/></a>
					</div>
					<div id="info">
						<text><a href="menteeprofile.php?id=<?php echo $UserID;?>"><?php echo $FirstName . " " . $LastName;?></a></text>
						<text style="float:right;"><?php echo $Location; ?></text><br>
						<?php if($Distance) { ?>
						<text style="float:right;"><?php echo $Distance." miles away"; ?></text><br>
						<?php } else { ?>
						<text style="float:right;"></text><br>
						<?php } ?>
						<text><?php echo $MajorIndustry1.", ".$MajorDegree1;?></text><br>
						<text><?php echo $School1;?></text><br>
						<text class="career_statement"><?php echo $CareerStatement;?></text>
					</div>
					<div id="ratings">
						<a href="menteeprofile.php?id=<?php echo $UserID;?>"><?php echo $EndorsementCount;?> endorsements</a><br>
						<hr>
						<form method="post" action="menteeprofile.php?id=<?php echo $UserID;?>">
							<div class="rating2">
					<?php if($AvgRating >= 5) {?>
							<input type="radio" id="star5" name="rating" value="5" checked="true" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($AvgRating < 5 && $AvgRating >= 4) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" checked="true" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($AvgRating < 4 && $AvgRating >= 3) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" checked="true" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($AvgRating < 3 && $AvgRating >= 2) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" checked="true" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($AvgRating < 2 && $AvgRating >= 1) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" checked="true" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } elseif($AvgRating < 1) { ?>
							<input type="radio" id="star5" name="rating" value="5" disabled/><label for="star5" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" disabled/><label for="star4" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" disabled/><label for="star3" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" disabled/><label for="star2" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" disabled/><label for="star1" title="<?php echo $AvgRating." of 5 stars";?>">&#9733;</label>
					<?php } ?>
							</div>
							<input type="submit" name="view_mentor" value="View this mentor"/>
						</form>
					</div>
					<hr>
					<?php }?>
				</div>
				<div class="page_changer">
					<div id="list">
						<ul>
						<?php for($i = 1; $i <= (ceil($resultsCount/10)); $i++) { ?>
						<li><a href="menteesearch.php?page=<?php echo $i."&sortby=".$sortby; ?>"><?php echo $i; ?></a></li>
							<?php if($i > 5) { ?>
								<li><a href="menteesearch.php?page=6">>></a></li>
							<?php } ?>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		<?php } elseif($_SESSION['user_account_type'] == 3) { ?> <!-- Else if user is logged in as a mentor with dual mentee membership -->
			<h3 style="text-align: center;">You are signed in as a Mentee. Logout and sign in to your Mentor account to search for Mentees.</h3><br>
			<h2 style="text-align: center; font-size: 30px;">OR</h2><br>
			<h3 style="text-align: center;">Click below to switch accounts.</h3><br>
			<form align="center" method="POST" action="switchaccounts.php">
				<input type="submit" name="switch_accounts" value="Switch accounts"/>
			</form>
		<?php } elseif($_SESSION['user_account_login'] == 2) { ?> <!-- Else if user is logged in as a mentee -->
			<h3 style="text-align: center;">You are registered only as a Mentee. You may register for a dual, Mentor-Mentee membership.</h3><br>
			<form align="center" method="POST" action="createdualmembership.php">
				<input type="submit" name="create_dual_membership" value="Create Dual Membership"/>
			</form>
		<?php } ?>
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