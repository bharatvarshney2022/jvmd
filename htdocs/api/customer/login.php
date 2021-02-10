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
	
	require_once DOL_DOCUMENT_ROOT.'/core/login/functions_dolibarr.php';
	
	$mobile = GETPOST('mobile', 'alpha');
	//$password = GETPOST('password', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	//$isExist = check_user_password($mobile, $password);
	$isExist = check_user_mobile($mobile);
	
	if($isExist->phone_mobile != $mobile)
	{
		$status_code = '0';
		$message = 'Incorrect Mobile Or Mobile not exist in our system !!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	else
	{
		if($isExist)
		{
			if($isExist->statut)
			{		
				$status_code = '1';
				$message = 'Customer verified successfully';
				
				$otp = rand(111111, 999999);
                $smsmessage = str_replace(" ", "%20", "Your OTP is ".$otp);
              	$table = MAIN_DB_PREFIX."socpeople";
                $updateSql ="UPDATE ".$table." SET";
				$updateSql.= " otp = '".$otp."' ";
				$updateSql.= " WHERE rowid = '".$isExist->rowid."' ";
		
				//echo $sql;
				$resql=$db->query($updateSql);

               //$this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=rahul100gm&password=rahul100gm&senderid=IOOGMS&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$smsmessage."&route=35");
				
				$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $isExist->rowid, 'email' => $isExist->email, 'firstname' => $isExist->firstname, 'lastname' => $isExist->lastname, 'user_otp' => $otp);
			}else{
				$status_code = '0';
				$message = 'Customer not active please contact support!!';
		
				$json = array('status_code' => $status_code, 'message' => $message);
			}	
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