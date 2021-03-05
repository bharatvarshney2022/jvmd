<?php
/* Copyright (C) 2001-2004  Rodolphe Quiedeville    <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2019  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2019  Regis Houssin           <regis.houssin@inodbox.com>
 * Copyright (C) 2012       Marcos García           <marcosgdf@gmail.com>
 * Copyright (C) 2013-2015  Raphaël Doursenaud      <rdoursenaud@gpcsolutions.fr>
 * Copyright (C) 2015       Florian Henry           <florian.henry@open-concept.pro>
 * Copyright (C) 2016-2018  Josep Lluis Amador      <joseplluis@lliuretic.cat>
 * Copyright (C) 2016       Ferran Marcet      	    <fmarcet@2byte.es>
 * Copyright (C) 2017       Rui Strecht      	    <rui.strecht@aliartalentos.com>
 * Copyright (C) 2017       Juanjo Menent      	    <jmenent@2byte.es>
 * Copyright (C) 2018       Nicolas ZABOURI         <info@inovea-conseil.com>
 * Copyright (C) 2020       Open-Dsi         		<support@open-dsi.fr>

 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope thaft it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       htdocs/societe/list.php
 *	\ingroup    societe
 *	\brief      Page to show list of third parties
 */

require_once '../main.inc.php';
include_once DOL_DOCUMENT_ROOT.'/contact/class/contact.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/societe/class/client.class.php';

$langs->loadLangs(array("companies", "commercial", "customers", "suppliers", "bills", "compta", "categories", "cashdesk"));

$action = GETPOST('action', 'aZ09');
$massaction = GETPOST('massaction', 'alpha');

$show_files = GETPOST('show_files', 'int');
$confirm = GETPOST('confirm', 'alpha');
$toselect = GETPOST('toselect', 'array');
$contextpage = GETPOST('contextpage', 'aZ') ?GETPOST('contextpage', 'aZ') : 'thirdpartylist';

if ($contextpage == 'poslist')
{
	$_GET['optioncss'] = 'print';
}

// Security check
$socid = GETPOST('socid', 'int');
if ($user->socid) $socid = $user->socid;
$result = restrictedArea($user, 'societe', $socid, '');

$search_all = trim(GETPOST('search_all', 'alphanohtml') ?GETPOST('search_all', 'alphanohtml') : GETPOST('sall', 'alphanohtml'));
$search_cti = preg_replace('/^0+/', '', preg_replace('/[^0-9]/', '', GETPOST('search_cti', 'alphanohtml'))); // Phone number without any special chars

$search_id = trim(GETPOST("search_id", "int"));
$search_nom = trim(GETPOST("search_nom", 'restricthtml'));
$search_alias = trim(GETPOST("search_alias", 'restricthtml'));
$search_nom_only = trim(GETPOST("search_nom_only", 'restricthtml'));
$search_barcode = trim(GETPOST("search_barcode", 'alpha'));
$search_customer_code = trim(GETPOST('search_customer_code', 'alpha'));
$search_supplier_code = trim(GETPOST('search_supplier_code', 'alpha'));
$search_account_customer_code = trim(GETPOST('search_account_customer_code', 'alpha'));
$search_account_supplier_code = trim(GETPOST('search_account_supplier_code', 'alpha'));
$search_address = trim(GETPOST('search_address', 'alpha'));
$search_town = trim(GETPOST("search_town", 'alpha'));
$search_zip = trim(GETPOST("search_zip", 'alpha'));
$search_state = trim(GETPOST("search_state", 'alpha'));
$search_region = trim(GETPOST("search_region", 'alpha'));
$search_email = trim(GETPOST('search_email', 'alpha'));
$search_phone = trim(GETPOST('search_phone', 'alpha'));
$search_fax = trim(GETPOST('search_fax', 'alpha'));
$search_url = trim(GETPOST('search_url', 'alpha'));
$search_idprof1 = trim(GETPOST('search_idprof1', 'alpha'));
$search_idprof2 = trim(GETPOST('search_idprof2', 'alpha'));
$search_idprof3 = trim(GETPOST('search_idprof3', 'alpha'));
$search_idprof4 = trim(GETPOST('search_idprof4', 'alpha'));
$search_idprof5 = trim(GETPOST('search_idprof5', 'alpha'));
$search_idprof6 = trim(GETPOST('search_idprof6', 'alpha'));
$search_vat = trim(GETPOST('search_vat', 'alpha'));
$search_sale = trim(GETPOST("search_sale", 'int'));
$search_categ_cus = trim(GETPOST("search_categ_cus", 'int'));
$search_categ_sup = trim(GETPOST("search_categ_sup", 'int'));
$search_country = GETPOST("search_country", 'intcomma');
$search_type_thirdparty = GETPOST("search_type_thirdparty", 'int');
$search_staff = GETPOST("search_staff", 'int');
$search_status = GETPOST("search_status", 'int');
$search_type = GETPOST('search_type', 'alpha');
$search_level = GETPOST("search_level", "array");
$search_stcomm = GETPOST('search_stcomm', 'int');
$search_import_key  = GETPOST("search_import_key", "alpha");
$search_parent_name = GETPOST('search_parent_name', 'alpha');

$type = GETPOST('type', 'alpha');
$optioncss = GETPOST('optioncss', 'alpha');
$mode = GETPOST("mode", 'alpha');
$place = GETPOST('place', 'aZ09') ? GETPOST('place', 'aZ09') : '0'; // $place is string id of table for Bar or Restaurant

$diroutputmassaction = $conf->societe->dir_output.'/temp/massgeneration/'.$user->id;

$limit = GETPOST('limit', 'int') ?GETPOST('limit', 'int') : $conf->liste_limit;
$sortfield = GETPOST("sortfield", 'alpha');
$sortorder = GETPOST("sortorder", 'alpha');
$page = GETPOSTISSET('pageplusone') ? (GETPOST('pageplusone') - 1) : GETPOST("page", 'int');
if (!$sortorder) $sortorder = "ASC";
if (!$sortfield) $sortfield = "s.nom";
if (empty($page) || $page < 0 || GETPOST('button_search', 'alpha') || GETPOST('button_removefilter', 'alpha')) { $page = 0; }     // If $page is not defined, or '' or -1 or if we click on clear filters or if we select empty mass action
$offset = $limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;

if ($type == 'c') { if (empty($contextpage) || $contextpage == 'thirdpartylist') $contextpage = 'customerlist'; if ($search_type == '') $search_type = '1,3'; }
if ($type == 'p') { if (empty($contextpage) || $contextpage == 'thirdpartylist') $contextpage = 'prospectlist'; if ($search_type == '') $search_type = '2,3'; }
if ($type == 't') { if (empty($contextpage) || $contextpage == 'poslist') $contextpage = 'poslist'; if ($search_type == '') $search_type = '1,2,3'; }
if ($type == 'f') { if (empty($contextpage) || $contextpage == 'thirdpartylist') $contextpage = 'supplierlist'; if ($search_type == '') $search_type = '4'; }

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$object = new Societe($db);
$hookmanager->initHooks(array('thirdpartylist'));
$extrafields = new ExtraFields($db);

// fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

$search_array_options = $extrafields->getOptionalsFromPost($object->table_element, '', 'search_');

// List of fields to search into when doing a "search in all"
$fieldstosearchall = array(
	's.nom'=>"ThirdPartyName",
	's.name_alias'=>"AliasNameShort",
	's.code_client'=>"CustomerCode",
	's.code_fournisseur'=>"SupplierCode",
	's.code_compta'=>"CustomerAccountancyCodeShort",
	's.code_compta_fournisseur'=>"SupplierAccountancyCodeShort",
	's.zip'=>"Zip",
	's.town'=>"Town",
	's.email'=>"EMail",
	's.url'=>"URL",
	's.tva_intra'=>"VATIntra",
	's.siren'=>"ProfId1",
	's.siret'=>"ProfId2",
	's.ape'=>"ProfId3",
	's.phone'=>"Phone",
	's.fax'=>"Fax",
);
if (($tmp = $langs->transnoentities("ProfId4".$mysoc->country_code)) && $tmp != "ProfId4".$mysoc->country_code && $tmp != '-') $fieldstosearchall['s.idprof4'] = 'ProfId4';
if (($tmp = $langs->transnoentities("ProfId5".$mysoc->country_code)) && $tmp != "ProfId5".$mysoc->country_code && $tmp != '-') $fieldstosearchall['s.idprof5'] = 'ProfId5';
if (($tmp = $langs->transnoentities("ProfId6".$mysoc->country_code)) && $tmp != "ProfId6".$mysoc->country_code && $tmp != '-') $fieldstosearchall['s.idprof6'] = 'ProfId6';
if (!empty($conf->barcode->enabled)) $fieldstosearchall['s.barcode'] = 'Gencod';
// Personalized search criterias. Example: $conf->global->THIRDPARTY_QUICKSEARCH_ON_FIELDS = 's.nom=ThirdPartyName;s.name_alias=AliasNameShort;s.code_client=CustomerCode'
if (!empty($conf->global->THIRDPARTY_QUICKSEARCH_ON_FIELDS)) $fieldstosearchall = dolExplodeIntoArray($conf->global->THIRDPARTY_QUICKSEARCH_ON_FIELDS);


