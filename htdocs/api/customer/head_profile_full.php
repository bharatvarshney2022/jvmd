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
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$fk_user = $isExist->fk_user;
		
		$objectUser1 = new User($db);
		$objectUser1->fetch($fk_user);
		
		$headData = array();
		
		$isExistInner = $objectUser1->getUserData($fk_user);
		if($isExistInner)
		{
			$firstUserGroup = $objectUser1->usergrouplisting($fk_user);
			
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
				$areaData = implode(",", $userData);
			}
			
			$headData[] = array('user_type' => $user_type, 'user_image' => $isExistInner->user_image, 'user_id' => $isExistInner->rowid, 'firstname' => $isExistInner->firstname, 'lastname' => $isExistInner->lastname, 'email' => $isExistInner->email, 'area' => $areaData);
			
			$fk_user1 = $isExistInner->fk_user;
			
			$objectUser2 = new User($db);
			$objectUser2->fetch($fk_user1);
			
			$isExistInner1 = $objectUser2->getUserData($fk_user1);
			if($isExistInner1)
			{
				$firstUserGroup1 = $objectUser2->usergrouplisting($fk_user1);
				
				if(is_null($isExistInner1->photo))
				{
					$isExistInner1->photo = 'no_image.png';
				
					$isExistInner1->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExistInner1->photo;
				}
				else
				{
					$isExistInner1->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExistInner1->rowid.'/'.$isExistInner1->photo;
				}
				
				$user_type1 = 0;
				if(isset($firstUserGroup1[0]))
				{
					$user_type1 = $firstUserGroup1[0];
				}
				
				$areaData1 = "";
			
				$userData1 = $objectUser1->userRegion($fk_user1);
				
				if($userData1)
				{
					$areaData1 = implode(",", $userData1);
				}
				
				$headData[] = array('user_type' => $user_type1, 'user_image' => $isExistInner1->user_image, 'user_id' => $isExistInner1->rowid, 'firstname' => $isExistInner1->firstname, 'lastname' => $isExistInner1->lastname, 'email' => $isExistInner1->email, 'area' => $areaData1);
				
				$fk_user2 = $isExistInner1->fk_user;
			}
		}
		
		if($headData)
		{
			$status_code = '1';
			$message = 'Head Profile.';
		}
		else
		{
			$status_code = '0';
			$message = 'Head Profile not exists.';
		}
		
		
		$json = array('status_code' => $status_code, 'message' => $message, 'headData' => $headData);
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