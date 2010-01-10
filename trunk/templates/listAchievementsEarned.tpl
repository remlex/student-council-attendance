{**
 * Project:     Student Council Attendance
 * File:        listAchievementsEarned.tpl
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
{config_load file=images.conf section="arrows"}
{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Attendance}

<h2>Achievement: {$achievement_name}</h2>

<a href="./index.php?page=listAchievements">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}


{if $achievement_lock == 0}
<br />
<FORM action="./index.php?page=process" method="post">
	<select name=member>{html_options options=$addable_members}</select>
	<select name=progress>{html_options options=$progress}</select>
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('addAchievementsEarned', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="action" value="addAchievementsEarned">
	<INPUT type="submit" value="Add Member">
</FORM>
{/if}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td></td>
		<td class="singlepicture">Name</td>
		<td>Progress</td>
		<td class="editdrill"></td>
	</tr>
{/strip}
{section name=mysec loop=$members}
{strip}
	{assign var='current_pk'  value=$members[mysec].id}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			{#images_blank#}
			{#images_divider#}
			{#images_blank#}
		</td>
		<td class="singlepicture">
			{if $achievement_lock == 0}
			<FORM action="./index.php?page=process" method="post">
				<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
				<input type="hidden" name="id" value="{$current_pk}">
				<input type="hidden" name="action" value="deleteAchievementsEarned">
				<INPUT type="image" src="{#url_delete#}">
			</FORM>
			{else}
			{#images_locked#}
			{/if}
		</td>
		<td>{$members[mysec].member}</td>
		<td>
			{$members[mysec].progress} of {$achievement_goal}
		</td>
		<td class="editdrill">
			{if $achievement_lock == 0}
				{if $members[mysec].progress == 1}
				{#images_decrease_disabled#}
				{else}
				<FORM action="./index.php?page=process" method="post">
					<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('decreaseAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
					<input type="hidden" name="id" value="{$current_pk}">
					<input type="hidden" name="action" value="decreaseAchievementsEarned">
					<INPUT type="image" src="{#url_decrease#}">
				</FORM>
				{/if}
				
				{if $members[mysec].progress < $achievement_goal}
				<FORM action="./index.php?page=process" method="post">
					<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('increaseAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
					<input type="hidden" name="id" value="{$current_pk}">
					<input type="hidden" name="action" value="increaseAchievementsEarned">
					<INPUT type="image" src="{#url_increase#}">
				</FORM>
				{else}
				{#images_increase_disabled#}
				{/if}
				
			{else}
				{#images_decrease_disabled#}
				{#images_increase_disabled#}
			{/if}
		</td>
	</tr>
{/strip}
{/section}
</table>




{include file="footer.tpl"}

