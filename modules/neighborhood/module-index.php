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
	

}

?>