// Define list of fields to show into list
$checkedcustomercode = (in_array($contextpage, array('thirdpartylist', 'customerlist', 'prospectlist', 'poslist')) ? 1 : 0);
$checkedsuppliercode = (in_array($contextpage, array('supplierlist')) ? 1 : 0);
$checkedcustomeraccountcode = (in_array($contextpage, array('customerlist')) ? 1 : 0);
$checkedsupplieraccountcode = (in_array($contextpage, array('supplierlist')) ? 1 : 0);
$checkedtypetiers = 1;
$checkedprofid1 = 0;
$checkedprofid2 = 0;
$checkedprofid3 = 0;
$checkedprofid4 = 0;
$checkedprofid5 = 0;
$checkedprofid6 = 0;
//$checkedprofid4=((($tmp = $langs->transnoentities("ProfId4".$mysoc->country_code)) && $tmp != "ProfId4".$mysoc->country_code && $tmp != '-') ? 1 : 0);
//$checkedprofid5=((($tmp = $langs->transnoentities("ProfId5".$mysoc->country_code)) && $tmp != "ProfId5".$mysoc->country_code && $tmp != '-') ? 1 : 0);
//$checkedprofid6=((($tmp = $langs->transnoentities("ProfId6".$mysoc->country_code)) && $tmp != "ProfId6".$mysoc->country_code && $tmp != '-') ? 1 : 0);
$checkprospectlevel = (in_array($contextpage, array('prospectlist')) ? 1 : 0);
$checkstcomm = (in_array($contextpage, array('prospectlist')) ? 1 : 0);
$arrayfields = array(
	's.rowid'=>array('label'=>"TechnicalID", 'position'=>1, 'checked'=>($conf->global->MAIN_SHOW_TECHNICAL_ID ? 1 : 0), 'enabled'=>($conf->global->MAIN_SHOW_TECHNICAL_ID ? 1 : 0)),
	's.nom'=>array('label'=>"ThirdPartyName", 'position'=>2, 'checked'=>1),
	's.name_alias'=>array('label'=>"AliasNameShort", 'position'=>3, 'checked'=>1),
	's.barcode'=>array('label'=>"Gencod", 'position'=>5, 'checked'=>1, 'enabled'=>(!empty($conf->barcode->enabled))),
	's.code_client'=>array('label'=>"CustomerCodeShort", 'position'=>10, 'checked'=>$checkedcustomercode),
	's.code_fournisseur'=>array('label'=>"SupplierCodeShort", 'position'=>11, 'checked'=>$checkedsuppliercode, 'enabled'=>(!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled) || !empty($conf->supplier_invoice->enabled))),
	's.code_compta'=>array('label'=>"CustomerAccountancyCodeShort", 'position'=>13, 'checked'=>$checkedcustomeraccountcode),
	's.code_compta_fournisseur'=>array('label'=>"SupplierAccountancyCodeShort", 'position'=>14, 'checked'=>$checkedsupplieraccountcode, 'enabled'=>(!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled) || !empty($conf->supplier_invoice->enabled))),
	's.address'=>array('label'=>"Address", 'position'=>19, 'checked'=>0),
	's.town'=>array('label'=>"Town", 'position'=>20, 'checked'=>0),
	's.zip'=>array('label'=>"Zip", 'position'=>21, 'checked'=>1),
	'state.nom'=>array('label'=>"State", 'position'=>22, 'checked'=>0),
	'region.nom'=>array('label'=>"Region", 'position'=>23, 'checked'=>0),
	'country.code_iso'=>array('label'=>"Country", 'position'=>24, 'checked'=>0),
	's.email'=>array('label'=>"Email", 'position'=>25, 'checked'=>0),
	's.url'=>array('label'=>"Url", 'position'=>26, 'checked'=>0),
	's.phone'=>array('label'=>"Phone", 'position'=>27, 'checked'=>1),
	's.fax'=>array('label'=>"Fax", 'position'=>28, 'checked'=>0),
	'typent.code'=>array('label'=>"ThirdPartyType", 'position'=>29, 'checked'=>$checkedtypetiers),
	'staff.code'=>array('label'=>"Staff", 'position'=>30, 'checked'=>0),
	's.siren'=>array('label'=>"ProfId1Short", 'position'=>40, 'checked'=>$checkedprofid1),
	's.siret'=>array('label'=>"ProfId2Short", 'position'=>41, 'checked'=>$checkedprofid2),
	's.ape'=>array('label'=>"ProfId3Short", 'position'=>42, 'checked'=>$checkedprofid3),
	's.idprof4'=>array('label'=>"ProfId4Short", 'position'=>43, 'checked'=>$checkedprofid4),
	's.idprof5'=>array('label'=>"ProfId5Short", 'position'=>44, 'checked'=>$checkedprofid5),
	's.idprof6'=>array('label'=>"ProfId6Short", 'position'=>45, 'checked'=>$checkedprofid6),
	's.tva_intra'=>array('label'=>"VATIntraShort", 'position'=>50, 'checked'=>0),
	'customerorsupplier'=>array('label'=>'NatureOfThirdParty', 'position'=>61, 'checked'=>1),
	's.fk_prospectlevel'=>array('label'=>"ProspectLevelShort", 'position'=>62, 'checked'=>$checkprospectlevel),
	's.fk_stcomm'=>array('label'=>"StatusProsp", 'position'=>63, 'checked'=>$checkstcomm),
	's2.nom'=>array('label'=>'ParentCompany', 'position'=>64, 'checked'=>0),
	's.datec'=>array('label'=>"DateCreation", 'checked'=>0, 'position'=>500),
	's.tms'=>array('label'=>"DateModificationShort", 'checked'=>0, 'position'=>500),
	's.status'=>array('label'=>"Status", 'checked'=>1, 'position'=>1000),
	's.import_key'=>array('label'=>"ImportId", 'checked'=>0, 'position'=>1100),
);
// Extra fields
include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_array_fields.tpl.php';

$object->fields = dol_sort_array($object->fields, 'position');
$arrayfields = dol_sort_array($arrayfields, 'position');

//echo '<pre>';print_r($arrayfields); exit;

/*
 * Actions
 */

if ($action == "change")	// Change customer for TakePOS
{
	$idcustomer = GETPOST('idcustomer', 'int');

	// Check if draft invoice already exists, if not create it
	$sql = "SELECT rowid FROM ".MAIN_DB_PREFIX."facture where ref='(PROV-POS".$_SESSION["takeposterminal"]."-".$place.")' AND entity IN (".getEntity('invoice').")";
	$result = $db->query($sql);
	$num_lines = $db->num_rows($result);
	if ($num_lines == 0)
	{
		require_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
		$invoice = new Facture($db);
		$constforthirdpartyid = 'CASHDESK_ID_THIRDPARTY'.$_SESSION["takeposterminal"];
		$invoice->socid = $conf->global->$constforthirdpartyid;
		$invoice->date = dol_now();
		$invoice->module_source = 'takepos';
		$invoice->pos_source = $_SESSION["takeposterminal"];
		$placeid = $invoice->create($user);
		$sql = "UPDATE ".MAIN_DB_PREFIX."facture set ref='(PROV-POS".$_SESSION["takeposterminal"]."-".$place.")' where rowid=".$placeid;
		$db->query($sql);
	}

	$sql = "UPDATE ".MAIN_DB_PREFIX."facture set fk_soc=".$idcustomer." where ref='(PROV-POS".$_SESSION["takeposterminal"]."-".$place.")'";
	$resql = $db->query($sql);
	?>
	    <script>
	    console.log("Reload page invoice.php with place=<?php print $place; ?>");
	    parent.$("#poslines").load("invoice.php?place=<?php print $place; ?>", function() {
	        //parent.$("#poslines").scrollTop(parent.$("#poslines")[0].scrollHeight);
			<?php if (!$resql) { ?>
				alert('Error failed to update customer on draft invoice.');
			<?php } ?>
	        parent.$.colorbox.close(); /* Close the popup */
	    });
	    </script>
    <?php
	exit;
}

