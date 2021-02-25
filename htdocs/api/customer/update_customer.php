<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$full_name = GETPOST('full_name', 'alpha');
	$secondary_phone = GETPOST('secondary_phone', 'alpha');
	$email = GETPOST('email', 'aphda');
	
	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$societeData = array();

	if($userExists)
	{
		// If 
		$result = $object->verifyPhoneUpdate($secondary_phone, $user_id);


		if($result < 0)
		{
			$status_code = '0';
			$message = 'Phone Already exists.';
		}
		else
		{
			// Update successfully.
			$object->rowid = $user_id;
			$object->full_name = $full_name;
			$object->fax = $secondary_phone;
			$object->email = $email;
			$object->updateProfile();

			$status_code = '1';
			$message = 'Profile updated successfully.';

			$objectNew = new Societe($db);
	
			$userExists = $objectNew->fetch($user_id);


			$societeData = array('full_name' => $objectNew->name, 'email' => $objectNew->email, 'primary_phone' => $objectNew->phone, 'secondary_phone' => ($objectNew->fax == NULL ? "" : $objectNew->fax), 'address' => $objectNew->address);
		
			$json = array('status_code' => $status_code, 'message' => $message, 'userData' => $societeData);
		}
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);