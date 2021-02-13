<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
	
	$user_id = GETPOST('user_id', 'int');
	
	$firstname = GETPOST('firstname', 'alpha');
	$lastname = GETPOST('lastname', 'alpha');
	$userPhoto = $_FILES['user_photo'];
	$user_token = GETPOST('user_token', 'alpha');
	
	$beneficial_name = GETPOST('beneficial_name', 'alpha');
	$bank_name = GETPOST('bank_name', 'alpha');
	$ifsc_code = GETPOST('ifsc_code', 'alpha');
	$account_number = GETPOST('account_number', 'alpha');
	$bank_branch_name = GETPOST('bank_branch_name', 'alpha');
	$pan_number = GETPOST('pan_number', 'alpha');
	$aadhar_number = GETPOST('aadhar_number', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$kyc1_filename = $kyc2_filename = '';
	
	$user_photo = '';
	if (!empty($userPhoto['name']))
	{
		$isimage = image_format_supported($userPhoto['name']);
		if ($isimage > 0)
		{
			$user_photo = dol_sanitizeFileName($userPhoto['name']);
			$user_photo1 = str_replace(".png", ".jpg", $user_photo);
			
			$dir = $conf->user->dir_output.'/'.get_exdir(0, 0, 0, 0, $object, 'user').$user_id;
			
			dol_mkdir($dir);

			if (@is_dir($dir)) {
				$newfile = $dir.'/'.$user_photo1;
				$result = dol_move_uploaded_file($userPhoto['tmp_name'], $newfile, 1, 0, $userPhoto['error']);
				
				$object->addThumbs($newfile);
				
				// Copy Files
				/*$user_image_mini = getImageFileNameForSize($user_photo1, '_mini');
				$user_image_mini1 = str_replace(".jpg", ".png", $user_image_mini);
				
				$user_image_small = getImageFileNameForSize($user_photo1, '_small');
				$user_image_small1 = str_replace(".jpg", ".png", $user_image_small);
				
				copy($dir."/thumbs/".$user_image_mini, $dir."/thumbs/".$user_image_mini1);
				copy($dir."/thumbs/".$user_image_small, $dir."/thumbs/".$user_image_small1);*/
			}
		}
	}
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$newToken = $object->userToken($user_id);
		
		if($newToken == $user_token)
		{
			$db->begin();
			
			//$user_photo = str_replace(".jpg", ".png", $user_photo);
			
			$object->updateGeneralUserProfile($user_id, $firstname, $lastname, $user_photo1);	
			
			$userFieldData = array('kyc1' => $kyc1_filename, 'kyc2' => $kyc2_filename, 'beneficial_name' => $beneficial_name, 'bank_name' => $bank_name, 'ifsc_code' => $ifsc_code, 'account_number' => $account_number, 'bank_branch_name' => $bank_branch_name, 'pan_number' => $pan_number, 'aadhar_number' => $aadhar_number);
					
			// Submit User KYC Data
			$object->SetUserExtraFields($user_id, $userFieldData);
			
			$db->commit();
			
			$status_code = '1';
			$message = 'User Profile updated successfully.';
			
			$newUserData = $object->getUserData($user_id);
			
			$newUserData->kyc1 = $newUserData->kyc2 = $newUserData->beneficial_name = $newUserData->bank_name = $newUserData->ifsc_code = $newUserData->account_number = $newUserData->bank_branch_name = $newUserData->pan_number = $newUserData->aadhar_number = '';
			
			$newUserDataAdditional = $object->getAdditionalFields($user_id);
			
			if($newUserDataAdditional)
			{
				$newUserData->kyc1 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$newUserData->rowid.'/'.$newUserDataAdditional->kyc1;
				$newUserData->kyc2 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$newUserData->rowid.'/'.$newUserDataAdditional->kyc2;
				$newUserData->beneficial_name = $newUserDataAdditional->beneficial_name;
				$newUserData->bank_name = $newUserDataAdditional->bank_name;
				$newUserData->ifsc_code = $newUserDataAdditional->ifsc_code;
				$newUserData->account_number = $newUserDataAdditional->account_number;
				$newUserData->bank_branch_name = $newUserDataAdditional->bank_branch_name;
				$newUserData->pan_number = $newUserDataAdditional->pan_number;
				$newUserData->aadhar_number = $newUserDataAdditional->aadhar_number;
			}
			
			if(is_null($newUserData->photo))
			{
				$newUserData->photo = 'no_image.png';
			
				$newUserData->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$newUserData->photo;
			}
			else
			{
				$user_image = getImageFileNameForSize($newUserData->photo, '_mini');
				$newUserData->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$user_id.'/'.$user_image;
			}
			
			$newUserData->user_id = $newUserData->rowid;
			
			unset($newUserData->rowid);	
			
			//unset($newUserData->photo);
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $newUserData->user_id, 'email' => $newUserData->email, 'user_mobile' => $newUserData->user_mobile, 'firstname' => $newUserData->firstname, 'lastname' => $newUserData->lastname, 'user_image' => $newUserData->user_image, 'pan_number' => $newUserData->pan_number, 'aadhar_number' => $newUserData->aadhar_number, 'bank_branch_name' => $newUserData->bank_branch_name, 'account_number' => $newUserData->account_number, 'ifsc_code' => $newUserData->ifsc_code, 'bank_name' => $newUserData->bank_name, 'beneficial_name' => $newUserData->beneficial_name, 'kyc1' => $newUserData->kyc1, 'kyc2' => $newUserData->kyc2);
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