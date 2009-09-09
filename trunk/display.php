<?php

//Include all of the essentials
include_once("./include.php");
require './libs/Smarty.class.php';

//Smarty Stuff
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("Name", "");

//----------------------------------------------------------------------------------------------------------------------------------//
// MODEL
//----------------------------------------------------------------------------------------------------------------------------------//
function report_members(){
	$query = <<<QUERY
	SELECT `id`, `name`, `position`, `warning`, `trouble`,
	  IFNULL(`committees`,0) committees,
	  IFNULL(`committee_head`,0) committee_head,
	  IFNULL(`total_achievements`,0) total_achievements,
	  IFNULL(`council_points`,0) council_points
	FROM v_members m
	LEFT JOIN (SELECT `member`, `warning`, `trouble` FROM v_standing_g vsg
			WHERE vsg.semester = (SELECT `id` FROM semester s WHERE s.startday < NOW() ORDER BY s.startday DESC LIMIT 1)
			AND vsg.meeting_type = 1) g
		ON m.id = g.member
	LEFT JOIN (SELECT `member`, COUNT(*) committees FROM committee_membership GROUP BY `member`) com
	  ON m.id = com.member
	LEFT JOIN (SELECT `member`, COUNT(*) total_achievements, SUM(`points`) council_points
		  FROM achievements_earned e
		  JOIN achievements a ON e.achievement = a.id
		  WHERE e.progress >= a.goal
		  GROUP BY member) a
	  ON m.id = a.member
	LEFT JOIN (SELECT `manager` committee_manager, COUNT(*) committee_head FROM committees GROUP BY `manager`) h
	  ON m.id = h.committee_manager
	ORDER BY `position_id`, `name`;
QUERY;
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_member_summary($id){
	$query = "SELECT `semester`, `meeting_type`, `position`, `Unknown`, `Present`, `Absent`, `Excused`, `CoOp`, `warning`, `trouble` FROM v_reports_member_summary WHERE `member` = " . $id . " ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_member_info($id){
	//$query = "SELECT `name`, `position`, `status` FROM v_members WHERE `id` = " . $id . ";";
	$query  = "SELECT m.name, p.name position, s.name status ";
	$query .= "FROM `members` m ";
	$query .= "JOIN `position` p ON m.`position` = p.id ";
	$query .= "JOIN `status` s ON m.`status` = s.id ";
	$query .= "WHERE m.id = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_member_details($id){
	$query = "SELECT `meeting_id`, `mdate`, `semester`, `meeting_type`, `position`, `status` FROM v_reports_member_details WHERE `member` = " . $id . " ORDER BY mdate DESC";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}






//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//COMMITTEES
function report_committee_manager($id){
	$query  = "SELECT c.`id`, c.`name`, c.`description`, COUNT(*) members FROM committees c ";
	$query .= "LEFT JOIN committee_membership m ON c.id = m.committee WHERE `manager` = " . $id . " GROUP BY c.`id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_committee_involvement($id){
	$query  = "SELECT m.`id`, `member` member_id, `committee` committee_id, s.name manager, c.`name` committee_name, c.`description` ";
	$query .= "FROM committee_membership m JOIN committees c ON m.committee = c.id ";
	$query .= "JOIN members s ON c.manager = s.id WHERE `member` = " . $id . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}
function report_member_committee_count($id){
	$query = "SELECT (SELECT COUNT(*) num FROM committees WHERE `manager` = " . $id . ") + (SELECT COUNT(*) num FROM committee_membership WHERE `member` = " . $id . ") committee_count";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}




//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//ACHIEVEMENTS
function report_achievement_categories(){
	$query = "SELECT `id`, `name` FROM achievement_category ORDER BY `id`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}
function report_member_achievements($id){
	$categories = report_achievement_categories();
	for($i = 0; $i < sizeof($categories); $i++){
		$query  = "SELECT a.`id`, e.`achievement`, a.`image`, a.`name`, a.`points` FROM achievements_earned e ";
		$query .= "JOIN achievements a ON e.achievement = a.id ";
		$query .= "WHERE `member` = " . $id . " AND a.goal <= e.progress AND a.`category` = " . $categories[$i]['id'] . " ";
		$query .= "ORDER BY `updated` DESC;";
		$result = mysql_query($query);
		$val = array();
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
		$categories[$i]['awarded'] = $val;
	}
	return $categories;
}

function report_member_achievements_in_progress($id){
	$query  = "SELECT e.`achievement`, a.`image`, a.`name`, a.`description`, a.`points`, a.`goal`, e.`progress` ";
	$query .= "FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id ";
	$query .= "WHERE `member` = " . $id . " AND a.goal > e.progress ";
	$query .= "ORDER BY `updated` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_member_achievements_earned_count($id){
	$query  = "SELECT COUNT(*) total FROM achievements_earned e JOIN achievements a ON e.achievement = a.id ";
	$query .= "WHERE `member` = " . $id . " AND a.goal <= e.progress ORDER BY `updated` DESC;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function report_member_achievements_points($id){
	$query  = "SELECT SUM(points) total FROM achievements_earned e JOIN achievements a ON e.achievement = a.id ";
	$query .= "WHERE `member` = " . $id . " AND a.goal <= e.progress ORDER BY `updated` DESC;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//ACHIEVEMENT PAGE
function report_achievement_details($id){
	$query  = "SELECT a.`id`, a.`category` category_id, c.`name` category_name, a.`name`, a.`image`, a.`description`, a.`goal`, a.`points`, a.`added`, a.`lock` ";
	$query .= "FROM achievements a JOIN achievement_category c ON a.`category` = c.`id` WHERE a.`id` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_achievement_list_active(){
	$categories = report_achievement_categories();
	for($i = 0; $i < sizeof($categories); $i++){
		$query = "SELECT added,  `id`, `image`, `name`, `description`, `goal`, `points` FROM achievements WHERE `lock` = 0 AND `category` = " . $categories[$i]['id'] . " ORDER BY `added` DESC, `id` ASC;";
		$result = mysql_query($query);
		$val = array();
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
		$categories[$i]['awarded'] = $val;
	}
	return $categories;
}

function report_achievement_list_locked(){
	$categories = report_achievement_categories();
	for($i = 0; $i < sizeof($categories); $i++){
		$query = "SELECT added,  `id`, `image`, `name`, `description`, `goal`, `points` FROM achievements WHERE `lock` = 1 AND `category` = " . $categories[$i]['id'] . " ORDER BY `added` DESC, `id` ASC;";
		$result = mysql_query($query);
		$val = array();
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
		$categories[$i]['awarded'] = $val;
	}
	return $categories;
}


function report_single_achievements_earned_active($id){
	$query  = "SELECT e.`id`, e.`member` member_id, m.`name` member_name FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id JOIN members m ON e.member = m.id JOIN position p ON m.position = p.id ";
	$query .= "WHERE e.`achievement` = " . $id . " AND e.`progress` >= a.`goal` AND p.`name` != 'Non-Member' ";
	$query .= "ORDER BY e.`updated` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_single_achievements_earned_in_progress($id){
	$query  = "SELECT e.`id`, e.`member` member_id, m.`name` member_name, e.`progress`, a.`goal` FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id JOIN members m ON e.member = m.id JOIN position p ON m.position = p.id ";
	$query .= "WHERE e.`achievement` = " . $id . " AND e.`progress` < a.`goal` AND p.`name` != 'Non-Member' ";
	$query .= "ORDER BY e.`updated` DESC; ";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_single_achievements_earned_historical($id){
	$query  = "SELECT e.`id`, e.`member` member_id, m.`name` member_name FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id JOIN members m ON e.member = m.id JOIN position p ON m.position = p.id ";
	$query .= "WHERE e.`achievement` = " . $id . " AND e.`progress` >= a.`goal` AND p.`name` = 'Non-Member' ";
	$query .= "ORDER BY e.`updated` DESC; ";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}






//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//COMMITTEE PAGE
function report_committee_categories(){
	$query = "SELECT c.`id`, m.`id` manager_id, m.`name` manager, p.name position, c.`name`, `description` FROM committees c JOIN members m ON c.manager = m.id JOIN position p on m.position = p.id ORDER BY c.id;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_committee_membership(){
	$committees = report_committee_categories();
	for($i = 0; $i < sizeof($committees); $i++){
		$query = "SELECT m.`id`, m.`name` member, p.`name` position FROM committee_membership c JOIN members m ON c.member = m.id JOIN position p on m.position = p.id WHERE c.`committee` = " . $committees[$i]['id'] . " ORDER BY m.position, m.name;";
		$result = mysql_query($query);
		$val = array();
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
		$committees[$i]['members'] = $val;
	}
	return $committees;
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//TODAYS ATTENDANCE SUMMARY
function report_todays_attendance(){
	$query = "SELECT * FROM v_attendance WHERE `meeting` = (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) ORDER BY `position_id`, `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_todays_quorum(){
	$query = "SELECT * FROM v_quorum WHERE `meeting` =  (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) LIMIT 1;";
	$result = mysql_query($query);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_today_meeting(){
	$query = "SELECT * FROM v_meetings WHERE `id` = (SELECT `id` FROM meetings WHERE mdate = DATE(NOW()) LIMIT 1) LIMIT 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_todays_need_to_join_committee(){
	$query  = "SELECT m.name, p.name position ";
	$query .= "FROM `members` m ";
	$query .= "JOIN `position` p ON m.position = p.id ";
	$query .= "WHERE m.id NOT IN( ";
	$query .= "  SELECT Distinct(m) FROM ( ";
	$query .= "    SELECT member m FROM committee_membership c ";
	$query .= "    UNION ";
	$query .= "  SELECT manager m FROM committees c) tmpa) ";
	$query .= "AND m.position != 17 AND m.position != 18 AND m.position != 20 ";
	$query .= "ORDER BY m.position, m.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_todays_new_achievement(){
	$query  = "SELECT m.name member, a.name achievement, a.description, a.points FROM achievements_earned e ";
	$query .= "JOIN achievements a ON e.achievement = a.id ";
	$query .= "JOIN members m ON e.member = m.id ";
	$query .= "WHERE e.updated > ( ";
	$query .= "  SELECT mdate FROM meetings WHERE meeting_type = 1 ";
	$query .= "  ORDER BY mdate DESC ";
	$query .= "  LIMIT 1,1) ";
	$query .= "ORDER BY m.position, m.name, a.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//RECENTLY EARNED ACHIEVEMENTS
function report_recently_earned_achievements_date(){
	$query = "SELECT MAX(`updated`) updated FROM v_achievements_earned;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function report_recently_earned_achievements(){
	$query  = "SELECT `member_id`, `member`, `achievement`, `category`, `name`, `description`, `image`, `points` ";
	$query .= "FROM v_achievements_earned ";
	$query .= "WHERE `updated` = (SELECT MAX(`updated`) FROM v_achievements_earned) ";
	$query .= "ORDER BY `category_id`, `achievement`, `member`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	$arr = $val;
	
	$cat = array();
	for($i = 0; $i < sizeof($arr); $i++){
		if(!in_array($arr[$i]['achievement'], $cat, true)){
			$cat[] = $arr[$i]['achievement'];
		}
	}
	
	$items = array();
	for($i = 0; $i < sizeof($cat); $i++){
		$items[$i]['achievement'] = $cat[$i];
		for($k = 0; $k < sizeof($arr); $k++){
			if($cat[$i] == $arr[$k]['achievement']){
				$items[$i]['category'] = $arr[$k]['category'];
				$items[$i]['name'] = $arr[$k]['name'];
				$items[$i]['description'] = $arr[$k]['description'];
				$items[$i]['image'] = $arr[$k]['image'];
				$items[$i]['points'] = $arr[$k]['points'];
				//break;
				
				$mem = Array();
				$mem['id'] = $arr[$k]['member_id'];
				$mem['name'] = $arr[$k]['member'];
				$items[$i]['members'][] = $mem;
			}
		}
	}
	return $items;
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//PERFECT ATTENDANCE
function report_perfect_attendance_semester(){
	$query = "SELECT CONCAT_WS(' ',`semester`, `year`) semester FROM semester WHERE startday < NOW() ORDER BY startday DESC LIMIT 1;";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

function report_perfect_attendance(){
	$query  = "SELECT * FROM ( ";
	$query .= "SELECT a.member, count(*) total, sum(if(a.status=2,1,0)) present, e.name, e.position ";
	$query .= "FROM attendance a ";
	$query .= "JOIN meetings m ON a.meeting = m.id ";
	$query .= "JOIN members e ON a.member = e.id ";
	$query .= "WHERE m.semester = (SELECT `id` FROM semester WHERE startday < NOW() ORDER BY startday DESC LIMIT 1) ";
	$query .= "  AND m.meeting_type = 1 ";
	$query .= "  AND m.mdate < NOW() ";
	$query .= "GROUP BY member ) tmp ";
	$query .= "WHERE total = present ";
	$query .= "ORDER BY position, name; ";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//MEETING ATTENDANCE
function report_memester_meting_type(){
	$query  = "SELECT s.id semester, s.year, s.semester, s.startday, t.id meeting_type, t.name, ";
	$query .= "  (SELECT COUNT(*) FROM meetings m WHERE m.semester = s.id AND m.meeting_type = t.id AND m.mdate < NOW()) num ";
	$query .= "FROM semester s ";
	$query .= "JOIN meeting_type t ";
	$query .= "WHERE s.startday < NOW() ";
	$query .= "ORDER BY s.startday, t.id;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

function report_meetings($meeting_type){
	$query = "SELECT `id`, `year`, `semester`, `startday` FROM semester WHERE `startday` < NOW() ORDER BY `startday` DESC;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	for($i = 0; $i < sizeof($val); $i++){
		$query  = "SELECT q.meeting, m.mdate, q.TotalMembers, q.TotalPresent, q.VotingMembers, q.VotingPresent, q.Quorum, q.QuorumTest ";
		$query .= "FROM v_quorum q ";
		$query .= "JOIN meetings m ON q.meeting = m.id ";
		$query .= "WHERE `semester` = " . $val[$i]['id'] . " AND `meeting_type` = " . $meeting_type . " AND mdate < NOW() ";
		$query .= "ORDER BY mdate DESC;";
		
		$result = mysql_query($query);
		$val[$i]['meetings'] = array();
		while($row = mysql_fetch_assoc($result)){
			$val[$i]['meetings'][] = $row;
		}
		
	}
	return $val;
}

function report_meeting_quorum($id){
	$query = "select `TotalMembers`, `TotalPresent`, `VotingMembers`, `VotingPresent`, `Quorum`, `QuorumTest` from v_quorum WHERE `meeting` = " . $id . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_meeting_info($id){
	$query = "SELECT `id`, `mdate`, `meeting_type`, `year`, `semester`, `description`, `semester_id`, `meeting_type_id` FROM v_meetings WHERE `id` = " . $id . "";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function report_meeting($id){
	$query  = "SELECT a.*, t.member, s.name status_name FROM v_attendance a ";
	$query .= "JOIN `status` s ON a.`status` = s.id ";
	$query .= "JOIN attendance t ON a.id = t.id ";
	$query .= "WHERE a.`meeting` = " . $id . " ";
	$query .= "ORDER BY a.`position_id`, a.`name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	return $val;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//GOOGLE CHARTS

function report_chart_member_breakdown($position){
	$query = "SELECT `name` FROM `position` WHERE `id` = " . $position . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$positionname =  str_replace(" ", "+", $row[0]);;
	
	$query  = "SELECT j.name name, count(*) number ";
	$query .= "FROM members m ";
	$query .= "JOIN major j ON m.major = j.id ";
	$query .= "JOIN position p ON m.position = p.id ";
	$query .= "WHERE p.id = " . $position . " ";
	$query .= "GROUP BY p.name, j.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=" . $positionname . "&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=400x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['name'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_committee_pi_chart(){
	$query  = "SELECT 'Not in a Committee' name, COUNT(DISTINCT(m.id)) number ";
	$query .= "FROM members m ";
	$query .= "LEFT JOIN committee_membership c ON m.id = c.member ";
	$query .= "WHERE c.id IS NULL ";
	$query .= "  AND m.position != 20 && m.position != 17 && m.position != 18 ";
	$query .= "UNION ";
	$query .= "SELECT 'In a Committee' name, COUNT(DISTINCT(m.id)) number ";
	$query .= "FROM members m ";
	$query .= "JOIN committee_membership c ON m.id = c.member ";
	$query .= "WHERE  m.position != 20 && m.position != 17 && m.position != 18;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Committee+Membership&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=400x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['name'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_major_pi_chart(){
	$query = "SELECT j.name, COUNT(*) as number ";
	$query .= "FROM members m ";
	$query .= "JOIN major j ON m.major = j.id ";
	$query .= "WHERE m.position != 20 && m.position != 17 && m.position != 18 ";
	$query .= "GROUP BY j.name;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	//Generate the URL
	$url = "http://chart.apis.google.com/chart?cht=p&chco=FF0000&chtt=Council+Members+by+Major&chd=t:";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['number'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= ",";
		}
	}
	$url .="&chs=400x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= $val[$i]['name'];
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

//----------------------------------------------------------------------------------------------------------------------------------//
// CONTROLLER
//----------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['charts'])){
	echo  '<img src="' . report_chart_major_pi_chart() . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(10) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(11) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(12) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(13) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(14) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(15) . '" /><br />';
	echo  '<img src="' . report_chart_member_breakdown(19) . '" /><br />';
	echo  '<img src="' . report_chart_committee_pi_chart() . '" /><br />';
	
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
	//print_r(report_meetings_general_business());
	//$smarty->assign("semesters", report_meetings_general_business());
	//$smarty->display("reportGBMeetings.tpl");
	$id = db_clean_int($_GET['meeting']);
	/*
	echo "quorum\n";
	print_r(report_meeting_quorum($id));
	echo "info\n";
	print_r(report_meeting_info($id));
	echo "meeting\n";
	print_r(report_meeting($id));
	*/
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