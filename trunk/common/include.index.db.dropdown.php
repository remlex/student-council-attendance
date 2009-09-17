<?php


function retreiveMajorValues(){
	$query = "SELECT `id`, `name` FROM `major` ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreivePositionValues(){
	$query = "SELECT `id`, `name` FROM `position` ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveStatusValues(){
	$query = "SELECT `id`, `name` FROM `status` ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveMeetingTypeValues(){
	$query = "SELECT `id`, `name` FROM `meeting_type` ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveSemesterValues(){
	$query = "SELECT `id`, CONCAT_WS(' ',`semester`,`year`) semester FROM semester ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveAttendanceMemberValues($meeting){
	$meeting_type = retreiveMeetingTypeForMeeting($meeting);
	$query = "SELECT `member`, `name` FROM v_member_dd WHERE member NOT IN (SELECT `member` FROM attendance WHERE `meeting` = " . $meeting . ") AND `meeting_type` = " . $meeting_type . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveAchievementCategoryValues(){
	$query = "SELECT `id`, `name` semester FROM achievement_category ORDER BY `id` ASC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

/* it's not that easy, we only want the achievements that the member DOESN'T already have...
function retreiveAchievementValues(){
	$query = "SELECT `id`, `name` FROM achievements a ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}
*/

function retreiveMembersAchivementsToEarnValues($member){
	$query = "SELECT `id`, `name` FROM achievements WHERE `id` NOT IN (SELECT achievement FROM achievements_earned WHERE member = " . $member . ") AND `lock` = 0;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveCommitteeMemberValues(){
	$query = "SELECT `id`,  CONCAT(`name`, ' (', `position`, ')') name FROM v_members m ORDER BY `position_id` , name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveCommitteeAddableMemberSelectionValues($committee){
	$query  = "SELECT `id`,  CONCAT(`name`, ' (', `position`, ')') name FROM v_members m ";
	$query .= "WHERE `id` NOT IN (SELECT `member` FROM committee_membership c WHERE c.committee = " . $committee . ") ";
	$query .= "  AND `id` != (SELECT `manager` FROM committees WHERE `id` = " . $committee . ") ";
	$query .= "ORDER BY `position_id` , name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

function retreiveAchievementAddableMemberSelectionValues($achievement){
	$query  = "SELECT `id`, CONCAT(`name`, ' (', `position`, ')') name FROM v_members m ";
	$query .= "WHERE m.id NOT IN (SELECT `member_id` FROM v_achievements_earned_all v WHERE v.achievement = " . $achievement . ") ";
	$query .= "ORDER BY `position_id`, `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_row($result)){
		$val[$row[0]] = $row[1];
	}
	return $val;
}

?>