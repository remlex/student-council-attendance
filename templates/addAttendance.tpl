
{include file="header.tpl" title=Attendance}


<h2>Add Attendance</h2>

<a href="./index.php?page=listAttendance&meeting={$meeting}">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Name: <select name=member>{html_options options=$member_attendance}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('addAttendance', 60, $this->get_template_vars('meeting')){/php}">
	<input type="hidden" name="meeting" value="{$meeting}">
	<input type="hidden" name="action" value="addAttendance">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}