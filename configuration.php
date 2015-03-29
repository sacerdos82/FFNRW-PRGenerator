<?php
	
// Smarty
define('THEME_NAME', 		'two');	// Verzeichnisname der verwendeten Theme

global $smarty;
$smarty = new Smarty();

$smarty->setTemplateDir(__PATH__.'/themes/'.THEME_NAME.'/');
$smarty->setCompileDir(__PATH__.'/cache/smarty-compiled/');
$smarty->setConfigDir(__PATH__.'/cache/smarty-config/');
$smarty->setCacheDir(__PATH__.'/cache/smary-cache/');

$smarty->assign('theme_dir', __URL__ .'/themes/'. THEME_NAME);
$smarty->assign('url', __URL__);

// Bei Fehlern die untere Zeile aktivieren um die Debug-Konsole zu starten
// $smarty->debugging = true;



// SLIM REST Framework
\Slim\Slim::registerAutoloader();

// Interne API
$api = new \Slim\Slim();
$api->config( 
	array(	'debug' 			=> true,
			'log.level' 		=> \Slim\Log::DEBUG,
			'cookies.lifetime' 	=> '60 minutes'
	)
);
$api->setName('vfn-nrw:pr-generator:api');



// Diverses
define('OPTION_LOGFILE',	true);

?>