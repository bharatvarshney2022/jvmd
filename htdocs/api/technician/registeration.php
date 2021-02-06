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
	
	$lastname = GETPOST('lastname', 'alpha');
	$firstname = GETPOST('firstname', 'alpha');
	$email_address = GETPOST('email_address', 'alpha');
	$mobile = GETPOST('mobile', 'alpha');
	$password = GETPOST('password', 'alpha');
	$confirm_password = GETPOST('confirm_password', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$isExist = $object->existMobile($mobile);
	
	if($isExist == 1)
	{
		$status_code = '0';
		$message = 'Mobile already exists!';
		
		$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'user_otp' => '');
	}
	
	$isExist = $object->existEmail($email_address);
	
	if($isExist == 1)
	{
		$status_code = '0';
		$message = 'Email already exists!';
		
		//$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'user_otp' => '');
	}
	
	if(!$json)
	{
		// Save USer
		$object->lastname = $lastname;
		$object->firstname = $firstname;
		$object->login = $object->user_mobile = $mobile;
		$object->email = $email_address;
		$object->user_status = 0;
		$object->employee = 0;
		$object->user_otp = $user_otp = rand(100000, 999999);
		
		require_once DOL_DOCUMENT_ROOT.'/core/lib/security2.lib.php';
		// PARTIAL WORKAROUND
		$generated_fake_api_key = getRandomPassword(true);
		
		$object->api_key = $generated_fake_api_key;
		$object->fk_country = 1;
		
		/*$password_crypted = dol_hash($password);
		$object->pass_crypted = $password_crypted;*/
		
		$db->begin();
		$id = $object->create($user);
		
		if ($id > 0) {
			$object->setPassword($user, $password);
			
			$db->commit();
			
			$object->setOTP($id, $user_otp);
			
			$content = str_replace(" ", "%20", "Your OTP is ".$user_otp);
			sendSMS($mobile, $content);
			
			$result = $object->SetUserGroup(24, $id, 1);
			
			$status_code = '1';
			$message = 'User created successfully';
			
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $id, 'user_otp' => "".$user_otp);
		}
		else
		{
			$db->rollback();
			
			$status_code = '0';
			$message = 'Something Went Wrong';
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'user_otp' => '');
		}	
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);