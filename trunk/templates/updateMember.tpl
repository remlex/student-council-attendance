{config_load file=images.conf section="arrows"}
{config_load file=images.conf section="delete"}
{include file="header.tpl" title=Attendance}


<h2>Update Member</h2>

{if $inactive == 1}
	<a href="./index.php?page=listMembers&inactive=1">{#images_back#}</a>
{else}
	<a href="./index.php?page=listMembers">{#images_back#}</a>
{/if}
{#images_divider#}
{#images_locked#}
{#images_divider#}
{#images_blank#}

{literal}
<script type="text/javascript">
	$(document).ready(
		function(){
			$("#tabs").tabs();
		}
	);
</script>
{/literal}

<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>Information</span></a></li>
        <li><a href="#fragment-2"><span>Add Achievement</span></a></li>
        <li><a href="#fragment-3"><span>Manage Achievements</span></a></li>
		<li><a href="#fragment-4"><span>Manage Committee Membership</span></a></li>
    </ul>
	
	
    <div id="fragment-1">
		<br />
        <FORM action="./index.php?page=process" method="post">
			<P>
			Name: <INPUT type="text" name="name" value="{$current_name}">
			<br />
			Ulink: <INPUT type="text" name="ulink" value="{$current_ulink}">
			<br />
			Position:<select name=position>{html_options options=$positions selected=$current_position}</select>
			<br />
			Default Status:<select name=status>{html_options options=$status selected=$current_status}</select>
			<br />
			
			<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('updateMember', 60, $this->get_template_vars('current_id')){/php}">
			<input type="hidden" name="id" value="{$current_id}">
			<input type="hidden" name="action" value="updateMember">
			<INPUT type="submit" value="Send"> <INPUT type="reset">
			</P>
		 </FORM>
    </div>
	
	
    <div id="fragment-2">
		<br />
		{if $achievements_to_earn|@count > 0}
		Achievement: 
        <select name=achievement id=achievement onchange='$("#achievement_to_add").load("index.php?page=achievementBlockMemberAdd&member={$current_id}&id=" + $("#achievement").val() );'>
			{html_options options=$achievements_to_earn}
		</select>
		<div id="achievement_to_add">
			<img src="./images/ajax-loader.gif" onLoad='$("#achievement_to_add").load("index.php?page=achievementBlockMemberAdd&member={$current_id}&id=" + $("#achievement").val() );'>
		</div>
		{else}
			<b>This member has earned all possible achievements.</b>
		{/if}
    </div>
	
	
    <div id="fragment-3">
		<br />
		<table>
		{strip}
			<tr bgcolor="#cccccc">
				<td class="editdrill"></td>
				<td class="singlepicture"></td>
				<td>Achievement</td>
				<td>Description</td>
				<td>Progress</td>
				<td class="editdrill"></td>
			</tr>
		{/strip}
		{section name=mysec loop=$earned_achievements}
		{strip}
			{assign var='current_pk'  value=$earned_achievements[mysec].id}
			<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
				<td class="editdrill">
					{#images_blank#}
					{#images_divider#}
					{#images_blank#}
				</td>
				<td class="singlepicture">
					{if $earned_achievements[mysec].lock == 0}
					<FORM action="./index.php?page=process" method="post">
						<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
						<input type="hidden" name="id" value="{$current_pk}">
						<input type="hidden" name="member" value="{$current_id}">
						<input type="hidden" name="action" value="deleteAchievementsEarned">
						<INPUT type="image" src="{#url_delete#}">
					</FORM>
					{else}
					{#images_locked#}
					{/if}
				</td>
				<td>{$earned_achievements[mysec].name}</td>
				<td>{$earned_achievements[mysec].description}</td>
				<td>
					{$earned_achievements[mysec].progress} of {$earned_achievements[mysec].goal}
				</td>
				<td class="editdrill">
					{if $earned_achievements[mysec].lock == 0}
						{if $earned_achievements[mysec].progress == 1}
						{#images_decrease_disabled#}
						{else}
						<FORM action="./index.php?page=process" method="post">
							<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('decreaseAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
							<input type="hidden" name="id" value="{$current_pk}">
							<input type="hidden" name="member" value="{$current_id}">
							<input type="hidden" name="action" value="decreaseAchievementsEarned">
							<INPUT type="image" src="{#url_decrease#}">
						</FORM>
						{/if}
						
						{if $earned_achievements[mysec].progress < $earned_achievements[mysec].goal}
						<FORM action="./index.php?page=process" method="post">
							<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('increaseAchievementsEarned', 60, $this->get_template_vars('current_pk')){/php}">
							<input type="hidden" name="id" value="{$current_pk}">
							<input type="hidden" name="member" value="{$current_id}">
							<input type="hidden" name="action" value="increaseAchievementsEarned">
							<INPUT type="image" src="{#url_increase#}">
						</FORM>
						{else}
						{#images_increase_disabled#}
						{/if}
						
					{else}
						{#images_decrease_disabled#}
						{#images_increase_disabled#}
					{/if}
				</td>
			</tr>
		{/strip}
		{/section}
		</table>
	</div>
	
	
	
	
	<div id="fragment-4">
		<br />
		<table>
		{strip}
			<tr bgcolor="#cccccc">
				<td class="editdrill"></td>
				<td>Committee</td>
				<td>Description</td>
				<td>Manager</td>
				<td></td>
			</tr>
		{/strip}
		
		{section name=mysec loop=$committee_membership}
		{strip}
			{assign var='current_pk'  value=$committee_membership[mysec].id}
			{assign var='committee_membership_id' value=$committee_membership[mysec].membership}
			<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
				<td class="editdrill">
					{#images_blank#}
					{#images_divider#}
					{#images_blank#}
				</td>
				<td>{$committee_membership[mysec].name}</td>
				<td>{$committee_membership[mysec].description}</td>
				<td>{$committee_membership[mysec].manager_name}</td>
				<td>
					{if $committee_membership[mysec].manager == $current_id}
						{#images_committees#}
					{elseif $committee_membership[mysec].is_member == 1}
						<FORM action="./index.php?page=process" method="post">
							<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('deleteCommitteeMembership', 60, $this->get_template_vars('committee_membership_id')){/php}">
							<input type="hidden" name="id" value="{$committee_membership_id}">
							<input type="hidden" name="member" value="{$current_id}">
							<input type="hidden" name="action" value="deleteCommitteeMembership">
							<INPUT type="image" src="{#url_delete#}">
						</FORM>
					{else}
						<FORM action="./index.php?page=process" method="post">
							<INPUT type="hidden" name="key" value="{php}echo secureform_add_pk('addCommitteeMembership', 60, $this->get_template_vars('current_pk')){/php}">
							<input type="hidden" name="id" value="{$current_pk}">
							<input type="hidden" name="member" value="{$current_id}">
							<input type="hidden" name="sendBackToMember" value="yes">
							<input type="hidden" name="action" value="addCommitteeMembership">
							<INPUT type="image" src="{#url_add#}">
						</FORM>
					{/if}
					
				</td>
			</tr>
		{/strip}
		{/section}
		</table>
	</div>
	
</div>



{include file="footer.tpl"}