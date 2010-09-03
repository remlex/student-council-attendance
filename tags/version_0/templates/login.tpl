{**
 * Project:     Student Council Attendance
 * File:        login.tpl
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
 *}
{include file="header.tpl" title=Attendance}

<br />
<br />

<h2>Login</h2>

<FORM action="./index.php?page=process" method="post">
	<P>
	
	Username: <INPUT type="text" name="uname">
	<br />
	Password: <INPUT type="password" name="passwd">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('authenticate', 4){/php}">
	<input type="hidden" name="action" value="authenticate">
	<INPUT type="submit" value="Send">
	</P>
 </FORM>

{include file="footer.tpl"}