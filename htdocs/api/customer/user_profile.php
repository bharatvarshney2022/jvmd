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
			$status_code = '1';
			$message = 'User Profile.';
			
			if(is_null($isExist->photo))
			{
				$isExist->photo = 'no_image.png';
			
				$isExist->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExist->photo;
			}
			else
			{
				$user_image = getImageFileNameForSize($isExist->photo, '_mini');
				$isExist->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExist->rowid.'/'.$user_image;
			}
			
			if(is_null($isExist->state_id))
			{
				$isExist->state_id = "2";
			}
			
			if(is_null($isExist->country_id))
			{
				$isExist->country_id = "1";
			}
			//unset($isExist->photo);
			
			$isExist->kyc1 = $isExist->kyc2 = $isExist->beneficial_name = $isExist->bank_name = $isExist->ifsc_code = $isExist->account_number = $isExist->bank_branch_name = $isExist->pan_number = $isExist->aadhar_number = '';
			
			$isExistAdditional = $object->getAdditionalFields($user_id);
			
			if($isExistAdditional)
			{
				$isExist->kyc1 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExist->rowid.'/'.$isExistAdditional->kyc1;
				$isExist->kyc2 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExist->rowid.'/'.$isExistAdditional->kyc2;
				$isExist->beneficial_name = $isExistAdditional->beneficial_name;
				$isExist->bank_name = $isExistAdditional->bank_name;
				$isExist->ifsc_code = $isExistAdditional->ifsc_code;
				$isExist->account_number = $isExistAdditional->account_number;
				$isExist->bank_branch_name = $isExistAdditional->bank_branch_name;
				$isExist->pan_number = $isExistAdditional->pan_number;
				$isExist->aadhar_number = $isExistAdditional->aadhar_number;
			}
			
			$isExist->user_id = $isExist->rowid;
			
			unset($isExist->rowid);	
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $isExist->user_id, 'email' => $isExist->email, 'user_mobile' => $isExist->user_mobile, 'firstname' => $isExist->firstname, 'lastname' => $isExist->lastname, 'user_image' => $isExist->user_image, 'pan_number' => $isExist->pan_number, 'aadhar_number' => $isExist->aadhar_number, 'password' => $isExist->pass_crypted, 'bank_branch_name' => $isExist->bank_branch_name, 'account_number' => $isExist->account_number, 'ifsc_code' => $isExist->ifsc_code, 'bank_name' => $isExist->bank_name, 'beneficial_name' => $isExist->beneficial_name, 'kyc1' => $isExist->kyc1, 'kyc2' => $isExist->kyc2);
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