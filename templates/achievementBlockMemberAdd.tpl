<FORM action="./index.php?page=process" method="post">
	<P>
	Progress: <select name=progress>{html_options options=$progress}</select>
	<br /><br />
	{include file="achievementBlockLarge.tpl"}
	<br />
	<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('addAchievementsEarned', 60, $this->get_template_vars('achievement_id')){/php}">
	<input type="hidden" name="id" value="{$achievement_id}">
	<input type="hidden" name="member" value="{$member_id}">
	<input type="hidden" name="sendBackToMember" value="yes">
	<input type="hidden" name="action" value="addAchievementsEarned">
	<INPUT type="submit" value="Send"> <INPUT type="reset">
	</P>
</FORM>