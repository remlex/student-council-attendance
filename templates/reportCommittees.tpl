{foreach from=$committees item=committee}

	<h3><a name="committee_{$committee.id}">{$committee.name}</a></h3>
	<i>{$committee.description}</i><br />
	<b>Chair:</b> <a href="/members?id={$committee.manager_id}">{$committee.manager}</a> ({$committee.position})<br />
	
	{if $committee.members|@count == 0}
	<br /><b>There are currently no members on this committee.  If you would like to join, contact the committee chair.</b><br /><br />
	{else}
	<ul>
	{foreach from=$committee.members name=foo item=member}
		{strip}
			<li><a href="/members?id={$member.id}">{$member.member}</a> ({$member.position})</li>

		{/strip}
	{/foreach}
	</ul>
	{/if}
	<hr>
	<br />
{/foreach}