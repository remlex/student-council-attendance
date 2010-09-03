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

<h2>Achievements</h2>

{foreach from=$achievements_active item=category}
{if $category.awarded|@count > 0}
	<h3>{$category.name}</h3>
	
	{assign var=columncount value=4}
	
	<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Badge</td>
		<td>Name</td>
		<td>Description</td>
		<td>Points</td>
	</tr>
	{foreach from=$category.awarded name=foo item=achievement}
		{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>
				<a href="{#url_achievement_id#}{$achievement.id}">
					<img src="{#image_achievement_picture#}{$achievement.image}" title="{$achievement.name}" />
				</a>
			</td>
			<td>{$achievement.name}</td>
			<td>{$achievement.description}</td>
			<td>{$achievement.points}</td>
		<tr>
		{/strip}
	{/foreach}
	</table>
	
	
{/if}
{/foreach}

<br />
<br />

<h2>Former Achievements</h2>

{foreach from=$achievements_locked item=category}
{if $category.awarded|@count > 0}
	<h3>{$category.name}</h3>
	
	{assign var=columncount value=4}
	
	<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Badge</td>
		<td>Name</td>
		<td>Description</td>
		<td>Points</td>
	</tr>
	{foreach from=$category.awarded name=foo item=achievement}
		{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>
				<a href="{#url_achievement_id#}{$achievement.id}">
					<img src="{#image_achievement_picture#}{$achievement.image}" title="{$achievement.name}" />
				</a>
			</td>
			<td>{$achievement.name}</td>
			<td>{$achievement.description}</td>
			<td>{$achievement.points}</td>
		<tr>
		{/strip}
	{/foreach}
	</table>
	
	
{/if}
{/foreach}