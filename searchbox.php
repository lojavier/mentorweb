<div class="search_box">
<?php if($_SESSION['user_account_login'] == 2) { ?>
	<form method="get" action="mentorsearch.php">
		<font class="title">SEARCH FOR MENTORS</font>
<?php } elseif($_SESSION['user_account_login'] == 1) {?>
	<form method="get" action="menteesearch.php">
		<font class="title">SEARCH FOR MENTEES</font>
<?php } ?>
		<hr><br>
		<label>Industry / Career</label><br>
		<select name="industry">
			<option value="-1" >Select one:</option>
<?php 	$sql = "SELECT DISTINCT IndustryCategory1 FROM mentorwebdb.industries ORDER BY IndustryCategory1 ASC;";
		$result = mysql_query($sql,$con);
		while($row = mysql_fetch_array($result)) { 
			$IndustryCategory1 = $row['IndustryCategory1'];
			echo "<option value=" . $IndustryCategory1 . ">" . $IndustryCategory1 . "</option>";
		} ?>
		</select><br><br>
		<label>Zip code</label><br>
		<input class="zipcode" type="text" name="zipcode" pattern="[0-9]{5}" placeholder="95112" title="5-Digit Zip Code" value="<?php echo $user_zipcode; ?>" autocomplete="on"/><br><br>
		<input type="submit" value="Search" />
	</form>
</div>