<!DOCTYPE html>
<html>
<head>
	<title>MentorWeb</title>
	<link rel="icon" href="mentorweb_logo.png" type="image/x-icon">
	<link rel='stylesheet' type='text/css' href='css/styles.css'>
	<link rel='stylesheet' type='text/css' href='css/menu_styles.css' />
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
			<div style='width:85%; padding-left: 50px;'>
			<h2>ABOUT US</h2>
			<p>Welcome to MentorWeb.</p>
			<h2>Mission</h2>
			<p>Our mission consists of creating a link between individuals seeking knowledge with individuals willing to provide knowledge.  
			The basic principle of MentorWeb is to provide a service to users who want to institute a connection between themselves and various professions in the industry.</p>
			<h2>Our Team</h2>
			<ul>
			<table>
			<tr><td><li>Lead Web Developer:</td><td>Lorenzo Javier</li></td></tr>
			<tr><td><li>Database Designer:</td><td>Delfin Libaste</li></td></tr>
			<tr><td><li>Layout Designer:</td><td>David Bui</li></td></tr>
			<tr><td><li>Documentation:</td><td>Bryan Radford, Zain Agha</li></td></tr>
			<tr><td><li>Lead Tester:</td><td>Yohan Bouvron</li></td></tr>
			</table>
			</ul>
			<h2>Information</h2>
			<p>For more information about please email us at info@mentorweb.com</p>
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