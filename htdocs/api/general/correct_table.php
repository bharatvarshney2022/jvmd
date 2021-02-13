<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	$json = array();
	
	global $db;
	
	$resql = $db->query("SHOW tables");
	
	while($obj = $db->fetch_object($resql))
	{
		$tableName = $obj->Tables_in_erp_subpe_new;
		
		$resql1 = $db->query("SHOW COLUMNS FROM ".$tableName);
				
		while($obj1 = $db->fetch_object($resql1))
		{
			$fieldName = $obj1->Field;
			
			if($fieldName == "rowid")
			{
				$db->query("ALTER TABLE `".$tableName."` CHANGE `rowid` `rowid` INT(11) NOT NULL AUTO_INCREMENT");
			}
		}
	}	