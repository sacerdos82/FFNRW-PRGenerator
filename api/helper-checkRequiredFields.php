<?php

function API_checkRequiredFields($requiredFields) {

	// Globale Variablen einbinden
	global $apiResponseHeader;


	$error = false;
    $errorFields = '';
    $requestParams = array();
    $requestParams = $_REQUEST;
    

    // PUT-Methode abfangen
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		
		$api_internal = \Slim\Slim::getInstance();
		parse_str($app->request()->getBody(), $requestParams);

    }
    
    
    // Paramenter prüfen
    foreach ($requiredFields as $field) {
		
		if (!isset($requestParams[$field]) || strlen(trim($requestParams[$field])) <= 0) {
            $error = true;
            $errorFields .= $field . ', ';
        }
        
    }
    
    
    // Fehler ausgeben
	if ($error) {
		
		$api_internal = \Slim\Slim::getInstance();
		
		// API Ausgabe erzeugen
		$errorMsg = returnError('E0002', 'API-Internal-CheckFields');
		$apiResponseHeader['error'] = true;
		$apiResponseHeader['code'] = $errorMsg['code'];
		$apiResponseHeader['message'] = $errorMsg['message'] .' ('. substr($errorFields, 0, -2) .')';
		API_Response(200, '');
		
		// Ausführung anhalten
		$api_internal->stop();
		
    }
    
}

?>