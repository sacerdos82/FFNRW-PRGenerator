<?php
	
function isValidURL($url) {
	
	if(preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) { return true; }
		else { return false; }
	
}

?>