<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.todaysattendance.php
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
 
function report_todays_attendance(){
	$query = "SELECT * FROM v_attendance WHERE `meeting` = (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) ORDER BY `position_id`, `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_todays_quorum(){
	$query = "SELECT * FROM v_quorum WHERE `meeting` =  (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) LIMIT 1;";
	$result = mysql_query($query);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_today_meeting(){
	$query = "SELECT * FROM v_meetings WHERE `id` = (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) LIMIT 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_todays_need_to_join_committee(){
	$query  = "SELECT m.name, p.name position ";
	$query .= "FROM `members` m ";
	$query .= "JOIN `position` p ON m.position = p.id ";
	$query .= "WHERE m.id NOT IN( ";
	$query .= "  SELECT Distinct(m) FROM ( ";
	$query .= "    SELECT member m FROM committee_membership c ";
	$query .= "    UNION ";
	$query .= "  SELECT manager m FROM committees c) tmpa) ";
	$query .= "AND m.position != 17 AND m.position != 18 AND m.position != 20 ";
	$query .= "ORDER BY m.position, m.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_todays_new_achievement(){
	$query  = "SELECT m.name member, a.name achievement, a.description, a.points FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id ";
	$query .= "JOIN members m ON e.member = m.id ";
	$query .= "WHERE e.updated > ( ";
	$query .= "  SELECT mdate FROM meetings WHERE meeting_type = 1 ";
	$query .= "  ORDER BY mdate DESC ";
	$query .= "  LIMIT 1,1) ";
	$query .= "ORDER BY m.position, m.name, a.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

?>