if (GETPOST('cancel', 'alpha')) { $action = 'list'; $massaction = ''; }
if (!GETPOST('confirmmassaction', 'alpha') && $massaction != 'presend' && $massaction != 'confirm_presend') { $massaction = ''; }

$parameters = array();
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (empty($reshook))
{
	// Selection of new fields
	include DOL_DOCUMENT_ROOT.'/core/actions_changeselectedfields.inc.php';

	// Did we click on purge search criteria ?
	if (GETPOST('button_removefilter_x', 'alpha') || GETPOST('button_removefilter.x', 'alpha') || GETPOST('button_removefilter', 'alpha')) // All tests are required to be compatible with all browsers
	{
		$search_id = '';
		$search_nom = '';
		$search_alias = '';
		$search_categ_cus = 0;
		$search_categ_sup = 0;
		$search_sale = '';
		$search_barcode = "";
		$search_customer_code = '';
		$search_supplier_code = '';
		$search_account_customer_code = '';
		$search_account_supplier_code = '';
		$search_address = '';
		$search_town = "";
		$search_zip = "";
		$search_state = "";
		$search_country = '';
		$search_email = '';
		$search_phone = '';
		$search_fax = '';
		$search_url = '';
		$search_idprof1 = '';
		$search_idprof2 = '';
		$search_idprof3 = '';
		$search_idprof4 = '';
		$search_idprof5 = '';
		$search_idprof6 = '';
		$search_vat = '';
		$search_type = '';
		$search_type_thirdparty = '';
		$search_staff = '';
		$search_status = -1;
		$search_stcomm = '';
	 	$search_level = '';
	 	$search_parent_name = '';
	 	$search_import_key = '';
	 	$toselect = '';
		$search_array_options = array();
	}

	// Mass actions
	$objectclass = 'Societe';
	$objectlabel = 'ThirdParty';
	$permissiontoread = $user->rights->societe->lire;
	$permissiontodelete = $user->rights->societe->supprimer;
	$uploaddir = $conf->societe->dir_output;
	include DOL_DOCUMENT_ROOT.'/core/actions_massactions.inc.php';

	if ($action == 'setstcomm')
	{
		$object = new Client($db);
		$result = $object->fetch(GETPOST('stcommsocid'));
		$object->stcomm_id = dol_getIdFromCode($db, GETPOST('stcomm', 'alpha'), 'c_stcomm');
		$result = $object->update($object->id, $user);
		if ($result < 0) setEventMessages($object->error, $object->errors, 'errors');

		$action = '';
	}
}

if ($search_status == '') $search_status = 1; // always display active thirdparty first



/*
 * View
 */

/*
 REM: Rules on permissions to see thirdparties
 Internal or External user + No permission to see customers => See nothing
 Internal user socid=0 + Permission to see ALL customers    => See all thirdparties
 Internal user socid=0 + No permission to see ALL customers => See only thirdparties linked to user that are sale representative
 External user socid=x + Permission to see ALL customers    => Can see only himself
 External user socid=x + No permission to see ALL customers => Can see only himself
 */

$form = new Form($db);
$formother = new FormOther($db);
$companystatic = new Societe($db);
$companyparent = new Societe($db);
$formcompany = new FormCompany($db);
$prospectstatic = new Client($db);
$prospectstatic->client = 2;
$prospectstatic->loadCacheOfProspStatus();


$title = $langs->trans("ListOfThirdParties");
if ($type == 'c' && (empty($search_type) || ($search_type == '1,3'))) $title = $langs->trans("ListOfCustomers");
if ($type == 'p' && (empty($search_type) || ($search_type == '2,3'))) $title = $langs->trans("ListOfProspects");
if ($type == 'f' && (empty($search_type) || ($search_type == '4'))) $title = $langs->trans("ListOfSuppliers");

// Select every potentiels, and note each potentiels which fit in search parameters
$tab_level = array();
$sql = "SELECT code, label, sortorder";
$sql .= " FROM ".MAIN_DB_PREFIX."c_prospectlevel";
$sql .= " WHERE active > 0";
$sql .= " ORDER BY sortorder";
$resql = $db->query($sql);
if ($resql)
{
	while ($obj = $db->fetch_object($resql))
	{
		// Compute level text
		$level = $langs->trans($obj->code);
		if ($level == $obj->code) $level = $langs->trans($obj->label);
		$tab_level[$obj->code] = $level;
	}
} else dol_print_error($db);

require_once DOL_DOCUMENT_ROOT.'/core/lib/usergroups.lib.php';
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
$vendor_pincode = false;
if($user_group_id == '4'){
	$vendor_pincode = 't';
}
$sql = "SELECT s.rowid, s.nom as name, s.name_alias, s.barcode, s.address, s.town, s.zip, s.datec, s.code_client, s.code_fournisseur, s.logo,";
$sql .= " s.entity,";
$sql .= " st.libelle as stcomm, st.picto as stcomm_picto, s.fk_stcomm as stcomm_id, s.fk_prospectlevel, s.prefix_comm, s.client, s.fournisseur, s.canvas, s.status as status,";
$sql .= " s.email, s.phone, s.fax, s.url, s.siren as idprof1, s.siret as idprof2, s.ape as idprof3, s.idprof4 as idprof4, s.idprof5 as idprof5, s.idprof6 as idprof6, s.tva_intra, s.fk_pays,";
$sql .= " s.tms as date_update, s.datec as date_creation,";
$sql .= " s.code_compta, s.code_compta_fournisseur, s.parent as fk_parent,";
$sql .= " s2.nom as name2,";
$sql .= " typent.code as typent_code,";
$sql .= " staff.code as staff_code,";
$sql .= " country.code as country_code, country.label as country_label,";
$sql .= " state.code_departement as state_code, state.nom as state_name,";
$sql .= " region.code_region as region_code, region.nom as region_name";
// We'll need these fields in order to filter by sale (including the case where the user can only see his prospects)
if ($search_sale) $sql .= ", sc.fk_soc, sc.fk_user";
// We'll need these fields in order to filter by categ
if ($search_categ_cus) $sql .= ", cc.fk_categorie, cc.fk_soc";
if ($search_categ_sup) $sql .= ", cs.fk_categorie, cs.fk_soc";
// Add fields from extrafields
if (!empty($extrafields->attributes[$object->table_element]['label'])) {
	foreach ($extrafields->attributes[$object->table_element]['label'] as $key => $val) $sql .= ($extrafields->attributes[$object->table_element]['type'][$key] != 'separate' ? ", ef.".$key.' as options_'.$key : '');
}
// Add fields from hooks
$parameters = array();
$reshook = $hookmanager->executeHooks('printFieldListSelect', $parameters); // Note that $action and $object may have been modified by hook
$sql .= $hookmanager->resPrint;
$sql .= " FROM ".MAIN_DB_PREFIX."societe as s";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s2 ON s.parent = s2.rowid";
if (is_array($extrafields->attributes[$object->table_element]['label']) && count($extrafields->attributes[$object->table_element]['label'])) $sql .= " LEFT JOIN ".MAIN_DB_PREFIX.$object->table_element."_extrafields as ef on (s.rowid = ef.fk_object)";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_country as country on (country.rowid = s.fk_pays)";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_typent as typent on (typent.id = s.fk_typent)";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_effectif as staff on (staff.id = s.fk_effectif)";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_departements as state on (state.rowid = s.fk_departement)";
$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_regions as region on (region.	code_region = state.fk_region)";
// We'll need this table joined to the select in order to filter by categ
if (!empty($search_categ_cus)) $sql .= ' LEFT JOIN '.MAIN_DB_PREFIX."categorie_societe as cc ON s.rowid = cc.fk_soc"; // We'll need this table joined to the select in order to filter by categ
if (!empty($search_categ_sup)) $sql .= ' LEFT JOIN '.MAIN_DB_PREFIX."categorie_fournisseur as cs ON s.rowid = cs.fk_soc"; // We'll need this table joined to the select in order to filter by categ
$sql .= ' LEFT JOIN '.MAIN_DB_PREFIX."c_stcomm as st ON s.fk_stcomm = st.id";
// We'll need this table joined to the select in order to filter by sale
if ($search_sale == -2) $sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe_commerciaux as sc ON sc.fk_soc = s.rowid";
elseif ($search_sale || (!$user->rights->societe->client->voir && !$socid)) $sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
$sql .= " WHERE s.entity IN (".getEntity('societe').")";
if (!$user->rights->societe->client->voir && !$socid)	$sql .= " AND s.rowid = sc.fk_soc AND sc.fk_user = ".$user->id;
if($vendor_pincode){
	$sql .= " AND FIND_IN_SET(ef.fk_pincode, (select apply_zipcode from ".MAIN_DB_PREFIX."user_extrafields where fk_object = '".$user->id."')) ";
}
if ($search_sale && $search_sale != -2)    $sql .= " AND s.rowid = sc.fk_soc"; // Join for the needed table to filter by sale
if (!$user->rights->fournisseur->lire) $sql .= " AND (s.fournisseur <> 1 OR s.client <> 0)"; // client=0, fournisseur=0 must be visible
if ($search_sale == -2)    $sql .= " AND sc.fk_user IS NULL";
elseif ($search_sale)          $sql .= " AND sc.fk_user = ".$db->escape($search_sale);
if ($search_categ_cus > 0) $sql .= " AND cc.fk_categorie = ".$db->escape($search_categ_cus);
if ($search_categ_sup > 0) $sql .= " AND cs.fk_categorie = ".$db->escape($search_categ_sup);
if ($search_categ_cus == -2)   $sql .= " AND cc.fk_categorie IS NULL";
if ($search_categ_sup == -2)   $sql .= " AND cs.fk_categorie IS NULL";

