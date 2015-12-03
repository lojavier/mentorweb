<?php

if(!$_GET['page']) { $page = 1; }
else { $page = $_GET['page']; }

if(!$_GET['sortby']) { $sortby = "default"; }
else { $sortby = $_GET['sortby']; }

$resultsCount = 0;
$resultsArray = array();

if($_SESSION['user_account_login'] == 2) {
	$account_personal_info = "mentor_personal_info";
	$account_career_info = "mentor_career_info";
	$endorsed_account_type=1;
	
} elseif($_SESSION['user_account_login'] == 1) {
	$account_personal_info = "mentee_personal_info";
	$account_career_info = "mentee_career_info";
	$endorsed_account_type=2;
}
$sql1 = "SELECT * FROM mentorwebdb.".$account_personal_info." WHERE ID!=".$_SESSION['user_id']." ORDER BY ID ASC;";
$result1 = mysql_query($sql1,$con);

while($row = mysql_fetch_array($result1)) {
	$resultsCount++;
	$UserID = $row['ID'];
	$FirstName = $row['FirstName'];
	$LastName = $row['LastName'];
	$ZipCode = $row['ZipCode'];
	$ProfilePic = $row['ProfilePic'];
	
	$resultsArray[$resultsCount][1] = $row['ID'];
	$resultsArray[$resultsCount][2] = $row['FirstName'];
	$resultsArray[$resultsCount][3] = $row['LastName'];
		$request1 = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . $row['ZipCode'] . "&sensor=false");
		$json1 = json_decode($request1, true); 
		$lat1 = $json1['results'][0]['geometry']['location']['lat'];
		$lon1 = $json1['results'][0]['geometry']['location']['lng'];
	$resultsArray[$resultsCount][4] = $json1['results'][0]['formatted_address'];
	$resultsArray[$resultsCount][5] = $row['ProfilePic'];
	
	$sql2 = "SELECT * FROM mentorwebdb.".$account_career_info." WHERE ID=".$row['ID']. " ORDER BY ID ASC;";
	$result2 = mysql_query($sql2,$con);
	while($row1 = mysql_fetch_array($result2)) {
		$sql3 = "SELECT DegreeType,DegreeConc FROM mentorwebdb.degrees WHERE DegreeID=" . $row1['MajorDegreeType1'] . ";";
		$result3 = mysql_query($sql3,$con);
		while($row2 = mysql_fetch_array($result3)) {
			$resultsArray[$resultsCount][6] = $row2['DegreeType'] . " of " . $row2['DegreeConc'];
		}
		$sql3 = "SELECT IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row1['MajorIndustry1'] . ";";
		$result3 = mysql_query($sql3,$con);
		while($row2 = mysql_fetch_array($result3)) {
			$resultsArray[$resultsCount][7] = $row2['IndustryCategory2'];
		}
		$sql3 = "SELECT SchoolName FROM mentorwebdb.schools WHERE SchoolID=" . $row1['School1'] . ";";
		$result3 = mysql_query($sql3,$con);
		while($row2 = mysql_fetch_array($result3)) {
			$resultsArray[$resultsCount][8] = $row2['SchoolName'];
		}
		$resultsArray[$resultsCount][9] = $row1['CareerStatement'];
	}
	
	$sql3 = "SELECT COUNT(*) as NumOfEndorsements FROM mentorwebdb.endorsements WHERE EndorsedID=".$row['ID']." AND EndorsedAccountType=".$endorsed_account_type.";";
	$result3 = mysql_query($sql3,$con);
	while($row3 = mysql_fetch_array($result3)) {
		$resultsArray[$resultsCount][10] = $row3['NumOfEndorsements'];
	}
	
	$sql3 = "SELECT AVG(Rating) as AvgRating FROM mentorwebdb.endorsements WHERE EndorsedID=".$row['ID']." AND EndorsedAccountType=".$endorsed_account_type.";";
	$result3 = mysql_query($sql3,$con);
	while($row3 = mysql_fetch_array($result3)) {
		$resultsArray[$resultsCount][11] = round($row3['AvgRating'],1);
	}
	
	if($sortby == "distance") {
		$request2 = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . $user_zipcode . "&sensor=false");
		$json2 = json_decode($request2, true); 
		$lat2 = $json2['results'][0]['geometry']['location']['lat'];
		$lon2 = $json2['results'][0]['geometry']['location']['lng'];
	
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$total = $miles * 0.8684;
		$resultsArray[$resultsCount][12] = round($total,2);
	} else { 
		$resultsArray[$resultsCount][12] = NULL; 
	} 
}

if($sortby == "rating") {
	$temp = array();
	$unordered = 1;
	while($unordered > 0) {
		for($i = 1; $i < $resultsCount; $i++) {
			if($resultsArray[$i][11] < $resultsArray[$i+1][11]) {
				$unordered++;
				for($j = 1; $j <= 12; $j++) {
					$temp[$i][$j] = $resultsArray[$i][$j];
					$resultsArray[$i][$j] = $resultsArray[$i+1][$j];
					$resultsArray[$i+1][$j] = $temp[$i][$j];
				}
				break;
			} else { 
				$unordered = 0; 
			}
		}
	}
}

if($sortby == "distance") {
	/*$temp = array();
	$unordered = 1;
	while($unordered > 0) {
		for($i = 1; $i < $resultsCount; $i++) {
			if($resultsArray[$i][12] > $resultsArray[$i+1][12]) {
				$unordered++;
				for($j = 1; $j <= 12; $j++) {
					$temp[$i][$j] = $resultsArray[$i][$j];
					$resultsArray[$i][$j] = $resultsArray[$i+1][$j];
					$resultsArray[$i+1][$j] = $temp[$i][$j];
				}
				break;
			} else { 
				$unordered = 0; 
			}
		}
	}*/
}
?>