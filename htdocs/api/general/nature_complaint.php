<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	
	$json = $brandData = array();

	$sql1 = 'SELECT rowid, label FROM '.MAIN_DB_PREFIX."c_call_source WHERE active = '1'";
	$resql1 = $db->query($sql1);
	
	if($resql1)
	{
		while($row = $db->fetch_array($resql1))
		{
			$brandData[] = array('nature_complaint_id' => $row['rowid'], 'nature_complaint_name' => $row['label']);
		}

		$status_code = '1';
		$message = 'Brand Listing';
			
		$json = array('status_code' => $status_code, 'message' => $message, 'nature_complaint_data' => $brandData);
	}
	else
	{
		$status_code = '0';
		$message = 'No Brand data exists';
			
		$json = array('status_code' => $status_code, 'message' => $message, 'nature_complaint_data' => $brandData);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);