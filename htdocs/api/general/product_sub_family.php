<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	
	$json = $brandData = array();

	$brand_id = GETPOST('brand_id', 'int');
	$sub_category_id = GETPOST('sub_category_id', 'int');

	$sql1 = 'SELECT rowid, nom FROM '.MAIN_DB_PREFIX."c_product_sub_family WHERE active = '1'";
	if($brand_id > 0)
	{
		$sql1 .= " AND fk_brand = '".(int)$brand_id."'";
	}
	if($sub_category_id > 0)
	{
		$sql1 .= " AND fk_family = '".(int)$sub_category_id."'";
	}
	echo $sql1;
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
			
		$json = array('status_code' => $status_code, 'message' => $message, 'zip_data' => $brandData);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);