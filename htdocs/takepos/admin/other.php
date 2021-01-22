<?php
/* Copyright (C) 2008-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2011-2017 Juanjo Menent		<jmenent@2byte.es>
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
 *	\file       htdocs/takepos/admin/setup.php
 *	\ingroup    takepos
 *	\brief      Setup page for TakePos module
 */
require '../../main.inc.php'; // Load $user and permissions
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/html.formproduct.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/pdf.lib.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT."/core/lib/takepos.lib.php";

// If socid provided by ajax company selector
if (!empty($_REQUEST['CASHDESK_ID_THIRDPARTY_id'])) {
	$_GET['CASHDESK_ID_THIRDPARTY'] = GETPOST('CASHDESK_ID_THIRDPARTY_id', 'alpha');
	$_POST['CASHDESK_ID_THIRDPARTY'] = GETPOST('CASHDESK_ID_THIRDPARTY_id', 'alpha');
	$_REQUEST['CASHDESK_ID_THIRDPARTY'] = GETPOST('CASHDESK_ID_THIRDPARTY_id', 'alpha');
}

// Security check
if (!$user->admin) accessforbidden();

$langs->loadLangs(array("admin", "cashdesk"));

global $db;

$sql = "SELECT code, libelle FROM ".MAIN_DB_PREFIX."c_paiement";
$sql .= " WHERE entity IN (".getEntity('c_paiement').")";
$sql .= " AND active = 1";
$sql .= " ORDER BY libelle";
$resql = $db->query($sql);
$paiements = array();
if ($resql) {
	while ($obj = $db->fetch_object($resql)) {
		array_push($paiements, $obj);
	}
}


/*
 * Actions
 */

if (GETPOST('action', 'alpha') == 'set') {
	$db->begin();
	if (GETPOST('socid', 'int') < 0) $_POST["socid"] = '';

	$res = dolibarr_set_const($db, "CASHDESK_SERVICES", GETPOST('CASHDESK_SERVICES', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_ROOT_CATEGORY_ID", GETPOST('TAKEPOS_ROOT_CATEGORY_ID', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_BAR_RESTAURANT", GETPOST('TAKEPOS_BAR_RESTAURANT', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_TICKET_VAT_GROUPPED", GETPOST('TAKEPOS_TICKET_VAT_GROUPPED', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_ORDER_PRINTERS", GETPOST('TAKEPOS_ORDER_PRINTERS', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_ORDER_NOTES", GETPOST('TAKEPOS_ORDER_NOTES', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_PHONE_BASIC_LAYOUT", GETPOST('TAKEPOS_PHONE_BASIC_LAYOUT', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_SUPPLEMENTS", GETPOST('TAKEPOS_SUPPLEMENTS', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_SUPPLEMENTS_CATEGORY", GETPOST('TAKEPOS_SUPPLEMENTS_CATEGORY', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_NUMPAD", GETPOST('TAKEPOS_NUMPAD', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_SORTPRODUCTFIELD", GETPOST('TAKEPOS_SORTPRODUCTFIELD', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_COLOR_THEME", GETPOST('TAKEPOS_COLOR_THEME', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_NUM_TERMINALS", GETPOST('TAKEPOS_NUM_TERMINALS', 'alpha'), 'chaine', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_DIRECT_PAYMENT", GETPOST('TAKEPOS_DIRECT_PAYMENT', 'int'), 'int', 0, '', $conf->entity);
	//$res = dolibarr_set_const($db, "TAKEPOS_HEAD_BAR", GETPOST('TAKEPOS_HEAD_BAR', 'int'), 'int', 0, '', $conf->entity);
	$res = dolibarr_set_const($db, "TAKEPOS_EMAIL_TEMPLATE_INVOICE", GETPOST('TAKEPOS_EMAIL_TEMPLATE_INVOICE', 'alpha'), 'chaine', 0, '', $conf->entity);
	if (!empty($conf->global->TAKEPOS_ENABLE_SUMUP)) {
		$res = dolibarr_set_const($db, "TAKEPOS_SUMUP_AFFILIATE", GETPOST('TAKEPOS_SUMUP_AFFILIATE', 'alpha'), 'chaine', 0, '', $conf->entity);
		$res = dolibarr_set_const($db, "TAKEPOS_SUMUP_APPID", GETPOST('TAKEPOS_SUMUP_APPID', 'alpha'), 'chaine', 0, '', $conf->entity);
	}

	dol_syslog("admin/cashdesk: level ".GETPOST('level', 'alpha'));

	if (!$res > 0) $error++;

	if (!$error) {
		$db->commit();
		setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
	} else {
		$db->rollback();
		setEventMessages($langs->trans("Error"), null, 'errors');
	}
}


/*
 * View
 */

llxHeader('', $langs->trans("CashDeskSetup"));

$linkback = '<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print load_fiche_titre($langs->trans("CashDeskSetup").' (TakePOS)', $linkback, 'title_setup');
$head = takepos_admin_prepare_head();
print dol_get_fiche_head($head, 'other', 'TakePOS', -1, 'cash-register');
print '<br>';


// Mode
print '<form action="'.$_SERVER["PHP_SELF"].'" method="post">';
print '<input type="hidden" name="token" value="'.newToken().'">';
print '<input type="hidden" name="action" value="set">';


print '<div class="div-table-responsive-no-min">';

// Marketplace
print "<table summary=\"list_of_modules\" class=\"noborder\" width=\"100%\">\n";
print '<tr class="liste_titre">'."\n";
print '<td class="titlefield" colspan="2">'.$langs->trans("WebSiteDesc").'</td>';
print '<td>'.$langs->trans("URL").'</td>';
print '</tr>';

$url = 'https://www.dolistore.com/45-pos';

print '<tr class="oddeven">'."\n";
print '<td class="titlefield"><a href="'.$url.'" target="_blank" rel="external"><img border="0" class="imgautosize imgmaxwidth180" src="'.DOL_URL_ROOT.'/theme/dolistore_logo.png"></a></td>';
print '<td>'.$langs->trans("DolistorePosCategory").'</td>';
print '<td><a href="'.$url.'" target="_blank" rel="external">'.$url.'</a></td>';
print '</tr>';

print "</table>\n";

print '</div>';

print '<br>';


print '<div class="div-table-responsive-no-min">';

// Support
print "<table summary=\"list_of_modules\" class=\"noborder\" width=\"100%\">\n";
print '<tr class="liste_titre">'."\n";
print '<td colspan="2">TakePOS Support</td>';
print '<td>'.$langs->trans("URL").'</td>';
print '</tr>';

$url = 'http://www.takepos.com';

print '<tr class="oddeven">'."\n";
print '<td class="left"><a href="'.$url.'" target="_blank" rel="external"><img border="0" class="imgautosize imgmaxwidth180" src="../img/takepos.png"></a></td>';
print '<td>TakePOS original developers</td>';
print '<td><a href="'.$url.'" target="_blank" rel="external">'.$url.'</a></td>';
print '</tr>';

print "</table>\n";

print '</div>';
print '<br>';

llxFooter();
$db->close();
