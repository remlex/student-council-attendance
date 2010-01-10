{**
 * Project:     Student Council Attendance
 * File:        reportCommittees.tpl
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

{foreach from=$committees item=committee}

	<h3><a name="committee_{$committee.id}">{$committee.name}</a></h3>
	<i>{$committee.description}</i><br />
	<b>Chair:</b> <a href="{#url_member_id#}{$committee.manager_id}">{$committee.manager}</a> ({$committee.position})<br />
	
	{if $committee.members|@count == 0}
	<br /><b>There are currently no members on this committee.  If you would like to join, contact the committee chair.</b><br /><br />
	{else}
	<ul>
	{foreach from=$committee.members name=foo item=member}
		{strip}
			<li><a href="{#url_member_id#}{$member.id}">{$member.member}</a> ({$member.position})</li>

		{/strip}
	{/foreach}
	</ul>
	{/if}
	<hr>
	<br />
{/foreach}