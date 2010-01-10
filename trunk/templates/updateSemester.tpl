{**
 * Project:     Student Council Attendance
 * File:        updateSemester.tpl
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
{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Attendance}

<h2>Update Semester</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteSemester', 60, $this->get_template_vars('semester_id')){/php}">
	<input type="hidden" name="id" value="{$semester_id}">
	<input type="hidden" name="action" value="deleteSemester">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
{#images_divider#}
{#images_blank#}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	Semester: {html_radios name='semester' options=$semester_choices selected=$semester_selected separator=' '}
	<br />
	Start Date: {html_select_date prefix='start_' start_year='-5' end_year='+5' time=$date_selected}
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateSemester', 60, $this->get_template_vars('semester_id')){/php}">
	<input type="hidden" name="id" value="{$semester_id}">
	<input type="hidden" name="action" value="updateSemester">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>

{include file="footer.tpl"}