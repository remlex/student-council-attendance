<?php

function db_clean_int($val){
	$val = mysql_escape_string($val);
	$val = intval($val);
	return $val;
}

function db_clean_text($val){
	$val = mysql_escape_string($val);
	return $val;
}

function smartyDateToDate($year, $month, $day){
	$date = $year . "-";
	if($month < 10){
		$date .= "0" . $month . "-";
	}
	else{
		$date .= $month . "-";
	}
	
	if($day < 10){
		$date .= "0" . $day;
	}
	else{
		$date .= $day;
	}
	return $date;
}

?>