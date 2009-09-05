{config_load file=display.links.conf}

<html>

<head>

</head>

<body>

<center>

{if $attendance|@count == 0}
	<h2>No attendance records for today.</h2>
{else}

<h1>Attendance for {$meeting.mdate}</h1>
<h2>{$meeting.meeting_type} - {$meeting.semester} {$meeting.year}</h2>

{assign var=color_unknown value=E6E6E6}
{assign var=color_present value=9AFF66}
{assign var=color_absent value=FF6666}
{assign var=color_excused value=FFFF33}
{assign var=color_coop value=66FDFF}

{if $quorum.QuorumTest == 0}
	<b>We still need {$quorum.Quorum-$quorum.VotingPresent} voting members to reach quorum.</b>
{else}
	<b>Quorum Has Been Met!</b>
{/if}
<br />
<br />
{assign var=columncount value=3}
	<table border=1 cellspacing=0 cellpadding=3>
	{foreach from=$attendance name=foo item=member}
		{if $smarty.foreach.foo.index == 0}
			<tr>
		{elseif $smarty.foreach.foo.index is div by $columncount}
			</tr><tr>
		{/if}
		{strip}
			{if $member.status == 1}
				<td bgcolor="#{$color_unknown}">
			{elseif $member.status == 2}
				<td bgcolor="#{$color_present}">
			{elseif $member.status == 3}
				<td bgcolor="#{$color_absent}">
			{elseif $member.status == 4}
				<td bgcolor="#{$color_excused}">
			{elseif $member.status == 5}
				<td bgcolor="#{$color_coop}">
			{else}
				<td>
			{/if}
		{/strip}
		{$member.name} 
		{if $member.position == "Voting Society"}
		{elseif $member.position == "Non-Voting Society"}
		{else}
			({$member.position})
		{/if}
		</td>
	{/foreach}
	{assign var=cellcount value=$attendance|@count}
	{if $cellcount < $columncount}
		{* Special case for first row *}
		{assign var=filler value=$columncount-$cellcount}
		
	{elseif $cellcount is div by $columncount}
		{* It worked out perfectly, so just close the row *}
		{assign var=filler value=0}
	{else}
		{* fill in the last row with blanks *}
		{assign var=temp value=$cellcount%$columncount}
		{assign var=filler value=$columncount-$temp}
	{/if}
	{section name=extra loop=$filler}
		<td></td>
	{/section}
	</tr>
	</table>
<br />
<table border=1 cellspacing=0 cellpadding=3>
	<tr style="font-weight: bold; ">
		<td width="100px">Key</td>
		<td width="100px" bgcolor="#{$color_unknown}">Unknown</td>
		<td width="100px" bgcolor="#{$color_present}">Present</td>
		<td width="100px" bgcolor="#{$color_absent}">Absent</td>
		<td width="100px" bgcolor="#{$color_excused}">Excused</td>
		<td width="100px" bgcolor="#{$color_coop}">Co-Op</td>
	</tr>
</table>

{/if}



{assign var=title_bg_color value=E6E6E6}

<br /><br /><br />


<h1>Achievements Awarded Since Last General Business Meeting</h1>
<table border=1 cellspacing=0 cellpadding=3>
	<tr bgcolor="#{$title_bg_color}">
		<td>Member</td>
		<td>Achievement</td>
		<td>Description</td>
		<td>Points</td>
	</tr>
	{foreach from=$newAchievements name=foo item=achievementAward}
		<tr>
			<td>{$achievementAward.member}</td>
			<td>{$achievementAward.achievement}</td>
			<td>{$achievementAward.description}</td>
			<td>{$achievementAward.points}</td>
		</tr>
	{/foreach}
</table>



<br /><br /><br />


<h1>Members Who Still Need to Join A Committee</h1>
<table border=1 cellspacing=0 cellpadding=3>
	<tr bgcolor="#{$title_bg_color}">
		<td>Member</td>
		<td>Position</td>
	</tr>
	{foreach from=$joinCommittee name=foo item=committee}
		<tr>
			<td>{$committee.name}</td>
			<td>{$committee.position}</td>
		</tr>
	{/foreach}
</table>


</center>
</body>

</html>