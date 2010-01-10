{**
 * Project:     Student Council Attendance
 * File:        reportCharts.tpl
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
<img src="{$member_distribution}" />
<br />
<hr />

<img src="{$member_standing}" />
<br />
<hr />

<img src="{$committee_involvement}" />
<br />
<hr />

<img src="{$all_members}" />
<br />
<hr />

{if $members_first_count > 0}
<img src="{$members_first}" />
<br />
<hr />
{/if}

{if $members_second_count > 0}
<img src="{$members_second}" />
<br />
<hr />
{/if}

{if $members_third_count > 0}
<img src="{$members_third}" />
<br />
<hr />
{/if}

{if $members_forth_count > 0}
<img src="{$members_forth}" />
<br />
<hr />
{/if}

{if $members_fifth_count > 0}
<img src="{$members_fifth}" />
<br />
<hr />
{/if}

{if $members_phd_count > 0}
<img src="{$members_phd}" />
<br />
<hr />
{/if}


{if $members_mal_count > 0}
<img src="{$members_mal}" />
<br />
<hr />
{/if}