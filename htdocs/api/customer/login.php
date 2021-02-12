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
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact_temp.class.php';
	require_once DOL_DOCUMENT_ROOT.'/societe/class/societe_temp.class.php';
	
	require_once DOL_DOCUMENT_ROOT.'/core/login/functions_dolibarr.php';
	
	$mobile = GETPOST('mobile', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$isExist = check_user_mobile($mobile);
	$isExist1 = check_user_mobile_temp($mobile);

	
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
			$updateSql.= " otp = '".$db->escape($otp)."' ";
			$updateSql.= " WHERE rowid = '".(int)$isExist->rowid."' ";
			$resql = $db->query($updateSql);

			//$this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=rahul100gm&password=rahul100gm&senderid=IOOGMS&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$smsmessage."&route=35");

			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => "".$isExist->rowid, 'email' => $isExist->email, 'fullname' => $isExist->firstname." ".$isExist->lastname, 'user_otp' => "".$otp, 'customer_type' => 'existing');
		} else {
			$status_code = '0';
			$message = 'Customer not activated! Please contact support!!';
	
			$json = array('status_code' => $status_code, 'message' => $message);
		}	
	}
	else
	{
		if($isExist1)
		{
			$status_code = '1';
			$message = 'Temporary account data exists';
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => "".$isExist1->rowid, 'user_otp' => "".$isExist1->otp, 'fullname' => '', 'customer_type' => 'new');
		}
		else
		{
			// Save data in Temp table
			$objectSoc = new SocieteTemp($db);

			$otp = rand(111111, 999999);

			$sql = "INSERT INTO ".MAIN_DB_PREFIX."societe_temp SET phone = '".$db->escape($mobile)."', statut = '0'";
			$resql = $db->query($sql);
			$last_insert = $db->last_insert_id(MAIN_DB_PREFIX."societe_temp");

			$sql = "INSERT INTO ".MAIN_DB_PREFIX."socpeople_temp SET fk_soc = '".(int)$last_insert."', phone = '".$db->escape($mobile)."', phone_mobile = '".$db->escape($mobile)."', otp = '".$db->escape($otp)."', statut = '0'";
			$resql = $db->query($sql);
			$last_insert_people = $db->last_insert_id(MAIN_DB_PREFIX."socpeople_temp");
			
			/*
			$object = new ContactTemp($db);

			$object->firstname = $object->lastname = $object->priv = "";
			$object->statut = 0;

			$object->create($tempUser);*/

			$status_code = '1';
			$message = 'New temporary account has been created!';
			
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => "".$last_insert, 'user_otp' => "".$otp, 'fullname' => '', 'customer_type' => 'new');
		}
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);