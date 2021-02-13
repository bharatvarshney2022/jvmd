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
	$password = GETPOST('password', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	$record = $object->fetch($user_id);
	
	if($record)
	{
		$db->begin();
		// Change Password
		$object->setPassword($user, $password);
			
		$db->commit();
			
		$status_code = '1';
		$message = 'Password changed successfully';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	else
	{
		$status_code = '0';
		$message = 'User not exists! Please try again';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);