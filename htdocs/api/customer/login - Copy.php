<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/usergroup.class.php';
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact_temp.class.php';
	require_once DOL_DOCUMENT_ROOT.'/societe/class/societe_temp.class.php';
	
	require_once DOL_DOCUMENT_ROOT.'/core/login/functions_dolibarr.php';
	
	$user_mobile = GETPOST('mobile', 'alpha');
	$email = GETPOST('email', 'alpha');
	$device_id = GETPOST('device_id', 'alpha');
	$fcmToken = GETPOST('fcmToken', 'alpha');
	
	$json = array();
	
	
	
	//$isExist = check_user_mobile($user_mobile, $device_id);
	$isExist = check_user_mobile_email($user_mobile, $email);
	$isEmailExist = check_user_email($email);
	$isExist1 = check_user_mobile_temp($user_mobile);
	$isDeviceExist = check_user_device($device_id);

	if($isExist)
	{
		if($isExist->statut)
		{		
			$status_code = '1';
			$messagetxt = 'Customer logged in successfully';
			
			$otp = rand(111111, 999999);
            $smsmessage = str_replace(" ", "%20", "Dear ".$isExist->firstname." ".$isExist->lastname.", Your OTP for login is ".$otp.". Please DO NOT share OTP.");

          	$table = MAIN_DB_PREFIX."socpeople";
            $updateSql ="UPDATE ".$table." SET";
			$updateSql.= " otp = '".$db->escape($otp)."',  email = '".$db->escape($email)."', fcmToken = '".$db->escape($fcmToken)."', device_id = '".$db->escape($device_id)."' ";
			$updateSql.= " WHERE rowid = '".(int)$isExist->rowid."' ";
			$resql = $db->query($updateSql);

			$id = $isExist->rowid;
			$object = new Contact($db);
			$object->fetch($id);
			/*Email*/
			// Actions to send emails
			/*$action = 'send';
			$_POST['sendto'] = $email;
			$_POST['receiver'] = 'contact';
			
			$_POST['message'] = "Dear ".$isExist->firstname." ".$isExist->lastname.", Your OTP for login is ".$otp.". Please DO NOT share OTP.";

			$_POST['subject'] = 'JVMD OTP Detail';
			
			$_POST['fromtype'] = 'company';
			//$_POST['sendtocc'] = 'ashok.sharma@microprixs.in';
			$_POST['sender'] = $email;
			
			$triggersendname = 'COMPANY_SENTBYMAIL';
			$paramname = '';
			$mode = 'Information';
			$trackid = '';
			include DOL_DOCUMENT_ROOT.'/core/actions_sendmails.inc.php';
*/
			$json = array('status_code' => $status_code, 'message' => $messagetxt, 'user_id' => "".$isExist->fk_soc, 'email' => $isExist->email, 'fullname' => $isExist->firstname." ".$isExist->lastname, 'mobile' => "".$user_mobile, 'user_otp' => "".$otp, 'customer_type' => 'existing');
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
			$messagetxt = 'New account has been created, Your OTP have been send on your email for verification.';

			$table = MAIN_DB_PREFIX."socpeople_temp";
            $updateSql ="UPDATE ".$table." SET";
			$updateSql.= " otp = '".$db->escape($isExist1->otp)."',  email = '".$db->escape($email)."' ";
			$updateSql.= " WHERE rowid = '".(int)$isExist1->rowid."' ";
			$resql = $db->query($updateSql);

			$smsmessage = str_replace(" ", "%20", "Dear ".$isExist->firstname." ".$isExist->lastname.", Your OTP for login is ".$isExist1->otp.". Please DO NOT share OTP.");
			$SENDERID = $conf->global->MAIN_MAIL_SMS_FROM;
			$PHONE = $user_mobile;
			$MESSAGE = $smsmessage;

			$url = "http://opensms.microprixs.com/api/mt/SendSMS?user=jmvd&password=jmvd&senderid=".$SENDERID."&channel=TRANS&DCS=0&flashsms=0&number=".$PHONE."&text=".$MESSAGE."&route=15";
		
			require_once DOL_DOCUMENT_ROOT.'/core/class/CSMSSend.class.php';
			$smsfile = new CSMSSend($url);
			$result = $smsfile->sendSMS();

			$object = new SocieteTemp($db);
			$object->fetch($isExist1->rowid);

			$id = $isExist1->rowid;


			/*Email*/
			// Actions to send emails
			$action = 'send';
			$_POST['sendto'] = $email;
			$_POST['receiver'] = 'societe_temp';
			$_POST['message'] = "Dear, Your OTP for login is ".$isExist1->otp.". Please DO NOT share OTP.";
			$_POST['subject'] = 'JVMD OTP Detail';
			
			$_POST['fromtype'] = 'company';
			//$_POST['sendtocc'] = 'ashok.sharma@microprixs.in';
			$_POST['sender'] = "support@serve.jmvdgroup.in";
			
			$triggersendname = 'COMPANY_SENTBYMAIL';
			$paramname = '';
			$mode = 'Information';
			$trackid = '';

			include DOL_DOCUMENT_ROOT.'/core/actions_sendmails.inc.php';
			

			$json = array('status_code' => $status_code, 'message' => $messagetxt, 'user_id' => "", 'user_otp' => "".$isExist1->otp, 'fullname' => '', 'mobile' => "".$user_mobile, 'email' => "".$email, 'customer_type' => 'new');
		}
		else
		{
			if($isEmailExist)
			{
				$status_code = '0';
				$message = 'Email id already exit, Please try another!!';
		
				$json = array('status_code' => $status_code, 'message' => $message);
			}else{	
				// Save data in Temp table
				$objectSoc = new SocieteTemp($db);

				$otp = rand(111111, 999999);

				$sql = "DELETE FROM ".MAIN_DB_PREFIX."societe_temp WHERE phone = '".$db->escape($user_mobile)."'";
				$resql = $db->query($sql);

				$sql = "INSERT INTO ".MAIN_DB_PREFIX."societe_temp SET phone = '".$db->escape($user_mobile)."', email = '".$db->escape($email)."', statut = '0'";
				$resql = $db->query($sql);
				$last_insert = $db->last_insert_id(MAIN_DB_PREFIX."societe_temp");

				$sql = "INSERT INTO ".MAIN_DB_PREFIX."socpeople_temp SET fk_soc = '".(int)$last_insert."', phone = '".$db->escape($user_mobile)."', phone_mobile = '".$db->escape($user_mobile)."', email = '".$db->escape($email)."', otp = '".$db->escape($otp)."', statut = '0'";
				$resql = $db->query($sql);
				$id = $last_insert_people = $db->last_insert_id(MAIN_DB_PREFIX."socpeople_temp");
				
				$object = new ContactTemp($db);
				$object->fetch($id);

				/*$object->firstname = $object->lastname = $object->priv = "";
				$object->statut = 0;

				$object->create($tempUser);*/

				$status_code = '1';
				$messagetxt = 'New account has been created, Your OTP have been send on your email for verification';

				$smsmessage = str_replace(" ", "%20", "Dear, Your OTP for login is ".$otp.". Please DO NOT share OTP.");
				$SENDERID = $conf->global->MAIN_MAIL_SMS_FROM;
				$PHONE = $user_mobile;
				$MESSAGE = $smsmessage;
				$url = "http://opensms.microprixs.com/api/mt/SendSMS?user=jmvd&password=jmvd&senderid=".$SENDERID."&channel=TRANS&DCS=0&flashsms=0&number=".$PHONE."&text=".$MESSAGE."&route=15";
			
				require_once DOL_DOCUMENT_ROOT.'/core/class/CSMSSend.class.php';
				$smsfile = new CSMSSend($url);
				$result = $smsfile->sendSMS();

				
				/*Email*/
				// Actions to send emails
				$action = 'send';
				$_POST['sendto'] = $email;
				$_POST['receiver'] = 'contact_temp';
				$_POST['message'] = "Dear, Your OTP for login is ".$otp.". Please DO NOT share OTP.";
				$_POST['subject'] = 'JVMD OTP Detail';
				
				$_POST['fromtype'] = 'company';
				//$_POST['sendtocc'] = 'ashok.sharma@microprixs.in';
				$_POST['sender'] = $email;
				
				$triggersendname = 'COMPANY_SENTBYMAIL';
				$paramname = '';
				$mode = 'Information';
				$trackid = '';

				include DOL_DOCUMENT_ROOT.'/core/actions_sendmails.inc.php';
				
				$json = array('status_code' => $status_code, 'message' => $messagetxt, 'user_id' => "", 'user_otp' => "".$otp, 'fullname' => '', 'mobile' => "".$user_mobile, 'email' => "".$email, 'customer_type' => 'new');
				
			}	
				
		}
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);