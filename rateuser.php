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
	if($_POST['ratingActive'] == 1) { 
		if($_SESSION['user_account_login'] == 1) { $userAccountType = 2; } 
		elseif($_SESSION['user_account_login'] == 2) { $userAccountType = 1; }
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
					<img src="<?php echo $_POST['profilepic']; ?>"/>
					<div id="basicinfo">
						<div style="float:left;">
						<text><?php echo $_POST['userName']; ?></text><br>
						<text><?php echo $_POST['CurrentPosition']; ?></text><br>
						<text><?php echo $_POST['CurrentCompany']; ?></text><br><br>
						<form method='POST' action='submit_endorsement.php'>
						<fieldset class="rating">
							<legend>Please rate:</legend>
							<input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="Amazing!">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4" required/><label for="star4" title="Really good">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3" required/><label for="star3" title="Very helpful">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2" required/><label for="star2" title="Needs some improvement">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1" required/><label for="star1" title="Not sure what they're doing">&#9733;</label>
						</fieldset><br>
						</div>
						<div style="float: right; margin-left: 25px; width: 450px;">
							<label>Endorsement Comments:</label><br>
							<textarea style='width: 98%; height: 140px;' name="endorsement_comments" required></textarea><br>
							<input style="float:right;" id="submit_rating_button" type="submit" value="Submit Endorsement" />
						</div>
						<input name="EndorsedID" type="text" value="<?php echo $_POST['userID']; ?>" hidden/>
						<input name="EndorsedAccountType" type="text"  value="<?php echo $userAccountType; ?>" hidden/>
						<input name="ratingActive" type="text"  value="1" hidden/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- CONTENT -->

<!-- FOOTER -->
	<?php include('footer.php'); ?>
<!-- FOOTER -->
	<?php } else { header('Location: index.php'); } ?>
<?php } else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>
</body>
</html>