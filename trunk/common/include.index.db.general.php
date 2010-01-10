<?php

/**
 * Project:     Student Council Attendance
 * File:        include.index.db.general.php
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

?>