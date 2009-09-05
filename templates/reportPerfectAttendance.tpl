{config_load file=display.links.conf}

<h2>{$semester}</h2>

{if $people|@count == 0}
	No one has perfect attendance for this semester.
{else}
	Congratulations and thanks go out to those members who have managed to attend every general business meeting thus far this semester:
	<ul>
	{foreach from=$people item=person}
		<li><a href="{#url_member_id#}{$person.member}">{$person.name}</a></li>
	{/foreach}
	</ul>
{/if}