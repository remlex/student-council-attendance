
{include file="header.tpl" title=Attendance}


<h2>Semesters</h2>

{#images_blank#}
{#images_divider#}
<a href="./index.php?page=addSemester">{#images_add#}</a>
{#images_divider#}
{#images_blank#}

<table>
{strip}
	<tr bgcolor="#cccccc">
		<td class="editdrill"></td>
		<td>Semester</td>
		<td>Start</td>
	</tr>
{/strip}
{section name=mysec loop=$all_semesters}
{strip}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td class="editdrill">
			<a href="./index.php?page=updateSemester&semester={$all_semesters[mysec].id}">{#images_edit#}</a>
			{#images_divider#}
			<a href="./index.php?page=listMeetings&semester={$all_semesters[mysec].id}">{#images_drilldown#}</a>
			</td>
		<td>{$all_semesters[mysec].semester} {$all_semesters[mysec].year}</td>
		<td>{$all_semesters[mysec].startday}</td>
	</tr>
{/strip}
{/section}
</table>




{include file="footer.tpl"}