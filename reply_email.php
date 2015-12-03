<!DOCTYPE html>
<html>
<head>
	<title>MentorWeb</title>
	<link rel="icon" href="mentorweb_logo.png" type="image/x-icon">
	<link rel='stylesheet' type='text/css' href='css/styles.css'>
	<link rel='stylesheet' type='text/css' href='css/menu_styles.css' />
	<link rel='stylesheet' type='text/css' href='css/email_tabs.css' />
	<script type="text/javascript" src="js/email_tabs.js"></script>
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
	<div id="content">
		<div class="container">
			<div class="email_table">
				<table border='0' align='center' width='90%' cellpadding='5'>
				<?php  $sql = "SELECT * FROM mentorwebdb.email WHERE EmailID=".$_GET['email_id'].";";
					$resultInbox = mysql_query($sql,$con);
					while($row = mysql_fetch_array($resultInbox)) {
						$senderID = $row['SenderID'];
						$senderAccountType = $row['SenderAccountType'];
						$sql1 = "SELECT user_first_name,user_last_name FROM mentorwebdb.login WHERE user_id=".$senderID.";";
						$resultInbox1 = mysql_query($sql1,$con); 
						while($row1 = mysql_fetch_array($resultInbox1)) {
							$senderName = $row1['user_first_name'] ." ". $row1['user_last_name'];
						}?>
						<tr><td colspan='2'>
						<form method="POST" action="send_reply_email.php">
							<label>Reply message:</label><br>
							<textarea style='width: 100%; height: 100px;' name="reply_message"></textarea><br>
							<input id="reply_button" type="submit"  value="Send Reply" />
							<input name="senderName" type="text"  value="<?php echo $senderName; ?>" hidden/>
							<input name="senderID" type="text"  value="<?php echo $senderID; ?>" hidden/>
							<input name="senderAccountType" type="text"  value="<?php echo $senderAccountType; ?>" hidden/>
							<input name="subject" type="text"  value="<?php echo $row['Subject']; ?>" hidden/>
							<input name="original_message" type="text"  value="<?php echo $row['Body']; ?>" hidden/>
						</form>
						</td></tr>
						<tr><td><?php echo "<br><b>FROM:</b> <br>" .$senderName; ?></td><tr>
						<tr><td><?php echo "<br><b>SUBJECT:</b> <br>".$row['Subject']?></td><td align='right'><?php echo $row['EmailTimeStamp']; ?></td></tr>	
						<tr><td><div class="sender"><?php echo "<br><b>MESSAGE:</b> <br>". $row['Body']; ?></div></td></tr>
				<?php } ?>
				</table>
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