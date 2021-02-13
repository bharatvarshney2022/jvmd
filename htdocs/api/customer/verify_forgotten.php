<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/usergroup.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$user_otp = GETPOST('user_otp', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->checkOTP($user_id, $user_otp);
	if($isExist == 0)
	{
		$status_code = '0';
		$message = 'Incorrect OTP! Please try again';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	if(!$json)
	{
		$db->begin();
		
		$object->verifyOTP($user_id, $user_otp);
		$db->commit();
			
		$status_code = '1';
		$message = 'User verified successfully';
		
		$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $user_id);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);