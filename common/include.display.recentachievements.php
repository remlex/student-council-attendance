<?php

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


?>