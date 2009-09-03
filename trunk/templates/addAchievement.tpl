
{include file="header.tpl" title=Achievements}


<h2>Add Attendance</h2>

<a href="./index.php?page=listAchievements">{#images_back#}</a>
{#images_divider#}
{#images_blank#}
{#images_divider#}
{#images_blank#}

<FORM action="./index.php?page=process" method="post">
	<P>
	Category: <select name=category>{html_options options=$categories}</select>
	<br />
	Name: <INPUT type="text" name="name">
	<br />
	Image: <INPUT type="text" name="image">
	<br />
	Description: <INPUT type="text" name="description">
	<br />
	Goal: <select name=goal>{html_options options=$goal}</select>
	<br />
	Points: <select name=points>{html_options options=$points}</select>
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('addAchievement', 60){/php}">
	<input type="hidden" name="action" value="addAchievement">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>


{include file="footer.tpl"}