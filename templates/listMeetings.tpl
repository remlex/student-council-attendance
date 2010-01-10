{**
 * Project:     Student Council Attendance
 * File:        listMeetings.tpl
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

<h2>Meetings for {$semester_semester} {$semester_year}</h2>

<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
<a href="./index.php?page=addMeeting&semester={$semester_id}">{#images_add#}</a>
{#images_divider#}
{#images_blank#}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Meeting Date</td>
		<td>Meeting Type</td>
		<td>Description</td>
	</tr>
{/strip}
{section name=mysec loop=$all_meetings}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateMeeting&meeting={$all_meetings[mysec].id}">{#images_edit#}</a>
			{#images_divider#}
			<a href="./index.php?page=listAttendance&meeting={$all_meetings[mysec].id}">{#images_drilldown#}</a>
		</td>
		<td>{$all_meetings[mysec].mdate}</td>
		<td>{$all_meetings[mysec].meeting_type}</td>
		<td>{$all_meetings[mysec].description}</td>
	</tr>
{/strip}
{/section}
</table>

{include file="footer.tpl"}