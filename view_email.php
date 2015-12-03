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
						$sql1 = "SELECT user_first_name,user_last_name FROM mentorwebdb.login WHERE user_id=".$row['SenderID'].";";
						$resultInbox1 = mysql_query($sql1,$con); 
						while($row1 = mysql_fetch_array($resultInbox1)) {
							$senderName = $row1['user_first_name'] ." ". $row1['user_last_name'];
						}
						if($row['SenderID'] == $_SESSION['user_id']) {
							$body = $row['Body'];
							$body = str_replace("/>"," disabled/>",$body);
						} else { $body = $row['Body']; }
						?>
						<tr><td><?php echo "<br><b>FROM:</b> <br>" .$senderName; ?></td><tr>
						<tr><td><?php echo "<br><b>SUBJECT:</b> <br>".$row['Subject']?></td><td align='right'><?php echo $row['EmailTimeStamp']; ?></td></tr>	
						<tr><td colspan='2'><div class="sender"><?php echo "<br><b>MESSAGE:</b> <br>". $body . "<br><br>"; ?></div></td></tr>
						<tr><td><a href="reply_email.php?email_id=<?php echo $row['EmailID']; ?>">REPLY</a></td></tr>
				<?php $sql2 = "UPDATE mentorwebdb.email SET Unread=0";
					$result = mysql_query($sql2,$con);
					} ?>
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