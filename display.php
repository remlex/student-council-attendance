<?php

/**
 * Project:     Student Council Attendance
 * File:        display.php
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
 */
 
//Include all of the essentials
include_once("./configs/config.php");
include_once($_CONFIG['smarty']);
include_once("./include.php");

//Smarty Stuff
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("Name", "");

//----------------------------------------------------------------------------------------------------------------------------------//
// MODEL
//----------------------------------------------------------------------------------------------------------------------------------//

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//MEMBERS
include_once ("./common/include.display.members.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//COMMITTEES
include_once ("./common/include.display.committees.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//ACHIEVEMENTS
include_once ("./common/include.display.achievements.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//TODAYS ATTENDANCE SUMMARY
include_once ("./common/include.display.todaysattendance.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//RECENTLY EARNED ACHIEVEMENTS
include_once ("./common/include.display.recentachievements.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//PERFECT ATTENDANCE
include_once ("./common/include.display.perfectattendance.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//MEETING ATTENDANCE
include_once ("./common/include.display.attendance.php");

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//GOOGLE CHARTS
include_once ("./common/include.display.charts.php");

//----------------------------------------------------------------------------------------------------------------------------------//
// CONTROLLER
//----------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['charts'])){
	$smarty->assign("all_members", report_chart_major_pie_chart());
	$smarty->assign("committee_involvement", report_chart_committee_pie_chart());
	
	$smarty->assign("members_first_count", report_chart_major_member_count(10));
	$smarty->assign("members_first", report_chart_member_breakdown(10));
	
	$smarty->assign("members_second_count", report_chart_major_member_count(11));
	$smarty->assign("members_second", report_chart_member_breakdown(11));
	
	$smarty->assign("members_third_count", report_chart_major_member_count(12));
	$smarty->assign("members_third", report_chart_member_breakdown(12));
	
	$smarty->assign("members_forth_count", report_chart_major_member_count(13));
	$smarty->assign("members_forth", report_chart_member_breakdown(13));
	
	$smarty->assign("members_fifth_count", report_chart_major_member_count(14));
	$smarty->assign("members_fifth", report_chart_member_breakdown(14));
	
	$smarty->assign("members_phd_count", report_chart_major_member_count(15));
	$smarty->assign("members_phd", report_chart_member_breakdown(15));
	
	$smarty->assign("members_mal_count", report_chart_major_member_count(19));
	$smarty->assign("members_mal", report_chart_member_breakdown(19));
	
	$smarty->assign("member_standing", report_chart_current_member_standing());
	
	$smarty->assign("member_distribution", report_chart_member_distribution());
	//Template
	$smarty->display("reportCharts.tpl");
}
else if(isset($_GET['achievements'])){
	$smarty->assign("achievements_active", report_achievement_list_active());
	$smarty->assign("achievements_locked", report_achievement_list_locked());
	
	//Template
	$smarty->display("reportAchievements.tpl");
}
else if(isset($_GET['gbmeeting'])){
	$smarty->assign("type", 1);
	$smarty->assign("semesters", report_meetings(1));
	$smarty->display("reportMeetings.tpl");
}
else if(isset($_GET['dmeeting'])){
	$smarty->assign("type", 2);
	$smarty->assign("semesters", report_meetings(2));
	$smarty->display("reportMeetings.tpl");
}
else if(isset($_GET['meeting'])){
	$id = db_clean_int($_GET['meeting']);
	$smarty->assign("quorum", report_meeting_quorum($id));
	$smarty->assign("info", report_meeting_info($id));
	$smarty->assign("meetings", report_meeting($id));
	$smarty->display("reportMeeting.tpl");
}
else if(isset($_GET['perfect'])){
	$smarty->assign("people", report_perfect_attendance());
	$smarty->assign("semester", report_perfect_attendance_semester());
	
	//Template
	$smarty->display("reportPerfectAttendance.tpl");
}
else if(isset($_GET['recentachievement'])){
	$smarty->assign("recent", report_recently_earned_achievements());
	$smarty->assign("updated", report_recently_earned_achievements_date());
	//Template
	$smarty->display("reportRecentAchievements.tpl");
}
else if(isset($_GET['achievement'])){
	$achievement_id = db_clean_int($_GET['achievement']);
	
	$smarty->assign("achievement_details", report_achievement_details($achievement_id));
	$smarty->assign("achievements_earned", report_single_achievements_earned_active($achievement_id));
	$smarty->assign("achievements_in_progress", report_single_achievements_earned_in_progress($achievement_id));
	$smarty->assign("achievements_historical", report_single_achievements_earned_historical($achievement_id));
	
	//Template
	$smarty->display("reportAchievement.tpl");
}
else if(isset($_GET['committee'])){
	$committee = db_clean_int($_GET['committee']);
	$smarty->assign("committees", report_committee_membership_single($committee));
	
	//Template
	$smarty->display("reportCommittees.tpl");
}
else if(isset($_GET['committees'])){
	$smarty->assign("committees", report_committee_membership());
	
	//Template
	$smarty->display("reportCommittees.tpl");
}
else if(isset($_GET['today'])){
	$smarty->assign("attendance", report_todays_attendance());
	$smarty->assign("quorum", report_todays_quorum());
	$smarty->assign("meeting", report_today_meeting());
	
	$smarty->assign("newAchievements", report_todays_new_achievement());
	$smarty->assign("joinCommittee", report_todays_need_to_join_committee());
	
	//Template
	$smarty->display("reportTodayAttendance.tpl");
}
else if(isset($_GET['id'])){
	$member_id = db_clean_int($_GET['id']);
	
	$member_info = report_member_info($member_id);
	
	//Member information
	$smarty->assign("member_name", $member_info['name']);
	$smarty->assign("member_position", $member_info['position']);
	$smarty->assign("member_status", $member_info['status']);
	$smarty->assign("member_major", $member_info['major']);
	
	//Attendance information
	$smarty->assign("member_summary", report_member_summary($member_id));
	$smarty->assign("member_details", report_member_details($member_id));
	
	//Committees information
	$smarty->assign("committee_count", report_member_committee_count($member_id));
	$smarty->assign("committee_manager", report_committee_manager($member_id));
	$smarty->assign("committee_involvement", report_committee_involvement($member_id));
	
	//Achievement information
	$smarty->assign("achievement_count", report_member_achievements_earned_count($member_id));
	$smarty->assign("achievement_points", report_member_achievements_points($member_id));
	$smarty->assign("achievements_awarded", report_member_achievements($member_id));
	$smarty->assign("achievements_in_progress", report_member_achievements_in_progress($member_id));
	
	//Template
	$smarty->display("reportMember.tpl");
}
else{
	$smarty->assign("members", report_members());
	$smarty->display("reportMembers.tpl");
}

?>