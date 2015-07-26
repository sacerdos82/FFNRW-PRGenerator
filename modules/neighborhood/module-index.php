<?php

// Modultemplate festlegen
global $theme_template;
$module_template = 'tpl-neighborhood.html'; // Namen der Template eingeben
if(file_exists(__PATH__ . '/themes/' . THEME_NAME . '/' . $module_template)) { $theme_template = $module_template; }


function initModule($action, $data) {
	
	// Globale Variablen
	global $smarty;
	
	
	// Modultitel
	$smarty->assign('title', 'VfN NRW | Nachbarschaftsbrief generieren');
	
	$smarty->assign('instructions', 'Du kannst in jedem Feld durch die Verwendung von "&lt;br&gt;" mehrere Zeilen erzeugen.');
	
	// Formular Absender
	$formSender = new html\form('sender', '', '', 'NONE');
	$formSender->addField('text', 'receiver', 'An wen geht der Brief?');
	$formSender->addField('text', 'name', 'Dein Name');
	$formSender->addField('text', 'contact1', 'Kontaktmöglichkeit 1');
	$formSender->addField('text', 'contact2', 'Kontaktmöglichkeit 2');
	$smarty->assign('formSender', $formSender->draw());
	
	
	// Formular Community
	$formCommunity = new html\form('community', '', '', 'NONE');
	$formCommunity->addField('text', 'name', 'Community Name');
	$formCommunity->addField('text', 'website', 'Community Website');
	$formCommunity->addField('text', 'email', 'Community Email');
	$formCommunity->addField('text', 'ssid', 'Community SSID');
	$smarty->assign('formCommunity', $formCommunity->draw());
	
	
	// Formular Organisation
	$formOrganisation = new html\form('organisation', '', '', 'NONE');
	$formOrganisation->addField('text', 'website', 'Organisation Website');
	$smarty->assign('formOrganisation', $formOrganisation->draw());
	
	
	// Formular Text
	$content = 	'<p>Hallo,<br><br></p>' . "\n"
			 .	'<p>Wie ihr vielleicht bereits bemerkt habt, gibt es in unserer Gegend ein neues WLAN, dessen Name "..." lautet.</p>'  . "\n"
			 .	'<p>Ihr dürft gerne euren Computer oder euer Telefon mit diesem Netzwerk verbinden und ins Internet gehen. Freifunk ist ein freies Netzwerk von Menschen und ihren Endgeräten, die mit ihrer Nachbarschaft kommunizieren und ihren Internet-Anschluss teilen möchten.</p>' . "\n"
			 .	'<p>Stellt auch ihr einen Freifunk-Knoten auf und erweitert das Netzwerk, um unsere Nachbarn zu erreichen, die außerhalb der Reichweite meines Knotens liegen. Als sog. Mesh-Netzwerk, kann es immer größer werden und noch mehr Menschen erreichen.Mit der Freifunk-Software lassen sich handelsübliche WLAN-Router zu Freifunk-Knoten umprogrammieren, die sich automatisch zueinander verbinden. Und das verbindet auch die Menschen.</p>' . "\n"
			 .	'<p>Mehr Informationen dazu findet ihr auf der Website. Dort wird alles ausführlich erklärt und es gibt Hinweise zu unseren Treffen. Ein fertiges Gerät, das ihr nur noch an eine Steckdose anschließen müsst, könnt ihr bei mir bekommen. Ein einzelnes Gerät verbraucht um die 7 Watt. Also nicht mehr als mit der Originalsoftware – und auch für Umwelt und kleine Geldbeutel nicht belastend.</p>' . "\n"
			 .	'<p>Meldet euch gerne bei mir, wenn ihr Fragen habt.<br><br></p>' . "\n"
			 .	'<p>Viele Grüße,</p>';
				
	$formContent = new html\form('content', '', '', 'NONE');
	$formContent->addField('textarea', 'content', 'Brieftext', '', '', '', '', $content);
	$smarty->assign('formContent', $formContent->draw());

}

?>