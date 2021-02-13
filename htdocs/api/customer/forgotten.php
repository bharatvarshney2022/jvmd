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
	
	$email = GETPOST('email', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$result = $object->fetch('', $email, '', 1);
	
	$isExist = $object->getUserEmail($email);
	if($isExist)
	{
		$password = getRandomPassword(false);
		
		$newpassword = $object->setPassword($result, $password, 1);
		
		if ($newpassword < 0)
        {
			$status_code = '0';
			$message = 'Password not set. Please try again';
		}
		else
		{
			$result = $object->send_password($result, $newpassword, 1);
			
			$status_code = '1';
			$message = 'Your new password sent to your Email. Please check';
		}
		
		//$content = str_replace(" ", "%20", "Your OTP is ".$isExist->user_otp);
		//sendSMS($isExist->user_mobile, $content);
		
		$json = array('status_code' => $status_code, 'message' => $message, 'result' => $result); //, 'user_otp' => $isExist->user_otp, 'login' => $isExist->login, 'user_id' => $isExist->rowid
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