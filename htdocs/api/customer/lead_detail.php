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
	require_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
	require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
	
	$user_id = GETPOST('user_id', 'int');
	$lead_id = GETPOST('lead_id', 'int');

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$societeProductData = array();

	if($userExists)
	{
		$object1 = new Project($db);

		$sql = "SELECT DISTINCT p.rowid as id, p.ref, p.title, p.fk_statut as status, p.tech_assigndatetime, p.fk_product, p.fk_brand, p.fk_category, p.fk_sub_category,
		 ef.fk_call_source, ef.fk_service_type";
		$sql .= ", p.datec as date_creation, p.tms as date_update ";
		$sql .= ", s.rowid as socid, s.nom as name, s.email";
		$sql .= " FROM ".MAIN_DB_PREFIX.$object1->table_element." as p";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX.$object1->table_element."_extrafields as ef on (p.rowid = ef.fk_object)";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s on p.fk_soc = s.rowid";
		$sql .= " WHERE p.fk_soc = '".$user_id."'";
		$sql .= " AND p.rowid = '".$lead_id."'";
		
		$result = $db->query($sql);
		if ($result) {
			$num = $db->num_rows($result);

			if($num > 0)
			{
				$status_code = '1';
				$message = 'Lead detail.';

				$obj = $db->fetch_object($result);

				$leadStatus = "";
				if($obj->status == 0)
				{
					$leadStatus = "Draft";
				}
				else if($obj->status == 1)
				{
					$leadStatus = "Open";
				}
				else if($obj->status == 2)
				{
					$leadStatus = "Close";
				}
				else if($obj->status == 3)
				{
					$leadStatus = "Reject";
				}

				$call_source = $service_type = "";
				if($obj->fk_call_source != NULL)
				{
					$call_source = GETDBVALUEBYID($obj->fk_call_source, "c_call_source", "label");
				}
				if($obj->fk_service_type != NULL)
				{
					$service_type = GETDBVALUEBYID($obj->fk_service_type, "c_service_type", "label");
				}
				$ac_capacity = "";
				$technician_name = $technician_mobile = ""; //fk_technician
				$json = array('status_code' => $status_code, 'message' => $message, 'lead_id' => $obj->id, 'lead_code' => $obj->ref, 'status' => $leadStatus, 'call_source' => $call_source, 'service_type' => $service_type, 'brand' => $obj->fk_brand, 'category_name' => $obj->fk_category, 'sub_category_name' => $obj->fk_sub_category, 'model' => ($obj->fk_model == NULL ? "-" : $obj->fk_model), 'product_name' => ($obj->fk_product == NULL ? "-" : $obj->fk_product), 'ac_capacity' => $ac_capacity, 'technician' => $technician_name, 'technician_phone' => $technician_mobile, 'tech_assigntime' => ($obj->tech_assigndatetime == NULL ? "-" : date('D d M Y h:i A', strtotime($obj->tech_assigndatetime))), 'date_added' => date('D d M Y h:i A', strtotime($obj->date_creation)));
			}
			else
			{
				$status_code = '0';
				$message = 'Sorry! No lead listing exists!!';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Sorry! No lead listing exists!!';
			
			$json = array('status_code' => $status_code, 'message' => $message);
		}
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! Customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);