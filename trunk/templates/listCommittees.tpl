
{include file="header.tpl" title=Attendance}


<h2>Committees</h2>

{#images_blank#}
{#images_divider#}
<a href="./index.php?page=addCommittee">{#images_add#}</a>
{#images_divider#}
{#images_blank#}



<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Name</td>
		<td>Description</td>
		<td>Manager</td>
		<td>Members</td>
	</tr>
{/strip}
{section name=mysec loop=$committees}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateCommittee&id={$committees[mysec].id}">{#images_edit#}</a>
			{#images_divider#}
			<a href="./index.php?page=listCommitteeMembership&id={$committees[mysec].id}">{#images_drilldown#}</a>
		</td>
		<td>{$committees[mysec].name}</td>
		<td>{$committees[mysec].description}</td>
		<td>{$committees[mysec].manager}</td>
		<td>{$committees[mysec].members}</td>
	</tr>
{/strip}
{/section}
</table>


{include file="footer.tpl"}