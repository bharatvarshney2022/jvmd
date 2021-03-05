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
	require_once DOL_DOCUMENT_ROOT . '/core/class/fcm_notify.class.php';
	
	$user_id = GETPOST('user_id', 'int');

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);


	if($userExists)
	{
		$object->socid = $user_id;
		$objectNot = new FCMNotify($db);

		$notifyData = $objectNot->getNotificationsArray('', $user_id, $objectNot, 0);
		//echo '<pre>';print_r($notifyData); exit;

		if($notifyData)
		{
			foreach($notifyData as $rowid => $notifyRow)
			{
				$objectNot->send($notifyRow['code'], $object);	
			}
		}
		exit;


		$result = sendFCM("Support Ticket Assigned", "Raj Kapoor has been assigned on Support Ticket JMD2021-02-00021
", "f0mQm6a5RXS600NETs7WHz:APA91bE6vi0rcfTgzvYxwyByOsgBDWnoAw0vXzVgBZ0KXkpe63A3jLb71dfDTxfKO4KojI9FkpNME-eZZxUwQ1Whw9B8eFI75LuW8Y_QHbYMLhZvSOJkDSLSIQWtL4htI4ihtZmy9ZLf");
		
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! Customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}	