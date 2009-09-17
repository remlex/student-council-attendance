<?php

function authenticate($user, $pass){
	$authentication['user'] = "myusername"; //This is just for demo purposes
	$authentication['pass'] = "mypassword"; //This is just for demo purposes
	if($user == $authentication['user'] && $pass == $authentication['pass']){
		return true;
	}
	else{
		return false;
	}
}

?>