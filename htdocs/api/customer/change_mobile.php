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
	
	$old_password = GETPOST('old_password', 'alpha');
	$old_mobile = GETPOST('old_mobile', 'alpha');
	$mobile = GETPOST('mobile', 'alpha');
	$user_token = GETPOST('user_token', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	$record = $object->fetch($user_id);
		
	if($record)
	{
		$newToken = $object->userToken($user_id);
		
		if($newToken == $user_token)
		{
			$user_mobile = $object->user_mobile;
			
			if($old_mobile == $user_mobile)
			{
				$isPwdCorrect = $object->checkPassword($user_id, $old_password);
				
				if($isPwdCorrect)
				{
					$db->begin();
					// Change Password
					$object->setUserMobile($user_id, $mobile);
						
					$db->commit();
					
					$status_code = '1';
					$message = 'Mobile number changed successfully';
					
					$json = array('status_code' => $status_code, 'message' => $message);
				}
				else
				{
					$status_code = '0';
					$message = 'In-corrrect old password! Please try again';
					
					$json = array('status_code' => $status_code, 'message' => $message);
				}
			}
			else
			{
				$status_code = '0';
				$message = 'Mobile mismatch';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Token mismatch';
			
			$json = array('status_code' => $status_code, 'message' => $message);
		}
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