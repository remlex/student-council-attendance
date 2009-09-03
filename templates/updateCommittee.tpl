{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Achievements}


<h2>Update Committee</h2>


<a href="./index.php?page=listCommittees">{#images_back#}</a>
{#images_divider#}

<FORM action="./index.php?page=process" method="post">
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteCommittee', 60, $this->get_template_vars('committee_id')){/php}">
	<input type="hidden" name="id" value="{$committee_id}">
	<input type="hidden" name="action" value="deleteCommittee">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
</FORM>
{#images_divider#}
{#images_blank#}


<FORM action="./index.php?page=process" method="post">
	<P>
	Name: <INPUT type="text" name="name" value="{$committee_name}">
	<br />
	Description: <INPUT type="text" name="description" value="{$committee_description}">
	<br />
	Manager: <select name=manager>{html_options options=$member_list selected=$committee_manager}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateCommittee', 60, $this->get_template_vars('committee_id')){/php}">
	<input type="hidden" name="id" value="{$committee_id}">
	<input type="hidden" name="action" value="updateCommittee">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}