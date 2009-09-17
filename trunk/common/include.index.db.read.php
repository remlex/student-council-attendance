<?php


//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE SEMESTER INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveSemesters(){
	$query = "SELECT `id`, `year`, `semester`, `startday` FROM semester ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveSemester($id){
	$query = "SELECT `id`, `year`, `semester`, `startday` FROM semester s WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function defaultSemester(){
	$query = "SELECT `id` FROM semester s ORDER BY `startday` DESC LIMIT 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveSemesterChildrenCount($id){
	$query = "SELECT `children` FROM v_semester_children WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE MEMBER INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveActiveMembers(){
	$query = "select `id`, `name`, `ulink`, `position`, `status`, `vote`, `quorum` from v_members ORDER BY `position_id`, `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveInactiveMembers(){
	$query = "select `id`, `name`, `ulink`, `position`, `status`, `vote`, `quorum` from v_members_non;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveMember($id){
	$query = "SELECT `id`, `name`, `ulink`, `position`, `status`, `major`, `student_id` FROM members WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}


//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE MEETING INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveMeeting($id){
	$query = "SELECT `id`, `mdate`, `meeting_type`, `semester`, `description` FROM meetings WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function retreiveMeetings($semester){
	$query = "SELECT `id`, `mdate`, `meeting_type`, `year`, `semester`, `description` FROM v_meetings m WHERE semester_id = " . $semester . " ORDER BY mdate DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveSemesterIdForMeeting($meeting){
	$query = "SELECT `semester` FROM meetings WHERE `id` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveMeetingTypeForMeeting($meeting){
	$query = "SELECT `meeting_type` FROM meetings WHERE `id` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}


function retreiveMeetingChildrenCount($meeting){
	$query = "SELECT `children` FROM v_meetings_children WHERE `id` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE ATTENDANCE INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveAttendance($meeting){
	$query = "SELECT `id`, `name`, `position`, `status`, `vote`, `present`, `quorum`  FROM v_attendance v WHERE meeting = " . $meeting . " ORDER BY `position_id`, `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveMeetingNameForAttendance($meeting){
	$query = "SELECT CONCAT_WS(' ', `meeting_type`, '-', `semester`, `year`, '-', `mdate`) meet FROM v_meetings m WHERE `id` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveStatusForMemberAttendanceRecord($attendance){
	$query = "SELECT `status` FROM attendance WHERE `id` = " . $attendance . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveAdditionalAttendanceMemberCount($meeting){
	$meeting_type = retreiveMeetingTypeForMeeting($meeting);
	$query = "SELECT COUNT(*) num FROM v_member_dd WHERE member NOT IN (SELECT `member` FROM attendance WHERE `meeting` = " . $meeting . ") AND `meeting_type` = " . $meeting_type . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveAttendanceMeetingLock($meeting){
	$query = "SELECT `lock` FROM meetings m WHERE `id` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveAttendanceMeetingId($attendance){
	$query = "SELECT `meeting` FROM attendance WHERE `id` = " . $attendance . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}
function retreiveAttendanceLock($attendance){
	$meeting = retreiveAttendanceMeetingId($attendance);
	return retreiveAttendanceMeetingLock($meeting);
}

function retreiveAttendanceRecordWithName($attendance){
	$query = "SELECT `id`, `name`, `position_id` position, `status` FROM v_attendance WHERE `id` = " . $attendance . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE QUORUM INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function currentQuorum(){
	$query = "select CEIL(SUM(quorum)*.5)+1 quorum from v_members;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveQuorumDetails($meeting){
	$query = "SELECT `TotalMembers`, `TotalPresent`, `VotingMembers`, `VotingPresent`, `Quorum`, `QuorumTest` FROM v_quorum WHERE `meeting` = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}



//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE ACHIEVEMENT INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveAchivements(){
	$query = "SELECT `id`, `category`, `image`, `name`, `description`, `goal`, `points`, `added`, `lock` FROM v_achievements ORDER BY category DESC, added DESC, points DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveAchievement($id){
	$query = "SELECT `id`, `category`, `name`, `image`, `description`, `goal`, `points`, `added`, `lock` FROM achievements WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function retreiveAchievementChildrenCount($achievement){
	$query = "SELECT `children` FROM v_achievement_children WHERE `id` = " . $achievement . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveAchievementLock($achievement){
	$query = "SELECT `lock` FROM achievements WHERE `id` = " . $achievement . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveAchievementsEarned($achievement){
	$query = "SELECT `id`, `member_id`, `member`, `progress` FROM v_achievements_earned_all v WHERE `achievement` = " . $achievement . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveAchievementsEarnedAchievementId($achievementearned){
	$query = "SELECT  `achievement` FROM achievements_earned WHERE `id` = " . $achievementearned . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE MEMBER ACHIEVEMENT INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveMemberAchievementList($id){
	$query  = "SELECT e.id, e.achievement, e.progress, a.goal, a.name, a.description, a.lock FROM achievements_earned e ";
	$query .= "JOIN achievements a ON a.id = e.achievement WHERE `member` = " . $id . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}


//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE COMMITTEE INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//
function retreiveCommittees(){
	$query = "SELECT `id`, `name`, `description`, `manager`, `members` FROM v_committees v;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveCommittee($id){
	$query = "SELECT `id`, `manager`, `name`, `description` FROM committees WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function retreiveCommitteeMembers($id){
	$query = "SELECT c.id, c.committee, c.member, m.name member FROM committee_membership c JOIN members m ON c.member = m.id WHERE c.committee = " . $id . " ORDER BY m.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function retreiveCommitteeChildrenCount($committee){
	$query = "SELECT `children` FROM v_committee_children WHERE `id` = " . $committee . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function retreiveCommitteeMembershipCommitteeId($id){
	$query = "SELECT `committee` FROM committee_membership WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}




//----------------------------------------------------------------------------------------------------------------------------------//
//RETREIVE MEMBER COMMITTEE INFORMATION
//----------------------------------------------------------------------------------------------------------------------------------//s
function retreiveCommitteeMemberToJoin($member){
	$query  = "SELECT c.id, c.name, c.description, m.name manager_name, c.manager, ";
	$query .= "  IF(manager = " . $member . ", 1, IF((SELECT COUNT(*) is_member FROM committee_membership cmp ";
	$query .= "      WHERE `member` = " . $member . " AND c.`id` = cmp.committee) = 1, 1, 0)) is_member, ";
	$query .= "  (SELECT cmp.`id` membership FROM committee_membership cmp WHERE `member` = 3 AND cmp.committee = c.`id`) membership ";
	$query .= "FROM committees c ";
	$query .= "JOIN members m ON c.manager = m.id ORDER BY c.`id`; ";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}


?>