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
	$societeNotificationData = array();

	if($userExists)
	{
		$object = new Product($db);

		$sql  = "SELECT fn.rowid, fn.tms as date_creation, fn.notification_text, ca.code";
		$sql .= " FROM ".MAIN_DB_PREFIX."fcm_notify as fn,";
		$sql .= " ".MAIN_DB_PREFIX."c_action_trigger as ca,";
		$sql .= " ".MAIN_DB_PREFIX."societe as s";
		$sql .= " WHERE fn.fk_soc = '".$user_id."'";
		$sql .= " ORDER BY fn.datec DESC";

		$result = $db->query($sql);
		if ($result) {
			$num = $db->num_rows($result);

			if($num > 0)
			{
				$status_code = '1';
				$message = 'Notification listing.';

				$i = 0;
				while ($i < $num) {
					$obj = $db->fetch_object($result);
					
					$societeNotificationData[] = array('notification_id' => $obj->rowid, 'notification_text' => $obj->notification_text, 'code' => $obj->code, 'date_added' =>  date('D d M Y h:i A', strtotime($obj->date_creation)));
					$i++;
				}

				$json = array('status_code' => $status_code, 'message' => $message, 'notification_data' => $societeNotificationData);
			}
			else
			{
				$status_code = '0';
				$message = 'Sorry! No Notification listing exists!!';
				
				$json = array('status_code' => $status_code, 'message' => $message);
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Sorry! No Notification listing exists!!';
			
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