<?php

//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// STANDARD FORM VALIDATION
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
//Given the form's name and time to live, add it as a valid key in the database
function secureform_add($name, $ttl){
	$uuid = uniqid("U",true);
	$query = "INSERT INTO form (`key`, `expires`, `name`, `session`) VALUES('" . $uuid . "', DATE_ADD(NOW(), INTERVAL " . $ttl . " MINUTE), '" . $name . "', '" . session_id() . "');";
	$result = mysql_query($query);
	return $uuid;
}

//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
//Test if a key for a given form is valid, if so, invalidate it (one time use) and return true, otherwise return false
function secureform_test($key, $name){
	//Remove expired sessions
	secureform_purge();
	//Is the key valid?
	$query = "SELECT COUNT(*) num FROM form WHERE `key` = '" . $key . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$found = $row[0];
	//The key was found, lets do some more processing...
	if($found == 1){
		$query = "SELECT `name`, `session` FROM form WHERE `key` = '" . $key . "';";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		//Test if the session expired...
			//We don't do this because we just removed all of the expired sessions from the database
		//Test if the form name matches
		if($row[0] != $name){
			return false; //INVALID
		}
		//Test if the session matches
		if($row[1] != session_id()){
			return false; //INVALID
		}
	}
	//The key was not found so we are done...
	else{
		return false; //INVALID
	}
	//Invalidate the current key
	$query = "DELETE FROM form WHERE `key` = '" . $key . "' LIMIT 1;";
	$result = mysql_query($query);
	//After all of those test, we are sure the session is valid!
	return true; //VALID
}


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
// FORM VALIDATION THAT IS BOUND TO A PRIMARY KEY
//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
//Given the form's name and time to live, add it as a valid choice in the database
function secureform_add_pk($name, $ttl, $pk){
	$uuid = uniqid("U",true);
	$query = "INSERT INTO form (`key`, `expires`, `name`, `session`, `pk`) VALUES('" . $uuid . "', DATE_ADD(NOW(), INTERVAL " . $ttl . " MINUTE), '" . $name . "', '" . session_id() . "', '" . $pk . "');";
	$result = mysql_query($query);
	return $uuid;
}

//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
//Test if a key for a given form is valid, if so, invalidate it (one time use) and return true, otherwise return false
function secureform_test_pk($key, $name, $pk){
	//Remove expired sessions
	secureform_purge();
	//Is the key valid?
	$query = "SELECT COUNT(*) num FROM form WHERE `key` = '" . $key . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$found = $row[0];
	//The key was found, lets do some more processing...
	if($found == 1){
		$query = "SELECT `name`, `session`, `pk` FROM form WHERE `key` = '" . $key . "';";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		//Test if the session expired...
			//We don't do this because we just removed all of the expired sessions from the database
		//Test if the form name matches
		if($row[0] != $name){
			return false; //INVALID
		}
		//Test if the session matches
		if($row[1] != session_id()){
			return false; //INVALID
		}
		//Test if the pk matches
		if($row[2] != $pk){
			return false; //INVALID
		}
	}
	//The key was not found so we are done...
	else{
		return false; //INVALID
	}
	//Invalidate the current key
	$query = "DELETE FROM form WHERE `key` = '" . $key . "' LIMIT 1;";
	$result = mysql_query($query);
	//After all of those test, we are sure the session is valid!
	return true; //VALID
}


//----------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------------------------------------//
//Remove all of the exired sessions from the database
function secureform_purge(){
	$query = "DELETE FROM form WHERE `expires` < NOW();";
	$result = mysql_query($query);
}

?>