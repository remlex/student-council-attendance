<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.perfectattendance.php
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
 
function report_perfect_attendance_semester(){
	$query = "SELECT CONCAT_WS(' ',`semester`, `year`) semester FROM semester WHERE startday < NOW() ORDER BY startday DESC LIMIT 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function report_perfect_attendance(){
	$query  = "SELECT * FROM ( ";
	$query .= "SELECT a.member, count(*) total, sum(if(a.status=2,1,0)) present, e.name, e.position ";
	$query .= "FROM attendance a ";
	$query .= "JOIN meetings m ON a.meeting = m.id ";
	$query .= "JOIN members e ON a.member = e.id ";
	$query .= "WHERE m.semester = (SELECT `id` FROM semester WHERE startday < NOW() ORDER BY startday DESC LIMIT 1) ";
	$query .= "  AND m.meeting_type = 1 ";
	$query .= "  AND m.mdate < NOW() ";
	$query .= "GROUP BY member ) tmp ";
	$query .= "WHERE total = present ";
	$query .= "ORDER BY position, name; ";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

?>