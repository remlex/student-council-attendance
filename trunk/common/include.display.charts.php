<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.charts.php
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
 
function report_chart_member_distribution(){
	$query  = "SELECT 'Directors' name, 1 pid, COUNT(*) number ";
	$query .= "FROM members WHERE position < 10 ";
	$query .= "UNION ";
	$query .= "SELECT p.name, p.id, COUNT(*) number ";
	$query .= "FROM members m ";
	$query .= "JOIN position p ON m.position = p.id ";
	$query .= "WHERE position != 20 AND position > 9 ";
	$query .= "GROUP BY p.name, p.id ";
	$query .= "ORDER BY pid;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Member+Distribution&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_current_member_standing(){
	$query  = "SELECT count(*) number, sum(warning), sum(trouble) ";
	$query .= "FROM v_standing_g vsg ";
	$query .= "JOIN members m ON vsg.member = m.id ";
	$query .= "WHERE vsg.semester = (SELECT `id` FROM semester s WHERE s.startday < NOW() ORDER BY s.startday DESC LIMIT 1) ";
	$query .= "	AND vsg.meeting_type = 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$standing['good'] =  $row[0] - $row[1] - $row[2];
	$standing['warning'] =  $row[1];
	$standing['bad'] =  $row[2];
	
	//Generate the URL
	$url  = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Member+Standing+For+Current+Semester&chd=t:";
	$url .= $standing['good'] . "," . $standing['warning'] . "," . $standing['bad'];
	$url .= "&chs=500x200&chl=";
	$url .= "Good|Warning|Bad";
	return $url;
}


function report_chart_major_member_count($position){
	$query = "SELECT COUNT(*) number FROM members WHERE `position` = " . $position . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}
function report_chart_member_breakdown($position){
	$query = "SELECT `name` FROM `position` WHERE `id` = " . $position . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$positionname =  str_replace(" ", "+", $row[0]);
	
	$query  = "SELECT j.shortname name, count(*) number ";
	$query .= "FROM members m ";
	$query .= "JOIN major j ON m.major = j.id ";
	$query .= "JOIN position p ON m.position = p.id ";
	$query .= "WHERE p.id = " . $position . " ";
	$query .= "GROUP BY p.name, j.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=" . $positionname . "&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_committee_pie_chart(){
	$query  = "SELECT 'Not in a Committee' name, COUNT(DISTINCT(m.id)) number ";
	$query .= "FROM members m ";
	$query .= "LEFT JOIN committee_membership c ON m.id = c.member ";
	$query .= "WHERE c.id IS NULL ";
	$query .= "  AND m.position != 20 && m.position != 17 && m.position != 18 ";
	$query .= "UNION ";
	$query .= "SELECT 'In a Committee' name, COUNT(DISTINCT(m.id)) number ";
	$query .= "FROM members m ";
	$query .= "JOIN committee_membership c ON m.id = c.member ";
	$query .= "WHERE  m.position != 20 && m.position != 17 && m.position != 18;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Committee+Membership&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}


function report_chart_major_pie_chart(){
	$query = "SELECT j.shortname name, COUNT(*) as number ";
	$query .= "FROM members m ";
	$query .= "JOIN major j ON m.major = j.id ";
	$query .= "WHERE m.position != 20 && m.position != 17 && m.position != 18 ";
	$query .= "GROUP BY j.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Council+Members+by+Major&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}


?>