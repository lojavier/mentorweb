<!DOCTYPE html>
<html>
<head>
	<title>MentorWeb</title>
	<link rel="icon" href="mentorweb_logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script type='text/javascript' src='js/passwordmatch.js'></script>
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
require_once("classes/Registration.php");

$login = new Login();
$registration = new Registration();

if ($login->isUserLoggedIn() == true) { // ************************************* logged in ******************************************************
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
			echo "<script>";
			echo "alert ('$error')";
			echo "</script>";
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo "<script>";
			echo "alert ('$message')";
			echo "</script>";
        }
    }
}
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo "<script>";
			echo "alert ('$error')";
			echo "</script>";
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo "<script>";
			echo "alert ('$message')";
			echo "</script>";
        }
    }
}
header('Location: home.php');
?>
<?php } else { // ************************************* NOT logged in ******************************************************
?>
<!-- HEADER -->
	<div id="header">
		<div class="container">
			<?php include('mentorweblogo.php'); ?>
			<div class="login">
				<form method="post" action="index.php" name="loginform">
				<table>
				<tr>
					<td>
					<label>&nbsp;&nbsp;Membership</label><br>
					<input id="" type="radio" name="user_account_login" value="1" required><font>Mentor</font>
					<input id="" type="radio" name="user_account_login" value="2" required><font>Mentee</font>
					</td>
					<td>
					<label>Email address</label><br>
					<input id="textbox1" type="email" name="user_email" autofocus required autocomplete="on" tabindex="1"/>
					</td>
					<td>
						<label>Password</label>
						<a href="passwordreset.php">Forgot your password?</a><br>
						<input id="textbox2" type="password" name="user_password" autocomplete="off" required tabindex="2"/>
						<input type="submit"  name="login" value="Sign in" />
					</td>
				</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
<!-- HEADER -->

<!-- CONTENT -->
	<div id="content">
		<div class="container">
			<h1 align="center">Connect to a mentor! Become a mentor!</h1>
			<div class="company_logos">
			<?php include('companydisplay.php'); ?>
			</div>
			<div class="register">
				<form method="post" action="index.php" name="registerform">
				<table>
				<tr>
					<td>
						<h2>Register today!</h2>
						<input id="radio1" type="radio" name="user_account_type" value="1" tabindex="3" required><font>Become a <i><b>Mentor</b></i></font>
						<input id="radio1" type="radio" name="user_account_type" value="2" tabindex="4" required><font>Become a <i><b>Mentee</b></i></font>
					</td>
				</tr>
				<tr>
					<td>
					<input class="textbox1" type="text" pattern="[a-zA-Z\-]{2,50}" name="user_first_name" placeholder="First name" tabindex="5" required autocomplete="on"/>
					<input class="textbox1" type="text" pattern="[a-zA-Z\-]{2,50}" name="user_last_name" placeholder="Last name" tabindex="6" required autocomplete="on"/>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
					<input class="textbox2" type="email" name="user_email" placeholder="Email address" tabindex="7" required autocomplete="on"/>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
					<input class="textbox2" id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" placeholder="Password (6 or more characters)" 
						tabindex="8" required autocomplete="off" />
					</td>
				</tr>
				<tr>
					<td colspan='2'>
					<input class="textbox2" id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}"  placeholder="Repeat password" 
						tabindex="9" required autocomplete="off" onkeyup="checkPass(); return false;"/> <br>
					<span id="confirmMessage" class="confirmMessage"></span>
					</td>
				</tr>
				<tr>
					<td>
					<input class="textbox3" type="text" pattern="[0-9]{5}" name="user_zip_code" placeholder="Zip code" title="5-Digit Zip Code" tabindex="10" 
						required autocomplete="on"/>
					</td>
				</tr>
				<tr>
					<td>
					<input id="submit_button" type="submit"  name="register" value="Join now" tabindex="11" />
					</td>
				</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
<!-- CONTENT -->

<!-- FOOTER -->
	<?php include('footer.php'); ?>
<!-- FOOTER -->
<?php
	// show potential errors / feedback (from login object)
	if (isset($login)) {
		if ($login->errors) {
			foreach ($login->errors as $error) {
				echo "<script>";
				echo "alert ('$error')";
				echo "</script>";
			}
		}
		if ($login->messages) {
			foreach ($login->messages as $message) {
				echo "<script>";
				echo "alert ('$message')";
				echo "</script>";
			}
		}
	}
	if (isset($registration)) {
		if ($registration->errors) {
			foreach ($registration->errors as $error) {
				echo "<script>";
				echo "alert ('$error')";
				echo "</script>";
			}
		}
		if ($registration->messages) {
			foreach ($registration->messages as $message) {
				echo "<script>";
				echo "alert ('$message')";
				echo "</script>";
			}
		}
	}
}
?>
</body>
</html>