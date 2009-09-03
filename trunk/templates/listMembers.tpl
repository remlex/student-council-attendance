{config_load file=images.conf section="vote"}
{include file="header.tpl" title=Attendance}


<h2>Members - Quorum: {$current_quorum} </h2>

{#images_blank#}
{#images_divider#}
{if $inactive == 1}
	<a href="./index.php?page=addMember&inactive=1">{#images_add#}</a>
{else}
	<a href="./index.php?page=addMember">{#images_add#}</a>
{/if}
{#images_divider#}
{#images_blank#}
<br />
{if $inactive == 1}
	<a href="./index.php?page=listMembers">Active Members</a>
{else}
	<a href="./index.php?page=listMembers&inactive=1">Inactive Members</a>
{/if}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Name</td>
		<td>Ulink</td>
		<td>Position</td>
		<td>Status</td>
		<td>Vote</td>
	</tr>
{/strip}
{section name=mysec loop=$all_members}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			{if $inactive == 1}
				<a href="./index.php?page=updateMember&id={$all_members[mysec].id}&inactive=1">
					{#images_edit#}
				</a>
			{else}
				<a href="./index.php?page=updateMember&id={$all_members[mysec].id}">
					{#images_edit#}
				</a>
			{/if}
			{#images_divider#}
			{#images_blank#}
		</td>
		<td>{$all_members[mysec].name}</td>
		<td>{$all_members[mysec].ulink}</td>
		<td>{$all_members[mysec].position}</td>
		<td>{$all_members[mysec].status}</td>
		<td class="singlepicture">
			{if $all_members[mysec].vote == 0}
				{#images_vote_none#}
			{else}
				{if $all_members[mysec].quorum == 1}
					{#images_vote_yes#}
				{else}
					{#images_vote_coop#}
				{/if}
			{/if}
		</td>
	</tr>
{/strip}
{/section}
</table>


{include file="footer.tpl"}