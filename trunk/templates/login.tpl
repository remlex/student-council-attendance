{include file="header.tpl" title=Attendance}

<br />
<br />


<h2>Login</h2>


<FORM action="./index.php?page=process" method="post">
	<P>
	
	Username: <INPUT type="text" name="uname">
	<br />
	Password: <INPUT type="password" name="passwd">
	<br />
	
	<INPUT type="hidden" name="key" value="{php}echo secureform_add('authenticate', 4){/php}">
	<input type="hidden" name="action" value="authenticate">
	<INPUT type="submit" value="Send">
	</P>
 </FORM>
 





{include file="footer.tpl"}