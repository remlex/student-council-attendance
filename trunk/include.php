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
 
include_once './configs/db.php'; //Connects to the database

include_once './common/include.index.authenticate.php';

//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE DON'T TOUCH A DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
include_once './common/include.index.general.php';

//----------------------------------------------------------------------------------------------------------------------------------//
// CLEAN THINGS BEFORE THEY TOUCH A DATABASE
//----------------------------------------------------------------------------------------------------------------------------------//
include_once './common/include.index.db.general.php';


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE READ FROM THE DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
include_once './common/include.index.db.dropdown.php';
include_once './common/include.index.db.read.php';


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// THESE MODIFY THE DATABSE
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
include_once './common/include.index.db.modify.php';





?>