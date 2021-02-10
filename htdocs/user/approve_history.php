<?php
/* Copyright (C) 2004      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2015 Regis Houssin        <regis.houssin@inodbox.com>
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
 *      \file       htdocs/user/approve_history.php
 *      \ingroup    usergroup
 *      \brief      Fiche de notes sur un utilisateur Dolibarr
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/usergroups.lib.php';
require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';

$id = GETPOST('id', 'int');
$approve_id = GETPOST('approve_id', 'int');
$action = GETPOST('action', 'aZ09');
$contextpage = GETPOST('contextpage', 'aZ') ?GETPOST('contextpage', 'aZ') : 'userapprove'; // To manage different context of search

// Load translation files required by page
$langs->loadLangs(array('companies', 'members', 'bills', 'users'));

$object = new User($db);
$object->fetch($id, '', '', 1);
$object->getrights();

// If user is not user read and no permission to read other users, we stop
//echo '<pre>';print_r($user->rights->user->user); exit;
if (($object->id != $user->id) && (!$user->rights->user->user->approval)) {
	accessforbidden();
}

// Security check
$socid = 0;
if ($user->socid > 0) $socid = $user->socid;
$feature2 = $user->rights->user->user->approval ? 'user' : '';

$usergroup = new UserGroup($db);
$groupslist = $usergroup->listGroupsForUser($user->id);

$user_group = 0;
$is_display = 0;
if ($groupslist != '-1')
{
	foreach ($groupslist as $groupforuser)
	{
		$user_group = $groupforuser->id;
	}
}

if($user->admin == 1) // || ($user_group == 3 || $user_group == 11 || $user_group == 12 || $user_group == 13))
{
	$result = restrictedArea($user, 'user', $id, 'user&user', $feature2);
}

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('usercard', 'userapprove', 'globalcard'));

// Insert Data if not exists
$sql = "SELECT rowid FROM ".MAIN_DB_PREFIX."user_approval";
$sql .= " WHERE fk_user=".$id;
$resql = $db->query($sql);
if($resql)
{
	$num = $db->num_rows($resql);
	if($num == 0)
	{
		// RM
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."user_approval (entity,fk_user,fk_usergroup,approve_statut)";
		$sql .= " VALUES('1','".(int)$id."','3','0')";
		$result = $db->query($sql);

		// CBO
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."user_approval (entity,fk_user,fk_usergroup,approve_statut)";
		$sql .= " VALUES('1','".(int)$id."','11','0')";
		$result = $db->query($sql);

		// Service Mgr.
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."user_approval (entity,fk_user,fk_usergroup,approve_statut)";
		$sql .= " VALUES('1','".(int)$id."','12','0')";
		$result = $db->query($sql);

		// Service Ex.
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."user_approval (entity,fk_user,fk_usergroup,approve_statut)";
		$sql .= " VALUES('1','".(int)$id."','13','0')";
		$result = $db->query($sql);
	}
}

if ($action == 'approve')
{

	if($approve_id > 0)
	{
		$sql = "SELECT rowid FROM ".MAIN_DB_PREFIX."user_approval";
		$sql .= " WHERE fk_user= '".$id."' AND rowid = '".$approve_id."' AND approve_statut = 0";
		$resql = $db->query($sql);
		if($resql)
		{
			$num = $db->num_rows($resql);
			if($num == 1)
			{
				$sql = "UPDATE ".MAIN_DB_PREFIX."user_approval";
				$sql .= " SET approve_statut = 1";
				$sql .= " WHERE fk_user= '".$id."' AND rowid = ".$approve_id;
				$result = $db->query($sql);
				$db->commit();
			}
		}

		header("Location: ".$_SERVER['PHP_SELF'].'?id='.$id);
		exit;
	}
}


/*
 * Actions
 */

$parameters = array('id'=>$socid);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (empty($reshook)) {
	if ($action == 'update' && $user->rights->user->user->creer && !$_POST["cancel"]) {
		$db->begin();

		$res = $object->update_note(dol_html_entity_decode(GETPOST('note_private', 'restricthtml'), ENT_QUOTES | ENT_HTML5));
		if ($res < 0) {
			$mesg = '<div class="error">'.$adh->error.'</div>';
			$db->rollback();
		} else {
			$db->commit();
		}
	}
}


/*
 * View
 */

llxHeader();

$form = new Form($db);

if ($id)
{
	$head = user_prepare_head($object);

	$title = $langs->trans("User");
	print dol_get_fiche_head($head, 'approval', $title, -1, 'user');

	$linkback = '';

	if ($user->rights->user->user->lire || $user->admin) {
		$linkback = '<a href="'.DOL_URL_ROOT.'/user/list.php?restore_lastsearch_values=1">'.$langs->trans("BackToList").'</a>';
	}

	dol_banner_tab($object, 'id', $linkback, $user->rights->user->user->lire || $user->admin);

	print '<div class="underbanner clearboth"></div>';

	print "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	print '<input type="hidden" name="token" value="'.newToken().'">';

	print '<div class="fichecenter">';
	print '<table class="border centpercent tableforfield">';

	$sql = "SELECT ua.rowid, ua.fk_usergroup, u.nom, ua.approve_statut FROM ".MAIN_DB_PREFIX."user_approval ua LEFT JOIN ".MAIN_DB_PREFIX."usergroup u ON ua.fk_usergroup = u.rowid WHERE fk_user = '".(int)$id."'";
	if($user->admin == 0)
	{
		$sql .= " AND fk_usergroup = '".$user_group."'";
	}
	$result = $db->query($sql);
	$res = $db->query($sql);
	if ($res) {
		$users = array();
		while ($rec = $db->fetch_object($res)) {
			//print_r($rec); exit;
			// Login
			print '<tr><td class="titlefield">'.$rec->nom.'</td><td class="valeur">'.
			($rec->approve_statut == 1 ? "<span class='badge  badge-status4 badge-status'>Approve</span>" : "<span class='badge  badge-status5 badge-status'>Dis-Approve</span>").'&nbsp;';

			if($rec->approve_statut == 0)
			{
				print '<a class="butAction" href="'.DOL_URL_ROOT.'/user/approve_history.php?action=approve&approve_id='.$rec->rowid.'&id='.$id.'">Approve User</a>';
			}
			print '</td></tr>';
		}
	}

	$editenabled = (($action == 'edit') && !empty($user->rights->user->user->creer));

	print "</table>";
	print '</div>';

	print dol_get_fiche_end();

	if ($action == 'edit')
	{
		print '<div class="center">';
		print '<input type="submit" class="button button-save" name="update" value="'.$langs->trans("Save").'">';
		print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		print '<input type="submit" class="button button-cancel" name="cancel" value="'.$langs->trans("Cancel").'">';
		print '</div>';
	}


	/*
     * Actions
     */

	//print '<div class="tabsAction">';

	if ($user->rights->user->user->creer && $action != 'edit')
	{
		//print "<a class=\"butAction\" href=\"approve_history.php?id=".$object->id."&amp;action=edit\">".$langs->trans('Modify')."</a>";
	}

	//print "</div>";

	print "</form>\n";
}

// End of page
llxFooter();
$db->close();
