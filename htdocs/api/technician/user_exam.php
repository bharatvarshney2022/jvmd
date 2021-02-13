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
	$exam_result = GETPOST('exam_result', 'int');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$db->begin();
		
		if($exam_result == 1)
		{
			/*$newUserData = $object->getUserData($user_id);
		
			$newUserData->kyc1 = $newUserData->kyc2 = $newUserData->beneficial_name = $newUserData->bank_name = $newUserData->ifsc_code = $newUserData->account_number = $newUserData->bank_branch_name = $newUserData->pan_number = '';
			
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
			}
			
			// Agent onboarding
			$url = 'http://www.piousindia.com/merchant_register.php';
			
			//create a new cURL resource
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			
			//print_r($newUserData); exit;
			
			//setup request to send json via POST
			// Pincode needs to be added
			
			$data = array(
				"reqCode" => "merchantonboard",
				"user_id" => "0".($user_id + 1000),
				"agentCode"  =>  "",
				"printedName"  => $newUserData->firstname. " ".$newUserData->lastname,
				"companyName"  => "",
				"typeEstablishment"  => "",
				"address"  => $newUserData->address. " ". $newUserData->address2,
				"addressRes"  => $newUserData->address. " ". $newUserData->address2,
				"pinCode"  => $newUserData->zip,
				"mccCode"  =>  "1731",
				"establishmentYrs"  => "",
				"establishmentNo"  => "",
				"saleTaxNo"  =>  "",
				"tinNo"  =>  "",
				"panTan"  =>  "".$newUserData->pan_number,
				"ownerName"  => "",
				"authorizedPerson"  => "",
				"mobileNo"  => $newUserData->user_mobile,
				"officeNo"  => "",
				"faxNo"  =>  "",
				"officePremisesStatus" => "",
				"yrsCurrentLocation" => "",
				"bankerBranchName"  => $newUserData->bank_branch_name,
				"bankName"  => $newUserData->bank_name,
				"accountNo"  => $newUserData->account_number,
				"ifscCode"  => $newUserData->ifsc_code,
				"dmtAccountNo"  => $newUserData->account_number,
				"dmtIfscCode"  => $newUserData->ifsc_code,
				"dmtAccountName"  => $newUserData->beneficial_name,
				"walletBalance"  =>  "0",
				"walletAccountNo"  => $newUserData->account_number,
				"walletIfscCode"  => $newUserData->ifsc_code,
				"virtualAccountno"  => "",
				"virtualIfsccode"  => "",
				"msisdn"  => "0".$newUserData->user_mobile, //Mobile Number
				"deviceType"  =>  "", // 
				"addressInstation"  => substr($newUserData->address, 0, 23), // 30 character only
				"name"  => $newUserData->firstname,
				"noContactPerson"  => $newUserData->user_mobile,
				"city"  =>  "57", // Number
				"state"  =>  "MH", // Code
				"country"  =>  "IN",
				"userId"  => "0".($user_id + 1000),
				"firstName"  => $newUserData->firstname,
				"lastName"  => $newUserData->firstname,
				"emailId"  => $newUserData->email,
				"dept"  =>  ""
			);
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$result = curl_exec($ch);
		
			//close cURL resource
			curl_close($ch);
			
			$resultData = json_decode($result);
			
			//print_r($resultData->responseCode); $resultData->responseCode; exit;
			
			if($resultData->responseCode != "00")
			{
				$db->rollback();
				
				$status_code = '0';
				$message = $resultData->responseCode." ".$resultData->responseMessage;
			}
			else
			{
				$object->createUserExamResult($user_id, $exam_result);	
				
				$object->updateMerchantExternalData($user_id, $resultData->merchantMasters->mid);
				
				$object->SetUserGroup(25, $user_id, 1);
				
				$db->commit();
				
				$status_code = '1';
				$message = 'Exam status inserted successfully.';
			}*/
			
			$object->createUserExamResult($user_id, $exam_result);	
				
			//$object->updateMerchantExternalData($user_id, $resultData->merchantMasters->mid);
			
			//$object->SetUserGroup(25, $user_id, 1);
			
			$db->commit();
			
			$status_code = '1';
			$message = 'Exam status inserted successfully.';
		}
		else
		{
			$object->createUserExamResult($user_id, $exam_result);	
			$db->commit();
			$status_code = '1';
			$message = 'Exam status inserted successfully.';
		}
		
		$isExistNew = $object->getUserData($user_id);
		
		$isExistNew->user_image = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$user_id.'/'.$isExistNew->photo;
		unset($isExistNew->photo);
		
		$json = array('status_code' => $status_code, 'message' => $message);
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