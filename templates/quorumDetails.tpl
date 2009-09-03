{config_load file=images.conf section="refresh"}
<table>
{strip}
	<tr bgcolor="#cccccc">
		<TH ROWSPAN=3 >
			<a href="#void" onClick='$("#quorumDetails").load("index.php?page=quorumDetails&meeting={$meeting_id}");'>
				{#images_refresh#}
			</a>
		</TH>
		<td width="75px"></td>
		<td width="100px"><b>All Members</b></td>
		<td width="100px"><b>Voting</b></td>
		<td width="100px"><b>Quorum</b></td>
	</tr>
{/strip}
{strip}
	<tr bgcolor="#eeeeee">
		<td>Total</td>
		<td>{$total_members}</td>
		<td>{$voting_members}</td>
		<td>{$quorum}</td>
	</tr>
{/strip}
{strip}
	<tr bgcolor="#dddddd">
		<td>Present</td>
		<td>{$total_present}</td>
		<td>{$voting_present}</td>
		<td>
			{if $quorum_test == 1}
				Met
			{else}
				Not Met
			{/if}
		
		</td>
	</tr>
{/strip}
</table>
