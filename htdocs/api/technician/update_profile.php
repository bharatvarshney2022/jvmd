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
	$email = GETPOST('email', 'alpha');
	
	$userPhoto = $_FILES['user_photo'];
	
	$user_photo = '';
	if (!empty($userPhoto['name']))
	{
		$isimage = image_format_supported($userPhoto['name']);
		if ($isimage > 0)
		{
			$user_photo = time()."-".dol_sanitizeFileName($userPhoto['name']);
			
			$dir = $conf->user->dir_output.'/'.get_exdir(0, 0, 0, 0, $object, 'user').$user_id;
			
			dol_mkdir($dir);

			if (@is_dir($dir)) {
				$newfile = $dir.'/'.$user_photo;
				$result = dol_move_uploaded_file($userPhoto['tmp_name'], $newfile, 1, 0, $userPhoto['error']);
			}
		}
	}
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$db->begin();
		
		$object->updateUserProfile($user_id, $firstname, $lastname, $email, $user_photo);	
		
		$db->commit();
		
		$status_code = '1';
		$message = 'User Profile updated successfully.';
		
		$isExistNew = $object->getUserData($user_id);
		
		if(is_null($isExistNew->photo))
		{
			$isExistNew->photo = 'no_image.png';
		
			$isExistNew->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$isExistNew->photo;
		}
		else
		{
			$isExistNew->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$user_id.'/'.$isExistNew->photo;
		}
		//unset($isExistNew->photo);
		
		if(is_null($isExistNew->state_id))
		{
			$isExistNew->state_id = "2";
		}
		
		if(is_null($isExistNew->country_id))
		{
			$isExistNew->country_id = "1";
		}
		
		$json = array('status_code' => $status_code, 'message' => $message, 'user_data' => $isExistNew);
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