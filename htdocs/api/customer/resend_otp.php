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
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact_temp.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
	
	$mobile = GETPOST('mobile', 'alpha');
	
	$json = array();
	
	$object = new ContactTemp($db);

	$isExist = $object->getOTPFromMobile($mobile);
	if($isExist)
	{
		$status_code = '1';
		$message = 'Resend OTP';

		$otp = rand(111111, 999999);
		$table = MAIN_DB_PREFIX."socpeople_temp";
        $updateSql ="UPDATE ".$table." SET";
		$updateSql.= " otp = '".$db->escape($otp)."' ";
		$updateSql.= " WHERE mobile = '".(int)$mobile."' ";
		$resql = $db->query($updateSql);
		
		$json = array('status_code' => $status_code, 'message' => $message, 'user_otp' => $isExist['otp']);
	}
	else
	{
		$status_code = '0';
		$message = 'Phone number not exists! Please try again';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);