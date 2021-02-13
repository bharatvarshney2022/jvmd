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
	require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$address1 = GETPOST('address1', 'alpha');
	$address2 = GETPOST('address2', 'alpha');
	$city = GETPOST('city', 'alpha');
	$pincode = GETPOST('pincode', 'alpha');
	$state = GETPOST('state', 'alpha');
	$country = GETPOST('country', 'alpha');
	
	$beneficial_name = GETPOST('beneficial_name', 'alpha');
	$bank_name = GETPOST('bank_name', 'alpha');
	$ifsc_code = GETPOST('ifsc_code', 'alpha');
	$account_number = GETPOST('account_number', 'alpha');
	$bank_branch_name = GETPOST('bank_branch_name', 'alpha');
	$pan_number = GETPOST('pan_number', 'alpha');
	
	$kyc1Data = $_FILES['kyc1'];
	$kyc2Data = $_FILES['kyc2'];
	
	$kyc1_filename = $kyc2_filename = '';
	
	$json = array();
	
	$object = new User($db);
	$userExists = $object->fetch($user_id);
	
	if (!empty($kyc1Data['name']))
	{
		$isimage = image_format_supported($kyc1Data['name']);
		if ($isimage > 0)
		{
			$kyc1_filename = time()."-".dol_sanitizeFileName($kyc1Data['name']);
			
			$dir = $conf->user->dir_output.'/'.get_exdir(0, 0, 0, 0, $object, 'user').$user_id;
			
			dol_mkdir($dir);

			if (@is_dir($dir)) {
				$newfile = $dir.'/'.$kyc1_filename;
				$result = dol_move_uploaded_file($kyc1Data['tmp_name'], $newfile, 1, 0, $kyc1Data['error']);
			}
		}
	}
	
	if (!empty($kyc2Data['name']))
	{
		$isimage = image_format_supported($kyc2Data['name']);
		if ($isimage > 0)
		{
			$kyc2_filename = time()."-".dol_sanitizeFileName($kyc2Data['name']);
			
			$dir = $conf->user->dir_output.'/'.get_exdir(0, 0, 0, 0, $object, 'user').$user_id;
			
			dol_mkdir($dir);

			if (@is_dir($dir)) {
				$newfile = $dir.'/'.$kyc2_filename;
				$result = dol_move_uploaded_file($kyc2Data['tmp_name'], $newfile, 1, 0, $kyc2Data['error']);
			}
		}
	}
	
	if($userExists)
	{
		$db->begin();
		
		$object->updateUserAddress($user_id, $address1, $address2, $city, $state, $pincode, $country);
		
		//kyc1	kyc2	kyc3	kyc4	beneficial_name
		$userFieldData = array('kyc1' => $kyc1_filename, 'kyc2' => $kyc2_filename, 'beneficial_name' => $beneficial_name, 'bank_name' => $bank_name, 'ifsc_code' => $ifsc_code, 'account_number' => $account_number, 'bank_branch_name' => $bank_branch_name, 'pan_number' => $pan_number);
				
		// Submit User KYC Data
		$object->SetUserExtraFields($user_id, $userFieldData);
		
		$newUserData = $object->getUserData($user_id);
		
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
		$url = 'http://www.piousindia.com/agent_register.php';
		
		//create a new cURL resource
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		
		//print_r($newUserData); exit;
		
		//setup request to send json via POST
		// Pincode needs to be added
		
		$new_user_id = $newUserData->rowid;
		
		if($new_user_id > 9 && $new_user_id <= 99)
		{
			$new_user_id = "00000000".$new_user_id;
		}
		else if($new_user_id > 99 && $new_user_id <= 999)
		{
			$new_user_id = "0000000".$new_user_id;
		}
		else if($new_user_id > 999 && $new_user_id <= 9999)
		{
			$new_user_id = "000000".$new_user_id;
		}
		else if($new_user_id > 9999 && $new_user_id <= 99999)
		{
			$new_user_id = "00000".$new_user_id;
		}
		else if($new_user_id > 99999 && $new_user_id <= 999999)
		{
			$new_user_id = "0000".$new_user_id;
		}
		else if($new_user_id > 999999 && $new_user_id <= 9999999)
		{
			$new_user_id = "000".$new_user_id;
		}
		else if($new_user_id > 9999999 && $new_user_id <= 99999999)
		{
			$new_user_id = "00".$new_user_id;
		}
		else if($new_user_id > 99999999 && $new_user_id <= 999999999)
		{
			$new_user_id = "0".$new_user_id;
		}
		
		$data = array(
			"reqCode" => "agentupayonboard",
			"agentCode"  => "".$new_user_id,
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
			"panTan"  =>  "".$pan_number,
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
			"msisdn"  => $newUserData->user_mobile, //Mobile Number
			"deviceType"  =>  "", // 
			"addressInstation"  => substr($newUserData->address, 0, 23), // 30 character only
			"name"  => $newUserData->firstname,
			"noContactPerson"  => $newUserData->user_mobile,
			"city"  => $city, // Number
			"state"  => $state, // Code
			"country"  =>  "IN",
			"userId"  => "".$new_user_id,
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
			// Assign on new Group
			$object->SetUserGroup(25, $user_id, 1);
		
			$object->updateExternalData($user_id, $resultData->merchantMasters->mid);
			
			$db->commit();
			
			// Update User ID from SiL
			$status_code = '1';
			$message = 'KYC data submitted successfully ';
		}
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! user not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);