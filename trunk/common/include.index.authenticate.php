<?php

/**
 * Project:     Student Council Attendance
 * File:        include.index.authenticate.php
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

?>