
{include file="header.tpl" title=Attendance}


<h2>Add Meeting</h2>

<a href="./index.php?page=listMeetings&semester={$selected_semester}">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	
	Meeting Date: {html_select_date start_year='-5' end_year='+5'}
	<br />
	Meeting Type: <select name=meeting_type>{html_options options=$meeting_type}</select>
	<br />
	Semester: <select name=semester>{html_options options=$semester selected=$selected_semester}</select>
	<br />
	Description: <INPUT type="text" name="description">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addMeeting', 60){/php}">
	<input type="hidden" name="action" value="addMeeting">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
 </FORM>

{include file="footer.tpl"}