<div class="logout">
	<table>
	<tr>
		<td>
		<?php $sql = "SELECT * FROM mentorwebdb.email WHERE RecipientID=".$_SESSION['user_id']." AND RecipientAccountType=".$_SESSION['user_account_login'].";";
			$result = mysql_query($sql,$con);
			while($row = mysql_fetch_array($result)) {
				$unread_mail += $row['Unread'];
			}
			if($unread_mail > 0) { ?>
			<a href="email.php"><img src="images/mail_logo_unread.jpg"></a>
		<?php } else { ?>
			<a href="email.php"><img src="images/mail_logo.JPG"></a>
		<?php } ?>
		</td>
		<td><h3><?php echo "Hello, " . $_SESSION['user_first_name'] . "!"?></h3></td>
		<td><a href="index.php?logout">Logout</a></td>
	</tr>
	</table>
</div>