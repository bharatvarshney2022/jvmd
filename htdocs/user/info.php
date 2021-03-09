<?php
/* Copyright (C) 2004-2007 Laurent Destailleur  <eldy@users.sourceforge.net>
 * 
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
 *      \file       htdocs/user/info.php
 *      \ingroup    core
 *		\brief      Page des informations d'un utilisateur
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/usergroups.lib.php';
require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';

// Load translation files required by page
$langs->load("users");

// Security check
$id = GETPOST('id', 'int');
$object = new User($db);
if ($id > 0 || !empty($ref))
{
	$result = $object->fetch($id, $ref, '', 1);
	$object->getrights();
}

// Security check
$socid = 0;
if ($user->socid > 0) $socid = $user->socid;
$feature2 = (($socid && $user->rights->user->self->creer) ? '' : 'user');

$result = restrictedArea($user, 'user', $id, 'user&user', $feature2);

// If user is not user that read and no permission to read other users, we stop
if (($object->id != $user->id) && (!$user->rights->user->user->lire))
  accessforbidden();



/*
 * View
 */

$form = new Form($db);

llxHeaderLayout();

$head = user_prepare_head($object);

$title = $langs->trans("User");

print '<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<!--begin::Card-->
									<div class="card card-custom gutter-b">
										<div class="card-footer">';

print dol_get_fiche_head_layout($head, 'info', $title, -1, 'user');

print '</div>
		<div class="card-body">';

$linkback = '';

if ($user->rights->user->user->lire || $user->admin) {
	$linkback = '<a href="'.DOL_URL_ROOT.'/user/list.php?restore_lastsearch_values=1">'.$langs->trans("BackToList").'</a>';
}

dol_banner_tab_layout($object, 'id', $linkback, $user->rights->user->user->lire || $user->admin);


$object->info($id); // This overwrite ->ref with login instead of id

print '</div>
</div>'; // card

print '<div class="card card-custom gutter-b"><div class="card-body">';


print '<div class="row">';
print '<div class="col-sm-12">';


dol_print_object_info($object);

print '</div>';
print '</div>';

print '</div>';
print '</div>';
print '</div>';
print '</div>';

// End of page
llxFooterLayout();

print '<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<!--end::Page Vendors-->';

print "	</body>\n";
print "</html>\n";

$db->close();
