<?php 
$con = mysql_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($_SESSION['user_account_login'] == 1) {
		$sql1 = "SELECT * FROM mentorwebdb.mentor_personal_info WHERE ID=" . $_SESSION['user_id'] . ";";
		$sql2 = "SELECT * FROM mentorwebdb.mentor_career_info WHERE ID=" . $_SESSION['user_id'] . ";";
		$result1 = mysql_query($sql1,$con);
		$result2 = mysql_query($sql2,$con);
	} elseif($_SESSION['user_account_login'] == 2) {
		$sql1 = "SELECT * FROM mentorwebdb.mentee_personal_info WHERE ID=" . $_SESSION['user_id'] . ";";
		$sql2 = "SELECT * FROM mentorwebdb.mentee_career_info WHERE ID=" . $_SESSION['user_id'] . ";";
		$result1 = mysql_query($sql1,$con);
		$result2 = mysql_query($sql2,$con);
	}
	while($row = mysql_fetch_array($result1)) {
		$FirstName = $row['FirstName'];
		$LastName = $row['LastName'];
		$ZipCode = $row['ZipCode'];
		$Phone = $row['Phone'];
		$Email = $row['Email'];
		$Birthday = $row['Birthday'];
		$ProfilePic = $row['ProfilePic'];
	}
	
	while($row = mysql_fetch_array($result2)) {
		if($row['MajorDegreeType1']) {
			$sql3 = "SELECT DegreeID,DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=" . $row['MajorDegreeType1'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorDegreeType1 = $row1['DegreeType'] . " of " . $row1['DegreeConc'];
				$MajorDegreePriority1 = $row1['DegreePriority'];
				$MajorDegreeID1 = $row1['DegreeID'];
			}
		
			$sql3 = "SELECT IndustryID,IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row['MajorIndustry1'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorIndustryID1 = $row1['IndustryID'];
				$MajorIndustry1 = $row1['IndustryCategory2'];
			}
			$sql3 = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools WHERE SchoolID=" . $row['School1'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorSchoolID1 = $row1['SchoolID'];
				$School1 = $row1['SchoolName'];
			}
		} else { 
			$MajorDegreeType1 = NULL; 
			$MajorIndustry1 = NULL;
			$School1 = NULL;
			$MajorDegreePriority1 = NULL;
		}
		
		if($row['MajorDegreeType2']) {
			$sql3 = "SELECT DegreeID,DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=" . $row['MajorDegreeType2'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorDegreeType2 = $row1['DegreeType'] . " of " . $row1['DegreeConc'];
				$MajorDegreePriority2 = $row1['DegreePriority'];
				$MajorDegreeID2 = $row1['DegreeID'];
			}
			$sql3 = "SELECT IndustryID,IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row['MajorIndustry2'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorIndustryID2 = $row1['IndustryID'];
				$MajorIndustry2 = $row1['IndustryCategory2'];
			}
			$sql3 = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools WHERE SchoolID=" . $row['School2'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorSchoolID2 = $row1['SchoolID'];
				$School2 = $row1['SchoolName'];
			}
		} else { 
			$MajorDegreeType2 = NULL; 
			$MajorIndustry2 = NULL;
			$School2 = NULL;
			$MajorDegreePriority2 = NULL;
		}
		
		if($row['MajorDegreeType3']) {
			$sql3 = "SELECT DegreeID, DegreeType,DegreeConc,DegreePriority FROM mentorwebdb.degrees WHERE DegreeID=" . $row['MajorDegreeType3'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorDegreeType3 = $row1['DegreeType'] . " of " . $row1['DegreeConc'];
				$MajorDegreePriority3 = $row1['DegreePriority'];
				$MajorDegreeID3 = $row1['DegreeID'];
			}
			$sql3 = "SELECT IndustryID,IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row['MajorIndustry3'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorIndustryID3 = $row1['IndustryID'];
				$MajorIndustry3 = $row1['IndustryCategory2'];
			}
			$sql3 = "SELECT SchoolID,SchoolName FROM mentorwebdb.schools WHERE SchoolID=" . $row['School3'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MajorSchoolID3 = $row1['SchoolID'];
				$School3 = $row1['SchoolName'];
			}
		} else { 
			$MajorDegreeType3 = NULL; 
			$MajorIndustry3 = NULL;
			$School3 = NULL;
			$MajorDegreePriority3 = NULL;
		}
		
		// Sorts the degrees from highest to lowest
		if($MajorDegreeType1 && $MajorDegreeType2 && $MajorDegreeType3) {
			if($MajorDegreePriority3 < $MajorDegreePriority1) {
				$tempDegreeType = $MajorDegreeType1;
				$tempIndustry = $MajorIndustry1;
				$tempSchool = $School1;
				$tempPriority = $MajorDegreePriority1;
				$tempDegreeID = $MajorDegreeID1;
				$MajorDegreeType1 = $MajorDegreeType3;
				$MajorIndustry1 = $MajorIndustry3;
				$School1 = $School3;
				$MajorDegreePriority1 = $MajorDegreePriority3;
				$MajorDegreeID1 = $MajorDegreeID3;
				$MajorDegreeType3 = $tempDegreeType;
				$MajorIndustry3 = $tempIndustry;
				$School3 = $tempSchool;
				$MajorDegreePriority3 = $tempPriority;
				$MajorDegreeID3 = $tempDegreeID;
				$tempIndustryID = $MajorIndustryID1;
				$MajorIndustryID1 = $MajorIndustryID3;
				$MajorIndustryID3 = $tempIndustryID;
				$tempSchoolID = $MajorSchoolID1;
				$MajorSchoolID1 =  $MajorSchoolID3;
				$MajorSchoolID3 = $tempSchoolID;
			}
			if($MajorDegreePriority2 < $MajorDegreePriority1) {
				$tempDegreeType = $MajorDegreeType1;
				$tempIndustry = $MajorIndustry1;
				$tempSchool = $School1;
				$tempPriority = $MajorDegreePriority1;
				$tempDegreeID = $MajorDegreeID1;
				$MajorDegreeType1 = $MajorDegreeType2;
				$MajorIndustry1 = $MajorIndustry2;
				$School1 = $School2;
				$MajorDegreePriority1 = $MajorDegreePriority2;
				$MajorDegreeID1 = $MajorDegreeID2;
				$MajorDegreeType2 = $tempDegreeType;
				$MajorIndustry2 = $tempIndustry;
				$School2 = $tempSchool;
				$MajorDegreePriority2 = $tempPriority;
				$MajorDegreeID2 = $tempDegreeID;
				$tempIndustryID = $$MajorIndustryID1;
				$MajorIndustryID1 = $MajorIndustryID2;
				$MajorIndustryID2 = $tempIndustryID;
				$tempSchoolID = $MajorSchoolID1;
				$MajorSchoolID1 =  $MajorSchoolID2;
				$MajorSchoolID2 = $tempSchoolID;
			}
			if($MajorDegreePriority3 < $MajorDegreePriority2) {
				$tempDegreeType = $MajorDegreeType2;
				$tempIndustry = $MajorIndustry2;
				$tempSchool = $School2;
				$tempPriority = $MajorDegreePriority2;
				$tempDegreeID = $MajorDegreeID2;
				$MajorDegreeType2 = $MajorDegreeType3;
				$MajorIndustry2 = $MajorIndustry3;
				$School2 = $School3;
				$MajorDegreePriority2 = $MajorDegreePriority3;
				$MajorDegreeID2 = $MajorDegreeID3;
				$MajorDegreeType3 = $tempDegreeType;
				$MajorIndustry3 = $tempIndustry;
				$School3 = $tempSchool;
				$MajorDegreePriority3 = $tempPriority;
				$MajorDegreeID3 = $tempDegreeID;
				$tempIndustryID = $$MajorIndustryID2;
				$MajorIndustryID2 = $MajorIndustryID3;
				$MajorIndustryID3 = $tempIndustryID;
				$tempSchoolID = $MajorSchoolID2;
				$MajorSchoolID2 =  $MajorSchoolID3;
				$MajorSchoolID3 = $tempSchoolID;
			}
		} elseif($MajorDegreeType1 && $MajorDegreeType2) {
			if($MajorDegreePriority2 < $MajorDegreePriority1) {
				$tempDegreeType = $MajorDegreeType1;
				$tempIndustry = $MajorIndustry1;
				$tempSchool = $School1;
				$tempPriority = $MajorDegreePriority1;
				$tempDegreeID = $MajorDegreeID1;
				$MajorDegreeType1 = $MajorDegreeType2;
				$MajorIndustry1 = $MajorIndustry2;
				$School1 = $School2;
				$MajorDegreePriority1 = $MajorDegreePriority2;
				$MajorDegreeID1 = $MajorDegreeID2;
				$MajorDegreeType2 = $tempDegreeType;
				$MajorIndustry2 = $tempIndustry;
				$School2 = $tempSchool;
				$MajorDegreePriority2 = $tempPriority;
				$MajorDegreeID2 = $tempDegreeID;
				$tempIndustryID = $$MajorIndustryID1;
				$MajorIndustryID1 = $MajorIndustryID2;
				$MajorIndustryID2 = $tempIndustryID;
				$tempSchoolID = $MajorSchoolID1;
				$MajorSchoolID1 =  $MajorSchoolID2;
				$MajorSchoolID2 = $tempSchoolID;
			}
		}
		
		if($row['MinorIndustry1']) {
			$sql3 = "SELECT IndustryID,IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row['MinorIndustry1'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MinorIndustryID1 = $row1['IndustryID'];
				$MinorIndustry1 = $row1['IndustryCategory2'];
			}
		} else {
			$MinorIndustry1 = NULL;
			$MinorIndustryID1 = NULL;
		}
		
		if($row['MinorIndustry2']) {
			$sql3 = "SELECT IndustryID,IndustryCategory2 FROM mentorwebdb.industries WHERE IndustryID=" . $row['MinorIndustry2'] . ";";
			$result3 = mysql_query($sql3,$con);
			while($row1 = mysql_fetch_array($result3)) {
				$MinorIndustryID2 = $row1['IndustryID'];
				$MinorIndustry2 = $row1['IndustryCategory2'];
			}
		} else {
			$MinorIndustry2 = NULL;
			$MinorIndustryID2 = NULL;
		}
		
		$CareerStatement = $row['CareerStatement'];
		$CurrentCompany = $row['CurrentCompany'];
		$CurrentPosition = $row['CurrentPosition'];
		$CurrentStartDate = $row['CurrentStartDate'];
		$CurrentStartDateFormat = substr($row['CurrentStartDate'],0,4) . "-" . substr($row['CurrentStartDate'],5,2);
		$CurrentDescription = $row['CurrentDescription'];
		$PreviousCompany1 = $row['PreviousCompany1'];
		$PreviousPosition1 = $row['PreviousPosition1'];
		$PreviousStartDate1 = $row['PreviousStartDate1'];
		$PreviousStartDate1Format = substr($row['PreviousStartDate1'],0,4) . "-" . substr($row['PreviousStartDate1'],5,2);
		$PreviousEndDate1 = $row['PreviousEndDate1'];
		$PreviousEndDate1Format = substr($row['PreviousEndDate1'],0,4) . "-" . substr($row['PreviousEndDate1'],5,2);
		$PreviousDescription1 = $row['PreviousDescription1'];
		$PreviousCompany2 = $row['PreviousCompany2'];
		$PreviousPosition2 = $row['PreviousPosition2'];
		$PreviousStartDate2 = $row['PreviousStartDate2'];
		$PreviousStartDate2Format = substr($row['PreviousStartDate2'],0,4) . "-" . substr($row['PreviousStartDate2'],5,2);
		$PreviousEndDate2 = $row['PreviousEndDate2'];
		$PreviousEndDate2Format = substr($row['PreviousEndDate2'],0,4) . "-" . substr($row['PreviousEndDate2'],5,2);
		$PreviousDescription2 = $row['PreviousDescription2'];
		//$ = $row[''];
	}
?>