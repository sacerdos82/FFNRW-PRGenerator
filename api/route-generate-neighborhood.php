<?php

$api->post('/generate/neighborhood', function() use ($api) {

	// Globale Variablen einbinden
	global $apiResponseHeader;


	// Prüfen ob alle für die Operation benötigen Daten vorhanden und nicht leer sind.
	API_checkRequiredFields(array('sender_receiver', 'sender_name', 'sender_contact1', 'community_name', 'community_ssid', 'content_content'));


	// erforderliche Variablen laden
	$sender_receiver		= $api->request->post('sender_receiver');
	$sender_name			= $api->request->post('sender_name');
	$sender_contact1		= $api->request->post('sender_contact1');
	$community_name			= $api->request->post('community_name');
	$community_ssid			= $api->request->post('community_ssid');
	$content_content		= $api->request->post('content_content');
	
	
	// optionale Variablen laden
	if( $api->request->post('sender_contact2') != null ) { $sender_contact2 = $api->request->post('sender_contact2'); } else { $sender_contact2 = ''; }
	if( $api->request->post('community_website') != null ) { $community_website = $api->request->post('community_website'); } else { $community_website = ''; }
	if( $api->request->post('community_email') != null ) { $community_email = $api->request->post('community_email'); } else { $community_email = ''; }
	if( $api->request->post('organisation_website') != null ) { $organisation_website = $api->request->post('organisation_website'); } else { $organisation_website = ''; }
	
	
	// mPDF initialisieren
	$style = file_get_contents(__PATH__ . '/templates/letter-a4-neighborhood.css');
	
	$html = 
	
		'<div id="project-infos">
				
			<p class="project-infos bold">Über das Projekt</p>
			<p class="project-infos">
				Unsere Vision ist die Demokratisierung der Kommunikationsmedien durch freie Netzwerke. Die praktische Umsetzung dieser Idee nehmen freifunk-Communities in der ganzen Welt in Angriff.<br>
				<br>
			</p>
			
			<p class="project-infos bold">Unsere Community</p>
			<p class="project-infos">'. $community_name .'</p>
			<p class="project-infos">'. $community_website .'</p>
			<p class="project-infos">'. $community_email .'</p>
			<p class="project-infos">'. $community_ssid .'<br><br></p>
			
			<p class="project-infos bold">Weitere Informationen</p>
			<p class="project-infos">freifunk.net</p>
			<p class="project-infos">'. $organisation_website .'<br><br></p>
			
			<p class="project-infos bold">Über mich</p>
			<p class="project-infos">'. $sender_name .'</p>
			<p class="project-infos">'. $sender_contact1 .'</p>
			<p class="project-infos">'. $sender_contact2 .'</p>
		
		</div>
		
		<div id="address">
				
			<p>'. $sender_receiver .'</p>
			
		</div>
		
		<div id="lettertext">'. $content_content .'</div>';
				
	
	$mpdf=new mPDF(	'',    // mode - default ''
					'',    // format - A4, for example, default ''
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
	$pagecount1 = $mpdf->SetSourceFile(__PATH__ . '/templates/letter-a4-basic.pdf');
	$templateID1 = $mpdf->ImportPage($pagecount1);
	$mpdf->SetPageTemplate($pagecount1); 
	
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