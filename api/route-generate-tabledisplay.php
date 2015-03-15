<?php

$api->post('/generate/tabledisplay', function() use ($api) {

	// Globale Variablen einbinden
	global $apiResponseHeader;


	// Prüfen ob alle für die Operation benötigen Daten vorhanden und nicht leer sind.
	API_checkRequiredFields(array('community_name', 'community_ssid', 'owner_name' ));


	// erforderliche Variablen laden
	$community_name			= $api->request->post('community_name');
	$community_ssid			= $api->request->post('community_ssid');
	$owner_name				= $api->request->post('owner_name');
	
	
	// optionale Variablen laden
	if( $api->request->post('community_website') != null ) { $community_website = $api->request->post('community_website'); } else { $community_website = ''; }
	if( $api->request->post('community_email') != null ) { $community_email = $api->request->post('community_email'); } else { $community_email = ''; }
	if( $api->request->post('organisation_website') != null ) { $organisation_website = $api->request->post('organisation_website'); } else { $organisation_website = ''; }
	if( $api->request->post('owner_website') != null ) { $owner_website = $api->request->post('owner_website'); } else { $owner_website = ''; }
	if( $api->request->post('owner_infos') != null ) { $owner_infos = $api->request->post('owner_infos'); } else { $owner_infos = ''; }
	
	
	// mPDF initialisieren
	$style = file_get_contents(__PATH__ . '/templates/div-a4-tabledisplay.css');
	
	$html = 
	
		'<div id="tabledisplay-target-community-ssid">'. $community_ssid .'</div>
				
		<div id="tabledisplay-information">
		
			freifunk.net<br>
			<span id="tabledisplay-target-organisation-website">'. $organisation_website .'</span>
			
		
		</div>
		
		<div id="tabledisplay-community">
			
			<p class="bold tabledisplay-community">Unsere Community</p>
			
			<p id="tabledisplay-target-community-name" class="tabledisplay-community">'. $community_name .'</p>				
			<p id="tabledisplay-target-community-website" class="tabledisplay-community">'. $community_website .'</p>
			<p id="tabledisplay-target-community-email" class="tabledisplay-community">'. $community_email .'</p>

		</div>
		
		<div id="tabledisplay-owner">
			
			<p id="tabledisplay-target-owner-name" class="bold tabledisplay-owner">'. $owner_name .'</p>				
			<p id="tabledisplay-target-owner-website" class="tabledisplay-owner">'. $owner_website .'</p>
			<p id="tabledisplay-target-owner-infos" class="tabledisplay-owner">'. $owner_infos .'</p>

		</div>';
				
	
	$mpdf=new mPDF(	'',    // mode - default ''
					'A4-L',    // format - A4, for example, default ''
					0,     // font size - default 0
					'',    // default font family
					0,    // margin_left
					0,    // margin right
					0,     // margin top
					0,    // margin bottom
					0,     // margin header
					0,     // margin footer
					'P'	);
					
	$mpdf->SetImportUse(); 
	$mpdf->SetDocTemplate(__PATH__ . '/templates/div-a4-tabledisplay.pdf', true);
	
	$mpdf->AddPage();

	$mpdf->WriteHTML($style, 1);
	$mpdf->WriteHTML($html);
	
	$filename = time() . '_' . randomString(10) . '.pdf';
	$link = __URL__ . '/cache/documents/'. $filename;
	$mpdf->Output(__PATH__ . '/cache/documents/'. $filename, 'F');
	
	if(isset($_SESSION['errors'])) {
		
		$codes = '';
		$messages = '';
		foreach($_SESSION['errors'] as $error) {
			
			$codes .= $error['code'] .' ';
			$messages .= $error['message'] .' ';
			
		}
		
		$apiResponseHeader['error'] = true;
		$apiResponseHeader['code'] = $codes;
		$apiResponseHeader['message'] = $messages;
		
		API_Response(200, '');
		$api->stop();
		
	} else {
		
		$apiResponseHeader['status'] = true;
		$apiResponseHeader['code'] = 'S0001';
		$apiResponseHeader['message'] = 'Operation ausgeführt';
	
		API_Response(200, $link);
		
	}
	
});

?>