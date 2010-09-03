{**
 * Project:     Student Council Attendance
 * File:        addSemester.tpl
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

<h2>Add Semester</h2>

<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Semester: {html_radios name='semester' options=$semester_choices selected=$semester_selected separator=' '}
	<br />
	Start Date: {html_select_date prefix='start_' start_year='-5' end_year='+5'}
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addSemester', 60){/php}">
	<input type="hidden" name="action" value="addSemester">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>

{include file="footer.tpl"}