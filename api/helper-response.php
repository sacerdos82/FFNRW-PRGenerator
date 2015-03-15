<?php

function API_Response($statusCode, $response) {
	
	// Globale Variablen einbinden
	global $apiResponseHeader;
	
	// Slim Object laden
	$api_internal = \Slim\Slim::getInstance();
	
	// StatusCode - 200, 400 etc. - setzen
	$api_internal->response->setStatus($statusCode);
	
	// Content-Type auf JSON setzen
	$api_internal->response->headers->set('Content-Type', 'application/json');
	
	// Response erstellen
	$apiResponse = array(	'header'	=> $apiResponseHeader,
						 	'body'		=> $response);
	
	// Response als JSON ausgeben
	echo json_encode($apiResponse);
	
}

?>