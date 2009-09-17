<?php


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

function deleteCommitteeMembershipByMember($committee, $member){
	$query = "DELETE FROM committee_membership WHERE `committee` = " . $committee . " AND `member` = " . $member . " LIMIT 1;";
	$result = mysql_query($query);
}

?>