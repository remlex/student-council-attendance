<?php

/**
 * Project:     Student Council Attendance
 * File:        include.display.recentachievements.php
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
 
function report_recently_earned_achievements_date(){
	$query = "SELECT MAX(`updated`) updated FROM v_achievements_earned;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function report_recently_earned_achievements(){
	$query  = "SELECT `member_id`, `member`, `achievement`, `category`, `name`, `description`, `image`, `points` ";
	$query .= "FROM v_achievements_earned ";
	$query .= "WHERE `updated` = (SELECT MAX(`updated`) FROM v_achievements_earned) ";
	$query .= "ORDER BY `category_id`, `achievement`, `member`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	$arr = $val;
	
	$cat = array();
	for($i = 0; $i < sizeof($arr); $i++){
		if(!in_array($arr[$i]['achievement'], $cat, true)){
			$cat[] = $arr[$i]['achievement'];
		}
	}
	
	$items = array();
	for($i = 0; $i < sizeof($cat); $i++){
		$items[$i]['achievement'] = $cat[$i];
		for($k = 0; $k < sizeof($arr); $k++){
			if($cat[$i] == $arr[$k]['achievement']){
				$items[$i]['category'] = $arr[$k]['category'];
				$items[$i]['name'] = $arr[$k]['name'];
				$items[$i]['description'] = $arr[$k]['description'];
				$items[$i]['image'] = $arr[$k]['image'];
				$items[$i]['points'] = $arr[$k]['points'];
				//break;
				
				$mem = Array();
				$mem['id'] = $arr[$k]['member_id'];
				$mem['name'] = $arr[$k]['member'];
				$items[$i]['members'][] = $mem;
			}
		}
	}
	return $items;
}


?>