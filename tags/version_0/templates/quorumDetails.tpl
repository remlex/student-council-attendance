{**
 * Project:     Student Council Attendance
 * File:        quorumDetails.tpl
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
{config_load file=images.conf section="refresh"}
<table>
{strip}
	<tr bgcolor="#cccccc">
		<TH ROWSPAN=3 >
			<a href="#void" onClick='$("#quorumDetails").load("index.php?page=quorumDetails&meeting={$meeting_id}");'>
				{#images_refresh#}
			</a>
		</TH>
		<td width="75px"></td>
		<td width="100px"><b>All Members</b></td>
		<td width="100px"><b>Voting</b></td>
		<td width="100px"><b>Quorum</b></td>
	</tr>
{/strip}
{strip}
	<tr bgcolor="#eeeeee">
		<td>Total</td>
		<td>{$total_members}</td>
		<td>{$voting_members}</td>
		<td>{$quorum}</td>
	</tr>
{/strip}
{strip}
	<tr bgcolor="#dddddd">
		<td>Present</td>
		<td>{$total_present}</td>
		<td>{$voting_present}</td>
		<td>
			{if $quorum_test == 1}
				Met
			{else}
				Not Met
			{/if}
		
		</td>
	</tr>
{/strip}
</table>
