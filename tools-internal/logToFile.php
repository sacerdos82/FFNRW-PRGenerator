<?php

function logToFile($logfile_name, $input) {
	
	if(!OPTION_LOGFILE) { 

		return false; 
		
	} else {
		
		$logfile_handle = fopen(__PATH__ . '/logfiles/'. date('Y-m') .'-'. $logfile_name . '.log', 'ab');
		fwrite($logfile_handle, date('Y-m-d H:i:s') .' | ' . $input . "\n");
		fclose($logfile_handle);

	}
}

?>