if ($search_all)           $sql .= natural_search(array_keys($fieldstosearchall), $search_all);
if (strlen($search_cti))   $sql .= natural_search('s.phone', $search_cti);

if ($search_id > 0)        $sql .= natural_search("s.rowid", $search_id, 1);
if ($search_nom)           $sql .= natural_search("s.nom", $search_nom);
if ($search_alias)         $sql .= natural_search("s.name_alias", $search_alias);
if ($search_nom_only)      $sql .= natural_search("s.nom", $search_nom_only);
if ($search_customer_code) $sql .= natural_search("s.code_client", $search_customer_code);
if ($search_supplier_code) $sql .= natural_search("s.code_fournisseur", $search_supplier_code);
if ($search_account_customer_code) $sql .= natural_search("s.code_compta", $search_account_customer_code);
if ($search_account_supplier_code) $sql .= natural_search("s.code_compta_fournisseur", $search_account_supplier_code);
if ($search_address)	   $sql.= natural_search('s.address', $search_address);
if ($search_town)          $sql .= natural_search("s.town", $search_town);
if (strlen($search_zip))   $sql .= natural_search("s.zip", $search_zip);
if ($search_state)         $sql .= natural_search("state.nom", $search_state);
if ($search_region)        $sql .= natural_search("region.nom", $search_region);
if ($search_country && $search_country != '-1')       $sql .= " AND s.fk_pays IN (".$db->sanitize($db->escape($search_country)).')';
if ($search_email)         $sql .= natural_search("s.email", $search_email);
if (strlen($search_phone)) $sql .= natural_search("s.phone", $search_phone);
if (strlen($search_fax))   $sql .= natural_search("s.fax", $search_fax);
if ($search_url)           $sql .= natural_search("s.url", $search_url);
if (strlen($search_idprof1)) $sql .= natural_search("s.siren", $search_idprof1);
if (strlen($search_idprof2)) $sql .= natural_search("s.siret", $search_idprof2);
if (strlen($search_idprof3)) $sql .= natural_search("s.ape", $search_idprof3);
if (strlen($search_idprof4)) $sql .= natural_search("s.idprof4", $search_idprof4);
if (strlen($search_idprof5)) $sql .= natural_search("s.idprof5", $search_idprof5);
if (strlen($search_idprof6)) $sql .= natural_search("s.idprof6", $search_idprof6);
if (strlen($search_vat))     $sql .= natural_search("s.tva_intra", $search_vat);
// Filter on type of thirdparty
if ($search_type > 0 && in_array($search_type, array('1,3', '1,2,3', '2,3'))) $sql .= " AND s.client IN (".$db->sanitize($db->escape($search_type)).")";
if ($search_type > 0 && in_array($search_type, array('4')))         $sql .= " AND s.fournisseur = 1";
if ($search_type == '0') $sql .= " AND s.client = 0 AND s.fournisseur = 0";
if ($search_status != '' && $search_status >= 0) $sql .= natural_search("s.status", $search_status, 2);
if (!empty($conf->barcode->enabled) && $search_barcode) $sql .= natural_search("s.barcode", $search_barcode);
if ($search_type_thirdparty && $search_type_thirdparty != '-1') $sql .= natural_search("s.fk_typent", $search_type_thirdparty, 2);
if (!empty($search_staff) && $search_staff != '-1')            $sql .= natural_search("s.fk_effectif", $search_staff, 2);
if ($search_level)  $sql .= natural_search("s.fk_prospectlevel", join(',', $search_level), 3);
if ($search_parent_name)   $sql .= natural_search("s2.nom", $search_parent_name);
if ($search_stcomm != '' && $search_stcomm != -2) $sql .= natural_search("s.fk_stcomm", $search_stcomm, 2);
if ($search_import_key)    $sql .= natural_search("s.import_key", $search_import_key);
// Add where from extra fields
include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_search_sql.tpl.php';
// Add where from hooks
$parameters = array('socid' => $socid);
$reshook = $hookmanager->executeHooks('printFieldListWhere', $parameters); // Note that $action and $object may have been modified by hook
if (empty($reshook)) {
	if ($socid) $sql .= " AND s.rowid = ".$socid;
}
$sql .= $hookmanager->resPrint;

$sql .= $db->order($sortfield, $sortorder);

// Count total nb of records
$nbtotalofrecords = '';
if (empty($conf->global->MAIN_DISABLE_FULL_SCANLIST))
{
	$result = $db->query($sql);
	$nbtotalofrecords = $db->num_rows($result);
	if (($page * $limit) > $nbtotalofrecords)	// if total resultset is smaller then paging size (filtering), goto and load page 0
	{
		$page = 0;
		$offset = 0;
	}
}

$sql .= $db->plimit($limit + 1, $offset);

$resql = $db->query($sql);
if (!$resql)
{
	dol_print_error($db);
	exit;
}

$num = $db->num_rows($resql);

$arrayofselected = is_array($toselect) ? $toselect : array();

if ($num == 1 && !empty($conf->global->MAIN_SEARCH_DIRECT_OPEN_IF_ONLY_ONE) && ($search_all != '' || $search_cti != '') && $action != 'list') {
	$obj = $db->fetch_object($resql);
	$id = $obj->rowid;
	if (!empty($conf->global->SOCIETE_ON_SEARCH_AND_LIST_GO_ON_CUSTOMER_OR_SUPPLIER_CARD)) {
		if ($obj->client > 0) {
			header("Location: ".DOL_URL_ROOT.'/comm/card.php?socid='.$id);
			exit;
		}
		if ($obj->fournisseur > 0) {
			header("Location: ".DOL_URL_ROOT.'/fourn/card.php?socid='.$id);
			exit;
		}
	}

	header("Location: ".DOL_URL_ROOT.'/societe/card.php?socid='.$id);
	exit;
}

$help_url = 'EN:Module_Third_Parties|FR:Module_Tiers|ES:Empresas';
llxHeaderLayout('', $langs->trans("ThirdParty"), $langs->trans("ThirdParty"), $help_url);

