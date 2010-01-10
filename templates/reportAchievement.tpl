{**
 * Project:     Student Council Attendance
 * File:        reportAchievements.tpl
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

<table>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Badge:</td>
		<td bgcolor="#eeeeee"><img src="{#image_achievement_picture#}{$achievement_details.image}" title="{$achievement_details.name}" /></td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Category:</td>
		<td bgcolor="#eeeeee">{$achievement_details.category_name}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Name:</td>
		<td bgcolor="#eeeeee">{$achievement_details.name}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Description:</td>
		<td bgcolor="#eeeeee">{$achievement_details.description}</td>
	</tr>
	{if $achievement_details.goal > 1}
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Goal:</td>
		<td bgcolor="#eeeeee">{$achievement_details.goal}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Council Points:</td>
		<td bgcolor="#eeeeee">{$achievement_details.points}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Available:</td>
		<td bgcolor="#eeeeee">
			{if $achievement_details.lock == 1}No{else}Yes{/if}
		</td>
	</tr>
</table>



<h2>Active Member With Achievement</h2>
{if $achievements_earned|@count == 0}
<b>No one has earned this achievement yet.</b>
{else}
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Name</td>
	</tr>
{/strip}
{section name=mysec loop=$achievements_earned}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td>
			<a href="{#url_member_id#}{$achievements_earned[mysec].member_id}">{$achievements_earned[mysec].member_name}</a>
		</td>
	</tr>
{/strip}
{/section}
</table>
{/if}





{if $achievements_in_progress|@count > 0}
<h2>Working Towards this Achievement</h2>
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Name</td>
		<td>Progress</td>
	</tr>
{/strip}
{section name=mysec loop=$achievements_in_progress}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td>
			<a href="{#url_member_id#}{$achievements_in_progress[mysec].member_id}">{$achievements_in_progress[mysec].member_name}</a>
		</td>
		<td>{$achievements_in_progress[mysec].progress} of {$achievements_in_progress[mysec].goal}</td>
	</tr>
{/strip}
{/section}
</table>
{/if}





{if $achievements_historical|@count > 0}
<h2>Achievements of Members Past</h2>
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Name</td>
	</tr>
{/strip}
{section name=mysec loop=$achievements_historical}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td>
			<a href="{#url_member_id#}{$achievements_historical[mysec].member_id}">{$achievements_historical[mysec].member_name}</a>
		</td>
	</tr>
{/strip}
{/section}
</table>
{/if}
