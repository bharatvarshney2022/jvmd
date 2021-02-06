<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$user_token = GETPOST('user_token', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$newToken = $object->userToken($user_id);
		
		if($newToken == $user_token)
		{
			$fk_user = $isExist->fk_user;
			
			$objectUser1 = new User($db);
			$objectUser1->fetch($fk_user);
			
			$headData = array();
			
			$isExistInner = $objectUser1->getUserData($fk_user);
			if($isExistInner)
			{
				$firstUserGroup = $objectUser1->usergrouplistingName($fk_user);
				
				if(is_null($isExistInner->photo))
				{
					$isExistInner->photo = 'no_image.png';
				
					$isExistInner->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExistInner->photo;
				}
				else
				{
					$isExistInner->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExistInner->rowid.'/'.$isExistInner->photo;
				}
				$user_type = 0;
				if(isset($firstUserGroup[0]))
				{
					$user_type = $firstUserGroup[0];
				}
				
				$areaData = "";
				
				$userData = $objectUser1->userState($fk_user);
				
				if($userData)
				{
					$areaData = implode(", ", $userData);
				}
							
				$status_code = '1';
				$message = 'Head Profile.';
				
				$json = array('status_code' => $status_code, 'message' => $message, 'user_type' => $user_type, 'user_image' => $isExistInner->user_image, 'firstname' => $isExistInner->firstname." ".$isExistInner->lastname, 'email' => $isExistInner->email, 'user_mobile' => $isExistInner->user_mobile, 'area' => $areaData);
			}
			else
			{
				$status_code = '0';
				$message = 'Head Profile not exists.';
				
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
		$message = 'User not exists.';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);