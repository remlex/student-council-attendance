{**
 * Project:     Student Council Attendance
 * File:        updateCommittee.tpl
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

<h2>Update Committee</h2>

<a href="./index.php?page=listCommittees">{#images_back#}</a>
{#images_divider#}

<FORM action="./index.php?page=process" method="post">
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteCommittee', 60, $this->get_template_vars('committee_id')){/php}">
	<input type="hidden" name="id" value="{$committee_id}">
	<input type="hidden" name="action" value="deleteCommittee">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
</FORM>
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Name: <INPUT type="text" name="name" value="{$committee_name}">
	<br />
	Description: <INPUT type="text" name="description" value="{$committee_description}">
	<br />
	Manager: <select name=manager>{html_options options=$member_list selected=$committee_manager}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateCommittee', 60, $this->get_template_vars('committee_id')){/php}">
	<input type="hidden" name="id" value="{$committee_id}">
	<input type="hidden" name="action" value="updateCommittee">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>

{include file="footer.tpl"}