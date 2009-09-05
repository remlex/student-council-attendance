{config_load file=display.links.conf}

<h2>{$updated|date_format:"%A, %B %e, %Y"}</h2>
{foreach from=$recent item=achievement}
	<hr />
	<h3>{$achievement.category}: <a href="{#url_achievement_id#}{$achievement.achievement}">{$achievement.name}</a></h3>
	<i>{$achievement.description}</i><br />
	{* $achievement.image *}
	{* $achievement.points *}
	
	{assign var=members value=$achievement.members}
	<ul>
	{foreach from=$members item=member}
		<li><a href="{#url_member_id#}{$member.id}">{$member.name}</a></li>
	{/foreach}
	</ul>
{/foreach}