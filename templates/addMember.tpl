
{include file="header.tpl" title=Attendance}


<h2>Add Member</h2>

{if $inactive == 1}
	<a href="./index.php?page=listMembers&inactive=1">{#images_back#}</a>
{else}
	<a href="./index.php?page=listMembers">{#images_back#}</a>
{/if}
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Name: <INPUT type="text" name="name">
	<br />
	Ulink: <INPUT type="text" name="ulink">
	<br />
	Position:<select name=position>{html_options options=$positions selected=19}</select>
	<br />
	Default Status:<select name=status>{html_options options=$status selected=1}</select>
	<br />
	Major: <select name=major>{html_options options=$majors selected=1}</select>
	<br />
	Student ID: <INPUT type="text" name="student_id">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addMember', 60){/php}">
	<input type="hidden" name="action" value="addMember">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}