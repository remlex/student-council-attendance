{**
 * Project:     Student Council Attendance
 * File:        addAchievement.tpl
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