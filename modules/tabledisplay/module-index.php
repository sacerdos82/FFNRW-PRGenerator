<?php

// Modultemplate festlegen
global $theme_template;
$module_template = 'tpl-tabledisplay.html'; // Namen der Template eingeben
if(file_exists(__PATH__ . '/themes/' . THEME_NAME . '/' . $module_template)) { $theme_template = $module_template; }


function initModule($action, $data) {
	
	// Globale Variablen
	global $smarty;
	
	
	// Modultitel
	$smarty->assign('title', 'VfN NRW | Tischaufsteller generieren');
	
	$smarty->assign('instructions', 'Du kannst in jedem Feld durch die Verwendung von "&lt;br&gt;" mehrere Zeilen erzeugen.');
	
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
	
	
	// Formular Aufsteller
	$formOwner = new html\form('owner', '', '', 'NONE');
	$formOwner->addField('text', 'name', 'Aufsteller Name');
	$formOwner->addField('text', 'website', 'Aufsteller Website');
	$formOwner->addField('textarea', 'infos', 'Aufsteller Infos');
	$smarty->assign('formOwner', $formOwner->draw());
	
}

?>