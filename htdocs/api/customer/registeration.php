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
	require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';
	require_once DOL_DOCUMENT_ROOT.'/contact/class/contact_temp.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';

	$temp_user_id = GETPOST('temp_user_id', 'int');
	$firstname = GETPOST('firstname', 'alpha');
	$lastname = GETPOST('lastname', 'alpha');
	$address = GETPOST('address', 'alpha');
	$email = GETPOST('email', 'alpha');
	$city = GETPOST('city', 'alpha');
	$state = GETPOST('state', 'alpha');
	$country = GETPOST('country', 'alpha');
	$userlatitude = GETPOST('userlatitude', 'alpha');
	$userlongitude = GETPOST('userlongitude', 'alpha');
	$postalCode = GETPOST('postalCode', 'alpha');
	$device_id = GETPOST('device_id', 'alpha');
	$fcmToken = GETPOST('fcmToken', 'alpha');

	global $user;
	
	$json = array();

	$object = new ContactTemp($db);
	$result = $object->fetch($temp_user_id);

	if($result)
	{
		// Check if already exists
		$objectSociete = new Societe($db);
		$resultSoc = $objectSociete->isDeviceExists($result->phone_mobile, $device_id);

		if($resultSoc == 0)
		{
			// Add values
			$object->firstname = $firstname;
			$object->lastname = $lastname;
			$object->address = $address.",".$city.",".$state;
			$object->email = $email;
			$object->town = $city;
			$object->fk_pays = '117'; // Country
			$object->zip = $postalCode;
			$object->userlatitude = $userlatitude;
			$object->userlongitude = $userlongitude;

			//$object->fk_departement = '';
			
			$update = $object->update($temp_user_id, null, 1, 'update', 1);
			
			if($update > 0)
			{
				// Insert new Contact
				$objectSociete = new Societe($db);
				$objectSociete->name = $firstname." ".$lastname;
				$objectSociete->name_alias = $firstname." ".$lastname;
				$objectSociete->code_client = '-1';
				$objectSociete->status = '1';
				$societe_id = $objectSociete->create($user);

				if($societe_id > 0)
				{
					$objectSociete->address = $address.",".$city.",".$state;
					$objectSociete->email = $email;
					$objectSociete->town = $city;
					$objectSociete->country_id = '117'; // Country
					$objectSociete->zip = $postalCode;
					$objectSociete->phone = $object->phone_mobile;
					$objectSociete->phone_mobile = $object->phone_mobile;
					$objectSociete->typent_id = '2';
					$objectSociete->client = '2';

					$objectSociete->update($societe_id);


					$objectContact = new Contact($db);

					$objectContact->socid = $societe_id;
					$objectContact->lastname = $lastname;
					$objectContact->firstname = $firstname;
					$objectContact->statut = '1';
					$contact_id = $objectContact->create($user);

					if($contact_id > 0)
					{
						$otp = rand(111111, 999999);

						$objectContact->otp = $otp;
						$objectContact->address = $address.",".$city.",".$state;
						$objectContact->email = $email;
						$objectContact->town = $city;
						$objectContact->country_id = '117'; // Country
						$objectContact->zip = $postalCode;
						$objectContact->userlatitude = $userlatitude;
						$objectContact->userlongitude = $userlongitude;
						$objectContact->device_id = $device_id;
						$objectContact->fcmToken = $fcmToken;
						$objectContact->phone_mobile = $object->phone_mobile;

						$objectContact->update($contact_id);
						$db->commit();
					}
					else
					{
						$db->rollback();
					}
				}
				else
				{
					$db->rollback();
				}

				$status_code = '1';
				$message = 'User created successfully';

				$json = array('status_code' => $status_code, 'message' => $message, "user_id" => "".$societe_id);
			}
			else
			{
				$status_code = '0';
				$message = 'Something went wrong OTP';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Sorry! Device and/or Phone already exists'.$resultSoc->phone_mobile;
			
			$json = array('status_code' => $status_code, 'message' => $message);
		}
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! user not exists.';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);