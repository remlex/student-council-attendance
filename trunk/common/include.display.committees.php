<?php


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


?>