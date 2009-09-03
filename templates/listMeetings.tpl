
{include file="header.tpl" title=Attendance}


<h2>Meetings for {$semester_semester} {$semester_year}</h2>

<a href="./index.php?page=listSemesters">{#images_back#}</a>
{#images_divider#}
<a href="./index.php?page=addMeeting&semester={$semester_id}">{#images_add#}</a>
{#images_divider#}
{#images_blank#}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Meeting Date</td>
		<td>Meeting Type</td>
		<td>Description</td>
	</tr>
{/strip}
{section name=mysec loop=$all_meetings}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateMeeting&meeting={$all_meetings[mysec].id}">{#images_edit#}</a>
			{#images_divider#}
			<a href="./index.php?page=listAttendance&meeting={$all_meetings[mysec].id}">{#images_drilldown#}</a>
		</td>
		<td>{$all_meetings[mysec].mdate}</td>
		<td>{$all_meetings[mysec].meeting_type}</td>
		<td>{$all_meetings[mysec].description}</td>
	</tr>
{/strip}
{/section}
</table>



{include file="footer.tpl"}