<?php
/* Copyright (C) 2003-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2014	   Juanjo Menent		<jmenent@2byte.es>
 * Copyright (C) 2018 	   Philippe Grand		<philippe.grand@atoo-net.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *      \file       htdocs/core/class/notify.class.php
 *      \ingroup    notification
 *      \brief      File of class to manage notifications
 */
require_once DOL_DOCUMENT_ROOT.'/core/class/CMailFile.class.php';


/**
 *      Class to manage notifications
 */
class FCMNotify
{
	/**
	 * @var int ID
	 */
	public $id;

	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var string[] Error codes (or messages)
	 */
	public $errors = array();

	public $author;
	public $ref;
	public $date;
	public $duree;
	public $note;

	/**
	 * @var int Project ID
	 */
	public $fk_project;

	// Les codes actions sont definis dans la table llx_notify_def

	// codes actions supported are
	// @todo defined also into interface_50_modNotificiation_Notificiation.class.php
	public $arrayofnotifsupported = array(
		'PROJET_CREATE',
		'PROJET_ACCEPT',
		'PROJET_TECHNICIAN_ASSIGN',
		'PROJET_RESCHEDULED',
		'PROJET_COMPLETE'
	);


	/**
	 *	Constructor
	 *
	 *	@param 		DoliDB		$db		Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}


	/**
	 *  Return message that say how many notification (and to which email) will occurs on requested event.
	 *	This is to show confirmation messages before event is recorded.
	 *
	 * 	@param	string	$action		Id of action in llx_c_action_trigger
	 * 	@param	int		$socid		Id of third party
	 *  @param	Object	$object		Object the notification is about
	 *	@return	string				Message
	 */
	public function confirmMessage($action, $socid, $object)
	{
		global $langs;
		$langs->load("mails");

		$listofnotiftodo = $this->getNotificationsArray($action, $socid, $object, 0);

		$texte = '';
		$nb = -1;
		if (is_array($listofnotiftodo)) {
			$nb = count($listofnotiftodo);
		}
		if ($nb < 0) {
			$texte = img_object($langs->trans("Notifications"), 'email').' '.$langs->trans("ErrorFailedToGetListOfNotificationsToSend");
		} elseif ($nb == 0) {
			$texte = img_object($langs->trans("Notifications"), 'email').' '.$langs->trans("NoNotificationsWillBeSent");
		} elseif ($nb == 1) {
			$texte = img_object($langs->trans("Notifications"), 'email').' '.$langs->trans("ANotificationsWillBeSent");
		} elseif ($nb >= 2) {
			$texte = img_object($langs->trans("Notifications"), 'email').' '.$langs->trans("SomeNotificationsWillBeSent", $nb);
		}

		if (is_array($listofnotiftodo)) {
			$i = 0;
			foreach ($listofnotiftodo as $val) {
				if ($i) {
					$texte .= ', ';
				} else {
					$texte .= ' (';
				}
				if ($val['isemailvalid']) {
					$texte .= $val['email'];
				} else {
					$texte .= $val['notificationdesc'];
				}
				$i++;
			}
			if ($i) {
				$texte .= ')';
			}
		}

		return $texte;
	}

