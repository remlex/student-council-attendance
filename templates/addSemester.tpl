
{include file="header.tpl" title=Attendance}


<h2>Add Semester</h2>

<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Semester: {html_radios name='semester' options=$semester_choices selected=$semester_selected separator=' '}
	<br />
	Start Date: {html_select_date prefix='start_' start_year='-5' end_year='+5'}
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addSemester', 60){/php}">
	<input type="hidden" name="action" value="addSemester">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}