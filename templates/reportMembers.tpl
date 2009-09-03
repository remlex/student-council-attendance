

<table>
{strip}
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Name</td>
		<td>Position</td>
		<td>Committees<br />Joined</td>
		<td>Achievements<br />(Total / Points)</td>
		<td>Attendance<br />Standing</td>
	</tr>
{/strip}
{section name=mysec loop=$members}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td><a href="./display.php?id={$members[mysec].id}">{$members[mysec].name}</a></td>
		<td>{$members[mysec].position}</td>
		{if $members[mysec].position == "Voting Society" || $members[mysec].position == "Non-Voting Society"}
			<td bgcolor="#7ACAFF">N/A</td>
		{elseif $members[mysec].committee_head+$members[mysec].committees > 0}
		<td>{$members[mysec].committee_head+$members[mysec].committees}</td>
		{else}
			<td bgcolor="#FF0000">None!</td>
		{/if}
		<td>{$members[mysec].total_achievements} / {$members[mysec].council_points}
		{if $members[mysec].position == "Member at Large"}
			<td bgcolor="#7ACAFF">N/A</td>
		{elseif $members[mysec].trouble == 1}
			<td bgcolor="#FF0000">Bad</td>
		{elseif $members[mysec].warning == 1}
			<td bgcolor="#FFFF00">Warning</td>
		{else}
			<td bgcolor="#00FF00">Good</td>
		{/if}
		
	</tr>
{/strip}
{/section}
</table>