	/**
	 * Return number of notifications activated for action code (and third party)
	 *
	 * @param	string	$notifcode		Code of action in llx_c_action_trigger (new usage) or Id of action in llx_c_action_trigger (old usage)
	 * @param	int		$socid			Id of third party or 0 for all thirdparties or -1 for no thirdparties
	 * @param	Object	$object			Object the notification is about (need it to check threshold value of some notifications)
	 * @param	int		$userid         Id of user or 0 for all users or -1 for no users
	 * @param   array   $scope          Scope where to search
	 * @return	array|int				<0 if KO, array of notifications to send if OK
	 */
	public function getNotificationsArray($notifcode, $socid = 0, $object = null, $userid = 0, $scope = array('thirdparty', 'user', 'global'))
	{
		global $conf, $user;

		$error = 0;
		$resarray = array();

		$valueforthreshold = 0;
		if (is_object($object)) {
			$valueforthreshold = $object->total_ht;
		}

		$sqlnotifcode = '';
		if ($notifcode) {
			if (is_numeric($notifcode)) {
				$sqlnotifcode = " AND n.fk_action = ".$notifcode; // Old usage
			} else {
				$sqlnotifcode = " AND a.code = '".$this->db->escape($notifcode)."'"; // New usage
			}
		}


		if (!$error) {
			if ($socid >= 0 && in_array('thirdparty', $scope)) {
				$sql = "SELECT n.rowid as notify_id, a.code, s.rowid as socid, pr.ref, c.email, c.fcmToken, c.rowid";
				$sql .= " FROM ".MAIN_DB_PREFIX."fcm_notify_def as n,";
				$sql .= " ".MAIN_DB_PREFIX."projet as pr,";
				$sql .= " ".MAIN_DB_PREFIX."socpeople as c,";
				$sql .= " ".MAIN_DB_PREFIX."c_action_trigger as a,";
				$sql .= " ".MAIN_DB_PREFIX."societe as s";
				$sql .= " WHERE n.fk_contact = c.rowid";
				$sql .= " AND a.rowid = n.fk_action";
				$sql .= " AND n.fk_projet = pr.rowid";
				$sql .= " AND n.fk_soc = s.rowid";
				$sql .= $sqlnotifcode;
				$sql .= " AND is_sent = 0 AND s.entity IN (".getEntity('societe').")";
				if ($socid > 0) {
					$sql .= " AND s.rowid = ".$socid;
				}

				dol_syslog(__METHOD__." ".$notifcode.", ".$socid."", LOG_DEBUG);

				$resql = $this->db->query($sql);
				if ($resql) {
					$num = $this->db->num_rows($resql);
					$i = 0;
					while ($i < $num) {
						$obj = $this->db->fetch_object($resql);
						if ($obj) {
							$newval2 = trim($obj->email);
							$newval3 = trim($obj->fcmToken);
							$isvalid = isValidEmail($newval2);
							$isvalid1 = isValidFCM($newval3);
							if (empty($resarray[$newval2])) {
							$resarray[$obj->notify_id] = array('type'=> 'tocontact', 'code'=>trim($obj->code), 'notificationdesc'=> $obj->ref, 'email'=>$newval2, 'fcmToken' => $newval3, 'contactid'=>$obj->rowid, 'isemailvalid'=>$isvalid, 'isfcmvalid'=>$isvalid1, 'lead_ref' => $obj->ref);
							}
						}
						$i++;
					}
				} else {
					$error++;
					$this->error = $this->db->lasterror();
				}
			}
		}

		if ($error) {
			return -1;
		}

		//var_dump($resarray);
		return $resarray;
	}

