<?php

function randomString($count) {
	
	$possibleChars = 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789'; 
	$randomString = ''; 
	
	while(strlen($randomString) < $count) { 
		$randomString .= substr($possibleChars, (rand() % (strlen($possibleChars))), 1); 
	}
	
	return $randomString;
	
}
	
?>