$param = '';
if (!empty($contextpage) && $contextpage != $_SERVER["PHP_SELF"]) $param .= '&contextpage='.urlencode($contextpage);
if ($limit > 0 && $limit != $conf->liste_limit) $param .= '&limit='.urlencode($limit);
if ($search_all != '')     $param = "&sall=".urlencode($search_all);
if ($search_categ_cus > 0) $param .= '&search_categ_cus='.urlencode($search_categ_cus);
if ($search_categ_sup > 0) $param .= '&search_categ_sup='.urlencode($search_categ_sup);
if ($search_sale > 0)	   $param .= '&search_sale='.urlencode($search_sale);
if ($search_id > 0)        $param .= "&search_id=".urlencode($search_id);
if ($search_nom != '')     $param .= "&search_nom=".urlencode($search_nom);
if ($search_alias != '')   $param .= "&search_alias=".urlencode($search_alias);
if ($search_address != '') $param .= '&search_address=' . urlencode($search_address);
if ($search_town != '')    $param .= "&search_town=".urlencode($search_town);
if ($search_zip != '')     $param .= "&search_zip=".urlencode($search_zip);
if ($search_phone != '')   $param .= "&search_phone=".urlencode($search_phone);
if ($search_fax != '')     $param .= "&search_fax=".urlencode($search_fax);
if ($search_email != '')   $param .= "&search_email=".urlencode($search_email);
if ($search_url != '')     $param .= "&search_url=".urlencode($search_url);
if ($search_state != '')   $param .= "&search_state=".urlencode($search_state);
if ($search_country != '') $param .= "&search_country=".urlencode($search_country);
if ($search_customer_code != '') $param .= "&search_customer_code=".urlencode($search_customer_code);
if ($search_supplier_code != '') $param .= "&search_supplier_code=".urlencode($search_supplier_code);
if ($search_account_customer_code != '') $param .= "&search_account_customer_code=".urlencode($search_account_customer_code);
if ($search_account_supplier_code != '') $param .= "&search_account_supplier_code=".urlencode($search_account_supplier_code);
if ($search_barcode != '') $param .= "&search_barcode=".urlencode($search_barcode);
if ($search_idprof1 != '') $param .= '&search_idprof1='.urlencode($search_idprof1);
if ($search_idprof2 != '') $param .= '&search_idprof2='.urlencode($search_idprof2);
if ($search_idprof3 != '') $param .= '&search_idprof3='.urlencode($search_idprof3);
if ($search_idprof4 != '') $param .= '&search_idprof4='.urlencode($search_idprof4);
if ($search_idprof5 != '') $param .= '&search_idprof5='.urlencode($search_idprof5);
if ($search_idprof6 != '') $param .= '&search_idprof6='.urlencode($search_idprof6);
if ($search_vat != '')     $param .= '&search_vat='.urlencode($search_vat);
if ($search_type_thirdparty != '')    $param .= '&search_type_thirdparty='.urlencode($search_type_thirdparty);
if ($search_type != '')    $param .= '&search_type='.urlencode($search_type);
if (is_array($search_level) && count($search_level)) foreach ($search_level as $slevel) $param .= '&search_level[]='.urlencode($slevel);
if ($search_status != '')  $param .= '&search_status='.urlencode($search_status);
if ($search_stcomm != '')  $param .= '&search_stcomm='.urlencode($search_stcomm);
if ($search_parent_name != '') $param .= '&search_parent_name='.urlencode($search_parent_name);
if ($search_import_key != '') $param .= '&search_import_key='.urlencode($search_import_key);
if ($type != '') $param .= '&type='.urlencode($type);
if ($optioncss != '')      $param .= '&optioncss='.urlencode($optioncss);
// Add $param from extra fields
//include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_search_param.tpl.php';

// Show delete result message
if (GETPOST('delsoc'))
{
	setEventMessages($langs->trans("CompanyDeleted", GETPOST('delsoc')), null, 'mesgs');
}

// List of mass actions available
$arrayofmassactions = array(
	'presend'=>$langs->trans("SendByMail"),
//    'builddoc'=>$langs->trans("PDFMerge"),
);
//if($user->rights->societe->creer) $arrayofmassactions['createbills']=$langs->trans("CreateInvoiceForThisCustomer");
if ($user->rights->societe->supprimer) $arrayofmassactions['predelete'] = '<span class="fa fa-trash paddingrightonly"></span>'.$langs->trans("Delete");
if (GETPOST('nomassaction', 'int') || in_array($massaction, array('presend', 'predelete'))) $arrayofmassactions = array();
$massactionbutton = $form->selectMassActionLayout('', $arrayofmassactions);


$typefilter = '';
$label = 'MenuNewThirdParty';

if (!empty($type))
{
	$typefilter = '&amp;type='.$type;
	if ($type == 'p') $label = 'MenuNewProspect';
	if ($type == 'c') $label = 'MenuNewCustomer';
	if ($type == 'f') $label = 'NewSupplier';
}

if ($contextpage == 'poslist' && $type == 't' && (!empty($conf->global->PRODUIT_MULTIPRICES) || !empty($conf->global->PRODUIT_CUSTOMER_PRICES) || !empty($conf->global->PRODUIT_CUSTOMER_PRICES_BY_QTY_MULTIPRICES))) {
	print get_htmloutput_mesg(img_warning('default').' '.$langs->trans("BecarefullChangeThirdpartyBeforeAddProductToInvoice"), '', 'warning', 1);
}

// Show the new button only when this page is not opend from the Extended POS (pop-up window)
// but allow it too, when a user has the rights to create a new customer
if ($contextpage != 'poslist') {
	$url = DOL_URL_ROOT.'/societe/card.php?action=create'.$typefilter;
	if (!empty($socid)) $url .= '&socid='.$socid;
	$newcardbutton = dolGetButtonTitleLayout($langs->trans($label), '', 'fa fa-plus-circle', $url, '', $user->rights->societe->creer);
} elseif ($user->rights->societe->creer) {
	$url = DOL_URL_ROOT.'/societe/card.php?action=create&type=t&contextpage=poslist&optioncss=print&backtopage='.urlencode($_SERVER["PHP_SELF"].'?type=t&contextpage=poslist&nomassaction=1&optioncss=print&place='.$place);
	$label = 'MenuNewCustomer';
	$newcardbutton .= dolGetButtonTitleLayout($langs->trans($label), '', 'fa fa-plus-circle', $url);
}

$totalnboflines = abs((int) $nbtotalofrecords);

