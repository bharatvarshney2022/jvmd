<?php
/* Copyright (C) 2005-2018	Laurent Destailleur	<eldy@users.sourceforge.net>
 * Copyright (C) 2005-2018	Regis Houssin		<regis.houssin@inodbox.com>
 * Copyright (C) 2019           Nicolas ZABOURI         <info@inovea-conseil.com>
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
 *	\file       htdocs/user/home.php
 *	\brief      Home page of users and groups management
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/user/class/usergroup.class.php';

$contextpage = GETPOST('contextpage', 'aZ') ?GETPOST('contextpage', 'aZ') : 'userhome'; // To manage different context of search

if (!$user->rights->user->user->lire && !$user->admin)
{
	// Redirection vers la page de l'utilisateur
	header("Location: card.php?id=".$user->id);
	exit;
}

// Load translation files required by page
$langs->load("users");

$canreadperms = true;
if (!empty($conf->global->MAIN_USE_ADVANCED_PERMS))
{
	$canreadperms = ($user->admin || $user->rights->user->group_advance->read);
}

// Security check (for external users)
$socid = 0;
if ($user->socid > 0) $socid = $user->socid;

$companystatic = new Societe($db);
$fuserstatic = new User($db);

// Initialize technical object to manage hooks. Note that conf->hooks_modules contains array
$hookmanager->initHooks(array('userhome'));


/*
 * View
 */
$user_group_id = 0;
$usergroup = new UserGroup($db);
$groupslist = $usergroup->listGroupsForUser($user->id);

if ($groupslist != '-1')
{
	foreach ($groupslist as $groupforuser)
	{
		$user_group_id = $groupforuser->id;
	}
}
llxHeaderLayout();

print '<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-custom">';

if($user_group_id == '17'){
	print load_fiche_titre_layout($langs->trans("Assign Vendors"), '', '');
}else{
	print load_fiche_titre_layout($langs->trans("MenuUsersAndGroups"), '', '');
}

print '<div class="card-body"><div class="row"><div class="col-md-6">';


// Search User
print '<div class="card card-custom">

	<div class="card-header"><h3 class="card-title">'.$langs->trans("Search").'</h3></div>
	<div class="card-body">
		<form method="post" action="'.DOL_URL_ROOT.'/core/search.php">';
		print '<input type="hidden" name="token" value="'.newToken().'">';

			print '<div class="form-group row">
				<label class="col-2 col-form-label">'.$langs->trans("User").'</label>
				<div class="col-10">
					<input class="form-control" name="search_user" size="18" type="text" value="" id="example-text-input">
				</div>
			</div>';

			// Search Group
			if ($canreadperms && $user_group_id != '17')
			{
				print '<div class="form-group row">
					<label class="col-2 col-form-label">'.$langs->trans("Group").'</label>
					<div class="col-10">
						<input class="form-control" name="search_group" size="18" type="text" value="" id="example-text-input">
					</div>
				</div>';
			}

			print '<div class="row">
				<div class="col-2"></div>
				<div class="col-10">
					<button type="submit" class="btn btn-success mr-2">'.$langs->trans("Search").'</button>
				</div>
			</div>';

		print '</form>
	</div>
</div>';

print '</div><div class="col-md-6">';


/*
 * Latest created users
 */
$max = 10;

$sql = "SELECT DISTINCT u.rowid, u.lastname, u.firstname, u.admin, u.login, u.fk_soc, u.datec, u.statut";
$sql .= ", u.entity";
$sql .= ", u.ldap_sid";
$sql .= ", u.photo";
$sql .= ", u.admin";
$sql .= ", u.email";
$sql .= ", s.nom as name";
$sql .= ", s.code_client";
$sql .= ", s.canvas";
$sql .= " FROM ".MAIN_DB_PREFIX."user as u";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s ON u.fk_soc = s.rowid";
// Add fields from hooks
$parameters = array();
$reshook = $hookmanager->executeHooks('printUserListWhere', $parameters); // Note that $action and $object may have been modified by hook
if ($reshook > 0) {
	$sql .= $hookmanager->resPrint;
} else {
	$sql .= " WHERE u.entity IN (".getEntity('user').")";
}
if (!empty($socid)) $sql .= " AND u.fk_soc = ".$socid;

if($user_group_id == '17')
{
	$vendor_list = '';
	$sqlVendor = "SELECT fk_vendor FROM `".MAIN_DB_PREFIX."user_extrafields` WHERE fk_object = '".$user->id."' ";
	$resqlVendor = $db->query($sqlVendor);
	if ($resqlVendor)
	{
		$rowVendor = $db->fetch_object($resqlVendor);
		$vendorData = $rowVendor->fk_vendor;
		
		//$vendorData[] = $user->id;

		if($vendorData)
		{
			//$vendor_list = implode(",", $vendorData);
			$sql .= " AND u.rowid IN (".$vendorData.")";
		}
	}

}

$sql .= $db->order("u.datec", "DESC");
$sql .= $db->plimit($max);

