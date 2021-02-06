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
	require_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
	
	$user_id = GETPOST('agent_id', 'int');
	
	$firstName = GETPOST('firstname', 'alpha');
	$lastName = GETPOST('lastname', 'alpha');
	$email_address = GETPOST('email_address', 'alpha');
	$mobileNo = GETPOST('mobile', 'alpha');
	$officeNo = GETPOST('officeNo', 'alpha');
	$faxNo = GETPOST('faxNo', 'alpha');
	$establishmentYrs = GETPOST('establishmentYrs', 'alpha');
	
	$printedName = GETPOST('printed_name', 'alpha');
	$companyName = GETPOST('company_name', 'alpha');
	
	$address = GETPOST('address1', 'alpha');
	$addressRes = GETPOST('address2', 'alpha');
	$pinCode = GETPOST('pincode', 'alpha');
	$city = GETPOST('city', 'int');
	$state = GETPOST('state', 'alpha');
	$country = GETPOST('country', 'alpha');
	
	$beneficial_name = GETPOST('beneficial_name', 'alpha');
	$bank_branch_name = GETPOST('bank_branch_name', 'alpha');
	$bank_name = GETPOST('bank_name', 'alpha');
	$account_number = GETPOST('account_number', 'alpha');
	$ifsc_code = GETPOST('ifsc_code', 'alpha');
	$pan_number = GETPOST('pan_number', 'alpha');
	$mccCode = 1731;//GETPOST('mccCode', 'alpha');
	
	$userPhoto = $_FILES['user_photo'];
	$kyc1Data = $_FILES['kyc1'];
	$kyc2Data = $_FILES['kyc2'];
	
	$kyc1_filename = $kyc2_filename = '';
	
	// TO DO
	$mid = GETPOST('mid', 'alpha');
	$groupMid = GETPOST('groupMid', 'alpha');
	$typeEstablishment = GETPOST('typeEstablishment', 'alpha');
	
	$establishmentNo = GETPOST('establishmentNo', 'alpha');
	$saleTaxNo = GETPOST('saleTaxNo', 'alpha');
	$tinNo = GETPOST('tinNo', 'alpha');
	$panTan = GETPOST('panTan', 'alpha');
	$ownerName = GETPOST('ownerName', 'alpha');
	$authorizedPerson = GETPOST('authorizedPerson', 'alpha');
	$officePremisesStatus = GETPOST('officePremisesStatus', 'alpha');
	$yrsCurrentLocation = GETPOST('yrsCurrentLocation', 'alpha');
	$dmtAccountNo = GETPOST('dmtAccountNo', 'alpha');
	$dmtIfscCode = GETPOST('dmtIfscCode', 'alpha');
	$dmtAccountName = GETPOST('dmtAccountName', 'alpha');
	$walletBalance = GETPOST('walletBalance', 'alpha');
	$walletAccountNo = GETPOST('walletAccountNo', 'alpha');
	$walletIfscCode = GETPOST('walletIfscCode', 'alpha');
	$virtualAccountno = GETPOST('virtualAccountno', 'alpha');
	$virtualIfsccode = GETPOST('virtualIfsccode', 'alpha');
	$msisdn = GETPOST('msisdn', 'alpha');
	$tid = GETPOST('tid', 'alpha');
	$deviceType = GETPOST('deviceType', 'alpha');
	$addressInstation = GETPOST('addressInstation', 'alpha');
	
	$noContactPerson = GETPOST('noContactPerson', 'alpha');
	
	$dept = GETPOST('dept', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	$userExists = $object->fetch($user_id);
	
	$isExist = $object->existMobile($mobileNo);
	
	if($isExist == 1)
	{
		$status_code = '0';
		$message = 'Mobile already exists!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$isExist = $object->existEmail($email_address);
	
	if($isExist == 1)
	{
		$status_code = '0';
		$message = 'Email already exists!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	if($userExists)
	{
		if(!$json)
		{
			// Save USer
			$object->lastname = $lastName;
			$object->firstname = $firstName;
			$object->login = $object->user_mobile = $mobileNo;
			
			$object->office_phone = $officeNo;
			$object->office_fax = $faxNo;
			
			$object->fk_establishment = $establishmentYrs;
			
			$object->fk_user = $user_id;
			
			$object->email = $email_address;
			$object->user_status = 1;
			$object->employee = 0;
			$object->user_otp = $user_otp = rand(100000, 999999);
			
			// Address Data
			$object->company_name = $companyName;
			$object->address = $address;
			$object->address2 = $addressRes;
			$object->city = $city;
			$object->state = $state;
			$object->pincode = $pinCode;
			$object->country = $country;
			
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
			
			$object->photo = $user_photo;
			
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
			
			require_once DOL_DOCUMENT_ROOT.'/core/lib/security2.lib.php';
			// PARTIAL WORKAROUND
			$generated_fake_api_key = getRandomPassword(true);
			
			$object->api_key = $generated_fake_api_key;
			$object->fk_country = 1;
			
			/*$password_crypted = dol_hash($password);
			$object->pass_crypted = $password_crypted;*/
			
			$db->begin();
			
			$merchant_id = $object->create($user);
			
			if ($merchant_id > 0) {
				
				$object->setPassword($user, $password);
					
				$object->setOTP($merchant_id, $user_otp);
				
				$object->SetUserGroup(25, $merchant_id, 1);
				
				$object->verifyOTP($merchant_id, $user_otp);
				
				$object->updateUserAddress($merchant_id, $address, $addressRes, $city, $state, $pincode, $country);
				
				$userFieldData = array('kyc1' => $kyc1_filename, 'kyc2' => $kyc2_filename, 'beneficial_name' => $beneficial_name, 'bank_name' => $bank_name, 'ifsc_code' => $ifsc_code, 'account_number' => $account_number, 'bank_branch_name' => $bank_branch_name, 'pan_number' => $pan_number);
						
				// Submit User KYC Data
				$object->SetUserExtraFields($merchant_id, $userFieldData);
				
				// Merchant Onboarding
				//$newUserData = $object->getUserData($merchant_id);
			
				$object->kyc1 = $object->kyc2 = $object->beneficial_name = $object->bank_name = $object->ifsc_code = $object->account_number = $object->bank_branch_name = $object->pan_number = '';
				
				$object->kyc1 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$user_id.'/'.$kyc1_filename;
				$object->kyc2 = $subpe_main_url_root.'/showimage?modulepart=userphoto&file='.$user_id.'/'.$kyc1_filename;
				$object->beneficial_name = $beneficial_name;
				$object->bank_name = $bank_name;
				$object->ifsc_code = $ifsc_code;
				$object->account_number = $account_number;
				$object->bank_branch_name = $bank_branch_name;
				$object->pan_number = $pan_number;
				
				// Agent onboarding
				$url = 'http://www.piousindia.com/merchant_register.php';
				
				//create a new cURL resource
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, $url);
				
				//setup request to send json via POST
				// Pincode needs to be added
				
				//address1, $addressRes, $city, $state, $pincode, $country
				/*$ = GETPOST('firstname', 'alpha');
				$lastName = GETPOST('lastname', 'alpha');
				$email_address = GETPOST('email_address', 'alpha');
				$mobileNo = GETPOST('mobile', 'alpha');
				$officeNo = GETPOST('officeNo', 'alpha');
				$faxNo = GETPOST('faxNo', 'alpha');*/
				
				$data = array(
					"reqCode" => "merchantonboard",
					"user_id" => "0".($merchant_id + 1000),
					"agentCode"  => $object->external_id,
					"printedName"  => $object->firstname. " ".$object->lastname,
					"companyName"  => $object->company_name,
					"typeEstablishment"  => "",
					"address"  => $object->address. " ". $object->address2,
					"addressRes"  => $object->address. " ". $object->address2,
					"pinCode"  => $object->zip,
					"mccCode"  =>  "1731",
					"establishmentYrs"  => "",
					"establishmentNo"  => "",
					"saleTaxNo"  =>  "",
					"tinNo"  =>  "",
					"panTan"  =>  "".$object->pan_number,
					"ownerName"  => $ownerName,
					"authorizedPerson"  => "",
					"mobileNo"  => $object->user_mobile,
					"officeNo"  => $object->office_phone,
					"faxNo"  =>  $object->office_fax,
					"officePremisesStatus" => "",
					"yrsCurrentLocation" => "",
					"bankerBranchName"  => $bank_branch_name,
					"bankName"  => $bank_name,
					"accountNo"  => $account_number,
					"ifscCode"  => $ifsc_code,
					"dmtAccountNo"  => $account_number,
					"dmtIfscCode"  => $ifsc_code,
					"dmtAccountName"  => $beneficial_name,
					"walletBalance"  =>  "0",
					"walletAccountNo"  => $account_number,
					"walletIfscCode"  => $ifsc_code,
					"virtualAccountno"  => "",
					"virtualIfsccode"  => "",
					"msisdn"  => "0".$object->user_mobile, //Mobile Number
					"deviceType"  =>  "", // 
					"addressInstation"  => substr($object->address, 0, 23), // 30 character only
					"name"  => $object->firstname,
					"noContactPerson"  => $object->user_mobile,
					"city"  =>  "57", // Number
					"state"  =>  "MH", // Code
					"country"  =>  "IN",
					"userId"  => $object->user_mobile,
					"firstName"  => $object->firstname,
					"lastName"  => $object->lastname,
					"emailId"  => $object->email,
					"dept"  =>  ""
				);
				
				//print_r($data); exit;
				
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
					$object->updateMerchantExternalData($merchant_id, $resultData->merchantMasters->mid);
					
					$db->commit();
					
					$status_code = '1';
					$message = 'Merchant created successfully';
				}
			}
			else
			{
				$db->rollback();
				
				$status_code = '0';
				$message = 'Something Went Wrong';
				
				$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'user_otp' => '');
			}	
				
			$json = array('status_code' => $status_code, 'message' => $message);
		}
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