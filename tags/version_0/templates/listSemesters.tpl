{**
 * Project:     Student Council Attendance
 * File:        listSemesters.tpl
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

<h2>Semesters</h2>

{#images_blank#}
{#images_divider#}
<a href="./index.php?page=addSemester">{#images_add#}</a>
{#images_divider#}
{#images_blank#}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Semester</td>
		<td>Start</td>
	</tr>
{/strip}
{section name=mysec loop=$all_semesters}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateSemester&semester={$all_semesters[mysec].id}">{#images_edit#}</a>
			{#images_divider#}
			<a href="./index.php?page=listMeetings&semester={$all_semesters[mysec].id}">{#images_drilldown#}</a>
			</td>
		<td>{$all_semesters[mysec].semester} {$all_semesters[mysec].year}</td>
		<td>{$all_semesters[mysec].startday}</td>
	</tr>
{/strip}
{/section}
</table>

{include file="footer.tpl"}