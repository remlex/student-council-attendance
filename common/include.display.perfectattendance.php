<?php

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

?>