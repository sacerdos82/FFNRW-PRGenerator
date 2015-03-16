<?php

$api->post('/generate/statement/tmg-2015-03-12', function() use ($api) {

	// Globale Variablen einbinden
	global $apiResponseHeader;



	// Modul vorerst sperren
	$apiResponseHeader['error'] = true;
	$apiResponseHeader['code'] = 'E0003';
	$apiResponseHeader['message'] = 'Modul noch nicht freigegeben';
	
	API_Response(200, '');
	$api->stop();



	// Prüfen ob alle für die Operation benötigen Daten vorhanden und nicht leer sind.
	API_checkRequiredFields(array('receiver_name', 'receiver_salutation', 'sender_name', 'sender_street', 'sender_city', 'sender_contact1', 'community_name', 'content_text' ));


	// erforderliche Variablen laden
	$receiver_name			= $api->request->post('receiver_name');
	$receiver_salutation	= $api->request->post('receiver_salutation');
	
	$sender_name			= $api->request->post('sender_name');
	$sender_street			= $api->request->post('sender_street');
	$sender_city			= $api->request->post('sender_city');
	$sender_contact1		= $api->request->post('sender_contact1');
	
	$community_name			= $api->request->post('community_name');
	
	$content_text			= $api->request->post('content_text');
	
	
	// optionale Variablen laden
	if( $api->request->post('sender_contact2') != null ) { $sender_contact2 = $api->request->post('sender_contact2'); } else { $sender_contact2 = ''; }
	if( $api->request->post('community_website') != null ) { $community_website = $api->request->post('community_website'); } else { $community_website = ''; }
	if( $api->request->post('community_email') != null ) { $community_email = $api->request->post('community_email'); } else { $community_email = ''; }
	if( $api->request->post('organisation_website') != null ) { $organisation_website = $api->request->post('organisation_website'); } else { $organisation_website = ''; }
	
	
	// mPDF initialisieren
	$style = file_get_contents(__PATH__ . '/templates/letter-a4-statement.css');
	
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
			<p class="project-infos">'. $community_email .'<br><br></p>
			
			<p class="project-infos bold">Weitere Informationen</p>
			<p class="project-infos">freifunk.net</p>
			<p class="project-infos">'. $organisation_website .'<br><br></p>
			
			<p class="project-infos bold">Über mich</p>
			<p class="project-infos">'. $sender_name .'</p>
			<p class="project-infos">'. $sender_contact1 .'</p>
			<p class="project-infos">'. $sender_contact2 .'<br><br></p>
			
			<p class="project-infos bold">Wichtiger Hinweis</p>
			<p class="project-infos">
				Dieser Brief wurde über prgenerator.freifunk-nrw.de erzeugt und legt lediglich meine persönliche Meinung dar.<br>
				Es handelt sich nicht um ein offizielles Anschreiben des Fördervereins Freie Netzwerke e.V. oder einer anderen Organisation.
			</p>
		
		</div>
		
		<div id="address">
				
			<p>
				<span class="address-sender">'. $sender_name .' - '. $sender_street .' - '. $sender_city .'</span><br>
				Deutscher Bundestag<br>
				Platz der Republik 1<br>
				11011 Berlin	
			</p>
			
		</div>
		
		<div id="lettertext">
			
			<p class="lettertext">'. $receiver_salutation . ',<br><br></p>
			
			<p class="lettertext">'. $content_text .'</p>
			
			<p>
				<br>
				Mit freundlichen Grüßen<br>
				<br><br>
				'. $sender_name .'
			</p>
		
		</div>';
				
	
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
	
	$pagecount2 = $mpdf->SetSourceFile(__PATH__ . '/templates/attachment-stellungnahme_tmg_stoererhaftung_12315.pdf');
    for ($i=1; $i<=$pagecount2; $i++) {
        $templateID2 = $mpdf->ImportPage($i);
        $mpdf->SetPageTemplate($templateID2);
        $mpdf->AddPage();
    }
	
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