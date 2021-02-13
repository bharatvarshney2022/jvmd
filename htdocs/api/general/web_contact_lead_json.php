<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/lead/class/lead.class.php';

	$json = array();
	
	global $db;
	
	$json = file_get_contents('php://input');

	$data = json_decode($json);
	echo '<pre>'; print_r($data); exit;
	
	$object = new Lead($db);
	
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
	
	$db->begin();
	
	$object->ref             = $defaultref;
	$object->title           = 'Other'; // Do not use 'alpha' here, we want field as it is
	$object->title_category  = 'Subpe';
	$object->lead_source 	 = '1';
	$object->socid           = NULL;
	$object->description     = 'Query Type: '.$type_Query.', Heard From: '.$type_hear.', Message: '.$candidate_mesage; // Do not use 'alpha' here, we want field as it is
	$object->public          = 1;
	$object->date_c = subpe_erp_now();
	$object->statut          = 1;
	$object->opp_status      = 1;
	
	// New Fields
	$object->assign          = '46';
	$object->customer_name      = $candidate_name;
	$object->customer_shop_name = $candidate_org;
	$object->customer_designation = $candidate_name;
	$object->customer_address1  = $candidate_city.",".$select_state;
	$object->customer_address2  = $select_state;
	$object->customer_email     = $candidate_mail;
	$object->customer_city      = $candidate_city;
	$object->customer_website   = '--';
	$object->customer_phone     = $candidate_number;
	$object->customer_pin_code  = '--';
	$object->customer_company   = $candidate_org;
	$object->company_type  = '1';
	
	$result = $object->create($user);
	
	//echo $result; exit;
	
	if($result > 0)
	{
		$db->commit();

		$status_code = '1';
		$message = 'Lead submitted successfully';
	}
	else
	{
		$status_code = '1';
		$message = 'Something went wrong. Please check the errors '.$object->error;
	}
	
	$json = array('status_code' => $status_code, 'message' => $message);
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);