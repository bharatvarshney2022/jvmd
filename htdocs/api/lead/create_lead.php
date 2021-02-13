<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	global $conf;
	
	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	
	require_once DOL_DOCUMENT_ROOT.'/lead/class/lead.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$user_token = GETPOST('user_token', 'alpha');
	
	$opp_status = GETPOST('opp_status', 'int');
	$title_category = GETPOST('title_category', 'alpha');
	$lead_source = GETPOST('lead_source', 'int');
	$title = GETPOST('title', 'alpha');
	$customer_name = GETPOST('customer_name', 'alpha');
	$customer_email = GETPOST('customer_email', 'alpha');
	$customer_phone = GETPOST('customer_phone', 'alpha');
	$customer_address1 = GETPOST('customer_address1', 'alpha');
	$customer_address2 = GETPOST('customer_address2', 'alpha');
	$customer_city = GETPOST('customer_city', 'alpha');
	$customer_pin_code = GETPOST('customer_pin_code', 'alpha');
	
	$json = array();
	
	$object = new User($db);
	
	$object->fetch($id);
	
	$isExist = $object->getUserData($user_id);
	if($isExist)
	{
		$newToken = $object->userToken($user_id);
		
		if($newToken == $user_token)
		{
			$objectLead = new Lead($db);
			
			// Check for already exists
			
			$isPhoneExists = $objectLead->getLeadPhone($customer_phone);
			$isMailExists = $objectLead->getLeadEmail($customer_email);
			
			if($isPhoneExists)
			{
				$status_code = '0';
				$message = 'Phone number already exists';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
			else if($isMailExists)
			{
				$status_code = '0';
				$message = 'Email address already exists';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
			else
			{
				$defaultref = '';
				$modele = 'mod_lead_simple';
			
				// Search template files
				$file = ''; $classname = ''; $filefound = 0;
				$dirmodels = array_merge(array('/'), (array) $conf->modules_parts['models']);
				foreach ($dirmodels as $reldir)
				{
					$file = dol_buildpath($reldir."core/modules/lead/".$modele.'.php', 0);
					if (file_exists($file))
					{
						$filefound = 1;
						$classname = $modele;
						break;
					}
				}
				
				if ($filefound)
				{
					$result = dol_include_once($reldir."core/modules/lead/".$modele.'.php');
					$modLead = new $classname;
			
					$defaultref = $modLead->getNextValue($thirdparty, $object);
				}
								
				$result = $objectLead->createLead($user_id, $defaultref, $opp_status, $title_category, $lead_source, $title, $customer_name, $customer_email, $customer_phone, $customer_address1, $customer_address2, $customer_city, $customer_pin_code);
				
				if($result > 0)
				{
					$categories = array('7');
					$result = $object->setCategories($categories);
					
					$status_code = '1';
					$message = 'Lead Created successfully';
							
					$json = array('status_code' => $status_code, 'message' => $message);
				}
				else
				{
					$status_code = '0';
					$message = 'Something went wrong. Please try again';
					
					$json = array('status_code' => $status_code, 'message' => $message);
				}
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Token mismatch';
			
			$json = array('status_code' => $status_code, 'message' => $message);
		}
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