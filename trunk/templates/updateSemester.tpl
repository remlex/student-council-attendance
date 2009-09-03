{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Attendance}


<h2>Update Semester</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteSemester', 60, $this->get_template_vars('semester_id')){/php}">
	<input type="hidden" name="id" value="{$semester_id}">
	<input type="hidden" name="action" value="deleteSemester">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
{#images_divider#}
{#images_blank#}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	Semester: {html_radios name='semester' options=$semester_choices selected=$semester_selected separator=' '}
	<br />
	Start Date: {html_select_date prefix='start_' start_year='-5' end_year='+5' time=$date_selected}
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateSemester', 60, $this->get_template_vars('semester_id')){/php}">
	<input type="hidden" name="id" value="{$semester_id}">
	<input type="hidden" name="action" value="updateSemester">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}