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
				<ul id="countrytabs" class="shadetabs">
				<li><a href="#" rel="country1" class="selected">Inbox</a></li>
				<li><a href="#" rel="country2">Sent</a></li>
				</ul>
				
				<div class="tabcontentstyle">
					<div id="country1" class="tabcontent"> <!-- INBOX -->
						<div class="inbox_list">
							<div id="list">
								<ul>
						<?php  $sql = "SELECT * FROM mentorwebdb.email WHERE RecipientID=".$_SESSION['user_id']." AND RecipientAccountType=".$_SESSION['user_account_login']." ORDER BY EmailTimeStamp DESC;";
							$resultInbox = mysql_query($sql,$con);
							while($row = mysql_fetch_array($resultInbox)) {
								$sql1 = "SELECT user_first_name,user_last_name FROM mentorwebdb.login WHERE user_id=".$row['SenderID'].";";
								$resultInbox1 = mysql_query($sql1,$con); 
								while($row1 = mysql_fetch_array($resultInbox1)) {
									$senderName = $row1['user_first_name'] ." ". $row1['user_last_name'];
								}
								if($row['Unread'] == 1) { ?>
								<b><li><a href="view_email.php?email_id=<?php echo $row['EmailID']; ?>">
								<div class="sender"><?php echo $senderName; ?></div>
								<div class="subject"><?php echo $row['Subject']; ?></div>
								<div class="timestamp"><?php echo $row['EmailTimeStamp']; ?></div>
								</a></li></b>
							<?php } else { ?>
								<li><a href="view_email.php?email_id=<?php echo $row['EmailID']; ?>">
								<div class="sender"><?php echo $senderName; ?></div>
								<div class="subject"><?php echo $row['Subject']; ?></div>
								<div class="timestamp"><?php echo $row['EmailTimeStamp']; ?></div>
								</a></li>
							<?php } ?>
						<?php } ?>
								</ul>
							</div>
						</div>
						<div style="display:block; visibility:hidden;" >hidden<br></div>
						<div class="page_changer">
							<div id="list">
								<ul>
						<?php for($i=1; $i<=10; $i++) { ?>
								<li><a href="email.php?mailbox=inbox?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php } ?>
								</ul>
							</div>
						</div>
						<div style="display:block; visibility:hidden;" >hidden<br><br></div>
					</div>

					<div id="country2" class="tabcontent"> <!-- SENT -->
						<div class="inbox_list">
							<div id="list">
								<ul>
						<?php $sql = "SELECT * FROM mentorwebdb.email WHERE SenderID=".$_SESSION['user_id']." AND SenderAccountType=".$_SESSION['user_account_login']." ORDER BY EmailTimeStamp DESC;";
							$resultInbox = mysql_query($sql,$con);
							while($row = mysql_fetch_array($resultInbox)) {
								$sql1 = "SELECT user_first_name,user_last_name FROM mentorwebdb.login WHERE user_id=".$row['SenderID'].";";
								$resultInbox1 = mysql_query($sql1,$con); 
								while($row1 = mysql_fetch_array($resultInbox1)) {
									$senderName = $row1['user_first_name'] ." ". $row1['user_last_name'];
								}?>
								<li><a href="view_email.php?email_id=<?php echo $row['EmailID']; ?>">
								<div class="sender"><?php echo $senderName; ?></div>
								<div class="subject"><?php echo $row['Subject']; ?></div>
								<div class="timestamp"><?php echo $row['EmailTimeStamp']; ?></div>
								</a></li>
						<?php } ?>
								</ul>
							</div>
						</div>
						<div style="display:block; visibility:hidden;" >hidden<br></div>
						<div class="page_changer">
							<div id="list">
								<ul>
						<?php for($i=1; $i<=10; $i++) { ?>
								<li><a href="email.php?mailbox=sent?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php } ?>
								</ul>
							</div>
						</div>
						<div style="display:block; visibility:hidden;" >hidden<br><br></div>
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