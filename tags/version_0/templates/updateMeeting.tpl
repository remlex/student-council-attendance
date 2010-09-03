{**
 * Project:     Student Council Attendance
 * File:        updateMeeting.tpl
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

<h2>Update Meeting</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listMeetings&semester={$selected_semester}">{#images_back#}</a>
{#images_divider#}
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteMeeting', 60, $this->get_template_vars('current_id')){/php}">
	<input type="hidden" name="id" value="{$current_id}">
	<input type="hidden" name="action" value="deleteMeeting">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
{#images_divider#}
{#images_blank#}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	
	Meeting Date: {html_select_date time=$time start_year='-5' end_year='+5' time=$current_mdate}
	<br />
	Meeting Type: <select name=meeting_type>{html_options options=$meeting_type selected=$current_meeting_type}</select>
	<br />
	Semester: <select name=semester>{html_options options=$semester selected=$current_semester}</select>
	<br />
	Description: <INPUT type="text" name="description" value="{$current_description}">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateMeeting', 60, $this->get_template_vars('current_id')){/php}">
	<input type="hidden" name="id" value="{$current_id}">
	<input type="hidden" name="action" value="updateMeeting">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
 </FORM>

{include file="footer.tpl"}