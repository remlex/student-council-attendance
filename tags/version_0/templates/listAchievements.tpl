{**
 * Project:     Student Council Attendance
 * File:        listAchievements.tpl
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
{include file="header.tpl" title=Achievements}

<h2>Achievements</h2>

{#images_blank#}
{#images_divider#}
<a href="./index.php?page=addAchievement">{#images_add#}</a>
{#images_divider#}
{#images_blank#}


<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td class="singlepicture"></td>
		<td>Category</td>
		<td>Name</td>
		<td>Descriptions</td>
		<td>Goal</td>
		<td>Points</td>
		<td class="singlepicture"></td>
	</tr>
{/strip}
{section name=mysec loop=$achievements}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateAchievement&id={$achievements[mysec].id}">
				{#images_edit#}
			</a>
			{#images_divider#}
			<a href="./index.php?page=listAchievementsEarned&id={$achievements[mysec].id}">{#images_drilldown#}</a>
		</td>
		<td class="singlepicture"><img src="./achievements/{$achievements[mysec].image}" height="24px" width="24px"/></td>
		<td>{$achievements[mysec].category}</td>
		<td>{$achievements[mysec].name}</td>
		<td>{$achievements[mysec].description}</td>
		<td>{$achievements[mysec].goal}</td>
		<td>{$achievements[mysec].points}</td>
		<td class="singlepicture">
			{if $achievements[mysec].lock == 1}
				{#images_big_locked#}
			{else}
				{#images_big_lock_off#}
			{/if}
		</td>
	</tr>
{/strip}
{/section}
</table>

{include file="footer.tpl"}