print '<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Card-->
								<div class="card card-custom">
									<div class="card-header py-3">
										<div class="card-title">
											<span class="card-icon">
												<i class="flaticon2-shopping-cart text-primary"></i>
											</span>
											<h3 class="card-label">'.$title .'('.$totalnboflines.')</h3>
										</div>
									</div>

									<div class="card-body">'."\n";

											print '								<form class="form" method="POST" action="'.$_SERVER["PHP_SELF"].'" name="formfilter" autocomplete="off">';
											if ($optioncss != '') print '<input type="hidden" name="optioncss" value="'.$optioncss.'">';
											print '<input type="hidden" name="token" value="'.newToken().'">';
											print '<input type="hidden" name="formfilteraction" id="formfilteraction" value="list">';
											print '<input type="hidden" name="sortfield" value="'.$sortfield.'">';
											print '<input type="hidden" name="sortorder" value="'.$sortorder.'">';
											//print '<input type="hidden" name="page" value="'.$page.'">';
											print '<input type="hidden" name="contextpage" value="'.$contextpage.'">';

										print '
										<!--begin: Search Form-->
										<div class="card card-custom card-collapsed" data-card="true" id="kt_card_4">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Filters</h3>
												</div>
												<div class="card-toolbar">
													<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
														<i class="ki ki-arrow-down icon-nm"></i>
													</a>
												</div>
											</div>

											<div class="card-body">
												<div class="row mb-6">
													<div class="col-lg-12 text-right mb-lg-0 mb-6">
														'.$newcardbutton.'
													</div>
												</div>
												<div class="row mb-6">
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Customer Name:</label>
															<input type="text" name="search_nom" class="form-control datatable-input" placeholder="Customer Name" data-col-index="0" />
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Alias Name:</label>
															<input type="text" name="search_alias" class="form-control datatable-input" placeholder="Customer Alias" data-col-index="1" />
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Customer Code:</label>
															<input type="text" name="search_customer_code" class="form-control datatable-input" placeholder="Customer Code" data-col-index="1" />
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Zip Code:</label>
															<input type="text" name="search_zip" class="form-control datatable-input" placeholder="Zip Code" data-col-index="4" />
														</div>
													</div>
													<div class="row mb-8">
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Customer Type:</label>
															<select class="form-control datatable-input" name="search_type_thirdparty" data-col-index="6">
																';
																$thirdParty = $formcompany->typent_array(0);
																foreach($thirdParty as $third_id => $third_name)
																{
																	print '<option value="'.$third_id.'">'.$third_name.'</option>';
																}
															print '</select>
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Phone:</label>
															<input type="text" name="search_phone" class="form-control datatable-input" placeholder="Phone" data-col-index="4" />
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Area Pincode:</label>
															<input type="text" name="search_options_fk_pincode" class="form-control datatable-input" placeholder="Area Pincode" data-col-index="4" />
														</div>
														<div class="col-lg-3 mb-lg-0 mb-6">
															<label>Status:</label>
															<select class="form-control datatable-input" name="search_status" data-col-index="6">
																<option value="">Select</option>
																<option value="0">'.$langs->trans('ActivityCeased').'</option>
																<option value="1">'.$langs->trans('InActivity').'</option>
																<option value="2">'.$langs->trans('Pending').'</option>
															</select>
														</div>
													</div>
													<div class="row mt-8">
														<div class="col-lg-12">
														<button class="btn btn-primary btn-primary--icon" id="kt_search">
															<span>
																<i class="la la-search"></i>
																<span>Search</span>
															</span>
														</button>&#160;&#160; 
														<button class="btn btn-secondary btn-secondary--icon button_removefilter" name="button_removefilter_x" value="x" id="kt_reset">
															<span>
																<i class="la la-close"></i>
																<span>Reset</span>
															</span>
														</button></div>
													</div>
												</div>
										</div>';

										$picto = '';

										print_barre_liste_layout($title, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, $massactionbutton, $num, $nbtotalofrecords, $picto, 0, '', '', $limit, 0, 0, 1);

										$topicmail = "Information";
										$modelmail = "thirdparty";
										$objecttmp = new Societe($db);
										$trackid = 'thi'.$object->id;
										include DOL_DOCUMENT_ROOT.'/core/tpl/massactions_pre.tpl.php';


										print '<div class="clearfix"></div>';

										print '<!--begin: Datatable-->
										<table class="table table-bordered table-checkable gutter-t" id="kt_datatable1">
											<thead>
												<tr>'."\n";
										if (!empty($arrayfields['s.rowid']['checked']))                   print_liste_field_titre_layout($arrayfields['s.rowid']['label'], $_SERVER["PHP_SELF"], "s.rowid", "", $param, "", $sortfield, $sortorder)."\n\n";
										if (!empty($arrayfields['s.nom']['checked']))                     print_liste_field_titre_layout($arrayfields['s.nom']['label'], $_SERVER["PHP_SELF"], "s.nom", "", $param, "", $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.name_alias']['checked']))              print_liste_field_titre_layout($arrayfields['s.name_alias']['label'], $_SERVER["PHP_SELF"], "s.name_alias", "", $param, "", $sortfield, $sortorder)."\n";
										//if (!empty($arrayfields['s.barcode']['checked']))                 print_liste_field_titre_layout($arrayfields['s.barcode']['label'], $_SERVER["PHP_SELF"], "s.barcode", $param, '', '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.code_client']['checked']))             print_liste_field_titre_layout($arrayfields['s.code_client']['label'], $_SERVER["PHP_SELF"], "s.code_client", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.code_fournisseur']['checked']))        print_liste_field_titre_layout($arrayfields['s.code_fournisseur']['label'], $_SERVER["PHP_SELF"], "s.code_fournisseur", "", $param, '', $sortfield, $sortorder)."\n";
										//if (!empty($arrayfields['s.code_compta']['checked']))             print_liste_field_titre_layout($arrayfields['s.code_compta']['label'], $_SERVER["PHP_SELF"], "s.code_compta", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.code_compta_fournisseur']['checked'])) print_liste_field_titre_layout($arrayfields['s.code_compta_fournisseur']['label'], $_SERVER["PHP_SELF"], "s.code_compta_fournisseur", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.address']['checked']))		 print_liste_field_titre_layout($arrayfields['s.address']['label'], $_SERVER['PHP_SELF'], 's.address', '', $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.town']['checked']))           print_liste_field_titre_layout($arrayfields['s.town']['label'], $_SERVER["PHP_SELF"], "s.town", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.zip']['checked']))            print_liste_field_titre_layout($arrayfields['s.zip']['label'], $_SERVER["PHP_SELF"], "s.zip", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['state.nom']['checked']))        print_liste_field_titre_layout($arrayfields['state.nom']['label'], $_SERVER["PHP_SELF"], "state.nom", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['region.nom']['checked']))       print_liste_field_titre_layout($arrayfields['region.nom']['label'], $_SERVER["PHP_SELF"], "region.nom", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['country.code_iso']['checked'])) print_liste_field_titre_layout($arrayfields['country.code_iso']['label'], $_SERVER["PHP_SELF"], "country.code_iso", "", $param, '', $sortfield, $sortorder, 'center ');
										if (!empty($arrayfields['typent.code']['checked']))      print_liste_field_titre_layout($arrayfields['typent.code']['label'], $_SERVER["PHP_SELF"], "typent.code", "", $param, '', $sortfield, $sortorder, 'center ');
										if (!empty($arrayfields['staff.code']['checked']))       print_liste_field_titre_layout($arrayfields['staff.code']['label'], $_SERVER["PHP_SELF"], "staff.code", "", $param, '', $sortfield, $sortorder, 'center ');
										if (!empty($arrayfields['s.email']['checked']))          print_liste_field_titre_layout($arrayfields['s.email']['label'], $_SERVER["PHP_SELF"], "s.email", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.phone']['checked']))          print_liste_field_titre_layout($arrayfields['s.phone']['label'], $_SERVER["PHP_SELF"], "s.phone", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.fax']['checked'])) print_liste_field_titre_layout($arrayfields['s.fax']['label'], $_SERVER["PHP_SELF"], "s.fax", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.url']['checked']))            print_liste_field_titre_layout($arrayfields['s.url']['label'], $_SERVER["PHP_SELF"], "s.url", "", $param, '', $sortfield, $sortorder)."\n";
										if (!empty($arrayfields['s.siren']['checked']))          print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId1Short"), $textprofid[1], 1, 0), $_SERVER["PHP_SELF"], "s.siren", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.siret']['checked']))          print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId2Short"), $textprofid[2], 1, 0), $_SERVER["PHP_SELF"], "s.siret", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.ape']['checked']))            print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId3Short"), $textprofid[3], 1, 0), $_SERVER["PHP_SELF"], "s.ape", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.idprof4']['checked']))        print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId4Short"), $textprofid[4], 1, 0), $_SERVER["PHP_SELF"], "s.idprof4", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.idprof5']['checked']))        print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId5Short"), $textprofid[4], 1, 0), $_SERVER["PHP_SELF"], "s.idprof5", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.idprof6']['checked']))        print_liste_field_titre_layout($form->textwithpicto($langs->trans("ProfId6Short"), $textprofid[4], 1, 0), $_SERVER["PHP_SELF"], "s.idprof6", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.tva_intra']['checked']))      print_liste_field_titre_layout($arrayfields['s.tva_intra']['label'], $_SERVER["PHP_SELF"], "s.tva_intra", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										//if (!empty($arrayfields['customerorsupplier']['checked']))        print_liste_field_titre_layout('Type')."\n"; // type of customer
										if (!empty($arrayfields['s.fk_prospectlevel']['checked']))        print_liste_field_titre_layout($arrayfields['s.fk_prospectlevel']['label'], $_SERVER["PHP_SELF"], "s.fk_prospectlevel", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s.fk_stcomm']['checked']))               print_liste_field_titre_layout($arrayfields['s.fk_stcomm']['label'], $_SERVER["PHP_SELF"], "s.fk_stcomm", "", $param, '', $sortfield, $sortorder, ' ')."\n";
										if (!empty($arrayfields['s2.nom']['checked']))           print_liste_field_titre_layout($arrayfields['s2.nom']['label'], $_SERVER["PHP_SELF"], "s2.nom", "", $param, '', $sortfield, $sortorder, ' ')."\n";

										include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_search_title.tpl.php';
										$varpage = empty($contextpage) ? $_SERVER["PHP_SELF"] : $contextpage;
										$selectedfields = $form->multiSelectArrayWithCheckboxLayout('selectedfields', $arrayfields, $varpage); 
										if ($massactionbutton && $contextpage != 'poslist') $selectedfields .= $form->showCheckAddButtonsLayout('checkforselect', 1);

										// Hook fields
										$parameters = array('arrayfields'=>$arrayfields, 'param'=>$param, 'sortfield'=>$sortfield, 'sortorder'=>$sortorder);
										$reshook = $hookmanager->executeHooks('printFieldListTitle', $parameters); // Note that $action and $object may have been modified by hook
										//print $hookmanager->resPrint;
										if (!empty($arrayfields['s.datec']['checked']))      print_liste_field_titre_layout($arrayfields['s.datec']['label'], $_SERVER["PHP_SELF"], "s.datec", "", $param, '', $sortfield, $sortorder, ' ');
										if (!empty($arrayfields['s.tms']['checked']))        print_liste_field_titre_layout($arrayfields['s.tms']['label'], $_SERVER["PHP_SELF"], "s.tms", "", $param, '', $sortfield, $sortorder, '  ');
										if (!empty($arrayfields['s.status']['checked']))     print_liste_field_titre_layout($arrayfields['s.status']['label'], $_SERVER["PHP_SELF"], "s.status", "", $param, '', $sortfield, $sortorder, ' ');
										if (!empty($arrayfields['s.import_key']['checked'])) print_liste_field_titre_layout($arrayfields['s.import_key']['label'], $_SERVER["PHP_SELF"], "s.import_key", "", $param, '', $sortfield, $sortorder, ' ');
										print_liste_field_titre_layout($selectedfields, $_SERVER["PHP_SELF"], "", '', '', '', $sortfield, $sortorder, ' ');
													
												print '</tr>
											</thead>
											<tbody>';

											$i = 0;
											$totalarray = array();
											while ($i < min($num, $limit))
											{
												$obj = $db->fetch_object($resql);

												$companystatic->id = $obj->rowid;
												$companystatic->name = $obj->name;
												$companystatic->name_alias = $obj->name_alias;
												$companystatic->logo = $obj->logo;
												$companystatic->canvas = $obj->canvas;
												$companystatic->client = $obj->client;
												$companystatic->status = $obj->status;
												$companystatic->email = $obj->email;
												$companystatic->fournisseur = $obj->fournisseur;
												$companystatic->code_client = $obj->code_client;
												$companystatic->code_fournisseur = $obj->code_fournisseur;
												$companystatic->tva_intra = $obj->tva_intra;
												$companystatic->country_code = $obj->country_code;

												$companystatic->code_compta_client = $obj->code_compta;
												$companystatic->code_compta_fournisseur = $obj->code_compta_fournisseur;

											   	$companystatic->fk_prospectlevel = $obj->fk_prospectlevel;
											   	$companystatic->fk_parent = $obj->fk_parent;
												$companystatic->entity = $obj->entity;

												print '<tr class=""';
												if ($contextpage == 'poslist')
												{
													print ' onclick="location.href=\'list.php?action=change&contextpage=poslist&idcustomer='.$obj->rowid.'&place='.urlencode($place).'\'"';
												}
												print '>';
												if (!empty($arrayfields['s.rowid']['checked']))
												{
													print '<td class="tdoverflowmax50">';
													print $obj->rowid;
													print "</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.nom']['checked']))
												{
													$savalias = $obj->name_alias;
													if (!empty($arrayfields['s.name_alias']['checked'])) $companystatic->name_alias = '';
													print '<td'.(empty($conf->global->MAIN_SOCIETE_SHOW_COMPLETE_NAME) ? ' class=""' : '').'>';
													if ($contextpage == 'poslist')
													{
														print $obj->name;
													} else {
														print $companystatic->getNomUrl(1, '', 100, 0, 1);
													}
													print "</td>\n";
													$companystatic->name_alias = $savalias;
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.name_alias']['checked']))
												{
													print '<td class="">';
													print $companystatic->name_alias;
													print "</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// Barcode
												if (!empty($arrayfields['s.barcode']['checked']))
												{
													//print '<td>'.$obj->barcode.'</td>';
													//if (!$i) $totalarray['nbfield']++;
												}
												// Customer code
												if (!empty($arrayfields['s.code_client']['checked']))
												{
													print '<td class="onall">'.$obj->code_client.'</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Supplier code
												if (!empty($arrayfields['s.code_fournisseur']['checked']))
												{
													print '<td class="onall">'.$obj->code_fournisseur.'</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Account customer code
												if (!empty($arrayfields['s.code_compta']['checked']))
												{
													//print '<td>'.$obj->code_compta.'</td>';
													//if (!$i) $totalarray['nbfield']++;
												}
												// Account supplier code
												if (!empty($arrayfields['s.code_compta_fournisseur']['checked']))
												{
													print '<td>'.$obj->code_compta_fournisseur.'</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Address
												if (!empty($arrayfields['s.address']['checked']))
												{
													print '<td>'.$obj->address.'</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Town
												if (!empty($arrayfields['s.town']['checked']))
												{
													print "<td>".$obj->town."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// Zip
												if (!empty($arrayfields['s.zip']['checked']))
												{
													print "<td>".$obj->zip."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// State
												if (!empty($arrayfields['state.nom']['checked']))
												{
													print "<td>".$obj->state_name."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// Region
												if (!empty($arrayfields['region.nom']['checked']))
												{
													print "<td>".$obj->region_name."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// Country
												if (!empty($arrayfields['country.code_iso']['checked']))
												{
													print '<td class="">';
													$labelcountry = ($obj->country_code && ($langs->trans("Country".$obj->country_code) != "Country".$obj->country_code)) ? $langs->trans("Country".$obj->country_code) : $obj->country_label;
													print $labelcountry;
													print '</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Type ent
												if (!empty($arrayfields['typent.code']['checked']))
												{
													print '<td class="">';
													if (!is_array($typenArray) || count($typenArray) == 0) $typenArray = $formcompany->typent_array(1);
													print $typenArray[$obj->typent_code];
													print '</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Staff
												if (!empty($arrayfields['staff.code']['checked']))
												{
													print '<td class="">';
													if (!is_array($staffArray) || count($staffArray) == 0) $staffArray = $formcompany->effectif_array(1);
													print $staffArray[$obj->staff_code];
													print '</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.email']['checked']))
												{
													print '<td class="tdoverflowmax150">'.dol_print_email($obj->email, $obj->rowid, $obj->socid, 'AC_EMAIL', 0, 0, 1)."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.phone']['checked']))
												{
													print "<td>".dol_print_phone($obj->phone, $obj->country_code, 0, $obj->rowid, 'AC_TEL')."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.fax']['checked']))
												{
													print "<td>".dol_print_phone($obj->fax, $obj->country_code, 0, $obj->rowid, 'AC_TEL')."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.url']['checked']))
												{
													print "<td>".$obj->url."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.siren']['checked']))
												{
													print "<td>".$obj->idprof1."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.siret']['checked']))
												{
													print "<td>".$obj->idprof2."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.ape']['checked']))
												{
													print "<td>".$obj->idprof3."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.idprof4']['checked']))
												{
													print "<td>".$obj->idprof4."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.idprof5']['checked']))
												{
													print "<td>".$obj->idprof5."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.idprof6']['checked']))
												{
													print "<td>".$obj->idprof6."</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// VAT
												if (!empty($arrayfields['s.tva_intra']['checked']))
												{
													print "<td>";
													print $obj->tva_intra;
													if ($obj->tva_intra && !isValidVATID($companystatic))
													{
														print img_warning("BadVATNumber", '', '');
													}
													print "</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}
												// Type
												if (!empty($arrayfields['customerorsupplier']['checked']))
												{
													//print '<td class="">';
													$s = '';
													if (($obj->client == 2 || $obj->client == 3) && empty($conf->global->SOCIETE_DISABLE_PROSPECTS))
													{
														$s .= '<a class="customer-back opacitymedium" title="'.$langs->trans("Prospect").'" href="'.DOL_URL_ROOT.'/comm/card.php?socid='.$companystatic->id.'">'.dol_substr($langs->trans("Prospect"), 0, 1).'</a>';
													}
													if (($obj->client == 1 || $obj->client == 3) && empty($conf->global->SOCIETE_DISABLE_CUSTOMERS))
													{
														$s .= '<a class="customer-back" title="'.$langs->trans("Customer").'" href="'.DOL_URL_ROOT.'/comm/card.php?socid='.$companystatic->id.'">'.dol_substr($langs->trans("Customer"), 0, 1).'</a>';
													}
													if ((!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled) || !empty($conf->supplier_invoice->enabled)) && $obj->fournisseur)
													{
														$s .= '<a class="vendor-back" title="'.$langs->trans("Supplier").'" href="'.DOL_URL_ROOT.'/fourn/card.php?socid='.$companystatic->id.'">'.dol_substr($langs->trans("Supplier"), 0, 1).'</a>';
													}
													//print $s;
													//print '</td>';
													//if (!$i) $totalarray['nbfield']++;
												}

												if (!empty($arrayfields['s.fk_prospectlevel']['checked']))
												{
													// Prospect level
													print '<td class="">';
													print $companystatic->getLibProspLevel();
													print "</td>";
													if (!$i) $totalarray['nbfield']++;
												}

												if (!empty($arrayfields['s.fk_stcomm']['checked']))
												{
													// Prospect status
													print '<td class="center "><div class="">';
													print '<div class="inline-block">'.$companystatic->LibProspCommStatut($obj->stcomm_id, 2, $prospectstatic->cacheprospectstatus[$obj->stcomm_id]['label'], $obj->stcomm_picto);
													print '</div> - <div class="inline-block">';
													foreach ($prospectstatic->cacheprospectstatus as $key => $val)
													{
														$titlealt = 'default';
														if (!empty($val['code']) && !in_array($val['code'], array('ST_NO', 'ST_NEVER', 'ST_TODO', 'ST_PEND', 'ST_DONE'))) $titlealt = $val['label'];
														if ($obj->stcomm_id != $val['id']) print '<a class="pictosubstatus" href="'.$_SERVER["PHP_SELF"].'?stcommsocid='.$obj->rowid.'&stcomm='.$val['code'].'&action=setstcomm&token='.newToken().$param.($page ? '&page='.urlencode($page) : '').'">'.img_action($titlealt, $val['code'], $val['picto']).'</a>';
													}
													print '</div></div></td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Parent company
												if (!empty($arrayfields['s2.nom']['checked']))
												{
													print '<td class="">';
													if ($companystatic->fk_parent > 0)
													{
														$companyparent->fetch($companystatic->fk_parent);
														print $companyparent->getNomUrl(1);
													}
													print "</td>";
													if (!$i) $totalarray['nbfield']++;
												}
												// Extra fields
												include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_print_fields.tpl.php';
												// Fields from hook
												$parameters = array('arrayfields'=>$arrayfields, 'obj'=>$obj, 'i'=>$i, 'totalarray'=>&$totalarray);
												$reshook = $hookmanager->executeHooks('printFieldListValue', $parameters); // Note that $action and $object may have been modified by hook
												//print $hookmanager->resPrint;
												// Date creation
												if (!empty($arrayfields['s.datec']['checked']))
												{
													print '<td class="center ">';
													print dol_print_date($db->jdate($obj->date_creation), 'dayhour', 'tzuser');
													print '</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Date modification
												if (!empty($arrayfields['s.tms']['checked']))
												{
													print '<td class="center ">';
													print dol_print_date($db->jdate($obj->date_update), 'dayhour', 'tzuser');
													print '</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												// Status
												if (!empty($arrayfields['s.status']['checked']))
												{
													print '<td class="center ">'.$companystatic->getLibStatut(5).'</td>';
													if (!$i) $totalarray['nbfield']++;
												}
												if (!empty($arrayfields['s.import_key']['checked']))
												{
													print '<td class="tdoverflowmax100">';
													print $obj->import_key;
													print "</td>\n";
													if (!$i) $totalarray['nbfield']++;
												}

												// Action column (Show the massaction button only when this page is not opend from the Extended POS)
												print '<td class="">';
												if (($massactionbutton || $massaction) && $contextpage != 'poslist')   // If we are in select mode (massactionbutton defined) or if we have already selected and sent an action ($massaction) defined
												{
													$selected = 0;
													if (in_array($obj->rowid, $arrayofselected)) $selected = 1;
													print '<input id="cb'.$obj->rowid.'" class="flat checkforselect" type="checkbox" name="toselect[]" value="'.$obj->rowid.'"'.($selected ? ' checked="checked"' : '').'>';
												}
												print '</td>';
												if (!$i) $totalarray['nbfield']++;

												print '</tr>'."\n";
												$i++;
											}
													
												print '
											</tbody>
										</table>
										<!--end: Datatable-->';

										

									print '</form>
									</div>
								</div>';



//print_barre_liste($title, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, $massactionbutton, $num, $nbtotalofrecords, 'building', 0, $newcardbutton, '', $limit, 0, 0, 1);

$langs->load("other");
$textprofid = array();
foreach (array(1, 2, 3, 4, 5, 6) as $key)
{
	$label = $langs->transnoentities("ProfId".$key.$mysoc->country_code);
	$textprofid[$key] = '';
	if ($label != "ProfId".$key.$mysoc->country_code)
	{	// Get only text between ()
		if (preg_match('/\((.*)\)/i', $label, $reg)) $label = $reg[1];
		$textprofid[$key] = $langs->trans("ProfIdShortDesc", $key, $mysoc->country_code, $label);
	}
}



if ($search_all)
{
	foreach ($fieldstosearchall as $key => $val) $fieldstosearchall[$key] = $langs->trans($val);
	//print '<div class="divsearchfieldfilter">'.$langs->trans("FilterOnInto", $search_all).join(', ', $fieldstosearchall).'</div>';
}

// Filter on categories
$moreforfilter = '';
if (empty($type) || $type == 'c' || $type == 'p')
{
	if (!empty($conf->categorie->enabled) && $user->rights->categorie->lire)
	{
		require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
		$moreforfilter .= '<div class="divsearchfield">';
	 	$moreforfilter .= $langs->trans('CustomersProspectsCategoriesShort').': ';
		$moreforfilter .= $formother->select_categories('customer', $search_categ_cus, 'search_categ_cus', 1, $langs->trans('CustomersProspectsCategoriesShort'));
	 	$moreforfilter .= '</div>';
	}
}
if (empty($type) || $type == 'f')
{
	if (!empty($conf->categorie->enabled) && $user->rights->categorie->lire)
	{
		require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
		$moreforfilter .= '<div class="divsearchfield">';
		$moreforfilter .= $langs->trans('SuppliersCategoriesShort').': ';
		$moreforfilter .= $formother->select_categories('supplier', $search_categ_sup, 'search_categ_sup', 1);
		$moreforfilter .= '</div>';
	}
}

// If the user can view prospects other than his'
if ($user->rights->societe->client->voir || $socid)
{
 	$moreforfilter .= '<div class="divsearchfield">';
 	$moreforfilter .= $langs->trans('SalesRepresentatives').': ';
	$moreforfilter .= $formother->select_salesrepresentatives($search_sale, 'search_sale', $user, 0, 1, 'maxwidth300', 1);
	$moreforfilter .= '</div>';
}
if ($moreforfilter)
{
	/*print '<div class="liste_titre liste_titre_bydiv centpercent">';
	print $moreforfilter;
	$parameters = array('type'=>$type);
	$reshook = $hookmanager->executeHooks('printFieldPreListTitle', $parameters); // Note that $action and $object may have been modified by hook
	print $hookmanager->resPrint;
	print '</div>';*/
}

$varpage = empty($contextpage) ? $_SERVER["PHP_SELF"] : $contextpage;
$selectedfields = $form->multiSelectArrayWithCheckbox('selectedfields', $arrayfields, $varpage); // This also change content of $arrayfields
// Show the massaction checkboxes only when this page is not opend from the Extended POS


if (empty($arrayfields['customerorsupplier']['checked'])) print '<input type="hidden" name="type" value="'.$type.'">';


// Fields from hook
$parameters = array('arrayfields'=>$arrayfields);
$reshook = $hookmanager->executeHooks('printFieldListOption', $parameters); // Note that $action and $object may have been modified by hook
//print $hookmanager->resPrint;



// Extra fields



$db->free($resql);

$parameters = array('arrayfields'=>$arrayfields, 'sql'=>$sql);
$reshook = $hookmanager->executeHooks('printFieldListFooter', $parameters); // Note that $action and $object may have been modified by hook
//print $hookmanager->resPrint;


// End of page
llxFooterLayout();

print '<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/cards-tools.js?v=7.2.0"></script>
<!--<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/advanced-search.js?v=7.2.0"></script>-->
<!--end::Page Vendors-->';

print "	</body>\n";
print "</html>\n";
$db->close();
