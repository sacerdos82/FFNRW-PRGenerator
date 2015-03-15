<?php

function isValidEmail($input) {
  
	// Nur ASCII-Zeichen erlaubt
  	$nonascii      = "\x80-\xff";
  	$nqtext        = "[^\\\\$nonascii\015\012\"]";
  	$qchar         = "\\\\[^$nonascii]";
  
  	// Optionen für nutzerspezifischen Teil
	$normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
	$quotedstring  = "\"(?:$nqtext|$qchar)+\"";
	$user_part     = "(?:$normuser|$quotedstring)";

	// Option für den Domainnamen
	$dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9._-]*\\.';
	$dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*';
	$dom_tldpart   = '[a-zA-Z]{2,5}';
	$domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";

	$regex         = "$user_part\@$domain_part";
	
	return preg_match("/^$regex$/",$input);
	
	}
	
?>