<h2>Achievements</h2>

{foreach from=$achievements_active item=category}
{if $category.awarded|@count > 0}
	<h3>{$category.name}</h3>
	
	{assign var=columncount value=4}
	
	<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Badge</td>
		<td>Name</td>
		<td>Description</td>
		<td>Points</td>
	</tr>
	{foreach from=$category.awarded name=foo item=achievement}
		{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>
				<a href="/achievements?id={$achievement.id}">
					<img src="./achievements/{$achievement.image}" title="{$achievement.name}" />
				</a>
			</td>
			<td>{$achievement.name}</td>
			<td>{$achievement.description}</td>
			<td>{$achievement.points}</td>
		<tr>
		{/strip}
	{/foreach}
	</table>
	
	
{/if}
{/foreach}

<br />
<br />

<h2>Former Achievements</h2>

{foreach from=$achievements_locked item=category}
{if $category.awarded|@count > 0}
	<h3>{$category.name}</h3>
	
	{assign var=columncount value=4}
	
	<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Badge</td>
		<td>Name</td>
		<td>Description</td>
		<td>Points</td>
	</tr>
	{foreach from=$category.awarded name=foo item=achievement}
		{strip}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>
				<a href="/achievements?id={$achievement.id}">
					<img src="./achievements/{$achievement.image}" title="{$achievement.name}" />
				</a>
			</td>
			<td>{$achievement.name}</td>
			<td>{$achievement.description}</td>
			<td>{$achievement.points}</td>
		<tr>
		{/strip}
	{/foreach}
	</table>
	
	
{/if}
{/foreach}