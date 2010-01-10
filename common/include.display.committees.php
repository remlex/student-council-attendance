<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.committees.php
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
 
function report_committee_manager($id){
	$query  = "SELECT c.`id`, c.`name`, c.`description`, COUNT(*) members FROM committees c ";
	$query .= "LEFT JOIN committee_membership m ON c.id = m.committee WHERE `manager` = " . $id . " GROUP BY c.`id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_committee_involvement($id){
	$query  = "SELECT m.`id`, `member` member_id, `committee` committee_id, s.name manager, c.`name` committee_name, c.`description` ";
	$query .= "FROM committee_membership m JOIN committees c ON m.committee = c.id ";
	$query .= "JOIN members s ON c.manager = s.id WHERE `member` = " . $id . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}
function report_member_committee_count($id){
	$query = "SELECT (SELECT COUNT(*) num FROM committees WHERE `manager` = " . $id . ") + (SELECT COUNT(*) num FROM committee_membership WHERE `member` = " . $id . ") committee_count";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}





function report_committee_categories(){
	$query = "SELECT c.`id`, m.`id` manager_id, m.`name` manager, p.name position, c.`name`, `description` FROM committees c JOIN members m ON c.manager = m.id JOIN position p on m.position = p.id ORDER BY c.id;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_committee_membership(){
	$committees = report_committee_categories();
	for($i = 0; $i < sizeof($committees); $i++){
		$query  = "SELECT m.`id`, m.`name` member, p.`name` position FROM committee_membership c ";
		$query .= "JOIN members m ON c.member = m.id JOIN position p on m.position = p.id WHERE c.`committee` = " . $committees[$i]['id'];
		$query .= " ORDER BY m.position, m.name;";
		$result = mysql_query($query);
		$val = array();
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
		$committees[$i]['members'] = $val;
	}
	return $committees;
}

function report_committee_membership_single($committee){
	$committees = report_committee_categories();
	for($i = 0; $i < sizeof($committees); $i++){
		//Only include the one committee
		if($committees[$i]['id'] == $committee){
			$query  = "SELECT m.`id`, m.`name` member, p.`name` position FROM committee_membership c ";
			$query .= "JOIN members m ON c.member = m.id JOIN position p on m.position = p.id WHERE c.`committee` = " . $committees[$i]['id'];
			$query .= " ORDER BY m.position, m.name;";
			$result = mysql_query($query);
			$val = array();
			while($row = mysql_fetch_assoc($result)){
				$val[] = $row;
			}
			$committees[$i]['members'] = $val;
			//Only return the sub segment of the committee array (lets us use the same template)
			$sub[0] = $committees[$i];
			return $sub;
		}
	}
}

?>