$resql = $db->query($sql);
if ($resql)
{
	$num = $db->num_rows($resql);

	print '<div class="card card-custom gutter-b">

		<div class="card-header"><h3 class="card-title">'.$langs->trans("LastUsersCreated", min($num, $max)).'</h3>
			<div class="card-toolbar"><div class="example-tools justify-content-center"><a class="" href="'.DOL_URL_ROOT.'/user/list.php?sortfield=u.datec&sortorder=DESC">'.$langs->trans("FullList").'</a></div></div>
		</div>
		<div class="card-body">
			<table class="table table-bordered table-checkable" id="kt_datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Username</th>
						<th>User Type</th>
						<th>Created at</th>
						<th>Status</th>
					</tr>
				</thead>

				<tbody>';

				$i = 0;

				while ($i < $num && $i < $max)
				{
					$obj = $db->fetch_object($resql);

					$fuserstatic->id = $obj->rowid;
					$fuserstatic->statut = $obj->statut;
					$fuserstatic->lastname = $obj->lastname;
					$fuserstatic->firstname = $obj->firstname;
					$fuserstatic->login = $obj->login;
					$fuserstatic->photo = $obj->photo;
					$fuserstatic->admin = $obj->admin;
					$fuserstatic->email = $obj->email;
					$fuserstatic->socid = $obj->fk_soc;

					$companystatic->id = $obj->fk_soc;
					$companystatic->name = $obj->name;
					$companystatic->code_client = $obj->code_client;
					$companystatic->canvas = $obj->canvas;

					print '<tr>';
					print '<td class="">';
					print $fuserstatic->getNomUrl(-1);
					if (!empty($conf->multicompany->enabled) && $obj->admin && !$obj->entity)
					{
						print img_picto($langs->trans("SuperAdministrator"), 'redstar');
					} elseif ($obj->admin)
					{
						print img_picto($langs->trans("Administrator"), 'star');
					}
					print "</td>";
					print '<td>'.$obj->login.'</td>';
					print "<td>";
					if ($obj->fk_soc)
					{
						print $companystatic->getNomUrl(1);
					} else {
						print $langs->trans("InternalUser");
					}
					if ($obj->ldap_sid)
					{
						print ' ('.$langs->trans("DomainUser").')';
					}

					$entity = $obj->entity;
					$entitystring = '';
					// TODO Set of entitystring should be done with a hook
					if (!empty($conf->multicompany->enabled) && is_object($mc))
					{
						if (empty($entity))
						{
							$entitystring = $langs->trans("AllEntities");
						} else {
							$mc->getInfo($entity);
							$entitystring = $mc->label;
						}
					}
					print ($entitystring ? ' ('.$entitystring.')' : '');

					print '</td>';
					print '<td class="">'.dol_print_date($db->jdate($obj->datec), 'dayhour').'</td>';
					print '<td class="">';
					print $fuserstatic->getLibStatutLayout(3);
					print '</td>';

					print '</tr>';
					$i++;
				}


				print "</tbody>
			</table>
		</div>
	</div>";

	$db->free($resql);
} else {
	dol_print_error($db);
}


/*
 * Last groups created
 */
if ($canreadperms && $user_group_id != '17')
{
	$max = 5;

	$sql = "SELECT g.rowid, g.nom as name, g.note, g.entity, g.datec";
	$sql .= " FROM ".MAIN_DB_PREFIX."usergroup as g";
	if (!empty($conf->multicompany->enabled) && $conf->entity == 1 && ($conf->global->MULTICOMPANY_TRANSVERSE_MODE || ($user->admin && !$user->entity)))
	{
		$sql .= " WHERE g.entity IS NOT NULL";
	} else {
		$sql .= " WHERE g.entity IN (0,".$conf->entity.")";
	}
	$sql .= $db->order("g.datec", "DESC");
	$sql .= $db->plimit($max);

	$resql = $db->query($sql);
	if ($resql)
	{
		$colspan = 1;
		if (!empty($conf->multicompany->enabled)) $colspan++;
		$num = $db->num_rows($resql);

		print '<div class="card card-custom gutter-b">

		<div class="card-header"><h3 class="card-title">'.$langs->trans("LastGroupsCreated", ($num ? $num : $max)).'</h3>
			<div class="card-toolbar"><div class="example-tools justify-content-center"><a class="" href="'.DOL_URL_ROOT.'/user/group/list.php?sortfield=g.datec&sortorder=DESC">'.$langs->trans("FullList").'</a></div></div>
		</div>
		<div class="card-body">
			<table class="table table-bordered table-checkable" id="kt_datatable">
				<thead>
					<tr>
						<th>Group Name</th>
						<th>Created at</th>
					</tr>
				</thead>

				<tbody>';

					$i = 0;

					$grouptemp = new UserGroup($db);

					while ($i < $num && (!$max || $i < $max))
					{
						$obj = $db->fetch_object($resql);

						$grouptemp->id = $obj->rowid;
						$grouptemp->name = $obj->name;
						$grouptemp->note = $obj->note;

						print '<tr class="">';
						print '<td>';
						print $grouptemp->getNomUrl(1);
						if (!$obj->entity)
						{
							print img_picto($langs->trans("GlobalGroup"), 'redstar');
						}
						print "</td>";
						if (!empty($conf->multicompany->enabled) && is_object($mc))
						{
							$mc->getInfo($obj->entity);
							print '<td>';
							print $mc->label;
							print '</td>';
						}
						print '<td class="nowrap right">'.dol_print_date($db->jdate($obj->datec), 'dayhour').'</td>';
						print "</tr>";
						$i++;
					}

		print "	</tbody>
			</table>
		</div></div>";

		$db->free($resql);
	} else {
		dol_print_error($db);
	}
}

//print '</td></tr></table>';
print '</div></div></div></div>';
print '</div></div></div></div>';

// Initialize technical object to manage hooks. Note that conf->hooks_modules contains array
$parameters = array('user' => $user);
$reshook = $hookmanager->executeHooks('dashboardUsersGroups', $parameters, $object); // Note that $action and $object may have been modified by hook

// End of page
llxFooterLayout();

print '<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<!--end::Page Vendors-->';

print "	</body>\n";
print "</html>\n";

$db->close();
