<?php
include_once './configs/db.php'; //Connects to the database




//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE DON'T TOUCH A DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//

function retreiveAchievementGoalValues(){
	$goal = array();
	for($i = 1; $i <= 10; $i++){
		$goal[$i] = $i;
	}
	return $goal;
}

function retreiveAchievementProgressValues($max){
	$goal = array();
	for($i = 1; $i <= $max; $i++){
		$goal[$i] = $i;
	}
	return $goal;
}

function retreiveAchievementPointsValues(){
	$points = array();
	for($i = 0; $i <= 200; $i += 5){
		$points[$i] = $i;
	}
	return $points;
}

//----------------------------------------------------------------------------------------------------------------------------------//
// CLEAN THINGS BEFORE THEY TOUCH A DATABASE
//----------------------------------------------------------------------------------------------------------------------------------//
function db_clean_int($val){
	$val = mysql_escape_string($val);
	$val = intval($val);
	return $val;
}

function db_clean_text($val){
	$val = mysql_escape_string($val);
	return $val;
}

function smartyDateToDate($year, $month, $day){
	$date = $year . "-";
	if($month < 10){
		$date .= "0" . $month . "-";
	}
	else{
		$date .= $month . "-";
	}
	
	if($day < 10){
		$date .= "0" . $day;
	}
	else{
		$date .= $day;
	}
	return $date;
}


function authenticate($user, $pass){
	$authentication['user'] = "myusername"; //This is just for demo purposes
	$authentication['pass'] = "mypassword"; //This is just for demo purposes
	if($user == $authentication['user'] && $pass == $authentication['pass']){
		return true;
	}
	else{
		return false;
	}
}



//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE READ FROM THE DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//


//----------------------------------------------------------------------------------------------------------------------------------//
// RETREIVE INFORMATION FOR USE IN DROP DOWN LISTS
//----------------------------------------------------------------------------------------------------------------------------------//
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






//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE MODIFY THE DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//


//----------------------------------------------------------------------------------------------------------------------------------//
// CHANGE A SINGLE MEMBERS STATUS FOR A SINGLE MEETING
//----------------------------------------------------------------------------------------------------------------------------------//
function attendanceUpdateStatus($attendance, $status){
	$query = "UPDATE attendance SET `status` = " . $status . " WHERE `id` = " . $attendance . " LIMIT 1;";
	$result = mysql_query($query);
}


//----------------------------------------------------------------------------------------------------------------------------------//
// ADD ALL OF THE MEMBERS TO A MEETINGS ATTENDANCE LIST
//----------------------------------------------------------------------------------------------------------------------------------//
function addMembersToAttendance($meeting){
	$query = "SELECT COUNT(*) num FROM attendance WHERE meeting = " . $meeting . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$attendanceCount = $row[0];
	
	if($attendanceCount > 0){
		//We don't automatically add members to attendance if there is already members added
	}
	else {
		$query  = "INSERT INTO attendance (`meeting`, `member`, `position`, `status`) ";
		$query .= "SELECT m.id meeting, r.member, r.position, r.status ";
		$query .= "FROM v_members_require r ";
		$query .= "JOIN meetings m ON r.meeting_type = m.meeting_type ";
		$query .= "WHERE m.id = " . $meeting . ";";
		mysql_query($query);
	}
}


//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE A SEMESTER
//----------------------------------------------------------------------------------------------------------------------------------//
function addSemester($semester, $date_day, $date_month, $date_year){
	$date = smartyDateToDate($date_year, $date_month, $date_day);
	$query = "INSERT INTO semester (`year`, `semester`, `startday`) VALUES ('" . $date_year . "', '" . $semester . "', '" . $date . "');";
	$result = mysql_query($query);
}

