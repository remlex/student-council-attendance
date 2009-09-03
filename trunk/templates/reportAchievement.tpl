
<table>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Badge:</td>
		<td bgcolor="#eeeeee"><img src="./achievements/{$achievement_details.image}" title="{$achievement_details.name}" /></td>
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
			<a href="/members?id={$achievements_earned[mysec].member_id}">{$achievements_earned[mysec].member_name}</a>
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
			<a href="/members?id={$achievements_in_progress[mysec].member_id}">{$achievements_in_progress[mysec].member_name}</a>
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
			<a href="/members?id={$achievements_historical[mysec].member_id}">{$achievements_historical[mysec].member_name}</a>
		</td>
	</tr>
{/strip}
{/section}
</table>
{/if}
