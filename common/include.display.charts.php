<?php


function report_chart_member_breakdown($position){
	$query = "SELECT `name` FROM `position` WHERE `id` = " . $position . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$positionname =  str_replace(" ", "+", $row[0]);;
	
	$query  = "SELECT j.shortname name, count(*) number ";
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
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_committee_pie_chart(){
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
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}

function report_chart_major_pie_chart(){
	$query = "SELECT j.shortname name, COUNT(*) as number ";
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
	$url .="&chs=500x200&chl=";
	for($i = 0; $i < sizeof($val); $i++){
		$url .= str_replace("&", "and", str_replace(" ", "+", $val[$i]['name']));
		if( ($i + 1) < sizeof($val) ){
			$url  .= "|";
		}
	}
	return $url;
}


?>