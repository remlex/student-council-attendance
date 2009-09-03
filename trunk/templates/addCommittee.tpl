{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Achievements}


<h2>Add Committee</h2>


<a href="./index.php?page=listCommittees">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}


<FORM action="./index.php?page=process" method="post">
	<P>
	Name: <INPUT type="text" name="name">
	<br />
	Description: <INPUT type="text" name="description">
	<br />
	Manager: <select name=manager>{html_options options=$member_list}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addCommittee', 60){/php}">
	<input type="hidden" name="action" value="addCommittee">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}