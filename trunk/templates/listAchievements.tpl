
{include file="header.tpl" title=Achievements}


<h2>Achievements</h2>

{#images_blank#}
{#images_divider#}
<a href="./index.php?page=addAchievement">{#images_add#}</a>
{#images_divider#}
{#images_blank#}


<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td class="singlepicture"></td>
		<td>Category</td>
		<td>Name</td>
		<td>Descriptions</td>
		<td>Goal</td>
		<td>Points</td>
		<td class="singlepicture"></td>
	</tr>
{/strip}
{section name=mysec loop=$achievements}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateAchievement&id={$achievements[mysec].id}">
				{#images_edit#}
			</a>
			{#images_divider#}
			<a href="./index.php?page=listAchievementsEarned&id={$achievements[mysec].id}">{#images_drilldown#}</a>
		</td>
		<td class="singlepicture"><img src="./achievements/{$achievements[mysec].image}" height="24px" width="24px"/></td>
		<td>{$achievements[mysec].category}</td>
		<td>{$achievements[mysec].name}</td>
		<td>{$achievements[mysec].description}</td>
		<td>{$achievements[mysec].goal}</td>
		<td>{$achievements[mysec].points}</td>
		<td class="singlepicture">
			{if $achievements[mysec].lock == 1}
				{#images_big_locked#}
			{else}
				{#images_big_lock_off#}
			{/if}
		</td>
	</tr>
{/strip}
{/section}
</table>

{include file="footer.tpl"}
