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
			
			$leadSource = $objectLead->getLeadSource();
			
			$leadCategory = $objectLead->getLeadCategories();
			
			$leadProduct = $objectLead->getLeadProducts();
			
			$leadCompanyType = $objectLead->getLeadCompanyType();
			
			$status_code = '1';
			$message = 'Lead Data';
					
			$json = array('status_code' => $status_code, 'message' => $message, 'lead_source' => $leadSource, 'lead_category' => $leadCategory, 'lead_product' => $leadProduct, 'lead_company_type' => $leadCompanyType);
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