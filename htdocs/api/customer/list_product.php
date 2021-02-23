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
	require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
	
	$user_id = GETPOST('user_id', 'int');

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$societeProductData = array();

	if($userExists)
	{
		$object = new Product($db);

		$sql  = "SELECT p.rowid as id, p.fk_soc, p.fk_product, b.nom as brandname, f.nom as familyname, sf.nom as subfamily, m.code as c_product_model, m.nom as pname, p.ac_capacity as capacity, p.component_no, p.datec as de, p.tms as date_update";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_customer as p";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_brands as b on p.fk_brand = b.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_family as f on p.fk_category = f.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_subfamily as sf on p.fk_subcategory = sf.rowid";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_product_model as m on p.fk_model = m.rowid";
		
		$sql .= " WHERE p.fk_soc = '".$user_id."'";
		$sql .= " ORDER BY p.datec DESC";

		$result = $db->query($sql);
		if ($result) {
			$num = $db->num_rows($result);

			$status_code = '1';
			$message = 'Product listing.';

			$i = 0;
			$producttmp = new Product($db);

			while ($i < $num) {
				$obj = $db->fetch_object($result);
				
				$producttmp->fetch($obj->fk_product);

				$societeProductData[] = array('product_id' => $obj->id, 'brand' => $obj->brandname, 'category_name' => $obj->familyname, 'sub_category_name' => $obj->subfamily, 'model' => $obj->c_product_model, 'product_name' => $obj->pname, 'capacity' => $obj->capacity, 'date_added' => $obj->de);
				$i++;
			}

			$json = array('status_code' => $status_code, 'message' => $message, 'product_data' => $societeProductData);
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