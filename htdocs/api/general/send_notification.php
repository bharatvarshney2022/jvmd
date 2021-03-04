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
	require_once DOL_DOCUMENT_ROOT . '/core/class/notify.class.php';
	
	$user_id = GETPOST('user_id', 'int');

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);


	if($userExists)
	{
		$notify = new Notify($db);
		$societeContact = $object->contact_property_array();
		
		if($societeContact)
		{
			foreach ($societeContact as $socid => $name) {
				# code...
				$object->socid = $socid;
				$object->projet_id = '53';
				$object->email = '53';

				//echo '<pre>'; print_r($object); exit;

				$action = "PROJET_CREATE";
				$result = $notify->send($action, $object);

				echo $result; exit;
			}
		}
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! Customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}	