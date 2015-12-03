<?php			
$sql = "SELECT * FROM mentorwebdb.company_logos;";
$result = mysql_query($sql,$con);

$company_logos = array();
$i = 0;

while($row = mysql_fetch_array($result)) {
	$company_logos[$i][0] = $row['companyName'];
	$company_logos[$i][1] = $row['companyURL'];
	$company_logos[$i][2] = $row['logo1'];
	$i++;
}

shuffle($company_logos);
echo "<table>";
$x = 0;
for($i = 1; $i < 4; $i++) {
	echo "<tr>";
	for($j = 1; $j < 4; $j++) {
		echo "<td><a href='". $company_logos[$x][1] . "' target='_blank'><img src='company_logos\\" . $company_logos[$x][2] . "' 
				alt='" . $company_logos[$x][0] . "' title='" . $company_logos[$x][0] . "' /></a></td>";
		$x++;
	}
	echo "</tr>";
}
echo "</table>";
?>