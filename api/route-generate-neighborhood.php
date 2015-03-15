<?php

$api->post('/generate/neighborhood', function() use ($api) {

	// Globale Variablen einbinden
	global $apiResponseHeader;


	// Prüfen ob alle für die Operation benötigen Daten vorhanden und nicht leer sind.
	API_checkRequiredFields(array('sender_receiver', 'sender_name', 'sender_contact1', 'community_name', 'community_ssid' ));


	// erforderliche Variablen laden
	$sender_receiver		= $api->request->post('sender_receiver');
	$sender_name			= $api->request->post('sender_name');
	$sender_contact1		= $api->request->post('sender_contact1');
	$community_name			= $api->request->post('community_name');
	$community_ssid			= $api->request->post('community_ssid');
	
	
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
			<p class="project-infos">'. $community_email .'<br><br></p>
			
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
		
		<div id="lettertext">
			
			<p class="lettertext">Hallo,<br><br></p>
			
			<p class="lettertext">Wie ihr vielleicht bereits bemerkt habt, gibt es in unserer Gegend ein neues WLAN, dessen Name "<span class="bold">'. $community_ssid .'</span>" lautet.</p>
			<p class="lettertext">Ihr dürft gerne euren Computer oder euer Telefon mit diesem Netzwerk verbinden und ins Internet gehen. Freifunk ist ein freies Netzwerk von Menschen und ihren Endgeräten, die mit ihrer Nachbarschaft kommunizieren und ihren Internet-Anschluss teilen möchten.</p>
			<p class="lettertext">Stellt auch ihr einen Freifunk-Knoten auf und erweitert das Netzwerk, um unsere Nachbarn zu erreichen, die außerhalb der Reichweite meines Knotens liegen. Als sog. Mesh-Netzwerk, kann es immer größer werden und noch mehr Menschen erreichen.Mit der Freifunk-Software lassen sich handelsübliche WLAN-Router zu Freifunk-Knoten umprogrammieren, die sich automatisch zueinander verbinden. Und das verbindet auch die Menschen.</p>
			<p class="lettertext">Mehr Informationen dazu findet ihr auf der Website. Dort wird alles ausführlich erklärt und es gibt Hinweise zu unseren Treffen. Ein fertiges Gerät, das ihr nur noch an eine Steckdose anschließen müsst, könnt ihr bei mir bekommen. Ein einzelnes Gerät verbraucht um die 7 Watt. Also nicht mehr als mit der Originalsoftware – und auch für Umwelt und kleine Geldbeutel nicht belastend.</p>
			<p class="lettertext">Meldet euch gerne bei mir, wenn ihr Fragen habt.<br><br></p>
			<p class="lettertext">Viele Grüße,</p>
		
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
	$mpdf->SetDocTemplate(__PATH__ . '/templates/letter-a4-basic.pdf', true);
	
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