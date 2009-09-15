{config_load file=display.links.conf}

{assign var=color_good value=9AFF66}
{assign var=color_warning value=FFFF33}
{assign var=color_bad value=FF6666}

<h2>Member Information</h2>
<table>
{strip}
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Name:</td>
		<td bgcolor="#eeeeee">{$member_name}</td>
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Position:</td>
		<td bgcolor="#eeeeee">{$member_position}</td>
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Major:</td>
		<td bgcolor="#eeeeee">{$member_major}</td>
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Council Status:</td>
		{if $member_status == "Co-Op"}
		<td bgcolor="#eeeeee">Currently On Co-Op</td>
		{elseif $member_status == "Excused"}
		<td bgcolor="#eeeeee">Excused for the semester</td>
		{else}
		<td bgcolor="#eeeeee">Normal</td>
		{/if}
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Committees Serving On:</td>
		<td bgcolor="#eeeeee">{$committee_count}</td>
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Achievements Earned:</td>
		<td bgcolor="#eeeeee">{$achievement_count}</td>
	</tr>
	<tr >
		<td bgcolor="#dddddd" style="font-weight:bold;">Council Points:</td>
		<td bgcolor="#eeeeee">{$achievement_points}</td>
	</tr>
	
{/strip}
</table>
<br />



<h2>Achievements</h2>
{if $achievement_count == 0}
<b>No achievements earned yet.</b>
{else}
{foreach from=$achievements_awarded item=category}
{if $category.awarded|@count > 0}
	<h3>{$category.name}</h3>
	
	{assign var=columncount value=4}
	
	<table>
	{foreach from=$category.awarded name=foo item=achievement}
		{if $smarty.foreach.foo.index == 0}
			<tr>
		{elseif $smarty.foreach.foo.index is div by $columncount}
			</tr><tr>
		{/if} 
		<td bgcolor="{cycle values="#cccccc,#eeeeee"}">
			<a href="{#url_achievement_id#}{$achievement.id}">
				<img src="{#image_achievement_picture#}{$achievement.image}" title="{$achievement.name}" />
			</a>
		</td>
	{/foreach}
	
	{assign var=cellcount value=$category.awarded|@count}
	
	{if $cellcount < $columncount}
		{* Special case for first row *}
		{assign var=filler value=$columncount-$cellcount}
		
	{elseif $cellcount is div by $columncount}
		{* It worked out perfectly, so just close the row *}
		{assign var=filler value=0}
	{else}
		{* fill in the last row with blanks *}
		{assign var=temp value=$cellcount%$columncount}
		{assign var=filler value=$columncount-$temp}
	{/if}
	{section name=extra loop=$filler}
		<td bgcolor="{cycle values="#cccccc,#eeeeee"}"><img src="{#image_achievement_picture#}void.png" /></td>
	{/section}
	</tr>
		
		
	</table>
{/if}
{/foreach}
{/if}



{if $achievements_in_progress|@count > 0}
<h3>In progress</h3>
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Achievement</td>
		<td>Description</td>
		<td>Progress</td>
		<td>Points</td>
	</tr>
{/strip}
{section name=mysec loop=$achievements_in_progress}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td>{$achievements_in_progress[mysec].name}</td>
		<td>{$achievements_in_progress[mysec].description}</td>
		<td>{$achievements_in_progress[mysec].progress} of {$achievements_in_progress[mysec].goal}</td>
		<td>{$achievements_in_progress[mysec].points}</td>
	</tr>
{/strip}
{/section}
</table>
{/if}
<br />



<h2>Committee Involvement</h2>
{if $committee_manager|@count > 0}
<h3>Chair</h3>
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Committee Name</td>
		<td>Description</td>
		<td>Members</td>
	</tr>
{/strip}
{section name=mysec loop=$committee_manager}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td><a href="{#url_committees#}#committee_{$committee_manager[mysec].id}">{$committee_manager[mysec].name}</a></td>
		<td>{$committee_manager[mysec].description}</td>
		<td>{$committee_manager[mysec].members}</td>
	</tr>
{/strip}
{/section}
</table>
{/if}



{if $committee_involvement|@count == 0 && $committee_manager|@count > 0}
{else}
<h3>Member</h3>
{/if}

{if $committee_involvement|@count == 0}
	{if $committee_manager|@count == 0}
		<b>Not a member of a committee.</b><br />
	{/if}
{else}
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Committee Name</td>
		<td>Description</td>
		<td>Manager</td>
	</tr>
{/strip}
{section name=mysec loop=$committee_involvement}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td><a href="{#url_committees#}#committee_{$committee_involvement[mysec].committee_id}">{$committee_involvement[mysec].committee_name}</a></td>
		<td>{$committee_involvement[mysec].description}</td>
		<td>{$committee_involvement[mysec].manager}</td>
	</tr>
{/strip}
{/section}
</table>
{/if}
<br />




<h2>Attendance</h2>
<h3>Summary</h3>
{if $member_summary|@count == 0}
<b>No attendance records for this member yet.</b>
{else}
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Semester</td>
		<td>Meeting</td>
		<td>Position</td>
		<td>Unknown</td>
		<td>Present</td>
		<td>Absent</td>
		<td>Excused</td>
		<td>Co-Op</td>
		<td>Standing</td>
	</tr>
{/strip}
{section name=mysec loop=$member_summary}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td>{$member_summary[mysec].semester}</td>
		<td>{$member_summary[mysec].meeting_type}</td>
		<td>{$member_summary[mysec].position}</td>
		<td>{$member_summary[mysec].Unknown}</td>
		<td>{$member_summary[mysec].Present}</td>
		<td>{$member_summary[mysec].Absent}</td>
		<td>{$member_summary[mysec].Excused}</td>
		<td>{$member_summary[mysec].CoOp}</td>
		{if $member_summary[mysec].position == "Member at Large"}
			<td bgcolor="#7ACAFF">N/A</td>
		{elseif $member_summary[mysec].trouble == 1}
			<td bgcolor="#{$color_bad}">Bad</td>
		{elseif $member_summary[mysec].warning == 1}
			<td bgcolor="#{$color_warning}">Warning</td>
		{else}
			<td bgcolor="#{$color_good}">Good</td>
		{/if}
	</tr>
{/strip}
{/section}
</table>
{/if}




<h3>Details</h3>
{if $member_details|@count == 0}
<b>No attendance records for this member yet.</b>
{else}
<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Date</td>
		<td>Semester</td>
		<td>Meeting</td>
		<td>Position</td>
		<td>Status</td>
	</tr>
{/strip}
{section name=mysec loop=$member_details}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		{if $member_details[mysec].meeting_type == "General Business Meeting"}
			<td><a href="{#url_meeting_general#}{$member_details[mysec].meeting_id}">{$member_details[mysec].mdate}</a></td>
		{elseif $member_details[mysec].meeting_type == "Directors Meeting"}
			<td><a href="{#url_meeting_directors#}{$member_details[mysec].meeting_id}">{$member_details[mysec].mdate}</a></td>
		{else}
			<td>{$member_details[mysec].mdate}</td>
		{/if}
		<td>{$member_details[mysec].semester}</td>
		<td>{$member_details[mysec].meeting_type}</td>
		<td>{$member_details[mysec].position}</td>
		<td>{$member_details[mysec].status}</td>
	</tr>
{/strip}
{/section}
</table>
{/if}
