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
	require_once DOL_DOCUMENT_ROOT.'/user/class/information_pages.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$status_code = '1';
		$message = 'About Data';
		
		$objectinfo = new InformationPages($db);
		
		$objectinfo->fetch(2);
		
		//echo '<pre>'; print_r($conf->global); exit;
				
		$json = array('status_code' => $status_code, 'message' => $message, 'phone' => $conf->global->MAIN_INFO_SOCIETE_TEL, 'email' => $conf->global->MAIN_INFO_SOCIETE_MAIL, 'address' => $conf->global->MAIN_INFO_SOCIETE_ADDRESS.' '.$conf->global->MAIN_INFO_SOCIETE_TOWN.', '.substr($conf->global->MAIN_INFO_SOCIETE_STATE, 5).', '.$conf->global->MAIN_INFO_SOCIETE_ZIP, 'about_title' => $objectinfo->title, 'about_content' => $objectinfo->content);
	}
	else
	{
		$status_code = '0';
		$message = 'User not exists.';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);