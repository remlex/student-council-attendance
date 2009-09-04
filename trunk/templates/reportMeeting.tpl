{config_load file=images.conf section="vote"}

<h2>{$info.meeting_type}<h2>
<h3>{$info.semester} {$info.year}: {$info.mdate}</h3>

<table>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Total Member:</td>
		<td bgcolor="#eeeeee">{$quorum.TotalPresent} of {$quorum.TotalMembers}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Voting Member:</td>
		<td bgcolor="#eeeeee">{$quorum.VotingPresent} of {$quorum.VotingMembers}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Quorum:</td>
		<td bgcolor="#eeeeee">{$quorum.Quorum}</td>
	</tr>
	<tr>
		<td bgcolor="#dddddd" style="font-weight:bold;">Quorum Met:</td>
		<td bgcolor="#eeeeee">
			{if $quorum.QuorumTest == 1}
				Yes
			{else}
				No
			{/if}
		</td>
	</tr>
</table>

<br /><br />

{assign var=color_unknown value=E6E6E6}
{assign var=color_present value=9AFF66}
{assign var=color_absent value=FF6666}
{assign var=color_excused value=FFFF33}
{assign var=color_coop value=66FDFF}

{if $meetings|@count > 0}
<table>
	<tr bgcolor="#cccccc" style="font-weight:bold;">
		<td>Member</td>
		<td>Position</td>
		<td>Voting Rights</td>
		<td>Attendance</td>
	</tr>
{foreach from=$meetings item=member}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td><a href="/members?id={$member.member}">{$member.name}</a></td>
		<td>{$member.position}</td>
		<td class="singlepicture">
			{if $member.vote == 0}
				{#images_vote_none#}
			{else}
				{if $member.quorum == 1}
					{#images_vote_yes#}
				{else}
					{#images_vote_coop#}
				{/if}
			{/if}
		</td>
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
			{$member.status_name}
		</td>
	</tr>
{/foreach}
</table>

<br />

<table border=0 cellspacing=0 cellpadding=0>
	<tr style="font-weight: bold; text-align:center; ">
		<td width="25%" bgcolor="#ffffff">Key</td>
		<td width="15%" bgcolor="#{$color_unknown}">Unknown</td>
		<td width="15%" bgcolor="#{$color_present}">Present</td>
		<td width="15%" bgcolor="#{$color_absent}">Absent</td>
		<td width="15%" bgcolor="#{$color_excused}">Excused</td>
		<td width="15%" bgcolor="#{$color_coop}">Co-Op</td>
	</tr>
</table>

{else}
<b>No attendance records yet for today.</b>
{/if}




