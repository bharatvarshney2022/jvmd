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

	$address = GETPOST('address', 'alpha');
	$city = GETPOST('city', 'alpha');
	$state = GETPOST('state', 'alpha');
	$country = GETPOST('country', 'alpha');
	$userlatitude = GETPOST('userlatitude', 'alpha');
	$userlongitude = GETPOST('userlongitude', 'alpha');
	$postalCode = GETPOST('postalCode', 'alpha');

	$fk_pincode = $fk_departement = 0;
	$sql = "SELECT z.rowid, z.zip FROM ".MAIN_DB_PREFIX."c_pincodes as z";
	$sql .= " WHERE z.active = 1 AND z.zip LIKE '".$db->escape($postalCode)."%'";
	$resql1 = $db->query($sql);
	if ($resql1)
	{
		$row = $db->fetch_array($resql1);
		$fk_pincode = $row['rowid'];
	}

	$sql = "SELECT z.rowid, z.nom FROM ".MAIN_DB_PREFIX."c_departements as z";
	$sql .= " WHERE z.active = 1 AND z.nom LIKE '".$db->escape($state)."%'";
	$resql1 = $db->query($sql);
	if ($resql1)
	{
		$row = $db->fetch_array($resql1);
		$fk_departement = $row['rowid'];
	}
	
	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$societeData = array();

	if($userExists)
	{
		// If 
		$result = 0;
		if($secondary_phone > 0)
		{
			$result = $object->verifyPhoneUpdate($secondary_phone, $user_id);
		}
		
		if($result < 0)
		{
			$status_code = '0';
			$message = 'Phone Already exists.';

			$json = array('status_code' => $status_code, 'message' => $message);
		}
		else
		{
			// Update successfully.
			$object->rowid = $user_id;
			$object->full_name = $full_name;
			$object->fax = $secondary_phone;
			$object->email = $email;
			$object->town = $city;
			$object->fk_departement = $fk_departement; // Country
			$object->zip = $postalCode;
			$object->userlatitude = $userlatitude;
			$object->userlongitude = $userlongitude;
			$resultUpdate = $object->updateProfile();

			if($resultUpdate > 0)
			{
				$db->commit();
				$status_code = '1';
				$message = 'Profile updated successfully.';

				$objectNew = new Societe($db);
		
				$userExists = $objectNew->fetch($user_id);


				$societeData = array('full_name' => $objectNew->name, 'email' => $objectNew->email, 'primary_phone' => $objectNew->phone, 'secondary_phone' => ($objectNew->fax == NULL ? "" : $objectNew->fax), 'address' => $objectNew->address);
			
				$json = array('status_code' => $status_code, 'message' => $message, 'userData' => $societeData);
			}
			else
			{
				$db->rollback();

				$status_code = '0';
				$message = 'Something went wrong';
			
				$json = array('status_code' => $status_code, 'message' => $message);
			}
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