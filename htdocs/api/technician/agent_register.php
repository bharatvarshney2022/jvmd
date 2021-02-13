<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	
	$mobile = "9462045321";
	$user_otp = rand(100000, 999999);
	$content = str_replace(" ", "%20", "Your OTP is ".$user_otp);
	//$result = sendSMS($mobile, $content);
	//echo $result;
	
	$url = 'https://merchant.subpe.in:8081/agentdistributor_api/CommonReq/service';
	
	$data = array(
		"reqCode" => "agentonboard",
		"agentCode"  =>  1,
		"firstName" => "Munjal",
		"middleName" => "",
		"lastName" =>  "Mayank",
		"mobileNo" =>  "9462045321",
		"officeNo" =>  "01414901608",
		"emailId" =>  "munjal@gmail.com",
		"bankerBranchName" =>  "",
		"accountNo" => "",
		"ifscCode" => "",
		"bankName" => "",
		"city" => "",
		"state" => "",
		"country" => "",
		"address1" => "",
		"address2" => ""
	);
	
	$header = 'Content-Type:application/json';
	
	$result = callThirdPartyAPI($url, $data, $header);
	echo $result;
	exit;
			
	// Send Data to Saraswat Infotech
	$url = 'https://merchant.subpe.in:8081/agentdistributor_api/CommonReq/service';
	
	//create a new cURL resource
	$ch = curl_init($url);
	
	//setup request to send json via POST
	// Pincode needs to be added
	
	$data = array(
		"reqCode" => "agentonboard",
		"agentCode"  =>  "1000001",
		"firstName" => "mayur",
		"middleName" => "mahendra",
		"lastName" =>  "more",
		"mobileNo" =>  "9462045320",
		"officeNo" =>  "9462045320",
		"emailId" =>  "mayur@gmail.com",
		"bankerBranchName" =>  "mumbai",
		"accountNo" => "45642237835335353",
		"ifscCode" => "HDFC0123456",
		"bankName" => "HDFC",
		"city" => "mumbai",
		"state" => "MH",
		"country" => "IN",
		"address1" => "Ellora Fiesta",
		"address2" => "Juinagar"
	);
	$payload = json_encode($data);
	
	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($payload))                                                                       
	);
	
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	
	//execute the POST request
	$result = curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	echo curl_errno($ch);
	echo curl_error($ch);
	
	//close cURL resource
	curl_close($ch);
	
	//echo $httpcode; exit;