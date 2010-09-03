<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.attendance.php
 *
 * Student Council Attendance is free software: you can redistribute 
 * it and/or modify it under the terms of the GNU General Public 
 * License as published by the Free Software Foundation, either 
 * version 3 of the License, or (at your option) any later version.
 * 
 * Student Council Attendance is distributed in the hope that it will 
 * be useful, but WITHOUT ANY WARRANTY; without even the implied 
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Student Council Attendance.  If not, see 
 * http://www.gnu.org/licenses/.
 *
 * @link http://code.google.com/p/student-council-attendance/
 * @copyright 2009 Speed School Student Council
 * @author Jared Hatfield
 * @package student-council-attendance
 * @version 1.0
 */
 
function report_memester_meting_type(){
	$query  = "SELECT s.id semester, s.year, s.semester, s.startday, t.id meeting_type, t.name, ";
	$query .= "  (SELECT COUNT(*) FROM meetings m WHERE m.semester = s.id AND m.meeting_type = t.id AND m.mdate < NOW()) num ";
	$query .= "FROM semester s ";
	$query .= "JOIN meeting_type t ";
	$query .= "WHERE s.startday < NOW() ";
	$query .= "ORDER BY s.startday, t.id;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_meetings($meeting_type){
	$query = "SELECT `id`, `year`, `semester`, `startday` FROM semester WHERE `startday` < NOW() ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	for($i = 0; $i < sizeof($val); $i++){
		$query  = "SELECT q.meeting, m.mdate, q.TotalMembers, q.TotalPresent, q.VotingMembers, q.VotingPresent, q.Quorum, q.QuorumTest ";
		$query .= "FROM v_quorum q ";
		$query .= "JOIN meetings m ON q.meeting = m.id ";
		$query .= "WHERE `semester` = " . $val[$i]['id'] . " AND `meeting_type` = " . $meeting_type . " AND mdate < NOW() ";
		$query .= "ORDER BY mdate DESC;";
		
		$result = mysql_query($query);
		$val[$i]['meetings'] = array();
		while($row = mysql_fetch_assoc($result)){
			$val[$i]['meetings'][] = $row;
		}
		
	}
	return $val;
}

function report_meeting_quorum($id){
	$query = "select `TotalMembers`, `TotalPresent`, `VotingMembers`, `VotingPresent`, `Quorum`, `QuorumTest` from v_quorum WHERE `meeting` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_meeting_info($id){
	$query = "SELECT `id`, `mdate`, `meeting_type`, `year`, `semester`, `description`, `semester_id`, `meeting_type_id` FROM v_meetings WHERE `id` = " . $id . "";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_meeting($id){
	$query  = "SELECT a.*, t.member, s.name status_name FROM v_attendance a ";
	$query .= "JOIN `status` s ON a.`status` = s.id ";
	$query .= "JOIN attendance t ON a.id = t.id ";
	$query .= "WHERE a.`meeting` = " . $id . " ";
	$query .= "ORDER BY a.`position_id`, a.`name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}


?>