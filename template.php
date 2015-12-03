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
			<?php include('mentorweblogo.php'); ?>
			<div class="logout">
				<table>
				<tr>
					<td><h4><?php echo "Hello, " . $_SESSION['user_first_name'] . "!" ?></h4></td>
					<td><a href="index.php?logout">Logout</a></td>
				</tr>
				</table>
			</div>
		</div>
	</div>
<!-- HEADER -->

<!-- MENU -->
<div id='cssmenu'>
<ul>
   <li><a href='home.php'><span>Home</span></a></li>
   <li class='has-sub'><a href='profile.php'><span>Profile</span></a>
      <ul>
         <li class='last'><a href='editprofile.php'><span>Edit Profile</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='mentorsearch.php'><span>Mentors</span></a>
      <ul>
         <li><a href='mentorsearch.php'><span>Find Mentors</span></a></li>
         <li class='last'><a href='mentorsignup.php'><span>Become a Mentor</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='menteesearch.php'><span>Mentees</span></a>
      <ul>
         <li><a href='menteesearch.php'><span>Find a Mentee</span></a></li>
         <li class='last'><a href='menteesignup.php'><span>Become a Mentee</span></a></li>
      </ul>
   </li>
   <li class='last'><a href='about.php'><span>About</span></a></li>
</ul>
</div>
<!-- MENU -->

<!-- CONTENT -->
	<div id="content">
		<div class="container">
			

		</div>
	</div>
<!-- CONTENT -->

<!-- FOOTER -->
	<div id="footer">
		<div class ="container" align="center">
			<h4>MentorWeb &copy; 2014</h4>
		<div>
	</div>
<!-- FOOTER -->
<?php } else { // ************************************* NOT logged in ******************************************************
header('Location: index.php');
}
?>
</body>
</html>