{**
 * Project:     Student Council Attendance
 * File:        listAttendance.tpl
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
{config_load file=images.conf section="vote"}
{include file="header.tpl" title=Attendance}

<h2>Attendance: {$meeting_name}</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listMeetings&semester={$semester_id}">{#images_back#}</a>
{#images_divider#}
{if $addable == 0}
	{#images_add_blocked#}
{elseif $meeting_lock == 1}
	{#images_add_blocked#}
{else}
	<a href="./index.php?page=addAttendance&meeting={$meeting_id}">{#images_add#}</a>
{/if}
{#images_divider#}
{if $meeting_lock == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('toggleAttendanceLock', 60, $this->get_template_vars('meeting_id')){/php}">
	<input type="hidden" name="id" value="{$meeting_id}">
	<input type="hidden" name="action" value="toggleAttendanceLock">
	<INPUT type="image" src="{#url_big_lock_off#}">
{else}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('toggleAttendanceLock', 60, $this->get_template_vars('meeting_id')){/php}">
	<input type="hidden" name="id" value="{$meeting_id}">
	<input type="hidden" name="action" value="toggleAttendanceLock">
	<INPUT type="image" src="{#url_big_locked#}">
{/if}
</FORM>

{if $meeting_count == 0}
	<br />
	<br />
	<FORM action="./index.php?page=process" method="post">
		<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('fillAttendanceList', 60, $this->get_template_vars('meeting_id')){/php}">
		<input type="hidden" name="id" value="{$meeting_id}">
		<input type="hidden" name="action" value="fillAttendanceList">
		<INPUT type="submit" value="Fill Attendance List">
	</FORM>
{else}
	<div id="quorumDetails">
		<img src="./images/ajax-loader.gif" onLoad='$("#quorumDetails").load("index.php?page=quorumDetails&meeting={$meeting_id}");'>
	</div>
	<table>
	{strip}
		<tr bgcolor="#cccccc">
			<td class="editdrill"></td>
			<td>Name</td>
			<td>Position</td>
			<td class="singlepicture">Vote</td>
			<td></td>
		</tr>
	{/strip}
	{section name=mysec loop=$attendance}
	{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td class="editdrill">
				{if $meeting_lock == 1}
					{#images_edit_blocked#}
				{else}
					<a href="./index.php?page=updateAttendance&attendance={$attendance[mysec].id}">
						{#images_edit#}
					</a>
				{/if}
				{#images_divider#}
				{#images_blank#}
			</td>
			<td>{$attendance[mysec].name}</td>
			<td>{$attendance[mysec].position}</td>
			<td class="singlepicture">
				{if $attendance[mysec].vote == 0}
					{#images_vote_none#}
				{else}
					{if $attendance[mysec].quorum == 1}
						{#images_vote_yes#}
					{else}
						{#images_vote_coop#}
					{/if}
				{/if}
			</td>
			<td>
				<div id="attendance_{$attendance[mysec].id}">
					{include file="attendanceBlock.tpl" lock=$meeting_lock currentStatus=$attendance[mysec].status attendance=$attendance[mysec].id}
				</div>
			</td>
		</tr>
	{/strip}
	{/section}
	</table>
{/if}



{include file="footer.tpl"}