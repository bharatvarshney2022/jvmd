<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	
	$json = array();
	
	$object = new Contact($db);
	
	$userExists = $object->fetch($user_id);
	$slider = array();

	if($userExists)
	{
		$slider[] = array("id"=>"1","image"=>$dolibarr_main_url_root."/viewimage.php?cache=1&modulepart=medias&file=slider1.jpg");
		$slider[] = array("id"=>"2","image"=>$dolibarr_main_url_root."/viewimage.php?cache=1&modulepart=medias&file=slider2.png");

		$status_code = '1';
		$message = 'Customer Dashboard';
		
		$json = array('status_code' => $status_code, 'message' => $message, 'userData' => $userExists, 'slider' => $slider);
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);