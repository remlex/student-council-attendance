<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.members.php
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
 
function report_members(){
	$query = <<<QUERY
	SELECT `id`, `name`, `position`, `warning`, `trouble`,
	  IFNULL(`committees`,0) committees,
	  IFNULL(`committee_head`,0) committee_head,
	  IFNULL(`total_achievements`,0) total_achievements,
	  IFNULL(`council_points`,0) council_points
	FROM v_members m
	LEFT JOIN (SELECT `member`, `warning`, `trouble` FROM v_standing_g vsg
			WHERE vsg.semester = (SELECT `id` FROM semester s WHERE s.startday < NOW() ORDER BY s.startday DESC LIMIT 1)
			AND vsg.meeting_type = 1) g
		ON m.id = g.member
	LEFT JOIN (SELECT `member`, COUNT(*) committees FROM committee_membership GROUP BY `member`) com
	  ON m.id = com.member
	LEFT JOIN (SELECT `member`, COUNT(*) total_achievements, SUM(`points`) council_points
		  FROM achievements_earned e
		  JOIN achievements a ON e.achievement = a.id
		  WHERE e.progress >= a.goal
		  GROUP BY member) a
	  ON m.id = a.member
	LEFT JOIN (SELECT `manager` committee_manager, COUNT(*) committee_head FROM committees GROUP BY `manager`) h
	  ON m.id = h.committee_manager
	ORDER BY `position_id`, `name`;
QUERY;
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_member_summary($id){
	$query = "SELECT `semester`, `meeting_type`, `position`, `Unknown`, `Present`, `Absent`, `Excused`, `CoOp`, `warning`, `trouble` FROM v_reports_member_summary WHERE `member` = " . $id . " ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_member_info($id){
	$query  = "SELECT m.name, p.name position, s.name status, j.name major ";
	$query .= "FROM `members` m ";
	$query .= "JOIN `position` p ON m.`position` = p.id ";
	$query .= "JOIN `status` s ON m.`status` = s.id ";
	$query .= "JOIN `major` j ON m.major = j.id ";
	$query .= "WHERE m.id = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_member_details($id){
	$query = "SELECT `meeting_id`, `mdate`, `semester`, `meeting_type`, `position`, `status` FROM v_reports_member_details WHERE `member` = " . $id . " ORDER BY mdate DESC";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}



?>