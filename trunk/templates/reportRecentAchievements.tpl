{**
 * Project:     Student Council Attendance
 * File:        reportRecentAchievements.tpl
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

<h2>{$updated|date_format:"%A, %B %e, %Y"}</h2>
{foreach from=$recent item=achievement}
	<hr />
	<h3>{$achievement.category}: <a href="{#url_achievement_id#}{$achievement.achievement}">{$achievement.name}</a></h3>
	<i>{$achievement.description}</i><br />
	{* $achievement.image *}
	{* $achievement.points *}
	
	{assign var=members value=$achievement.members}
	<ul>
	{foreach from=$members item=member}
		<li><a href="{#url_member_id#}{$member.id}">{$member.name}</a></li>
	{/foreach}
	</ul>
{/foreach}