	/**
	 *  Check if notification are active for couple action/company.
	 * 	If yes, send mail and save trace into llx_notify.
	 *
	 * 	@param	string	$notifcode			Code of action in llx_c_action_trigger (new usage) or Id of action in llx_c_action_trigger (old usage)
	 * 	@param	Object	$object				Object the notification deals on
	 *	@param 	array	$filename_list		List of files to attach (full path of filename on file system)
	 *	@param 	array	$mimetype_list		List of MIME type of attached files
	 *	@param 	array	$mimefilename_list	List of attached file name in message
	 *	@return	int							<0 if KO, or number of changes if OK
	 */
	public function send($notifcode, $object)
	{
		global $user, $conf, $langs, $mysoc;
		global $hookmanager;
		global $dolibarr_main_url_root;
		global $action;

		if (!in_array($notifcode, $this->arrayofnotifsupported)) {
			return 0;
		}

		require_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
		if (!is_object($hookmanager)) {
			include_once DOL_DOCUMENT_ROOT.'/core/class/hookmanager.class.php';
			$hookmanager = new HookManager($this->db);
		}
		$hookmanager->initHooks(array('notification'));

		dol_syslog(get_class($this)."::send notifcode=".$notifcode.", object=".$object->id);

		$langs->load("other");

		// Define $urlwithroot
		$urlwithouturlroot = preg_replace('/'.preg_quote(DOL_URL_ROOT, '/').'$/i', '', trim($dolibarr_main_url_root));
		$urlwithroot = $urlwithouturlroot.DOL_URL_ROOT; // This is to use external domain name found into config file
		//$urlwithroot=DOL_MAIN_URL_ROOT;						// This is to use same domain name than current

		// Define some vars
		$application = 'JMVD';
		if (!empty($conf->global->MAIN_APPLICATION_TITLE)) {
			$application = $conf->global->MAIN_APPLICATION_TITLE;
		}
		$replyto = $conf->notification->email_from;
		$object_type = '';
		$link = '';
		$num = 0;
		$error = 0;

		$oldref = (empty($object->oldref) ? $object->ref : $object->oldref);
		$newref = (empty($object->newref) ? $object->ref : $object->newref);

		$sql = '';

		// Check notification per third party
		if (!empty($object->socid) && $object->socid > 0) {
			$sql .= "SELECT c.fcmToken, c.email, c.rowid as socp_id, c.lastname, c.firstname, ";
			$sql .= " a.rowid as actionid, a.label, a.code, n.rowid as notify_id, n.type, fk_projet";
			$sql .= " FROM ".MAIN_DB_PREFIX."socpeople as c,";
			$sql .= " ".MAIN_DB_PREFIX."c_action_trigger as a,";
			$sql .= " ".MAIN_DB_PREFIX."fcm_notify_def as n,";
			$sql .= " ".MAIN_DB_PREFIX."societe as s";
			$sql .= " WHERE n.fk_contact = c.rowid AND a.rowid = n.fk_action";
			$sql .= " AND n.fk_soc = s.rowid";
			$sql .= " AND c.statut = 1 AND is_sent = 0";
			if (is_numeric($notifcode)) {
				$sql .= " AND n.fk_action = ".$notifcode; // Old usage
			} else {
				$sql .= " AND a.code = '".$this->db->escape($notifcode)."'"; // New usage
			}
			$sql .= " AND s.rowid = ".$object->socid;
		}

		$count = 0;
		$result = $this->db->query($sql);
		if ($result) {
			$num = $this->db->num_rows($result);
			if ($num > 0) {
				$i = 0;
				while ($i < $num && !$error) {	// For each notification couple defined (third party/actioncode)
					$obj = $this->db->fetch_object($result);

					//echo '<pre>'; print_r($obj);

					$projtitle = $projref = $projtechnician = '';
					if (!empty($obj->fk_projet)) {
						
						$proj = new Project($this->db);
						$proj->fetch($obj->fk_projet);
						$projtitle = $proj->title;
						$projref = $proj->ref;
						$projprojtechnician = $proj->fk_technician;
					}

					$sendto = dolGetFirstLastname($obj->firstname, $obj->lastname)." <".$obj->email.">";
					$notifcodedefid = $obj->actionid;
					$object_type = 'projet';
					$type_target = 'tosocid';

					$sql = "INSERT INTO ".MAIN_DB_PREFIX."fcm_notify (daten, fk_action, fk_soc, fk_contact, type, objet_type, type_target, objet_id, email, fcm_token)";
					$sql .= " VALUES ('".$this->db->idate(dol_now())."', ".$notifcodedefid.", ".($object->socid ? $object->socid : 'null').", ".$obj->socp_id.", '".$obj->type."', '".$object_type."', '".$type_target."', ".$obj->fk_projet.", '".$this->db->escape($obj->email)."', '".$this->db->escape($obj->fcmToken)."')";
					if($this->db->query($sql))
					{
						if($obj->code == 'PROJET_CREATE')
						{
							$fcmResult = sendFCM($obj->label, "Lead #".$projref." has been created", $obj->fcmToken);
							$fcmResultRow = json_decode($fcmResult);
							
							if($fcmResultRow->success == 1)
							{
								$sql1 = "UPDATE ".MAIN_DB_PREFIX."fcm_notify_def SET is_sent = 1 WHERE rowid = '".$obj->notify_id."'";
								$this->db->query($sql1);
								$count++;
							}
						}
						elseif($obj->code == 'PROJET_ACCEPT')
						{
							$fcmResult = sendFCM($obj->label, "Lead #".$projref." has been accepted", $obj->fcmToken);
							$fcmResultRow = json_decode($fcmResult);
							
							if($fcmResultRow->success == 1)
							{
								$sql1 = "UPDATE ".MAIN_DB_PREFIX."fcm_notify_def SET is_sent = 1 WHERE rowid = '".$obj->notify_id."'";
								$this->db->query($sql1);
								$count++;
							}
						}
					}
					$i++;
				}
			} else {
				dol_syslog("No notification to thirdparty sent, nothing into notification setup for the thirdparty socid = ".(empty($object->socid) ? '' : $object->socid));
			}
		} else {
			$error++;
			$this->errors[] = $this->db->lasterror();
			dol_syslog("Failed to get list of notification to send ".$this->db->lasterror(), LOG_ERR);
			return -1;
		}

		if (!$error) {
			return $count;
		} else {
			return -1 * $error;
		}
	}
}
