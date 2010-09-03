{**
 * Project:     Student Council Attendance
 * File:        addMeeting.tpl
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

<h2>Add Meeting</h2>

<a href="./index.php?page=listMeetings&semester={$selected_semester}">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	
	Meeting Date: {html_select_date start_year='-5' end_year='+5'}
	<br />
	Meeting Type: <select name=meeting_type>{html_options options=$meeting_type}</select>
	<br />
	Semester: <select name=semester>{html_options options=$semester selected=$selected_semester}</select>
	<br />
	Description: <INPUT type="text" name="description">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addMeeting', 60){/php}">
	<input type="hidden" name="action" value="addMeeting">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
 </FORM>

{include file="footer.tpl"}