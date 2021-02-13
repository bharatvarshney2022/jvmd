<?php
	// Send Data to Saraswat Infotech
	$url = 'https://www.mhmart.in/agent_register.php';
	
	//create a new cURL resource
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	
	//setup request to send json via POST
	// Pincode needs to be added
	
	$data = array(
		"reqCode" => "agentupayonboard",
		"agentCode"  =>  "123464",
		"printedName"  =>  "SIL ONE hfsdkjfh sdhk",
		"companyName"  =>  "sil",
		"typeEstablishment"  =>  "SIL",
		"address"  =>  "SEALINK",
		"addressRes"  =>  "TATAPRESS",
		"pinCode"  =>  "400025",
		"mccCode"  =>  "1731",
		"establishmentYrs"  =>  "2019",
		"establishmentNo"  =>  "DEEP4",
		"saleTaxNo"  =>  "SHUBHAM12",
		"tinNo"  =>  "VIREN",
		"panTan"  =>  "SHETTY",
		"ownerName"  =>  "SAYALI",
		"authorizedPerson"  =>  "VINAYAK",
		"mobileNo"  =>  "1000454774",
		"officeNo"  =>  "02243868",
		"faxNo"  =>  "022389746575",
		"officePremisesStatus"  =>  "Rented",
		"yrsCurrentLocation"  =>  "123",
		"bankerBranchName"  =>  "VASHI BRANCH",
		"bankName"  =>  "SARASWAT",
		"accountNo"  =>  "123456789011",
		"ifscCode"  =>  "IDBI0000111",
		"dmtAccountNo"  =>  "18054686",
		"dmtIfscCode"  =>  "IDBI0000111",
		"dmtAccountName"  =>  "CHANDGAD SOCTY",
		"walletBalance"  =>  "110",
		"walletAccountNo"  =>  "464234167974444",
		"walletIfscCode"  =>  "111fsdsf534",
		"virtualAccountno"  =>  "5345464567567653",
		"virtualIfsccode"  =>  "AZgdg545311",
		"msisdn"  =>  "1248379024",
		"deviceType"  =>  "Y2000",
		"addressInstation"  =>  "ADD23",
		"name"  =>  "DEEP NAGWEKAR",
		"noContactPerson"  =>  "6781285794",
		"city"  =>  "57",
		"state"  =>  "GJ",
		"country"  =>  "IN",
		"userId"  =>  "USERID14",
		"firstName"  =>  "NANDINI",
		"lastName"  =>  "POOJARI",
		"emailId"  =>  "rahul12@gmail.com",
		"dept"  =>  "IT"
	);
	//$payload = json_encode($data);
	
	//echo $payload; exit;
	
	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
	//execute the POST request
	$result = curl_exec($ch);
	
	//close cURL resource
	curl_close($ch);
	
	header('Content-Type: application/json');
	
	echo $result; exit;