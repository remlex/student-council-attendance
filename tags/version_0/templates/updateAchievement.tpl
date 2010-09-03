{**
 * Project:     Student Council Attendance
 * File:        updateAchievement.tpl
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
{include file="header.tpl" title=Achievements}

<h2>Update Attendance</h2>

<a href="./index.php?page=listAchievements">{#images_back#}</a>
{#images_divider#}

<FORM action="./index.php?page=process" method="post">
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteAchievement', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="action" value="deleteAchievement">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
</FORM>


{#images_divider#}
<FORM action="./index.php?page=process" method="post">
{if $achievement_lock == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('toggleAchievementLock', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="action" value="toggleAchievementLock">
	<INPUT type="image" src="{#url_big_lock_off#}">
{else}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('toggleAchievementLock', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="action" value="toggleAchievementLock">
	<INPUT type="image" src="{#url_big_locked#}">
{/if}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	Category: <select name=category>{html_options options=$categories selected=$achievement_category}</select>
	<br />
	Name: <INPUT type="text" name="name" value="{$achievement_name}">
	<br />
	Image: <INPUT type="text" name="image" value="{$achievement_image}">
	<br />
	Description: <INPUT type="text" name="description" value="{$achievement_description}">
	<br />
	Goal: <select name=goal>{html_options options=$goal selected=$achievement_goal}</select>
	<br />
	Points: <select name=points>{html_options options=$points selected=$achievement_points}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateAchievement', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="action" value="updateAchievement">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>

{include file="footer.tpl"}