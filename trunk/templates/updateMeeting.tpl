{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Attendance}


<h2>Update Meeting</h2>

<FORM action="./index.php?page=process" method="post">
<a href="./index.php?page=listMeetings&semester={$selected_semester}">{#images_back#}</a>
{#images_divider#}
{if $children == 0}
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteMeeting', 60, $this->get_template_vars('current_id')){/php}">
	<input type="hidden" name="id" value="{$current_id}">
	<input type="hidden" name="action" value="deleteMeeting">
	<INPUT type="image" src="{#url_delete#}">
{else}
	{#images_locked#}
{/if}
{#images_divider#}
{#images_blank#}
</FORM>

<FORM action="./index.php?page=process" method="post">
	<P>
	
	Meeting Date: {html_select_date time=$time start_year='-5' end_year='+5' time=$current_mdate}
	<br />
	Meeting Type: <select name=meeting_type>{html_options options=$meeting_type selected=$current_meeting_type}</select>
	<br />
	Semester: <select name=semester>{html_options options=$semester selected=$current_semester}</select>
	<br />
	Description: <INPUT type="text" name="description" value="{$current_description}">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateMeeting', 60, $this->get_template_vars('current_id')){/php}">
	<input type="hidden" name="id" value="{$current_id}">
	<input type="hidden" name="action" value="updateMeeting">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
 </FORM>

{include file="footer.tpl"}