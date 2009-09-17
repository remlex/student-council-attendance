<?php

function retreiveAchievementGoalValues(){
	$goal = array();
	for($i = 1; $i <= 10; $i++){
		$goal[$i] = $i;
	}
	return $goal;
}

function retreiveAchievementProgressValues($max){
	$goal = array();
	for($i = 1; $i <= $max; $i++){
		$goal[$i] = $i;
	}
	return $goal;
}

function retreiveAchievementPointsValues(){
	$points = array();
	for($i = 0; $i <= 200; $i += 5){
		$points[$i] = $i;
	}
	return $points;
}


?>