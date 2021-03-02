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

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$societeProductData = array();

	if($userExists)
	{
		$object1 = new Project($db);
		$sql = "SELECT DISTINCT p.rowid as id, p.ref, p.title, p.fk_statut as status, p.fk_technician, p.tech_assigndatetime, p.fk_product, br.nom as brand_name, ca.nom as category_name, sca.nom as sub_category_name, pmo.nom as model_name, pr.label as product_name";
		$sql .= ", p.datec as date_creation, p.tms as date_update";
		$sql .= ", s.rowid as socid, s.nom as name, s.email, ef.fk_call_source, ef.fk_service_type ";
		$sql .= " FROM ".MAIN_DB_PREFIX.$object1->table_element." as p";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX.$object1->table_element."_extrafields as ef on (p.rowid = ef.fk_object)";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s on p.fk_soc = s.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_brands as br on p.fk_brand = br.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_family as ca on p.fk_category = ca.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_subfamily as sca on p.fk_sub_category = sca.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_model as pmo on p.fk_model = pmo.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."product as pr on p.fk_product = pr.rowid";
		$sql .= " WHERE p.fk_soc = '".$user_id."'";
		$sql .= " ORDER BY p.datec DESC";
		
		$result = $db->query($sql);
		if ($result) {
			$num = $db->num_rows($result);

			$status_code = '1';
			$message = 'List listing.';

			$i = 0;

			while ($i < $num) {
				$obj = $db->fetch_object($result);
				
				$societeLeadData[] = array('lead_id' => $obj->id, 'status' => $obj->labelStatus[$obj->status], 'brand' => $obj->brand_name, 'category_name' => $obj->category_name, 'sub_category_name' => $obj->sub_category_name, 'model' => $obj->model_name, 'product_name' => $obj->product_name, 'date_added' => $obj->date_creation);
				$i++;
			}

			$json = array('status_code' => $status_code, 'message' => $message, 'lead_data' => $societeLeadData);
		}
		else
		{
			$status_code = '0';
			$message = 'Sorry! No product listing exists!!';
			
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