function updateSemester($id, $semester, $date_day, $date_month, $date_year){
	$date = smartyDateToDate($date_year, $date_month, $date_day);
	$query = "UPDATE semester SET `year` = '" . $date_year . "', `semester` = '" . $semester . "', `startday` = '" . $date . "' WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}

function deleteSemester($id){
	$query = "DELETE FROM semester WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}

//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE A SEMESTER
//----------------------------------------------------------------------------------------------------------------------------------//
function addMeeting($m_day, $m_month, $m_year, $meeting_type, $semester, $description){
	$date = smartyDateToDate($m_year, $m_month, $m_day);
	$query = "INSERT INTO meetings (`mdate`, `meeting_type`, `semester`, `description`) VALUES('" . $date . "', " . $meeting_type . ", " . $semester . ", '" . $description . "');";
	$result = mysql_query($query);
}

function updateMeeting($id, $m_day, $m_month, $m_year, $meeting_type, $semester, $description){
	$date = smartyDateToDate($m_year, $m_month, $m_day);
	$query = "UPDATE meetings SET `mdate` = '" . $date . "', `meeting_type` = " . $meeting_type . ", `semester` = " . $semester . ", `description` = '" . $description . "' WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}

function deleteMeeting($id){
	$query = "DELETE FROM meetings WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}

//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD A MEMBER (We don't delete members, we make them inactive...)
//----------------------------------------------------------------------------------------------------------------------------------//
function addMember($name, $ulink, $position, $status, $major, $student_id){
	$query  = "INSERT INTO members (`name`, `ulink`, `position`, `status`, `major`, `student_id`) ";
	$query .= "VALUES('" . $name . "', '" . $ulink . "', " . $position . ", " . $status . ", " . $major . ", " . $student_id . ");";
	$result = mysql_query($query);
}

function updateMember($id, $name, $ulink, $position, $status, $major, $student_id){
	$query  = "UPDATE members SET `name` = '" . $name . "', `ulink` = '" . $ulink . "', ";
	$query .= "`position` = " . $position . ", `status` = " . $status . ", `major` = " . $major . ", `student_id` = " . $student_id;
	$query .= " WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}

//----------------------------------------------------------------------------------------------------------------------------------//
// TOGGLE A MEETING LOCK
//----------------------------------------------------------------------------------------------------------------------------------//
function toggleMeetingLock($meeting){
	$lock = retreiveAttendanceMeetingLock($meeting);
	if($lock == 0){
		$query = "UPDATE meetings SET `lock` = 1 WHERE `id` = " . $meeting ." LIMIT 1;";
	}
	else{
		$query = "UPDATE meetings SET `lock` = 0 WHERE `id` = " . $meeting . " LIMIT 1;";
	}
	$result = mysql_query($query);
}

//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE AN ATTENDANCE ENTRY
//----------------------------------------------------------------------------------------------------------------------------------//

function addAttendance($member, $meeting){
	$query = "INSERT INTO attendance (`meeting`, `member`, `position`, `status`) SELECT " . $meeting . ", `id`, `position`, `status` FROM members WHERE `id` = " . $member . " LIMIT 1;";
	$result = mysql_query($query);
}

function updateAttendance($attendance, $position, $status){
	$query = "UPDATE attendance SET `position` = " . $position . ", `status` = " . $status . " WHERE `id` = " . $attendance . " LIMIT 1;";
	$result = mysql_query($query);
}

function deleteAttendance($attendance){
	$query = "DELETE FROM attendance WHERE `id` = " . $attendance . " LIMIT 1;";
	$result = mysql_query($query);
}


//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE AN ACHIEVEMENT
//----------------------------------------------------------------------------------------------------------------------------------//
function addAchievement($category, $name, $image, $description, $goal, $points){
	$query  = "INSERT INTO achievements (`category`, `name`, `image`, `description`, `goal`, `points`, `added`) ";
	$query .= "VALUES (" . $category . ", '" . $name . "', '" . $image . "', '" . $description . "', " . $goal . ", " . $points . ", NOW());";
	$result = mysql_query($query);
}

function updateAchievement($achievement, $category, $name, $image, $description, $goal, $points){
	$query = "UPDATE achievements SET `category` = " . $category . ", `name` = '" . $name . "', `image` = '" . $image . "', `description` = '" . $description . "', `goal` = " . $goal . ", `points` = " . $points . " WHERE `id` = " . $achievement . " LIMIT 1;";
	$result = mysql_query($query);
}

function deleteAchievement($achievement){
	$query = "DELETE FROM achievements WHERE `id` = " . $achievement . " LIMIT 1;";
	$result = mysql_query($query);
}


//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE AN ACHIEVEMENTS EARNED
//----------------------------------------------------------------------------------------------------------------------------------//
function addAchievementsEarned($member, $achievement, $progress){
	$query = "INSERT INTO achievements_earned (`member`, `achievement`, `progress`, `updated`) VALUES(" . $member . ", " . $achievement . ", " . $progress . ", NOW());";
	$result = mysql_query($query);
}

function deleteAchievementsEarned($achievement){
	$query = "DELETE FROM achievements_earned WHERE `id` = " . $achievement . " LIMIT 1;";
	$result = mysql_query($query);
}

function increaseAchievementsEarnedProgress($id){
	$query = "SELECT `achievement`, `progress` FROM achievements_earned WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$earned = mysql_fetch_row($result);
	$achievement = retreiveAchievement($earned[0]);
	
	$goal = $achievement['goal'];
	$progress = $earned[1];
	
	//We aren't already at the goal so we can move our progress upward...
	if($progress < $goal){
		$query = "UPDATE achievements_earned SET `progress` = " . ($progress + 1) . ", `updated` = NOW() WHERE `id` = " . $id . ";";
		$result = mysql_query($query);
	}
}

function decreaseAchievementsEarnedProgress($id){
	$query = "SELECT `achievement`, `progress` FROM achievements_earned WHERE `id` = " . $id . ";";
	$result = mysql_query($query);
	$earned = mysql_fetch_row($result);
	
	$progress = $earned[1];
	//We can only decrease if it is greater than 1
	if($progress > 1){
		$query = "UPDATE achievements_earned SET `progress` = " . ($progress - 1) . ", `updated` = NOW() WHERE `id` = " . $id . ";";
		$result = mysql_query($query);
	}
}


//----------------------------------------------------------------------------------------------------------------------------------//
// TOGGLE AN ACHIEVEMENT LOCK
//----------------------------------------------------------------------------------------------------------------------------------//
function toggleAchievementLock($achievement){
	$lock = retreiveAchievementLock($achievement);
	if($lock == 0){
		$query = "UPDATE achievements SET `lock` = 1 WHERE `id` = " . $achievement ." LIMIT 1;";
	}
	else{
		$query = "UPDATE achievements SET `lock` = 0 WHERE `id` = " . $achievement . " LIMIT 1;";
	}
	$result = mysql_query($query);
}


//----------------------------------------------------------------------------------------------------------------------------------//
// UPDATE / ADD / DELETE AN COMMITTEE ENTRY
//----------------------------------------------------------------------------------------------------------------------------------//
function addCommittee($manager, $name, $description){
	$query = "INSERT INTO committees (`manager`, `name`, `description`) VALUES (" . $manager . ", '" . $name . "', '" . $description . "');";
	$result = mysql_query($query);
}

function updateCommittee($committee, $manager, $name, $description){
	$query = "UPDATE committees SET `manager` = " . $manager . ", `name` = '" . $name . "', `description` = '" . $description . "' WHERE `id` = " . $committee . " LIMIT 1;";
	$result = mysql_query($query);
}

function deleteCommittee($committee){
	$query = "DELETE FROM committees WHERE `id` = " . $committee . " LIMIT 1;";
	$result = mysql_query($query);
}

//----------------------------------------------------------------------------------------------------------------------------------//
// ADD / DELETE AN COMMITTEE MEMBERSHIP ENTRY
//----------------------------------------------------------------------------------------------------------------------------------//
function addCommitteeMembership($committee, $member){
	$query = "INSERT INTO committee_membership (`committee`, `member`) VALUES (" . $committee . ", " . $member . ");";
	$result = mysql_query($query);
}

function deleteCommitteeMembership($id){
	$query = "DELETE FROM committee_membership WHERE `id` = " . $id . " LIMIT 1;";
	$result = mysql_query($query);
}







?>