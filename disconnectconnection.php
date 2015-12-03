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
	if($_POST['disconnectActive'] == 1) { 
		if($_SESSION['user_account_login'] == 1) { 
			$MentorID = $_SESSION['user_id'];
			$MenteeID = $_POST['userID'];
		} 
		elseif($_SESSION['user_account_login'] == 2) { 
			$MentorID = $_POST['userID'];
			$MenteeID = $_SESSION['user_id'];
		}
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
			<h2 align='center'>Do you want to <u><i>disconnect</i></u> from <?php echo $_POST['userName']; ?>?</h2>
			<form align='center' method='POST' action='disconnect_confirmation.php'>
			<input name="MentorID" type="text" value="<?php echo $MentorID; ?>" hidden/>
			<input name="MenteeID" type="text" value="<?php echo $MenteeID; ?>" hidden/>
			<input name="disconnectActive" type="text" value="1" hidden/>
			<input name="disconnection" type="submit" value="YES" />
			<input name="disconnection" type="submit" value="NO" />
			</form>
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