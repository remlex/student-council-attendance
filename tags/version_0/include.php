<?php

/**
 * Project:     Student Council Attendance
 * File:        include.php
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

// Connect to the database
$link = mysql_connect($_CONFIG['host'], $_CONFIG['username'], $_CONFIG['password']) or die('Could not connect to mysql server.' );
mysql_select_db($_CONFIG['database'], $link) or die('Could not select database.');

// Include all of the required files
include_once './common/form.incl.php';
include_once './common/include.index.authenticate.php';
include_once './common/include.index.general.php';
include_once './common/include.index.db.general.php';
include_once './common/include.index.db.dropdown.php';
include_once './common/include.index.db.read.php';
include_once './common/include.index.db.modify.php';


?>