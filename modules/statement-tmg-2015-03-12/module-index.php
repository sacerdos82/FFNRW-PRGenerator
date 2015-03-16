<?php

// Modultemplate festlegen
global $theme_template;
$module_template = 'tpl-statement-tmg-2015-03-12.html'; // Namen der Template eingeben
if(file_exists(__PATH__ . '/themes/' . THEME_NAME . '/' . $module_template)) { $theme_template = $module_template; }


function initModule($action, $data) {
	
	// Globale Variablen
	global $smarty;
	
	
	// Modultitel
	$smarty->assign('title', 'VfN NRW | Anschreiben Abgeordneter Bundestag - Entwurf TMG 12.03.2015');
	
	$smarty->assign('instructions', 'Du kannst in jedem Feld durch die Verwendung von "&lt;br&gt;" mehrere Zeilen erzeugen.');
	
	// Formular Empfänder
	$formReceiver = new html\form('receiver', '', '', 'NONE');
	$formReceiver->addField('text', 'name', 'Name des Abgeordneten', '', '', 'Den Namen deines Abgeordneten kannst du <a href="http://www.bundestag.de/abgeordnete">hier</a> herausfinden');
	$formReceiver->addField('text', 'salutation', 'Anrede');
	$smarty->assign('formReceiver', $formReceiver->draw());
	
	// Formular Absender
	$formSender = new html\form('sender', '', '', 'NONE');
	$formSender->addField('text', 'name', 'Dein Name');
	$formSender->addField('text', 'street', 'Deine Straße');
	$formSender->addField('text', 'city', 'Deine PLZ / Dein Ort');
	$formSender->addField('text', 'contact1', 'Kontaktmöglichkeit 1');
	$formSender->addField('text', 'contact2', 'Kontaktmöglichkeit 2');
	$smarty->assign('formSender', $formSender->draw());
	
	
	// Formular Community
	$formCommunity = new html\form('community', '', '', 'NONE');
	$formCommunity->addField('text', 'name', 'Community Name');
	$formCommunity->addField('text', 'website', 'Community Website');
	$formCommunity->addField('text', 'email', 'Community Email');
	$smarty->assign('formCommunity', $formCommunity->draw());
	
	
	// Formular Organisation
	$formOrganisation = new html\form('organisation', '', '', 'NONE');
	$formOrganisation->addField('text', 'website', 'Organisation Website');
	$smarty->assign('formOrganisation', $formOrganisation->draw());
	
	
	// Formular Text
	$formContent = new html\form('content', '', '', 'NONE');
	$formContent->addField('textarea', 'text', 'Inhalt', '', '', '', '',
		'der kürzlich öffentlich gewordene Entwurf zur Neuregelung des Telemediengesetzes (vom 17.2.2015) der Bundesregierung stellt die Verbreitung digitaler Netzwerke in Deutschland vor große Herausforderungen.<br><br>'.
		'Mit diesem Entwurf positioniert sich die Bundesregierung leider klar gegen die Verbreitung digitaler Netzwerke und WLAN-Zugangspunkte zum Internet in Deutschland. Der Förderverein freie Netzwerke e.V. (siehe Anhang) legt in sechs Punkten dar, warum diese Gesetzesänderung weder wünschenswert, noch überhaupt umsetzbar ist und die aktuelle Situation eher verschlechtert als verbessert, sowie zu enormen Kosten für Verwaltung und Wirtschaft führen wird.<br><br>'.
		'Meiner Meinung nach kann es sich Deutschland aus ökonomischer wie kultureller Sicht nicht länger leisten noch weiter in Hinblick auf die Verfügbarkeit breitbandiger und neutraler Internetzugänge noch weiter zurück zu fallen.<br><br>'.
		'Deutschland hat im Schnitt weniger als 3 frei zugängliche Hotspots pro 10.000 Einwohner. Zum Vergleich: In Schweden sind es 10, in Großbritannien knapp 30, in Südkorea gut 37. Darüber hinaus ist Deutschland eines der ganz wenigen Länder weltweit, dass weiterhin an einer Störerhaftung in WLAN-Netzwerken festhält.<br><br>'.
		'Jeder neue Wachstumsmarkt stützt sich auf diese Technologie. Jeder bedeutende Gesellschaftliche Diskurs wird mittlerweile im Internet ausgetragen. Wenn neue Arbeitsplätze und neue Formen des Erwerbs entstehen werden, dann hier.<br><br>'.
		'Ich bitte Sie deshalb um Unterstützung und würden mich sehr freuen, wenn Sie die Stellungnahme im Anhang bei der weiteren Arbeit an dem Gesetz beziehungsweise in Gesprächen mit den Parteikollegen berücksichtigen.' );
	$smarty->assign('formContent', $formContent->draw());
	

}

?>