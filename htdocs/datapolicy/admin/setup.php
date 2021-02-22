<?php
/* 
 * Copyright (C) 2018      Nicolas ZABOURI      <info@inovea-conseil.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    htdocs/datapolicy/admin/setup.php
 * \ingroup datapolicy
 * \brief   datapolicy setup page.
 */

require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT."/core/lib/admin.lib.php";
require_once '../lib/datapolicy.lib.php';

// Translations
$langs->load('admin');
$langs->load('companies');
$langs->load('members');
$langs->load('datapolicy@datapolicy');

// Access control
if (!$user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'aZ09');
$backtopage = GETPOST('backtopage', 'alpha');

$arrayofparameters = array();
$arrayofparameters['ThirdParty'] = array(
	'DATAPOLICY_TIERS_CLIENT'=>array('css'=>'minwidth200'),
	'DATAPOLICY_TIERS_PROSPECT'=>array('css'=>'minwidth200'),
	'DATAPOLICY_TIERS_PROSPECT_CLIENT'=>array('css'=>'minwidth200'),
	'DATAPOLICY_TIERS_NIPROSPECT_NICLIENT'=>array('css'=>'minwidth200'),
	'DATAPOLICY_TIERS_FOURNISSEUR'=>array('css'=>'minwidth200'),
);
if (!empty($conf->global->DATAPOLICY_USE_SPECIFIC_DELAY_FOR_CONTACT)) {
	$arrayofparameters['Contact'] = array(
		'DATAPOLICY_CONTACT_CLIENT'=>array('css'=>'minwidth200'),
		'DATAPOLICY_CONTACT_PROSPECT'=>array('css'=>'minwidth200'),
		'DATAPOLICY_CONTACT_PROSPECT_CLIENT'=>array('css'=>'minwidth200'),
		'DATAPOLICY_CONTACT_NIPROSPECT_NICLIENT'=>array('css'=>'minwidth200'),
		'DATAPOLICY_CONTACT_FOURNISSEUR'=>array('css'=>'minwidth200'),
	);
}
if (!empty($conf->adherent->enabled)) {
	$arrayofparameters['Member'] = array(
		'DATAPOLICY_ADHERENT'=>array('css'=>'minwidth200'),
	);
}



/*
 * Actions
 */

include DOL_DOCUMENT_ROOT.'/core/actions_setmoduleoptions.inc.php';

$valTab = array(
	'' => $langs->trans('Never'),
	'6' => $langs->trans('NB_MONTHS', 6),
	'12' => $langs->trans('ONE_YEAR'),
	'24' => $langs->trans('NB_YEARS', 2),
	'36' => $langs->trans('NB_YEARS', 3),
	'48' => $langs->trans('NB_YEARS', 4),
	'60' => $langs->trans('NB_YEARS', 5),
	'120' => $langs->trans('NB_YEARS', 10),
	'180' => $langs->trans('NB_YEARS', 15),
	'240' => $langs->trans('NB_YEARS', 20),
);


/*
 * View
 */

$page_name = "datapolicySetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.($backtopage ? $backtopage : DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, 'object_generic');

// Configuration header
$head = datapolicyAdminPrepareHead();
print dol_get_fiche_head($head, 'settings', '', -1, "datapolicy@datapolicy");

// Setup page goes here
echo '<span class="opacitymedium">'.$langs->trans("datapolicySetupPage").'</span><br><br>';


if ($action == 'edit')
{
	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="update">';

	print '<table class="noborder centpercent">';
	print '<tr class="liste_titre"><td class="titlefield">'.$langs->trans("Parameter").'</td><td>'.$langs->trans("Value").'</td></tr>';

	foreach ($arrayofparameters as $title => $tab)
	{
		print '<tr class="trforbreak"><td class="titlefield trforbreak" colspan="2">'.$langs->trans($title).'</td></tr>';
		foreach ($tab as $key => $val)
		{
			print '<tr class="oddeven"><td>';
			print $form->textwithpicto($langs->trans($key), $langs->trans($key.'Tooltip'));
			print '</td><td>';
			print '<select name="'.$key.'"  class="flat '.(empty($val['css']) ? 'minwidth200' : $val['css']).'">';
			foreach ($valTab as $key1 => $val1) {
				print '<option value="'.$key1.'" '.($conf->global->$key == $key1 ? 'selected="selected"' : '').'>';
				print $val1;
				print '</option>';
			}
			print '</select>';
			print '</td></tr>';
		}
	}

	print '</table>';

	print '<br><div class="center">';
	print '<input class="button button-save" type="submit" value="'.$langs->trans("Save").'">';
	print '</div>';

	print '</form>';
	print '<br>';
} else {
	print '<table class="noborder centpercent">';
	print '<tr class="liste_titre"><td class="titlefield">'.$langs->trans("Parameter").'</td><td>'.$langs->trans("Value").'</td></tr>';

	foreach ($arrayofparameters as $title => $tab)
	{
		print '<tr class="trforbreak"><td class="titlefield trforbreak" colspan="2">'.$langs->trans($title).'</td></tr>';
		foreach ($tab as $key => $val)
		{
			print '<tr class="oddeven"><td>';
			print $form->textwithpicto($langs->trans($key), $langs->trans('DATAPOLICY_Tooltip_SETUP'));
			print '</td><td>'.($conf->global->$key == '' ? $langs->trans('None') : $valTab[$conf->global->$key]).'</td></tr>';
		}
	}

	print '</table>';

	print '<div class="tabsAction">';
	print '<a class="butAction" href="'.$_SERVER["PHP_SELF"].'?action=edit">'.$langs->trans("Modify").'</a>';
	print '</div>';
}


// Page end
print dol_get_fiche_end();

llxFooter();
$db->close();
