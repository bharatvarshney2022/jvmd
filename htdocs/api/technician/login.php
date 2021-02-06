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
	
	require_once DOL_DOCUMENT_ROOT.'/core/login/functions_subpe.php';
	
	$mobile = GETPOST('mobile', 'alpha');
	$password = GETPOST('password', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$isExist = check_user_password($mobile, $password);
	
	if($isExist->login != $mobile)
	{
		$status_code = '0';
		$message = 'Incorrect Mobile or Password!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	else
	{
		if($isExist)
		{
			$status_code = '1';
			$message = 'User logged-in successfully';
			
			$user_profile = $object->userProfileExists($isExist->rowid);
			$isExist->user_profile = $user_profile;
			
			// Last Question answer
			$answered = $object->lastAnswered($isExist->rowid);
			$isExist->question_completed = $answered;
			
			$isExist->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExist->rowid.'/'.$isExist->photo;
			
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_data' => $isExist);
		}
		else
		{
			$status_code = '0';
			$message = 'Sorry! User not exists.';
			
			$json = array('status_code' => $status_code, 'message' => $message);
		}
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);