{**
 * Project:     Student Council Attendance
 * File:        listCommitteeMembership.tpl
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
{include file="header.tpl" title=Attendance}

<h2>Committee: {$committee_name}</h2>

<a href="./index.php?page=listCommittees">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<br />
<FORM action="./index.php?page=process" method="post">
	<select name=member>{html_options options=$addable_members}</select>
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('addCommitteeMembership', 60, $this->get_template_vars('committee_id')){/php}">
	<input type="hidden" name="id" value="{$committee_id}">
	<input type="hidden" name="action" value="addCommitteeMembership">
	<INPUT type="submit" value="Add Member">
</FORM>

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td></td>
		<td>Name</td>
		
	</tr>
{/strip}
{section name=mysec loop=$membership}
{strip}
	{assign var='current_pk'  value=$membership[mysec].id}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			{#images_blank#}
			{#images_divider#}
			{#images_blank#}
		</td>
		<td>
		<FORM action="./index.php?page=process" method="post">
			<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteCommitteeMembership', 60, $this->get_template_vars('current_pk')){/php}">
			<input type="hidden" name="id" value="{$current_pk}">
			<input type="hidden" name="action" value="deleteCommitteeMembership">
			<INPUT type="image" src="{#url_delete#}">
		</FORM>
		</td>
		<td>{$membership[mysec].member}</td>
	</tr>
{/strip}
{/section}
</table>


{include file="footer.tpl"}