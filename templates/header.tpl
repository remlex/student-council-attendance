{**
 * Project:     Student Council Attendance
 * File:        header.tpl
 *
 * Student Council Attendance is free software: you can redistribute 
 * it and/or modify it under the terms of the GNU General Public 
 * License as published by the Free Software Foundation, either 
 * version 3 of the License, or (at your option) any later version.
 * 
 * Student Council Attendance is distributed in the hope that it will 
 * be useful, but WITHOUT ANY WARRANTY; without even the implied 
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Student Council Attendance.  If not, see 
 * http://www.gnu.org/licenses/.
 *
 * @link http://code.google.com/p/student-council-attendance/
 * @copyright 2009 Speed School Student Council
 * @author Jared Hatfield
 * @package student-council-attendance
 * @version 1.0
 *}
{config_load file=images.conf}
{config_load file=images.conf section="home_nav"}
<HTML>
<HEAD>
<TITLE>{$title} - {$Name}</TITLE>
{literal}
<style type="text/css">
	img{
		border:none;
	}
	
	a{
		text-decoration: none;
	}

	form{
		display: inline;
	}
	
	table{
		width: 100%;
	}
	
	h2{
		background-color: lightgray;
		color: darkred;
		padding: 10px;
	}
	
	table.maintable{
		width: 800px;
		border-width: 1px;
		border-spacing: 10px;
		border-style: outset;
	}
	
	table.maintable tr.header{
		background-color: darkred;
	}
	
	table.maintable tr.header h1{
		color: white;
		text-align:center;
	}
	
	table tr td.editdrill{
		width: 65px;
	}
	
	table tr td.singlepicture{
		width: 30px;
	}
	
	#quorumdetails table{
		width:60%; margin-left:20%; margin-right:20%;
	}
</style>
<link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.tabs.css" rel="stylesheet" />
{/literal}

{literal}
  <script type="text/javascript" src="http://jqueryui.com/latest/jquery-1.4.1.js"></script>
  <script type="text/javascript" src="http://jqueryui.com/latest/ui/jquery.ui.core.js"></script>
  <script type="text/javascript" src="http://jqueryui.com/latest/ui/jquery.ui.tabs.js"></script>
{/literal}

</HEAD>
<BODY bgcolor="#ffffff">


<table class="maintable" align="center">
	{strip}
	<tr class="header">
		<td><h1>Speed School Student Council Management</h1></td>
	</tr>
	{/strip}
	{strip}
	<tr>
		<td>
			<center>
			<a href="./index.php?page=home">{#images_home#}</a>
			{#images_divider#}
			<a href="./index.php?page=listMembers">{#images_members#}</a>
			{#images_divider#}
			<a href="./index.php?page=listSemesters">{#images_calendar#}</a>
			{#images_divider#}
			<a href="./index.php?page=listAchievements">{#images_achievements#}</a>
			{#images_divider#}
			<a href="./index.php?page=listCommittees">{#images_committees#}</a>
			{#images_divider#}
			<a href="./index.php?page=logout">{#images_logout#}</a>
			</center>
		</td>
	</tr>
	
	{/strip}
	<tr>
		<td>

