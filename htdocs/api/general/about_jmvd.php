<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	global $conf;
	
	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	
	$json = array();
	
	$status_code = '1';
	$message = 'About Data';
		
	$json = array('status_code' => $status_code, 'message' => $message, 'phone' => $conf->global->MAIN_INFO_SOCIETE_TEL, 'email' => $conf->global->MAIN_INFO_SOCIETE_MAIL, 'address' => $conf->global->MAIN_INFO_SOCIETE_ADDRESS.' '.$conf->global->MAIN_INFO_SOCIETE_TOWN.', '.substr($conf->global->MAIN_INFO_SOCIETE_STATE, 5).', '.$conf->global->MAIN_INFO_SOCIETE_ZIP, 'about' => $conf->global->MAIN_INFO_SOCIETE_ABOUT);
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);