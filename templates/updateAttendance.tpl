{**
 * Project:     Student Council Attendance
 * File:        updateAttendance.tpl
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

<h2>Update Attendance</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listAttendance&meeting={$meeting}">{#images_back#}</a>
{#images_divider#}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteAttendance', 60, $this->get_template_vars('attendance_id')){/php}">
	<input type="hidden" name="id" value="{$attendance_id}">
	<input type="hidden" name="action" value="deleteAttendance">
	<INPUT type="image" src="{#url_delete#}">
{#images_divider#}
{#images_blank#}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	Name: {$attendance_name}
	<br />
	Position:<select name=position>{html_options options=$positions selected=$attendance_position}</select>
	<br />
	Status:<select name=status>{html_options options=$status selected=$attendance_status}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateAttendance', 60, $this->get_template_vars('attendance_id')){/php}">
	<input type="hidden" name="id" value="{$attendance_id}">
	<input type="hidden" name="action" value="updateAttendance">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
 </FORM>

{include file="footer.tpl"}