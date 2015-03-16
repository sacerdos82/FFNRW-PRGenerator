<?php


function returnError($errorcode, $location) {

	$errorcodes = array(	'E0001'	=> 'Keine Daten übermittelt.',
							'E0002'	=> 'Felder fehlen oder sind leer.',
							'E0003' => 'Modul nicht freigegeben' );
							
	logtoFile('general-errors', '('. $location . ') ' . $errorcode .': '. $errorcodes[$errorcode]);
	
	$output_array = array(  'output'	=> '['. $location .'] ('. $errorcode .') '. $errorcodes[$errorcode],
							'code'		=> $errorcode,
							'message'	=> $errorcodes[$errorcode] );
							
	$_SESSION['errors'][] = $output_array;

	return $output_array;
	
}

?>