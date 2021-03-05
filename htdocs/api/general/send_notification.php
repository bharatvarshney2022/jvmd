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
		$result = sendFCM("Raj Kapoor has been assigned on Test", "Support Ticket Assigned", "f0mQm6a5RXS600NETs7WHz:APA91bE6vi0rcfTgzvYxwyByOsgBDWnoAw0vXzVgBZ0KXkpe63A3jLb71dfDTxfKO4KojI9FkpNME-eZZxUwQ1Whw9B8eFI75LuW8Y_QHbYMLhZvSOJkDSLSIQWtL4htI4ihtZmy9ZLf");
		print_r($result);
		exit;

		print '<table class="noborder centpercent">';

		// List of current notifications for objet_type='withdraw'
		$sql = "SELECT u.nom,";
		$sql.= " nd.rowid, ad.code, ad.label";
		$sql.= " FROM ".MAIN_DB_PREFIX."societe as u,";
		$sql.= " ".MAIN_DB_PREFIX."notify_def as nd,";
		$sql.= " ".MAIN_DB_PREFIX."c_action_trigger as ad";
		$sql.= " WHERE u.rowid = nd.fk_soc";
		$sql.= " AND nd.fk_action = ad.rowid";
		$sql.= " AND u.entity IN (0,".$conf->entity.")";
		$sql.= " AND u.rowid = ".$user_id."";

		$resql = $db->query($sql);
		if ($resql)
		{
		    $num = $db->num_rows($resql);
		    $i = 0;
		    while ($i < $num)
		    {
		        $obj = $db->fetch_object($resql);


		        print '<tr class="oddeven">';
		        print '<td>'.$obj->nom.'</td>';
		        $label=($langs->trans("Notify_".$obj->code)!="Notify_".$obj->code?$langs->trans("Notify_".$obj->code):$obj->label);
		        print '<td>'.$label.'</td>';
		        print '<td class="right"><a href="'.$_SERVER["PHP_SELF"].'?action=deletenotif&token='.newToken().'&notif='.$obj->rowid.'">'.img_delete().'</a></td>';
		        print '</tr>';
		        $i++;
		    }
		    $db->free($resql);
		}

		print '</table>';
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! Customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}	