<?php


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


?>