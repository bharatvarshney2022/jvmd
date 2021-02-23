<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
	
	$json = $brandData = array();

	$brand_name = GETPOST('brand_id', 'alpha');
	$category_name = GETPOST('category_id', 'alpha');

	$objectPro1 = new Product($db);
	$brand_id = $objectPro1->getBrandByName($brand_name);
	$category_id = $objectPro1->getCategoryByName($category_name);

	$sql1 = 'SELECT rowid, nom FROM '.MAIN_DB_PREFIX."c_product_subfamily WHERE active = '1'";
	if($brand_id > 0)
	{
		$sql1 .= " AND fk_brand = '".(int)$brand_id."'";
	}
	if($category_id > 0)
	{
		$sql1 .= " AND fk_family = '".(int)$category_id."'";
	}
	$resql1 = $db->query($sql1);
	
	if($resql1)
	{
		while($row = $db->fetch_array($resql1))
		{
			$brandData[] = array('sub_category_id' => $row['rowid'], 'sub_category_name' => $row['nom']);
		}

		$status_code = '1';
		$message = 'Product Sub Family Listing';
			
		$json = array('status_code' => $status_code, 'message' => $message, 'sub_category_data' => $brandData);
	}
	else
	{
		$status_code = '0';
		$message = 'No Product Sub Family data exists';
			
		$json = array('status_code' => $status_code, 'message' => $message, 'sub_category_data' => $brandData);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);