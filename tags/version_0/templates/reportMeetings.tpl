{**
 * Project:     Student Council Attendance
 * File:        reportMeetings.tpl
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
{config_load file=display.links.conf}

{if $type == 1}
	<h2>General Business Meetings</h2>
{elseif $type == 2}
	<h2>Directors Meetings</h2>
{/if}

{assign var=color_good value=9AFF66}
{assign var=color_warning value=FFFF33}
{assign var=color_bad value=FF6666}


{foreach from=$semesters item=semester}
{if $semester.meetings|@count > 0}
	<h3>{$semester.semester} {$semester.year}</h3>
	
	
	<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Date</td>
		<td>Members Present</td>
		<td>Voting Members Present</td>
		<td>Quorum</td>
	</tr>
	{foreach from=$semester.meetings name=foo item=meeting}
		{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			{if $type == 1}
				<td><a href="{#url_meeting_general#}{$meeting.meeting}">{$meeting.mdate}</a></td>
			{else if $type == 2}
				<td><a href="{#url_meeting_directors#}{$meeting.meeting}">{$meeting.mdate}</a></td>
			{/if}
			
			<td>{$meeting.TotalPresent} of {$meeting.TotalMembers}</td>
			<td>{$meeting.VotingPresent} of {$meeting.VotingMembers}</td>
			{if $meeting.QuorumTest == 1}
				<td bgcolor="#{$color_good}">{$meeting.Quorum}</td>
			{else}
				<td bgcolor="#{$color_bad}">{$meeting.Quorum}</td>
			{/if}
		<tr>
		{/strip}
	{/foreach}
	</table>
{/if}
{/foreach}
