<?php
/* 
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
 *	    \file       htdocs/admin/dict.php
 *		\ingroup    setup
 *		\brief      Page to administer data tables
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formadmin.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/accounting.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formaccounting.class.php';

// Load translation files required by the page
$langs->loadLangs(array("errors", "admin", "main", "companies", "resource", "holiday", "accountancy", "hrm", "orders", "contracts", "projects", "propal", "bills", "interventions"));

$action = GETPOST('action', 'alpha') ?GETPOST('action', 'alpha') : 'view';
$confirm = GETPOST('confirm', 'alpha');
$id = GETPOST('id', 'int');
$rowid = GETPOST('rowid', 'alpha');
$entity = GETPOST('entity', 'int');
$code = GETPOST('code', 'alpha');

$allowed = $user->admin;
if ($id == 7 && !empty($user->rights->accounting->chartofaccount)) $allowed = 1; // Tax page allowed to manager of chart account
if ($id == 10 && !empty($user->rights->accounting->chartofaccount)) $allowed = 1; // Vat page allowed to manager of chart account
if ($id == 17 && !empty($user->rights->accounting->chartofaccount)) $allowed = 1; // Dictionary with type of expense report and accounting account allowed to manager of chart account
if (!$allowed) accessforbidden();

$acts = array(); $actl = array();
$acts[0] = "activate";
$acts[1] = "disable";
$actl[0] = img_picto($langs->trans("Disabled"), 'switch_off');
$actl[1] = img_picto($langs->trans("Activated"), 'switch_on');

$listoffset = GETPOST('listoffset');
$listlimit = GETPOST('listlimit') > 0 ?GETPOST('listlimit') : 1000; // To avoid too long dictionaries
$active = 1;

$sortfield = GETPOST("sortfield", 'alpha');
$sortorder = GETPOST("sortorder", 'alpha');
$page = GETPOSTISSET('pageplusone') ? (GETPOST('pageplusone') - 1) : GETPOST("page", 'int');
if (empty($page) || $page == -1) { $page = 0; }     // If $page is not defined, or '' or -1
$offset = $listlimit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;

$search_country_id = GETPOST('search_country_id', 'int');
if (!GETPOSTISSET('search_country_id') && $search_country_id == '' && ($id == 2 || $id == 3 || $id == 10))	// Not a so good idea to force on current country for all dictionaries. Some tables have entries that are for all countries, we must be able to see them, so this is done for dedicated dictionaries only.
{
	$search_country_id = $mysoc->country_id;
}
$search_code = GETPOST('search_code', 'alpha');

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('admin'));

// This page is a generic page to edit dictionaries
// Put here declaration of dictionaries properties

// Sort order to show dictionary (0 is space). All other dictionaries (added by modules) will be at end of this.
//$taborder = array(9, 0, 4, 3, 2, 43, 44, 0, 45, 46, 47,48,  0, 1, 8, 19, 16, 39, 27, 40, 38, 0, 5, 11, 0, 32, 33, 34, 0, 6, 0, 29, 0, 7, 24, 28, 17, 35, 36, 0, 10, 23, 12, 13, 0, 14, 0, 22, 20, 18, 21, 41, 0, 15, 30, 0, 37, 42, 0, 25, 0);
$taborder = array(9, 0, 4, 3, 2, 43, 44, 0, 49, 0, 45, 46, 47,48, 52, 0, 50, 51, 0, 39, 40, 38, 0, 11, 0, 32, 33, 34, 0, 6, 0, 29, 0, 7, 24, 28, 17, 35, 36, 0, 10, 12, 13, 0, 14, 0, 22, 20, 18, 21, 41, 0, 15, 30, 0, 37, 42, 0, 25, 0);

// Name of SQL tables of dictionaries
$tabname = array();
$tabname[1] = MAIN_DB_PREFIX."c_forme_juridique";
$tabname[2] = MAIN_DB_PREFIX."c_departements";
$tabname[3] = MAIN_DB_PREFIX."c_regions";
$tabname[4] = MAIN_DB_PREFIX."c_country";
$tabname[5] = MAIN_DB_PREFIX."c_civility";
$tabname[6] = MAIN_DB_PREFIX."c_actioncomm";
$tabname[7] = MAIN_DB_PREFIX."c_chargesociales";
$tabname[8] = MAIN_DB_PREFIX."c_typent";
$tabname[9] = MAIN_DB_PREFIX."c_currencies";
$tabname[10] = MAIN_DB_PREFIX."c_tva";
$tabname[11] = MAIN_DB_PREFIX."c_type_contact";
$tabname[12] = MAIN_DB_PREFIX."c_payment_term";
$tabname[13] = MAIN_DB_PREFIX."c_paiement";
$tabname[14] = MAIN_DB_PREFIX."c_ecotaxe";
$tabname[15] = MAIN_DB_PREFIX."c_paper_format";
$tabname[16] = MAIN_DB_PREFIX."c_prospectlevel";
$tabname[17] = MAIN_DB_PREFIX."c_type_fees";
$tabname[18] = MAIN_DB_PREFIX."c_shipment_mode";
$tabname[19] = MAIN_DB_PREFIX."c_effectif";
$tabname[20] = MAIN_DB_PREFIX."c_input_method";
$tabname[21] = MAIN_DB_PREFIX."c_availability";
$tabname[22] = MAIN_DB_PREFIX."c_input_reason";
$tabname[23] = MAIN_DB_PREFIX."c_revenuestamp";
$tabname[24] = MAIN_DB_PREFIX."c_type_resource";
$tabname[25] = MAIN_DB_PREFIX."c_type_container";
//$tabname[26]= MAIN_DB_PREFIX."c_units";
$tabname[27] = MAIN_DB_PREFIX."c_stcomm";
$tabname[28] = MAIN_DB_PREFIX."c_holiday_types";
$tabname[29] = MAIN_DB_PREFIX."c_lead_status";
$tabname[30] = MAIN_DB_PREFIX."c_format_cards";
//$tabname[31]= MAIN_DB_PREFIX."accounting_system";
$tabname[32] = MAIN_DB_PREFIX."c_hrm_public_holiday";
$tabname[33] = MAIN_DB_PREFIX."c_hrm_department";
$tabname[34] = MAIN_DB_PREFIX."c_hrm_function";
$tabname[35] = MAIN_DB_PREFIX."c_exp_tax_cat";
$tabname[36] = MAIN_DB_PREFIX."c_exp_tax_range";
$tabname[37] = MAIN_DB_PREFIX."c_units";
$tabname[38] = MAIN_DB_PREFIX."c_socialnetworks";
$tabname[39] = MAIN_DB_PREFIX."c_prospectcontactlevel";
$tabname[40] = MAIN_DB_PREFIX."c_stcommcontact";
$tabname[41] = MAIN_DB_PREFIX."c_transport_mode";
$tabname[42] = MAIN_DB_PREFIX."c_product_nature";
$tabname[43] = MAIN_DB_PREFIX."c_cities";
$tabname[44] = MAIN_DB_PREFIX."c_pincodes";
$tabname[45] = MAIN_DB_PREFIX."c_brands";
$tabname[46] = MAIN_DB_PREFIX."c_product_family";
$tabname[47] = MAIN_DB_PREFIX."c_product_subfamily";
$tabname[48] = MAIN_DB_PREFIX."c_product_model";
$tabname[49] = MAIN_DB_PREFIX."c_comman_departments";
$tabname[50] = MAIN_DB_PREFIX."c_call_source";
$tabname[51] = MAIN_DB_PREFIX."c_service_type";
$tabname[52] = MAIN_DB_PREFIX."c_product_capacity";


// Dictionary labels
$tablib = array();
$tablib[1] = "DictionaryCompanyJuridicalType";
$tablib[2] = "DictionaryCanton";
$tablib[3] = "DictionaryRegion";
$tablib[4] = "DictionaryCountry";
$tablib[5] = "DictionaryCivility";
$tablib[6] = "DictionaryActions";
$tablib[7] = "DictionarySocialContributions";
$tablib[8] = "DictionaryCompanyType";
$tablib[9] = "DictionaryCurrency";
$tablib[10] = "DictionaryVAT";
$tablib[11] = "DictionaryTypeContact";
$tablib[12] = "DictionaryPaymentConditions";
$tablib[13] = "DictionaryPaymentModes";
$tablib[14] = "DictionaryEcotaxe";
$tablib[15] = "DictionaryPaperFormat";
$tablib[16] = "DictionaryProspectLevel";
$tablib[17] = "DictionaryFees";
$tablib[18] = "DictionarySendingMethods";
$tablib[19] = "DictionaryStaff";
$tablib[20] = "DictionaryOrderMethods";
$tablib[21] = "DictionaryAvailability";
$tablib[22] = "DictionarySource";
$tablib[23] = "DictionaryRevenueStamp";
$tablib[24] = "DictionaryResourceType";
$tablib[25] = "DictionaryTypeOfContainer";
//$tablib[26]= "DictionaryUnits";
$tablib[27] = "DictionaryProspectStatus";
$tablib[28] = "DictionaryHolidayTypes";
$tablib[29] = "DictionaryOpportunityStatus";
$tablib[30] = "DictionaryFormatCards";
//$tablib[31]= "DictionaryAccountancysystem";
$tablib[32] = "DictionaryPublicHolidays";
$tablib[33] = "DictionaryDepartment";
$tablib[34] = "DictionaryFunction";
$tablib[35] = "DictionaryExpenseTaxCat";
$tablib[36] = "DictionaryExpenseTaxRange";
$tablib[37] = "DictionaryMeasuringUnits";
$tablib[38] = "DictionarySocialNetworks";
$tablib[39] = "DictionaryProspectContactLevel";
$tablib[40] = "DictionaryProspectContactStatus";
$tablib[41] = "DictionaryTransportMode";
$tablib[42] = "DictionaryProductNature";
$tablib[43] = "DictionaryCity";
$tablib[44] = "DictionaryPincode";
$tablib[45] = "DictionaryProductBrands";
$tablib[46] = "DictionaryProductCategory";
$tablib[47] = "DictionaryProductSubCategory";
$tablib[48] = "DictionaryProductModel";
$tablib[49] = "DictionaryCommanDepartment";
$tablib[50] = "DictionarySourceCall";
$tablib[51] = "DictionaryServiceType";
$tablib[52] = "DictionaryProductCapacity";

// Requests to extract data
$tabsql = array();
$tabsql[1] = "SELECT f.rowid as rowid, f.code, f.libelle, c.code as country_code, c.label as country, f.active FROM ".MAIN_DB_PREFIX."c_forme_juridique as f, ".MAIN_DB_PREFIX."c_country as c WHERE f.fk_pays=c.rowid";
$tabsql[2] = "SELECT d.rowid as rowid, d.code_departement as code, d.nom as libelle, d.fk_region as region_id, r.nom as region, c.code as country_code, c.label as country, d.active FROM ".MAIN_DB_PREFIX."c_departements as d, ".MAIN_DB_PREFIX."c_regions as r, ".MAIN_DB_PREFIX."c_country as c WHERE d.fk_region=r.code_region and r.fk_pays=c.rowid and r.active=1 and c.active=1";
$tabsql[3] = "SELECT r.rowid as rowid, r.code_region as state_code, r.nom as libelle, r.fk_pays as country_id, c.code as country_code, c.label as country, r.active FROM ".MAIN_DB_PREFIX."c_regions as r, ".MAIN_DB_PREFIX."c_country as c WHERE r.fk_pays=c.rowid and c.active=1";
$tabsql[4] = "SELECT c.rowid as rowid, c.code, c.label, c.active, c.favorite FROM ".MAIN_DB_PREFIX."c_country AS c";
$tabsql[5] = "SELECT c.rowid as rowid, c.code as code, c.label, c.active FROM ".MAIN_DB_PREFIX."c_civility AS c";
$tabsql[6] = "SELECT a.id    as rowid, a.code as code, a.libelle AS libelle, a.type, a.active, a.module, a.color, a.position FROM ".MAIN_DB_PREFIX."c_actioncomm AS a";
$tabsql[7] = "SELECT a.id    as rowid, a.code as code, a.libelle AS libelle, a.accountancy_code as accountancy_code, a.deductible, c.code as country_code, c.label as country, a.fk_pays as country_id, a.active FROM ".MAIN_DB_PREFIX."c_chargesociales AS a, ".MAIN_DB_PREFIX."c_country as c WHERE a.fk_pays=c.rowid and c.active=1";
$tabsql[8] = "SELECT t.id	 as rowid, t.code as code, t.libelle, t.fk_country as country_id, c.code as country_code, c.label as country, t.position, t.active FROM ".MAIN_DB_PREFIX."c_typent as t LEFT JOIN ".MAIN_DB_PREFIX."c_country as c ON t.fk_country=c.rowid";
$tabsql[9] = "SELECT c.code_iso as code, c.label, c.unicode, c.active FROM ".MAIN_DB_PREFIX."c_currencies AS c";
$tabsql[10] = "SELECT t.rowid, t.code, t.taux, t.localtax1_type, t.localtax1, t.localtax2_type, t.localtax2, c.label as country, c.code as country_code, t.fk_pays as country_id, t.recuperableonly, t.note, t.active, t.accountancy_code_sell, t.accountancy_code_buy FROM ".MAIN_DB_PREFIX."c_tva as t, ".MAIN_DB_PREFIX."c_country as c WHERE t.fk_pays=c.rowid";
$tabsql[11] = "SELECT t.rowid as rowid, t.element, t.source, t.code, t.libelle, t.position, t.active FROM ".MAIN_DB_PREFIX."c_type_contact AS t";
$tabsql[12] = "SELECT c.rowid as rowid, c.code, c.libelle, c.libelle_facture, c.nbjour, c.type_cdr, c.decalage, c.active, c.sortorder, c.entity FROM ".MAIN_DB_PREFIX."c_payment_term AS c WHERE c.entity = ".getEntity($tabname[12]);
$tabsql[13] = "SELECT c.id    as rowid, c.code, c.libelle, c.type, c.active, c.entity FROM ".MAIN_DB_PREFIX."c_paiement AS c WHERE c.entity = ".getEntity($tabname[13]);
$tabsql[14] = "SELECT e.rowid as rowid, e.code as code, e.label, e.price, e.organization, e.fk_pays as country_id, c.code as country_code, c.label as country, e.active FROM ".MAIN_DB_PREFIX."c_ecotaxe AS e, ".MAIN_DB_PREFIX."c_country as c WHERE e.fk_pays=c.rowid and c.active=1";
$tabsql[15] = "SELECT rowid   as rowid, code, label as libelle, width, height, unit, active FROM ".MAIN_DB_PREFIX."c_paper_format";
$tabsql[16] = "SELECT code, label as libelle, sortorder, active FROM ".MAIN_DB_PREFIX."c_prospectlevel";
$tabsql[17] = "SELECT id      as rowid, code, label, accountancy_code, active FROM ".MAIN_DB_PREFIX."c_type_fees";
$tabsql[18] = "SELECT rowid   as rowid, code, libelle, tracking, active FROM ".MAIN_DB_PREFIX."c_shipment_mode";
$tabsql[19] = "SELECT id      as rowid, code, libelle, active FROM ".MAIN_DB_PREFIX."c_effectif";
$tabsql[20] = "SELECT rowid   as rowid, code, libelle, active FROM ".MAIN_DB_PREFIX."c_input_method";
$tabsql[21] = "SELECT c.rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_availability AS c";
$tabsql[22] = "SELECT rowid   as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_input_reason";
$tabsql[23] = "SELECT t.rowid as rowid, t.taux, t.revenuestamp_type, c.label as country, c.code as country_code, t.fk_pays as country_id, t.note, t.active, t.accountancy_code_sell, t.accountancy_code_buy FROM ".MAIN_DB_PREFIX."c_revenuestamp as t, ".MAIN_DB_PREFIX."c_country as c WHERE t.fk_pays=c.rowid";
$tabsql[24] = "SELECT rowid   as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_type_resource";
$tabsql[25] = "SELECT rowid   as rowid, code, label, active, module FROM ".MAIN_DB_PREFIX."c_type_container as t WHERE t.entity IN (".getEntity('c_type_container').")";
//$tabsql[26]= "SELECT rowid   as rowid, code, label, short_label, active FROM ".MAIN_DB_PREFIX."c_units";
$tabsql[27] = "SELECT id      as rowid, code, libelle, picto, active FROM ".MAIN_DB_PREFIX."c_stcomm";
$tabsql[28] = "SELECT h.rowid as rowid, h.code, h.label, h.affect, h.delay, h.newbymonth, h.fk_country as country_id, c.code as country_code, c.label as country, h.active FROM ".MAIN_DB_PREFIX."c_holiday_types as h LEFT JOIN ".MAIN_DB_PREFIX."c_country as c ON h.fk_country=c.rowid";
$tabsql[29] = "SELECT rowid   as rowid, code, label, percent, position, active FROM ".MAIN_DB_PREFIX."c_lead_status";
$tabsql[30] = "SELECT rowid, code, name, paper_size, orientation, metric, leftmargin, topmargin, nx, ny, spacex, spacey, width, height, font_size, custom_x, custom_y, active FROM ".MAIN_DB_PREFIX."c_format_cards";
//$tabsql[31]= "SELECT s.rowid as rowid, pcg_version, s.label, s.active FROM ".MAIN_DB_PREFIX."accounting_system as s";
$tabsql[32] = "SELECT a.id    as rowid, a.entity, a.code, a.fk_country as country_id, c.code as country_code, c.label as country, a.dayrule, a.day, a.month, a.year, a.active FROM ".MAIN_DB_PREFIX."c_hrm_public_holiday as a LEFT JOIN ".MAIN_DB_PREFIX."c_country as c ON a.fk_country=c.rowid AND c.active=1";
$tabsql[33] = "SELECT rowid, pos, code, label, active FROM ".MAIN_DB_PREFIX."c_hrm_department";
$tabsql[34] = "SELECT rowid, pos, code, label, c_level, active FROM ".MAIN_DB_PREFIX."c_hrm_function";
$tabsql[35] = "SELECT c.rowid, c.label, c.active, c.entity FROM ".MAIN_DB_PREFIX."c_exp_tax_cat c";
$tabsql[36] = "SELECT r.rowid, r.fk_c_exp_tax_cat, r.range_ik, r.active, r.entity FROM ".MAIN_DB_PREFIX."c_exp_tax_range r";
$tabsql[37] = "SELECT r.rowid, r.code, r.label, r.short_label, r.unit_type, r.scale, r.active FROM ".MAIN_DB_PREFIX."c_units r";
$tabsql[38] = "SELECT rowid, entity, code, label, url, icon, active FROM ".MAIN_DB_PREFIX."c_socialnetworks";
$tabsql[39] = "SELECT code, label as libelle, sortorder, active FROM ".MAIN_DB_PREFIX."c_prospectcontactlevel";
$tabsql[40] = "SELECT id as rowid, code, libelle, picto, active FROM ".MAIN_DB_PREFIX."c_stcommcontact";
$tabsql[41] = "SELECT rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_transport_mode";
$tabsql[42] = "SELECT rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_product_nature";

//$tabsql[2] = "SELECT d.rowid as rowid, d.code_departement as code, d.nom as libelle, d.fk_region as region_id, r.nom as region, c.code as country_code, c.label as country, d.active FROM ".MAIN_DB_PREFIX."c_departements as d, ".MAIN_DB_PREFIX."c_regions as r, ".MAIN_DB_PREFIX."c_country as c WHERE d.fk_region=r.code_region and r.fk_pays=c.rowid and r.active=1 and c.active=1";
$tabsql[43] = "SELECT ct.rowid as rowid, ct.code_city as code, ct.nom as libelle, ct.fk_state as state_id, d.nom as state, d.fk_region, r.nom as region, c.code as country_code, c.label as country, ct.active FROM ".MAIN_DB_PREFIX."c_cities as ct, ".MAIN_DB_PREFIX."c_departements as d, ".MAIN_DB_PREFIX."c_regions as r, ".MAIN_DB_PREFIX."c_country as c WHERE ct.fk_state = d.rowid and d.fk_region=r.code_region and r.fk_pays=c.rowid and d.active=1 and r.active=1 and c.active=1";

$tabsql[44] = "SELECT p.rowid as rowid, p.code as code, p.zip as libelle, p.active, p.fk_city as city_id, ct.nom as city, p.fk_county as state_id, d.nom as state FROM ".MAIN_DB_PREFIX."c_pincodes as p, ".MAIN_DB_PREFIX."c_cities as ct, ".MAIN_DB_PREFIX."c_departements as d WHERE p.fk_city = ct.rowid and p.fk_county = d.rowid and d.active=1 and ct.active=1";

$tabsql[45] = "SELECT rowid as rowid, code, nom, active FROM ".MAIN_DB_PREFIX."c_brands";
$tabsql[46] = "SELECT f.rowid as rowid, f.code, f.nom, f.active, b.nom as brand, f.fk_brand FROM ".MAIN_DB_PREFIX."c_product_family as f, ".MAIN_DB_PREFIX."c_brands b WHERE f.fk_brand = b.rowid";

$tabsql[47] = "SELECT sf.rowid as rowid, sf.code as code, sf.nom as label, sf.fk_brand, sf.active, b.nom as brand, sf.fk_family, f.nom as category FROM ".MAIN_DB_PREFIX."c_product_subfamily as sf,".MAIN_DB_PREFIX."c_product_family as f, ".MAIN_DB_PREFIX."c_brands b WHERE sf.fk_brand = b.rowid AND sf.fk_family = f.rowid ";

$tabsql[48] = "SELECT pm.rowid as rowid, pm.code as modelno, pm.nom as name, pm.fk_subfamily, sf.nom as subcategory, pm.fk_family, f.nom as category, pm.fk_brand, b.nom as brand, pm.is_installable, pm.active FROM ".MAIN_DB_PREFIX."c_product_model as pm, ".MAIN_DB_PREFIX."c_product_subfamily as sf,".MAIN_DB_PREFIX."c_product_family as f,".MAIN_DB_PREFIX."c_brands as b WHERE pm.fk_family = f.rowid and pm.fk_subfamily = sf.rowid AND pm.fk_brand = b.rowid ";

$tabsql[49] = "SELECT rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_comman_departments";

$tabsql[50] = "SELECT rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_call_source";
$tabsql[51] = "SELECT rowid as rowid, code, label, active FROM ".MAIN_DB_PREFIX."c_service_type";
$tabsql[52] = "SELECT rowid as rowid, code, nom, active FROM ".MAIN_DB_PREFIX."c_product_capacity";


// Criteria to sort dictionaries
$tabsqlsort = array();
$tabsqlsort[1] = "country ASC, code ASC";
$tabsqlsort[2] = "country ASC, code ASC";
$tabsqlsort[3] = "country ASC, code ASC";
$tabsqlsort[4] = "code ASC";
$tabsqlsort[5] = "label ASC";
$tabsqlsort[6] = "a.type ASC, a.module ASC, a.position ASC, a.code ASC";
$tabsqlsort[7] = "country ASC, code ASC, a.libelle ASC";
$tabsqlsort[8] = "country DESC,".(!empty($conf->global->SOCIETE_SORT_ON_TYPEENT) ? ' t.position ASC,' : '')." libelle ASC";
$tabsqlsort[9] = "label ASC";
$tabsqlsort[10] = "country ASC, code ASC, taux ASC, recuperableonly ASC, localtax1 ASC, localtax2 ASC";
$tabsqlsort[11] = "t.element ASC, t.source ASC, t.position ASC, t.code ASC";
$tabsqlsort[12] = "sortorder ASC, code ASC";
$tabsqlsort[13] = "code ASC";
$tabsqlsort[14] = "country ASC, e.organization ASC, code ASC";
$tabsqlsort[15] = "rowid ASC";
$tabsqlsort[16] = "sortorder ASC";
$tabsqlsort[17] = "code ASC";
$tabsqlsort[18] = "code ASC, libelle ASC";
$tabsqlsort[19] = "id ASC";
$tabsqlsort[20] = "code ASC, libelle ASC";
$tabsqlsort[21] = "code ASC, label ASC";
$tabsqlsort[22] = "code ASC, label ASC";
$tabsqlsort[23] = "country ASC, taux ASC";
$tabsqlsort[24] = "code ASC, label ASC";
$tabsqlsort[25] = "t.module ASC, t.code ASC, t.label ASC";
//$tabsqlsort[26]="code ASC";
$tabsqlsort[27] = "code ASC";
$tabsqlsort[28] = "country ASC, code ASC";
$tabsqlsort[29] = "position ASC";
$tabsqlsort[30] = "code ASC";
//$tabsqlsort[31]="pcg_version ASC";
$tabsqlsort[32] = "country, year ASC, month ASC, day ASC";
$tabsqlsort[33] = "code ASC";
$tabsqlsort[34] = "code ASC";
$tabsqlsort[35] = "c.label ASC";
$tabsqlsort[36] = "r.fk_c_exp_tax_cat ASC, r.range_ik ASC";
$tabsqlsort[37] = "r.unit_type ASC, r.scale ASC, r.code ASC";
$tabsqlsort[38] = "rowid, code ASC";
$tabsqlsort[39] = "sortorder ASC";
$tabsqlsort[40] = "code ASC";
$tabsqlsort[41] = "code ASC";
$tabsqlsort[42] = "code ASC";
$tabsqlsort[43] = "state ASC, country ASC, code ASC";
$tabsqlsort[44] = "libelle ASC";
$tabsqlsort[45] = "nom ASC";
$tabsqlsort[46] = "nom ASC";
$tabsqlsort[47] = "rowid DESC";
$tabsqlsort[48] = "rowid DESC";
$tabsqlsort[49] = "rowid DESC";
$tabsqlsort[50] = "rowid DESC";
$tabsqlsort[51] = "rowid DESC";
$tabsqlsort[52] = "rowid DESC";

// Field names in select result for dictionary display
$tabfield = array();
$tabfield[1] = "code,libelle,country";
$tabfield[2] = "code,libelle,region_id,region,country"; // "code,libelle,region,country_code-country"
$tabfield[3] = "code,libelle,country_id,country";
$tabfield[4] = "code,label";
$tabfield[5] = "code,label";
$tabfield[6] = "code,libelle,type,color,position";
$tabfield[7] = "code,libelle,country,accountancy_code,deductible";
$tabfield[8] = "code,libelle,country_id,country".(!empty($conf->global->SOCIETE_SORT_ON_TYPEENT) ? ',position' : '');
$tabfield[9] = "code,label,unicode";
$tabfield[10] = "country_id,country,code,taux,localtax1_type,localtax1,localtax2_type,localtax2,recuperableonly,accountancy_code_sell,accountancy_code_buy,note";
$tabfield[11] = "element,source,code,libelle,position";
$tabfield[12] = "code,libelle,libelle_facture,nbjour,type_cdr,decalage,sortorder,entity";
$tabfield[13] = "code,libelle,type,entity";
$tabfield[14] = "code,label,price,organization,country";
$tabfield[15] = "code,libelle,width,height,unit";
$tabfield[16] = "code,libelle,sortorder";
$tabfield[17] = "code,label,accountancy_code";
$tabfield[18] = "code,libelle,tracking";
$tabfield[19] = "code,libelle";
$tabfield[20] = "code,libelle";
$tabfield[21] = "code,label";
$tabfield[22] = "code,label";
$tabfield[23] = "country_id,country,taux,revenuestamp_type,accountancy_code_sell,accountancy_code_buy,note";
$tabfield[24] = "code,label";
$tabfield[25] = "code,label";
//$tabfield[26]= "code,label,short_label";
$tabfield[27] = "code,libelle,picto";
$tabfield[28] = "code,label,affect,delay,newbymonth,country_id,country";
$tabfield[29] = "code,label,percent,position";
$tabfield[30] = "code,name,paper_size,orientation,metric,leftmargin,topmargin,nx,ny,spacex,spacey,width,height,font_size,custom_x,custom_y";
//$tabfield[31]= "pcg_version,label";
$tabfield[32] = "code,dayrule,year,month,day,country_id,country";
$tabfield[33] = "code,label";
$tabfield[34] = "code,label";
$tabfield[35] = "label";
$tabfield[36] = "range_ik,fk_c_exp_tax_cat";
$tabfield[37] = "code,label,short_label,unit_type,scale";
$tabfield[38] = "code,label,url,icon,entity";
$tabfield[39] = "code,libelle,sortorder";
$tabfield[40] = "code,libelle,picto";
$tabfield[41] = "code,label";
$tabfield[42] = "code,label";
$tabfield[43] = "code,libelle,state,region_id,region";
$tabfield[44] = "code,libelle,city,state";
$tabfield[45] = "code,nom";
$tabfield[46] = "brand,code,nom";
$tabfield[47] = "brand,category,code,label";
$tabfield[48] = "brand,category,subcategory,modelno,name";
$tabfield[49] = "code,label";
$tabfield[50] = "code,label";
$tabfield[51] = "code,label";
$tabfield[52] = "code,nom";

// Edit field names for editing a record
$tabfieldvalue = array();
$tabfieldvalue[1] = "code,libelle,country";
$tabfieldvalue[2] = "code,libelle,region"; // "code,libelle,region"
$tabfieldvalue[3] = "code,libelle,country";
$tabfieldvalue[4] = "code,label";
$tabfieldvalue[5] = "code,label";
$tabfieldvalue[6] = "code,libelle,type,color,position";
$tabfieldvalue[7] = "code,libelle,country,accountancy_code,deductible";
$tabfieldvalue[8] = "code,libelle,country".(!empty($conf->global->SOCIETE_SORT_ON_TYPEENT) ? ',position' : '');
$tabfieldvalue[9] = "code,label,unicode";
$tabfieldvalue[10] = "country,code,taux,localtax1_type,localtax1,localtax2_type,localtax2,recuperableonly,accountancy_code_sell,accountancy_code_buy,note";
$tabfieldvalue[11] = "element,source,code,libelle,position";
$tabfieldvalue[12] = "code,libelle,libelle_facture,nbjour,type_cdr,decalage,sortorder";
$tabfieldvalue[13] = "code,libelle,type";
$tabfieldvalue[14] = "code,label,price,organization,country";
$tabfieldvalue[15] = "code,libelle,width,height,unit";
$tabfieldvalue[16] = "code,libelle,sortorder";
$tabfieldvalue[17] = "code,label,accountancy_code";
$tabfieldvalue[18] = "code,libelle,tracking";
$tabfieldvalue[19] = "code,libelle";
$tabfieldvalue[20] = "code,libelle";
$tabfieldvalue[21] = "code,label";
$tabfieldvalue[22] = "code,label";
$tabfieldvalue[23] = "country,taux,revenuestamp_type,accountancy_code_sell,accountancy_code_buy,note";
$tabfieldvalue[24] = "code,label";
$tabfieldvalue[25] = "code,label";
//$tabfieldvalue[26]= "code,label,short_label";
$tabfieldvalue[27] = "code,libelle,picto";
$tabfieldvalue[28] = "code,label,affect,delay,newbymonth,country";
$tabfieldvalue[29] = "code,label,percent,position";
$tabfieldvalue[30] = "code,name,paper_size,orientation,metric,leftmargin,topmargin,nx,ny,spacex,spacey,width,height,font_size,custom_x,custom_y";
//$tabfieldvalue[31]= "pcg_version,label";
$tabfieldvalue[32] = "code,dayrule,day,month,year,country";
$tabfieldvalue[33] = "code,label";
$tabfieldvalue[34] = "code,label";
$tabfieldvalue[35] = "label";
$tabfieldvalue[36] = "range_ik,fk_c_exp_tax_cat";
$tabfieldvalue[37] = "code,label,short_label,unit_type,scale";
$tabfieldvalue[38] = "code,label,url,icon";
$tabfieldvalue[39] = "code,libelle,sortorder";
$tabfieldvalue[40] = "code,libelle,picto";
$tabfieldvalue[41] = "code,label";
$tabfieldvalue[42] = "code,label";
$tabfieldvalue[43] = "code,libelle,state,region"; // 
$tabfieldvalue[44] = "code,libelle,city,state";
$tabfieldvalue[45] = "code,nom";
$tabfieldvalue[46] = "code,nom,brand";
$tabfieldvalue[47] = "code,label,brand,category";
$tabfieldvalue[48] = "brand,category,subcategory,modelno,name";
$tabfieldvalue[49] = "code,label";
$tabfieldvalue[50] = "code,label";
$tabfieldvalue[51] = "code,label";
$tabfieldvalue[52] = "code,nom";

// Field names in the table for inserting a record
$tabfieldinsert = array();
$tabfieldinsert[1] = "code,libelle,fk_pays";
$tabfieldinsert[2] = "code_departement,nom,fk_region";
$tabfieldinsert[3] = "code_region,nom,fk_pays";
$tabfieldinsert[4] = "code,label";
$tabfieldinsert[5] = "code,label";
$tabfieldinsert[6] = "code,libelle,type,color,position";
$tabfieldinsert[7] = "code,libelle,fk_pays,accountancy_code,deductible";
$tabfieldinsert[8] = "code,libelle,fk_country".(!empty($conf->global->SOCIETE_SORT_ON_TYPEENT) ? ',position' : '');
$tabfieldinsert[9] = "code_iso,label,unicode";
$tabfieldinsert[10] = "fk_pays,code,taux,localtax1_type,localtax1,localtax2_type,localtax2,recuperableonly,accountancy_code_sell,accountancy_code_buy,note";
$tabfieldinsert[11] = "element,source,code,libelle,position";
$tabfieldinsert[12] = "code,libelle,libelle_facture,nbjour,type_cdr,decalage,sortorder,entity";
$tabfieldinsert[13] = "code,libelle,type,entity";
$tabfieldinsert[14] = "code,label,price,organization,fk_pays";
$tabfieldinsert[15] = "code,label,width,height,unit";
$tabfieldinsert[16] = "code,label,sortorder";
$tabfieldinsert[17] = "code,label,accountancy_code";
$tabfieldinsert[18] = "code,libelle,tracking";
$tabfieldinsert[19] = "code,libelle";
$tabfieldinsert[20] = "code,libelle";
$tabfieldinsert[21] = "code,label";
$tabfieldinsert[22] = "code,label";
$tabfieldinsert[23] = "fk_pays,taux,revenuestamp_type,accountancy_code_sell,accountancy_code_buy,note";
$tabfieldinsert[24] = "code,label";
$tabfieldinsert[25] = "code,label";
//$tabfieldinsert[26]= "code,label,short_label";
$tabfieldinsert[27] = "code,libelle,picto";
$tabfieldinsert[28] = "code,label,affect,delay,newbymonth,fk_country";
$tabfieldinsert[29] = "code,label,percent,position";
$tabfieldinsert[30] = "code,name,paper_size,orientation,metric,leftmargin,topmargin,nx,ny,spacex,spacey,width,height,font_size,custom_x,custom_y";
//$tabfieldinsert[31]= "pcg_version,label";
//$tabfieldinsert[32]= "code,label,range_account,sens,category_type,formula,position,fk_country";
$tabfieldinsert[32] = "code,dayrule,day,month,year,fk_country";
$tabfieldinsert[33] = "code,label";
$tabfieldinsert[34] = "code,label";
$tabfieldinsert[35] = "label";
$tabfieldinsert[36] = "range_ik,fk_c_exp_tax_cat";
$tabfieldinsert[37] = "code,label,short_label,unit_type,scale";
$tabfieldinsert[38] = "code,label,url,icon,entity";
$tabfieldinsert[39] = "code,label,sortorder";
$tabfieldinsert[40] = "code,libelle,picto";
$tabfieldinsert[41] = "code,label";
$tabfieldinsert[42] = "code,label";
$tabfieldinsert[43] = "code_city,nom,fk_state";
$tabfieldinsert[44] = "code,zip,fk_city,fk_county";
$tabfieldinsert[45] = "code,nom";
$tabfieldinsert[46] = "code,nom,fk_brand";
$tabfieldinsert[47] = "code,nom,fk_brand,fk_family";
$tabfieldinsert[48] = "fk_brand,fk_family,fk_subfamily,code,nom";
$tabfieldinsert[49] = "code,label";
$tabfieldinsert[50] = "code,label";
$tabfieldinsert[51] = "code,label";
$tabfieldinsert[52] = "code,nom";

// Rowid name of field depending if field is autoincrement on or off..
// Use "" if id field is "rowid" and has autoincrement on
// Use "nameoffield" if id field is not "rowid" or has not autoincrement on
$tabrowid = array();
$tabrowid[1] = "";
$tabrowid[2] = "";
$tabrowid[3] = "";
$tabrowid[4] = "rowid";
$tabrowid[5] = "rowid";
$tabrowid[6] = "id";
$tabrowid[7] = "id";
$tabrowid[8] = "id";
$tabrowid[9] = "code_iso";
$tabrowid[10] = "";
$tabrowid[11] = "rowid";
$tabrowid[12] = "";
$tabrowid[13] = "id";
$tabrowid[14] = "";
$tabrowid[15] = "";
$tabrowid[16] = "code";
$tabrowid[17] = "id";
$tabrowid[18] = "rowid";
$tabrowid[19] = "id";
$tabrowid[20] = "";
$tabrowid[21] = "rowid";
$tabrowid[22] = "rowid";
$tabrowid[23] = "";
$tabrowid[24] = "";
$tabrowid[25] = "";
//$tabrowid[26]= "";
$tabrowid[27] = "id";
$tabrowid[28] = "";
$tabrowid[29] = "";
$tabrowid[30] = "";
//$tabrowid[31]= "";
$tabrowid[32] = "id";
$tabrowid[33] = "rowid";
$tabrowid[34] = "rowid";
$tabrowid[35] = "";
$tabrowid[36] = "";
$tabrowid[37] = "";
$tabrowid[38] = "";
$tabrowid[39] = "code";
$tabrowid[40] = "id";
$tabrowid[41] = "";
$tabrowid[42] = "rowid";
$tabrowid[43] = "";
$tabrowid[44] = "";
$tabrowid[45] = "";
$tabrowid[46] = "";
$tabrowid[47] = "";
$tabrowid[48] = "";
$tabrowid[49] = "rowid";
$tabrowid[50] = "rowid";
$tabrowid[51] = "rowid";
$tabrowid[52] = "rowid";

// Condition to show dictionary in setup page
$tabcond = array();
$tabcond[1] = (!empty($conf->societe->enabled));
$tabcond[2] = true;
$tabcond[3] = true;
$tabcond[4] = true;
$tabcond[5] = (!empty($conf->societe->enabled) || !empty($conf->adherent->enabled));
$tabcond[6] = !empty($conf->agenda->enabled);
$tabcond[7] = !empty($conf->tax->enabled);
$tabcond[8] = !empty($conf->societe->enabled);
$tabcond[9] = true;
$tabcond[10] = true;
$tabcond[11] = (!empty($conf->societe->enabled));
$tabcond[12] = (!empty($conf->commande->enabled) || !empty($conf->propal->enabled) || !empty($conf->facture->enabled) || (!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD)) || !empty($conf->supplier_invoice->enabled) || !empty($conf->supplier_order->enabled));
$tabcond[13] = (!empty($conf->commande->enabled) || !empty($conf->propal->enabled) || !empty($conf->facture->enabled) || (!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD)) || !empty($conf->supplier_invoice->enabled) || !empty($conf->supplier_order->enabled));
$tabcond[14] = (!empty($conf->product->enabled) && (!empty($conf->ecotax->enabled) || !empty($conf->global->MAIN_SHOW_ECOTAX_DICTIONNARY)));
$tabcond[15] = true;
$tabcond[16] = (!empty($conf->societe->enabled) && empty($conf->global->SOCIETE_DISABLE_PROSPECTS));
$tabcond[17] = (!empty($conf->deplacement->enabled) || !empty($conf->expensereport->enabled));
$tabcond[18] = !empty($conf->expedition->enabled) || !empty($conf->reception->enabled);
$tabcond[19] = !empty($conf->societe->enabled);
$tabcond[20] = (!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled));
$tabcond[21] = !empty($conf->propal->enabled);
$tabcond[22] = (!empty($conf->commande->enabled) || !empty($conf->propal->enabled));
$tabcond[23] = true;
$tabcond[24] = !empty($conf->resource->enabled);
$tabcond[25] = !empty($conf->website->enabled);
//$tabcond[26]= ! empty($conf->product->enabled);
$tabcond[27] = !empty($conf->societe->enabled);
$tabcond[28] = !empty($conf->holiday->enabled);
$tabcond[29] = !empty($conf->projet->enabled);
$tabcond[30] = !empty($conf->label->enabled);
//$tabcond[31]= ! empty($conf->accounting->enabled);
$tabcond[32] = (!empty($conf->holiday->enabled) || !empty($conf->hrm->enabled));
$tabcond[33] = !empty($conf->hrm->enabled);
$tabcond[34] = !empty($conf->hrm->enabled);
$tabcond[35] = !empty($conf->expensereport->enabled);
$tabcond[36] = !empty($conf->expensereport->enabled);
$tabcond[37] = !empty($conf->product->enabled);
$tabcond[38] = !empty($conf->socialnetworks->enabled);
$tabcond[39] = (!empty($conf->societe->enabled) && empty($conf->global->SOCIETE_DISABLE_PROSPECTS) && !empty($conf->global->THIRDPARTY_ENABLE_PROSPECTION_ON_ALTERNATIVE_ADRESSES));
$tabcond[40] = (!empty($conf->societe->enabled) && !empty($conf->global->THIRDPARTY_ENABLE_PROSPECTION_ON_ALTERNATIVE_ADRESSES));
$tabcond[41] = !empty($conf->intracommreport->enabled);
$tabcond[42] = !empty($conf->product->enabled);
$tabcond[43] = true;
$tabcond[44] = true;
$tabcond[45] = true;
$tabcond[46] = true;
$tabcond[47] = true;
$tabcond[48] = true;
$tabcond[49] = true;
$tabcond[50] = true;
$tabcond[51] = true;
$tabcond[52] = true;

// List of help for fields
$tabhelp = array();
$tabhelp[1]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[2]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[3]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[4]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[5]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[6]  = array('code'=>$langs->trans("EnterAnyCode"), 'color'=>$langs->trans("ColorFormat"), 'position'=>$langs->trans("PositionIntoComboList"));
$tabhelp[7]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[8]  = array('code'=>$langs->trans("EnterAnyCode"), 'position'=>$langs->trans("PositionIntoComboList"));
$tabhelp[9]  = array('code'=>$langs->trans("EnterAnyCode"), 'unicode'=>$langs->trans("UnicodeCurrency"));
$tabhelp[10] = array('code'=>$langs->trans("EnterAnyCode"), 'taux'=>$langs->trans("SellTaxRate"), 'recuperableonly'=>$langs->trans("RecuperableOnly"), 'localtax1_type'=>$langs->trans("LocalTaxDesc"), 'localtax2_type'=>$langs->trans("LocalTaxDesc"));
$tabhelp[11] = array('code'=>$langs->trans("EnterAnyCode"), 'position'=>$langs->trans("PositionIntoComboList"));
$tabhelp[12] = array('code'=>$langs->trans("EnterAnyCode"), 'type_cdr'=>$langs->trans("TypeCdr", $langs->transnoentitiesnoconv("NbOfDays"), $langs->transnoentitiesnoconv("Offset"), $langs->transnoentitiesnoconv("NbOfDays"), $langs->transnoentitiesnoconv("Offset")));
$tabhelp[13] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[14] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[15] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[16] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[17] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[18] = array('code'=>$langs->trans("EnterAnyCode"), 'tracking'=>$langs->trans("UrlTrackingDesc"));
$tabhelp[19] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[20] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[21] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[22] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[23] = array('revenuestamp_type'=>'FixedOrPercent');
$tabhelp[24] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[25] = array('code'=>$langs->trans('EnterAnyCode'));
//$tabhelp[26] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[27] = array('code'=>$langs->trans("EnterAnyCode"), 'picto'=>$langs->trans("PictoHelp"));
$tabhelp[28] = array('affect'=>$langs->trans("FollowedByACounter"), 'delay'=>$langs->trans("MinimumNoticePeriod"), 'newbymonth'=>$langs->trans("NbAddedAutomatically"));
$tabhelp[29] = array('code'=>$langs->trans("EnterAnyCode"), 'percent'=>$langs->trans("OpportunityPercent"), 'position'=>$langs->trans("PositionIntoComboList"));
$tabhelp[30] = array('code'=>$langs->trans("EnterAnyCode"), 'name'=>$langs->trans("LabelName"), 'paper_size'=>$langs->trans("LabelPaperSize"));
//$tabhelp[31] = array('pcg_version'=>$langs->trans("EnterAnyCode"));
$tabhelp[32] = array('code'=>$langs->trans("EnterAnyCode"), 'dayrule'=>"Keep empty for a date defined with month and day (most common case).<br>Use a keyword like 'easter', 'eastermonday', ... for a date predefined by complex rules.", 'country'=>$langs->trans("CountryIfSpecificToOneCountry"), 'year'=>$langs->trans("ZeroMeansEveryYear"));
$tabhelp[33] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[34] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[35] = array();
$tabhelp[36] = array('range_ik'=>$langs->trans('PrevRangeToThisRange'));
$tabhelp[37] = array('code'=>$langs->trans("EnterAnyCode"), 'unit_type' => $langs->trans('MeasuringUnitTypeDesc'), 'scale' => $langs->trans('MeasuringScaleDesc'));
$tabhelp[38] = array('code'=>$langs->trans("EnterAnyCode"), 'url' => $langs->trans('UrlSocialNetworksDesc'), 'icon' => $langs->trans('FafaIconSocialNetworksDesc'));
$tabhelp[39] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[40] = array('code'=>$langs->trans("EnterAnyCode"), 'picto'=>$langs->trans("PictoHelp"));
$tabhelp[41] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[42] = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[43]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[44]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[45]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[46]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[47]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[48]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[49]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[50]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[51]  = array('code'=>$langs->trans("EnterAnyCode"));
$tabhelp[52]  = array('code'=>$langs->trans("EnterAnyCode"));

// List of check for fields (NOT USED YET)
$tabfieldcheck = array();
$tabfieldcheck[1]  = array();
$tabfieldcheck[2]  = array();
$tabfieldcheck[3]  = array();
$tabfieldcheck[4]  = array();
$tabfieldcheck[5]  = array();
$tabfieldcheck[6]  = array();
$tabfieldcheck[7]  = array();
$tabfieldcheck[8]  = array();
$tabfieldcheck[9]  = array();
$tabfieldcheck[10] = array();
$tabfieldcheck[11] = array();
$tabfieldcheck[12] = array();
$tabfieldcheck[13] = array();
$tabfieldcheck[14] = array();
$tabfieldcheck[15] = array();
$tabfieldcheck[16] = array();
$tabfieldcheck[17] = array();
$tabfieldcheck[18] = array();
$tabfieldcheck[19] = array();
$tabfieldcheck[20] = array();
$tabfieldcheck[21] = array();
$tabfieldcheck[22] = array();
$tabfieldcheck[23] = array();
$tabfieldcheck[24] = array();
$tabfieldcheck[25] = array();
//$tabfieldcheck[26] = array();
$tabfieldcheck[27] = array();
$tabfieldcheck[28] = array();
$tabfieldcheck[29] = array();
$tabfieldcheck[30] = array();
//$tabfieldcheck[31] = array();
$tabfieldcheck[32] = array();
$tabfieldcheck[33] = array();
$tabfieldcheck[34] = array();
$tabfieldcheck[35] = array();
$tabfieldcheck[36] = array();
$tabfieldcheck[37] = array();
$tabfieldcheck[38] = array();
$tabfieldcheck[39] = array();
$tabfieldcheck[40] = array();
$tabfieldcheck[41] = array();
$tabfieldcheck[42] = array();
$tabfieldcheck[43]  = array();
$tabfieldcheck[44]  = array();
$tabfieldcheck[45]  = array();
$tabfieldcheck[46]  = array();
$tabfieldcheck[47]  = array();
$tabfieldcheck[48]  = array();
$tabfieldcheck[49]  = array();
$tabfieldcheck[50]  = array();
$tabfieldcheck[51]  = array();
$tabfieldcheck[52]  = array();

// Complete all arrays with entries found into modules
complete_dictionary_with_modules($taborder, $tabname, $tablib, $tabsql, $tabsqlsort, $tabfield, $tabfieldvalue, $tabfieldinsert, $tabrowid, $tabcond, $tabhelp, $tabfieldcheck);


// Defaut sortorder
if (empty($sortfield))
{
	$tmp1 = explode(',', $tabsqlsort[$id]);
	$tmp2 = explode(' ', $tmp1[0]);
	$sortfield = preg_replace('/^.*\./', '', $tmp2[0]);
}

// Define elementList and sourceList (used for dictionary type of contacts "llx_c_type_contact")
$elementList = array();
$sourceList = array();
if ($id == 11)
{
	$elementList = array(
		'' => '',
		'societe' => $langs->trans('ThirdParty'),
		// 'proposal' => $langs->trans('Proposal'),
		// 'order' => $langs->trans('Order'),
		// 'invoice' => $langs->trans('Bill'),
		'supplier_proposal' => $langs->trans('SupplierProposal'),
		'order_supplier' => $langs->trans('SupplierOrder'),
		'invoice_supplier' => $langs->trans('SupplierBill'),
		// 'intervention' => $langs->trans('InterventionCard'),
		// 'contract' => $langs->trans('Contract'),
		'project' => $langs->trans('Project'),
		'project_task' => $langs->trans('Task'),
        'ticket' => $langs->trans('Ticket'),
		'agenda' => $langs->trans('Agenda'),
		'dolresource' => $langs->trans('Resource'),
		// old deprecated
		'propal' => $langs->trans('Proposal'),
		'commande' => $langs->trans('Order'),
		'facture' => $langs->trans('Bill'),
		'fichinter' => $langs->trans('InterventionCard'),
		'contrat' => $langs->trans('Contract'),
	);
	if (!empty($conf->global->MAIN_SUPPORT_SHARED_CONTACT_BETWEEN_THIRDPARTIES)) $elementList["societe"] = $langs->trans('ThirdParty');

	complete_elementList_with_modules($elementList);

	asort($elementList);
	$sourceList = array(
			'internal' => $langs->trans('Internal'),
			'external' => $langs->trans('External')
	);
}

// Define localtax_typeList (used for dictionary "llx_c_tva")
$localtax_typeList = array();
if ($id == 10)
{
	$localtax_typeList = array(
		"0" => $langs->trans("No"),
		"1" => $langs->trans("Yes").' ('.$langs->trans("Type")." 1)", //$langs->trans("%ageOnAllWithoutVAT"),
		"2" => $langs->trans("Yes").' ('.$langs->trans("Type")." 2)", //$langs->trans("%ageOnAllBeforeVAT"),
		"3" => $langs->trans("Yes").' ('.$langs->trans("Type")." 3)", //$langs->trans("%ageOnProductsWithoutVAT"),
		"4" => $langs->trans("Yes").' ('.$langs->trans("Type")." 4)", //$langs->trans("%ageOnProductsBeforeVAT"),
		"5" => $langs->trans("Yes").' ('.$langs->trans("Type")." 5)", //$langs->trans("%ageOnServiceWithoutVAT"),
		"6" => $langs->trans("Yes").' ('.$langs->trans("Type")." 6)"	//$langs->trans("%ageOnServiceBeforeVAT"),
	);
}



/*
 * Actions
 */

if (GETPOST('button_removefilter', 'alpha') || GETPOST('button_removefilter.x', 'alpha') || GETPOST('button_removefilter_x', 'alpha'))
{
	$search_country_id = '';
	$search_code = '';
}

// Actions add or modify an entry into a dictionary
if (GETPOST('actionadd') || GETPOST('actionmodify'))
{
	$listfield = explode(',', str_replace(' ', '', $tabfield[$id]));
	$listfieldinsert = explode(',', $tabfieldinsert[$id]);
	$listfieldmodify = explode(',', $tabfieldinsert[$id]);
	$listfieldvalue = explode(',', $tabfieldvalue[$id]);

	// Check that all fields are filled
	$ok = 1;
	foreach ($listfield as $f => $value)
	{
		// Discard check of mandatory fields for country for some tables
		if ($value == 'country_id' && in_array($tablib[$id], array('DictionaryPublicHolidays', 'DictionaryVAT', 'DictionaryRegion', 'DictionaryCompanyType', 'DictionaryHolidayTypes', 'DictionaryRevenueStamp', 'DictionaryAccountancysystem', 'DictionaryAccountancyCategory'))) continue; // For some pages, country is not mandatory
		if ($value == 'country' && in_array($tablib[$id], array('DictionaryPublicHolidays', 'DictionaryCanton', 'DictionaryCompanyType', 'DictionaryHolidayTypes', 'DictionaryRevenueStamp'))) continue; // For some pages, country is not mandatory
		// Discard check of mandatory fiedls for other fields
		if ($value == 'localtax1' && empty($_POST['localtax1_type'])) continue;
		if ($value == 'localtax2' && empty($_POST['localtax2_type'])) continue;
		if ($value == 'color' && empty($_POST['color'])) continue;
		if ($value == 'formula' && empty($_POST['formula'])) continue;
		if ($value == 'dayrule' && empty($_POST['dayrule'])) continue;
		if ($value == 'sortorder') continue; // For a column name 'sortorder', we use the field name 'position'
		if ((!GETPOSTISSET($value) || GETPOST($value) == '')
			&& (!in_array($listfield[$f], array('decalage', 'module', 'accountancy_code', 'accountancy_code_sell', 'accountancy_code_buy', 'tracking', 'picto'))  // Fields that are not mandatory
			&& ($id != 10 || ($listfield[$f] != 'code' && $listfield[$f] != 'note')) // Field code and note is not mandatory for dictionary table 10
			)
		) {
			$ok = 0;
			$fieldnamekey = $listfield[$f];
			// We take translate key of field
			if ($fieldnamekey == 'libelle' || ($fieldnamekey == 'label'))  $fieldnamekey = 'Label';
			if ($fieldnamekey == 'libelle_facture') $fieldnamekey = 'LabelOnDocuments';
			if ($fieldnamekey == 'nbjour')   $fieldnamekey = 'NbOfDays';
			if ($fieldnamekey == 'decalage') $fieldnamekey = 'Offset';
			if ($fieldnamekey == 'module')   $fieldnamekey = 'Module';
			if ($fieldnamekey == 'code') $fieldnamekey = 'Code';
			if ($fieldnamekey == 'note') $fieldnamekey = 'Note';
			if ($fieldnamekey == 'taux') $fieldnamekey = 'Rate';
			if ($fieldnamekey == 'type') $fieldnamekey = 'Type';
			if ($fieldnamekey == 'position') $fieldnamekey = 'Position';
			if ($fieldnamekey == 'unicode') $fieldnamekey = 'Unicode';
			if ($fieldnamekey == 'deductible') $fieldnamekey = 'Deductible';
			if ($fieldnamekey == 'sortorder') $fieldnamekey = 'SortOrder';
			if ($fieldnamekey == 'category_type') $fieldnamekey = 'Calculated';
			if ($fieldnamekey == 'revenuestamp_type') $fieldnamekey = 'TypeOfRevenueStamp';
			if ($fieldnamekey == 'use_default') $fieldnamekey = 'UseByDefault';

			setEventMessages($langs->transnoentities("ErrorFieldRequired", $langs->transnoentities($fieldnamekey)), null, 'errors');
		}
	}
	// Other checks
	if (GETPOST('actionadd') && $tabname[$id] == MAIN_DB_PREFIX."c_actioncomm" && GETPOSTISSET("type") && in_array(GETPOST("type"), array('system', 'systemauto'))) {
		$ok = 0;
		setEventMessages($langs->transnoentities('ErrorReservedTypeSystemSystemAuto'), null, 'errors');
	}
	if (GETPOSTISSET("code"))
	{
		if (GETPOST("code") == '0')
		{
			$ok = 0;
			setEventMessages($langs->transnoentities('ErrorCodeCantContainZero'), null, 'errors');
		}
		/*if (!is_numeric($_POST['code']))	// disabled, code may not be in numeric base
    	{
	    	$ok = 0;
	    	$msg .= $langs->transnoentities('ErrorFieldFormat', $langs->transnoentities('Code')).'<br>';
	    }*/
	}
	if (GETPOSTISSET("country") && ($_POST["country"] == '0') && ($id != 2))
	{
		if (in_array($tablib[$id], array('DictionaryCompanyType', 'DictionaryHolidayTypes')))	// Field country is no mandatory for such dictionaries
		{
			$_POST["country"] = '';
		} else {
			$ok = 0;
			setEventMessages($langs->transnoentities("ErrorFieldRequired", $langs->transnoentities("Country")), null, 'errors');
		}
	}
	if (($id == 3 || $id == 42) && !is_numeric($_POST["code"])) {
	   	$ok = 0;
	   	setEventMessages($langs->transnoentities("ErrorFieldMustBeANumeric", $langs->transnoentities("Code")), null, 'errors');
	}

	// Clean some parameters
	if ((!empty($_POST["localtax1_type"]) || ($_POST['localtax1_type'] == '0')) && empty($_POST["localtax1"])) $_POST["localtax1"] = '0'; // If empty, we force to 0
	if ((!empty($_POST["localtax2_type"]) || ($_POST['localtax2_type'] == '0')) && empty($_POST["localtax2"])) $_POST["localtax2"] = '0'; // If empty, we force to 0
	if ($_POST["accountancy_code"] <= 0) $_POST["accountancy_code"] = ''; // If empty, we force to null
	if ($_POST["accountancy_code_sell"] <= 0) $_POST["accountancy_code_sell"] = ''; // If empty, we force to null
	if ($_POST["accountancy_code_buy"] <= 0) $_POST["accountancy_code_buy"] = ''; // If empty, we force to null
	if ($id == 10 && GETPOSTISSET("code"))  // Spaces are not allowed into code for tax dictionary
	{
		$_POST["code"] = preg_replace('/[^a-zA-Z0-9\-\+]/', '', $_POST["code"]);
	}

	// If check ok and action add, add the line
	if ($ok && GETPOST('actionadd'))
	{
		if ($tabrowid[$id])
		{
			// Get free id for insert
			$newid = 0;
			$sql = "SELECT max(".$tabrowid[$id].") newid from ".$tabname[$id];
			$result = $db->query($sql);
			if ($result)
			{
				$obj = $db->fetch_object($result);
				$newid = ($obj->newid + 1);
			} else {
				dol_print_error($db);
			}
		}

		// Add new entry
		$sql = "INSERT INTO ".$tabname[$id]." (";
		// List of fields
		if ($tabrowid[$id] && !in_array($tabrowid[$id], $listfieldinsert))
			$sql .= $tabrowid[$id].",";
		$sql .= $tabfieldinsert[$id];
		$sql .= ",active)";
		$sql .= " VALUES(";

		// List of values
		if ($tabrowid[$id] && !in_array($tabrowid[$id], $listfieldinsert))
			$sql .= $newid.",";
		$i = 0;
		foreach ($listfieldinsert as $f => $value)
		{
			$keycode = $listfieldvalue[$i];
			if (empty($keycode)) $keycode = $value;

			if ($value == 'price' || preg_match('/^amount/i', $value) || $value == 'taux') {
				$_POST[$keycode] = price2num($_POST[$keycode], 'MU');
			} elseif ($value == 'entity') {
				$_POST[$keycode] = getEntity($tabname[$id]);
			}

			if ($i) $sql .= ",";

			if ($keycode == 'sortorder')		// For column name 'sortorder', we use the field name 'position'
			{
				$sql .= "'".(int) GETPOST('position', 'int')."'";
			} elseif ($_POST[$keycode] == '' && !($keycode == 'code' && $id == 10)) $sql .= "null"; // For vat, we want/accept code = ''
			elseif ($keycode == 'content') {
				$sql .= "'".$db->escape(GETPOST($keycode, 'restricthtml'))."'";
			} elseif (in_array($keycode, array('joinfile', 'private', 'position', 'scale'))) {
				$sql .= (int) GETPOST($keycode, 'int');
			} else {
				$sql .= "'".$db->escape(GETPOST($keycode, 'nohtml'))."'";
			}

			$i++;
		}
		$sql .= ",1)";

		dol_syslog("actionadd", LOG_DEBUG);
		$result = $db->query($sql);
		if ($result)	// Add is ok
		{
			setEventMessages($langs->transnoentities("RecordCreatedSuccessfully"), null, 'mesgs');

			// Clean $_POST array, we keep only id of dictionary
			if ($id == 10 && GETPOST('country', 'int') > 0) {
				$search_country_id = GETPOST('country', 'int');
			}
			$_POST = array('id'=>$id);
		} else {
			if ($db->errno() == 'DB_ERROR_RECORD_ALREADY_EXISTS') {
				setEventMessages($langs->transnoentities("ErrorRecordAlreadyExists"), null, 'errors');
			} else {
				dol_print_error($db);
			}
		}
	}

	// If verif ok and action modify, modify the line
	if ($ok && GETPOST('actionmodify'))
	{
		if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

		// Modify entry
		$sql = "UPDATE ".$tabname[$id]." SET ";
		// Modifie valeur des champs
		if ($tabrowid[$id] && !in_array($tabrowid[$id], $listfieldmodify))
		{
			$sql .= $tabrowid[$id]."=";
			$sql .= "'".$db->escape($rowid)."', ";
		}
		$i = 0;
		foreach ($listfieldmodify as $field)
		{
			$keycode = $listfieldvalue[$i];
			if (empty($keycode)) $keycode = $field;

			if ($field == 'price' || preg_match('/^amount/i', $field) || $field == 'taux') {
				$_POST[$keycode] = price2num($_POST[$keycode], 'MU');
			} elseif ($field == 'entity') {
				$_POST[$keycode] = getEntity($tabname[$id]);
			}

			if ($i) $sql .= ",";
			$sql .= $field."=";
			if ($listfieldvalue[$i] == 'sortorder')		// For column name 'sortorder', we use the field name 'position'
			{
				$sql .= (int) GETPOST('position', 'int');
			} elseif ($_POST[$keycode] == '' && !($keycode == 'code' && $id == 10)) $sql .= "null"; // For vat, we want/accept code = ''
			elseif ($keycode == 'content') {
				$sql .= "'".$db->escape(GETPOST($keycode, 'restricthtml'))."'";
			} elseif (in_array($keycode, array('private', 'position', 'scale'))) {
				$sql .= (int) GETPOST($keycode, 'int');
			} else {
				$sql .= "'".$db->escape(GETPOST($keycode, 'nohtml'))."'";
			}

			$i++;
		}
		if (in_array($rowidcol, array('code', 'code_iso'))) {
			$sql .= " WHERE ".$rowidcol." = '".$db->escape($rowid)."'";
		} else {
			$sql .= " WHERE ".$rowidcol." = ".((int) $rowid);
		}
		if (in_array('entity', $listfieldmodify)) $sql .= " AND entity = '".getEntity($tabname[$id])."'";

		dol_syslog("actionmodify", LOG_DEBUG);
		//print $sql;
		$resql = $db->query($sql);
		if (!$resql)
		{
			setEventMessages($db->error(), null, 'errors');
		}
	}
	//$_GET["id"]=GETPOST('id', 'int');       // Force affichage dictionnaire en cours d'edition
}

if (GETPOST('actioncancel'))
{
	//$_GET["id"]=GETPOST('id', 'int');       // Force affichage dictionnaire en cours d'edition
}

if ($action == 'confirm_delete' && $confirm == 'yes')       // delete
{
	if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

	$sql = "DELETE FROM ".$tabname[$id]." WHERE ".$rowidcol."='".$db->escape($rowid)."'".($entity != '' ? " AND entity = ".(int) $entity : '');

	dol_syslog("delete", LOG_DEBUG);
	$result = $db->query($sql);
	if (!$result)
	{
		if ($db->errno() == 'DB_ERROR_CHILD_EXISTS')
		{
			setEventMessages($langs->transnoentities("ErrorRecordIsUsedByChild"), null, 'errors');
		} else {
			dol_print_error($db);
		}
	}
}

// activate
if ($action == $acts[0])
{
	if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

	if ($rowid) {
		$sql = "UPDATE ".$tabname[$id]." SET active = 1 WHERE ".$rowidcol."='".$db->escape($rowid)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	} elseif ($code) {
		$sql = "UPDATE ".$tabname[$id]." SET active = 1 WHERE code='".dol_escape_htmltag($code)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	}

	$result = $db->query($sql);
	if (!$result)
	{
		dol_print_error($db);
	}
}

// disable
if ($action == $acts[1])
{
	if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

	if ($rowid) {
		$sql = "UPDATE ".$tabname[$id]." SET active = 0 WHERE ".$rowidcol."='".$db->escape($rowid)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	} elseif ($code) {
		$sql = "UPDATE ".$tabname[$id]." SET active = 0 WHERE code='".dol_escape_htmltag($code)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	}

	$result = $db->query($sql);
	if (!$result)
	{
		dol_print_error($db);
	}
}

// favorite
if ($action == 'activate_favorite')
{
	if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

	if ($rowid) {
		$sql = "UPDATE ".$tabname[$id]." SET favorite = 1 WHERE ".$rowidcol."='".$db->escape($rowid)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	} elseif ($code) {
		$sql = "UPDATE ".$tabname[$id]." SET favorite = 1 WHERE code='".dol_escape_htmltag($code)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	}

	$result = $db->query($sql);
	if (!$result)
	{
		dol_print_error($db);
	}
}

// disable favorite
if ($action == 'disable_favorite')
{
	if ($tabrowid[$id]) { $rowidcol = $tabrowid[$id]; } else { $rowidcol = "rowid"; }

	if ($rowid) {
		$sql = "UPDATE ".$tabname[$id]." SET favorite = 0 WHERE ".$rowidcol."='".$db->escape($rowid)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	} elseif ($code) {
		$sql = "UPDATE ".$tabname[$id]." SET favorite = 0 WHERE code='".dol_escape_htmltag($code)."'".($entity != '' ? " AND entity = ".(int) $entity : '');
	}

	$result = $db->query($sql);
	if (!$result)
	{
		dol_print_error($db);
	}
}


/*
 * View
 */

$form = new Form($db);
$formadmin = new FormAdmin($db);

$title = $langs->trans("DictionarySetup");

llxHeaderLayout('', $title, $title);

$linkback = '';
if ($id)
{
	$title .= ' - '.$langs->trans($tablib[$id]);
	$linkback = '<a href="'.$_SERVER['PHP_SELF'].'">'.$langs->trans("BackToDictionaryList").'</a>';
}
$titlepicto = 'title_setup';
if ($id == 10 && GETPOST('from') == 'accountancy')
{
	$title = $langs->trans("MenuVatAccounts");
	$titlepicto = 'accountancy';
}
if ($id == 7 && GETPOST('from') == 'accountancy')
{
	$title = $langs->trans("MenuTaxAccounts");
	$titlepicto = 'accountancy';
}

print '<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<!--begin::Card-->
									<div class="card card-custom gutter-b">';

print load_fiche_titre_layout($title, $linkback, $titlepicto);

print '<div class="card-footer">';
if (empty($id))
{
	print '<p><span class="opacitymedium">'.$langs->trans("DictionaryDesc");
	print " ".$langs->trans("OnlyActiveElementsAreShown")."<br>\n";
	print '</span></p>';
}

print '</div>
			<div class="card-body">';


$param = '&id='.urlencode($id);
if ($search_country_id > 0) $param .= '&search_country_id='.urlencode($search_country_id);
if ($search_code != '')     $param .= '&search_code='.urlencode($search_country_id);
if ($entity != '') $param .= '&entity='.(int) $entity;
$paramwithsearch = $param;
if ($sortorder) $paramwithsearch .= '&sortorder='.urlencode($sortorder);
if ($sortfield) $paramwithsearch .= '&sortfield='.urlencode($sortfield);
if (GETPOST('from')) $paramwithsearch .= '&from='.urlencode(GETPOST('from', 'alpha'));


// Confirmation of the deletion of the line
if ($action == 'delete')
{
	print $form->formconfirm($_SERVER["PHP_SELF"].'?'.($page ? 'page='.$page.'&' : '').'rowid='.urlencode($rowid).'&code='.urlencode($code).$paramwithsearch, $langs->trans('DeleteLine'), $langs->trans('ConfirmDeleteLine'), 'confirm_delete', '', 0, 1);
}
//var_dump($elementList);

/*
 * Show a dictionary
 */
if ($id)
{
	// Single form

	// Complete search values request with sort criteria
	$sql = $tabsql[$id];

	if (!preg_match('/ WHERE /', $sql)) $sql .= " WHERE 1 = 1";
	if ($search_country_id > 0) $sql .= " AND c.rowid = ".$search_country_id;
	if ($search_code != '' && $id == 9)     $sql .= natural_search("code_iso", $search_code);
	elseif ($search_code != '' && $id == 28)    $sql .= natural_search("h.code", $search_code);
	elseif ($search_code != '' && $id == 32)    $sql .= natural_search("a.code", $search_code);
	elseif ($search_code != '' && $id == 3)     $sql .= natural_search("r.code_region", $search_code);
	elseif ($search_code != '' && $id != 9)     $sql .= natural_search("code", $search_code);

	if ($sortfield)
	{
		// If sort order is "country", we use country_code instead
		if ($sortfield == 'country') $sortfield = 'country_code';
		$sql .= $db->order($sortfield, $sortorder);
		$sql .= ", ";
		// Clear the required sort criteria for the tabsqlsort to be able to force it with selected value
		$tabsqlsort[$id] = preg_replace('/([a-z]+\.)?'.$sortfield.' '.$sortorder.',/i', '', $tabsqlsort[$id]);
		$tabsqlsort[$id] = preg_replace('/([a-z]+\.)?'.$sortfield.',/i', '', $tabsqlsort[$id]);
	} else {
		$sql .= " ORDER BY ";
	}
	$sql .= $tabsqlsort[$id];
	$sql .= $db->plimit($listlimit + 1, $offset);
	//print $sql;

	if (empty($tabfield[$id]))
	{
		dol_print_error($db, 'The table with id '.$id.' has no array tabfield defined');
		exit;
	}
	$fieldlist = explode(',', $tabfield[$id]);

	print '<form action="'.$_SERVER['PHP_SELF'].'?id='.$id.'" method="POST">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="from" value="'.dol_escape_htmltag(GETPOST('from', 'alpha')).'">';

	if ($id == 10 && empty($conf->global->FACTURE_TVAOPTION))
	{
		print info_admin($langs->trans("VATIsUsedIsOff", $langs->transnoentities("Setup"), $langs->transnoentities("CompanyFoundation")));
		print "<br>\n";
	}

	// Form to add a new line
	if ($tabname[$id])
	{
		$alabelisused = 0;
		$withentity = null;

		$fieldlist = explode(',', $tabfield[$id]);

		print '<table class="table table-bordered">';

		// Line for title
		$tdsoffields = '<tr class="">';
		foreach ($fieldlist as $field => $value)
		{
			if ($fieldlist[$field] == 'entity') {
				$withentity = getEntity($tabname[$id]);
				continue;
			}

			// Define field friendly name from its technical name
			$valuetoshow = ucfirst($fieldlist[$field]); // Par defaut
			$valuetoshow = $langs->trans($valuetoshow); // try to translate
			$class = '';

			if ($fieldlist[$field] == 'pos') { $valuetoshow = $langs->trans("Position"); $class = ''; }
			if ($fieldlist[$field] == 'source') { $valuetoshow = $langs->trans("Contact"); }
			if ($fieldlist[$field] == 'price') { $valuetoshow = $langs->trans("PriceUHT"); }
			if ($fieldlist[$field] == 'taux') {
				if ($tabname[$id] != MAIN_DB_PREFIX."c_revenuestamp") $valuetoshow = $langs->trans("Rate");
				else $valuetoshow = $langs->trans("Amount");
				$class = 'center';
			}
			if ($fieldlist[$field] == 'localtax1_type') { $valuetoshow = $langs->trans("UseLocalTax")." 2"; $class = "center"; $sortable = 0; }
			if ($fieldlist[$field] == 'localtax1') { $valuetoshow = $langs->trans("Rate")." 2"; $class = "center"; }
			if ($fieldlist[$field] == 'localtax2_type') { $valuetoshow = $langs->trans("UseLocalTax")." 3"; $class = "center"; $sortable = 0; }
			if ($fieldlist[$field] == 'localtax2') { $valuetoshow = $langs->trans("Rate")." 3"; $class = "center"; }
			if ($fieldlist[$field] == 'organization') { $valuetoshow = $langs->trans("Organization"); }
			if ($fieldlist[$field] == 'lang') { $valuetoshow = $langs->trans("Language"); }
			if ($fieldlist[$field] == 'type') {
				if ($tabname[$id] == MAIN_DB_PREFIX."c_paiement") $valuetoshow = $form->textwithtooltip($langs->trans("Type"), $langs->trans("TypePaymentDesc"), 2, 1, img_help(1, ''));
				else $valuetoshow = $langs->trans("Type");
			}
			if ($fieldlist[$field] == 'code') { $valuetoshow = $langs->trans("Code"); $class = ''; }
			if ($fieldlist[$field] == 'libelle' || $fieldlist[$field] == 'label')
			{
				$valuetoshow = $form->textwithtooltip($langs->trans("Label"), $langs->trans("LabelUsedByDefault"), 2, 1, img_help(1, ''));
			}
			if ($fieldlist[$field] == 'libelle_facture') {
				$valuetoshow = $form->textwithtooltip($langs->trans("LabelOnDocuments"), $langs->trans("LabelUsedByDefault"), 2, 1, img_help(1, ''));
			}
			if ($fieldlist[$field] == 'country') {
				if (in_array('region_id', $fieldlist)) { print '<td>&nbsp;</td>'; continue; }		// For region page, we do not show the country input
				$valuetoshow = $langs->trans("Country");
			}
			if ($fieldlist[$field] == 'recuperableonly') { $valuetoshow = $langs->trans("NPR"); $class = "center"; }
			if ($fieldlist[$field] == 'nbjour') { $valuetoshow = $langs->trans("NbOfDays"); }
			if ($fieldlist[$field] == 'type_cdr') { $valuetoshow = $langs->trans("AtEndOfMonth"); $class = "center"; }
			if ($fieldlist[$field] == 'decalage') { $valuetoshow = $langs->trans("Offset"); }
			if ($fieldlist[$field] == 'width' || $fieldlist[$field] == 'nx') { $valuetoshow = $langs->trans("Width"); }
			if ($fieldlist[$field] == 'height' || $fieldlist[$field] == 'ny') { $valuetoshow = $langs->trans("Height"); }
			if ($fieldlist[$field] == 'unit' || $fieldlist[$field] == 'metric') { $valuetoshow = $langs->trans("MeasuringUnit"); }
			if ($fieldlist[$field] == 'region_id' || $fieldlist[$field] == 'country_id') { $valuetoshow = ''; }
			if ($fieldlist[$field] == 'accountancy_code') { $valuetoshow = $langs->trans("AccountancyCode"); }
			if ($fieldlist[$field] == 'accountancy_code_sell') { $valuetoshow = $langs->trans("AccountancyCodeSell"); }
			if ($fieldlist[$field] == 'accountancy_code_buy') { $valuetoshow = $langs->trans("AccountancyCodeBuy"); }
			if ($fieldlist[$field] == 'pcg_version' || $fieldlist[$field] == 'fk_pcg_version') { $valuetoshow = $langs->trans("Pcg_version"); }
			if ($fieldlist[$field] == 'account_parent') { $valuetoshow = $langs->trans("Accountparent"); }
			if ($fieldlist[$field] == 'pcg_type') { $valuetoshow = $langs->trans("Pcg_type"); }
			if ($fieldlist[$field] == 'pcg_subtype') { $valuetoshow = $langs->trans("Pcg_subtype"); }
			if ($fieldlist[$field] == 'sortorder') { $valuetoshow = $langs->trans("SortOrder"); }
			if ($fieldlist[$field] == 'short_label') { $valuetoshow = $langs->trans("ShortLabel"); }
			if ($fieldlist[$field] == 'range_account') { $valuetoshow = $langs->trans("Range"); }
			if ($fieldlist[$field] == 'sens') { $valuetoshow = $langs->trans("Sens"); }
			if ($fieldlist[$field] == 'category_type') { $valuetoshow = $langs->trans("Calculated"); }
			if ($fieldlist[$field] == 'formula') { $valuetoshow = $langs->trans("Formula"); }
			if ($fieldlist[$field] == 'paper_size') { $valuetoshow = $langs->trans("PaperSize"); }
			if ($fieldlist[$field] == 'orientation') { $valuetoshow = $langs->trans("Orientation"); }
			if ($fieldlist[$field] == 'leftmargin') { $valuetoshow = $langs->trans("LeftMargin"); }
			if ($fieldlist[$field] == 'topmargin') { $valuetoshow = $langs->trans("TopMargin"); }
			if ($fieldlist[$field] == 'spacex') { $valuetoshow = $langs->trans("SpaceX"); }
			if ($fieldlist[$field] == 'spacey') { $valuetoshow = $langs->trans("SpaceY"); }
			if ($fieldlist[$field] == 'font_size') { $valuetoshow = $langs->trans("FontSize"); }
			if ($fieldlist[$field] == 'custom_x') { $valuetoshow = $langs->trans("CustomX"); }
			if ($fieldlist[$field] == 'custom_y') { $valuetoshow = $langs->trans("CustomY"); }
			if ($fieldlist[$field] == 'percent') { $valuetoshow = $langs->trans("Percentage"); }
			if ($fieldlist[$field] == 'affect') { $valuetoshow = $langs->trans("WithCounter"); }
			if ($fieldlist[$field] == 'delay') { $valuetoshow = $langs->trans("NoticePeriod"); }
			if ($fieldlist[$field] == 'newbymonth') { $valuetoshow = $langs->trans("NewByMonth"); }
			if ($fieldlist[$field] == 'fk_tva') { $valuetoshow = $langs->trans("VAT"); }
			if ($fieldlist[$field] == 'range_ik') { $valuetoshow = $langs->trans("RangeIk"); }
			if ($fieldlist[$field] == 'fk_c_exp_tax_cat') { $valuetoshow = $langs->trans("CarCategory"); }
			if ($fieldlist[$field] == 'revenuestamp_type') { $valuetoshow = $langs->trans('TypeOfRevenueStamp'); }
			if ($fieldlist[$field] == 'use_default') { $valuetoshow = $langs->trans('Default'); $class = 'center'; }
			if ($fieldlist[$field] == 'unit_type') { $valuetoshow = $langs->trans('TypeOfUnit'); }

			if ($id == 2 || $id == 43)	// Special case for state page
			{
				if ($fieldlist[$field] == 'region_id') { $valuetoshow = '&nbsp;'; $showfield = 1; }
				if ($fieldlist[$field] == 'region') { $valuetoshow = $langs->trans("Country").'/'.$langs->trans("Region"); $showfield = 1; }
			}

			if ($valuetoshow != '')
			{
				$tdsoffields .= '<td'.($class ? ' class="'.$class.'"' : '').'>';
				if (!empty($tabhelp[$id][$value]) && preg_match('/^http(s*):/i', $tabhelp[$id][$value])) $tdsoffields .= '<a href="'.$tabhelp[$id][$value].'" target="_blank">'.$valuetoshow.' '.img_help(1, $valuetoshow).'</a>';
				elseif (!empty($tabhelp[$id][$value])) $tdsoffields .= $form->textwithpicto($valuetoshow, $tabhelp[$id][$value]);
				else $tdsoffields .= $valuetoshow;
				$tdsoffields .= '</td>';
			}
			if ($fieldlist[$field] == 'libelle' || $fieldlist[$field] == 'label') $alabelisused = 1;
		}

		if ($id == 4) $tdsoffields .= '<td></td>';
		$tdsoffields .= '<td>';
		$tdsoffields .= '<input type="hidden" name="id" value="'.$id.'">';
		if (!is_null($withentity))
			$tdsoffields .= '<input type="hidden" name="entity" value="'.$withentity.'">';
		$tdsoffields .= '</td>';
		//$tdsoffields .= '<td style="min-width: 26px;"></td>';
		//$tdsoffields .= '<td style="min-width: 26px;"></td>';
		$tdsoffields .= '</tr>';

		print $tdsoffields;


		$obj = new stdClass();
		// If data was already input, we define them in obj to populate input fields.
		if (GETPOST('actionadd'))
		{
			foreach ($fieldlist as $key=>$val)
			{
				if (GETPOST($val) != '')
					$obj->$val = GETPOST($val);
			}
		}

		$tmpaction = 'create';
		$parameters = array('fieldlist'=>$fieldlist, 'tabname'=>$tabname[$id]);
		$reshook = $hookmanager->executeHooks('createDictionaryFieldlist', $parameters, $obj, $tmpaction); // Note that $action and $object may have been modified by some hooks
		$error = $hookmanager->error; $errors = $hookmanager->errors;

		if ($id == 3) unset($fieldlist[2]); // Remove field ??? if dictionary Regions

		// Line to enter new values
		print '<!-- line to add new entry -->';
		print '<tr class="">';

		if (empty($reshook))
		{
	   		fieldList($fieldlist, $obj, $tabname[$id], 'add');
		}

		if ($id == 4) print '<td></td>';
		print '<td class="center">';
		if ($action != 'edit')
		{
			print '<input type="submit" class="btn btn-info" name="actionadd" value="'.$langs->trans("Add").'">';
		}
		print '</td>';

		print "</tr>";

		print '</table>';
	}

	print '</form>';


	print '<br>';


	print '<form action="'.$_SERVER['PHP_SELF'].'?id='.$id.'" method="POST">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="from" value="'.dol_escape_htmltag(GETPOST('from', 'alpha')).'">';

	// List of available record in database
	dol_syslog("htdocs/admin/dict", LOG_DEBUG);

	$resql = $db->query($sql);
	if ($resql)
	{
		$num = $db->num_rows($resql);
		$i = 0;

		// There is several pages
		if ($num > $listlimit || $page)
		{
			print_fleche_navigation($page, $_SERVER["PHP_SELF"], $paramwithsearch, ($num > $listlimit), '<li class="pagination"><span>'.$langs->trans("Page").' '.($page + 1).'</span></li>');
			print '<div class="clearboth"></div>';
		}

		print '<table class="table table-bordered">';

		// Title line with search input fields
		print '<tr class="">';
		$filterfound = 0;
		foreach ($fieldlist as $field => $value)
		{
			if ($fieldlist[$field] == 'entity') continue;

			$showfield = 1; // By default

			if ($fieldlist[$field] == 'region_id' || $fieldlist[$field] == 'country_id') { $showfield = 0; }

			if ($showfield)
			{
				if ($value == 'country')
				{
					print '<td class="">';
					print $form->select_country($search_country_id, 'search_country_id', '', 28, 'maxwidth150 maxwidthonsmartphone');
					print '</td>';
					$filterfound++;
				} elseif ($value == 'code')
				{
					print '<td class="">';
					print '<input type="text" class="form-control" name="search_code" value="'.dol_escape_htmltag($search_code).'">';
					print '</td>';
					$filterfound++;
				} else {
					print '<td class="">';
					print '</td>';
				}
			}
		}
		if ($id == 4) print '<td></td>';
		print '<td class=""></td>';
		print '<td class="" colspan="2">';
		if ($filterfound)
		{
			$searchpicto = $form->showFilterAndCheckAddButtons(0);
			print $searchpicto;
		}
		print '</td>';
		print '</tr>';

		// Title of lines
		print '<tr class="">';
		foreach ($fieldlist as $field => $value)
		{
			if ($fieldlist[$field] == 'entity') continue;

			if (in_array($value, array('label', 'libelle', 'libelle_facture')) && empty($tabhelp[$id][$value])) {
				$tabhelp[$id][$value] = $langs->trans('LabelUsedByDefault');
			}

			// Determines the name of the field in relation to the possible names
			// in data dictionaries
			$showfield = 1; // By defaut
			$cssprefix = '';
			$sortable = 1;
			$valuetoshow = ucfirst($fieldlist[$field]); // By defaut
			$valuetoshow = $langs->trans($valuetoshow); // try to translate

			// Special cases
			if ($fieldlist[$field] == 'source') { $valuetoshow = $langs->trans("Contact"); }
			if ($fieldlist[$field] == 'price') { $valuetoshow = $langs->trans("PriceUHT"); }
			if ($fieldlist[$field] == 'taux') {
				if ($tabname[$id] != MAIN_DB_PREFIX."c_revenuestamp") $valuetoshow = $langs->trans("Rate");
				else $valuetoshow = $langs->trans("Amount");
				$cssprefix = 'center ';
			}
			if ($fieldlist[$field] == 'localtax1_type') { $valuetoshow = $langs->trans("UseLocalTax")." 2"; $cssprefix = "center "; $sortable = 0; }
			if ($fieldlist[$field] == 'localtax1') { $valuetoshow = $langs->trans("Rate")." 2"; $cssprefix = "center "; $sortable = 0; }
			if ($fieldlist[$field] == 'localtax2_type') { $valuetoshow = $langs->trans("UseLocalTax")." 3"; $cssprefix = "center "; $sortable = 0; }
			if ($fieldlist[$field] == 'localtax2') { $valuetoshow = $langs->trans("Rate")." 3"; $cssprefix = "center "; $sortable = 0; }
			if ($fieldlist[$field] == 'organization') { $valuetoshow = $langs->trans("Organization"); }
			if ($fieldlist[$field] == 'lang') { $valuetoshow = $langs->trans("Language"); }
			if ($fieldlist[$field] == 'type') { $valuetoshow = $langs->trans("Type"); }
			if ($fieldlist[$field] == 'code') { $valuetoshow = $langs->trans("Code"); }
			if ($fieldlist[$field] == 'pos') { $cssprefix = 'right '; $valuetoshow = $langs->trans("Position"); }
			if ($fieldlist[$field] == 'position') { $cssprefix = 'right '; $valuetoshow = $langs->trans("Position"); }
			if ($fieldlist[$field] == 'libelle' || $fieldlist[$field] == 'label') { $valuetoshow = $langs->trans("Label"); }
			if ($fieldlist[$field] == 'libelle_facture') { $valuetoshow = $langs->trans("LabelOnDocuments"); }
			if ($fieldlist[$field] == 'country') { $valuetoshow = $langs->trans("Country"); }
			if ($fieldlist[$field] == 'recuperableonly') { $valuetoshow = $langs->trans("NPR"); $cssprefix = "center "; }
			if ($fieldlist[$field] == 'nbjour') { $valuetoshow = $langs->trans("NbOfDays"); }
			if ($fieldlist[$field] == 'type_cdr') { $valuetoshow = $langs->trans("AtEndOfMonth"); $cssprefix = "center "; }
			if ($fieldlist[$field] == 'decalage') { $valuetoshow = $langs->trans("Offset"); }
			if ($fieldlist[$field] == 'width' || $fieldlist[$field] == 'nx') { $valuetoshow = $langs->trans("Width"); }
			if ($fieldlist[$field] == 'height' || $fieldlist[$field] == 'ny') { $valuetoshow = $langs->trans("Height"); }
			if ($fieldlist[$field] == 'unit' || $fieldlist[$field] == 'metric') { $valuetoshow = $langs->trans("MeasuringUnit"); }
			if ($fieldlist[$field] == 'accountancy_code') { $valuetoshow = $langs->trans("AccountancyCode"); }
			if ($fieldlist[$field] == 'accountancy_code_sell') { $valuetoshow = $langs->trans("AccountancyCodeSell"); $sortable = 0; }
			if ($fieldlist[$field] == 'accountancy_code_buy') { $valuetoshow = $langs->trans("AccountancyCodeBuy"); $sortable = 0; }
			if ($fieldlist[$field] == 'fk_pcg_version') { $valuetoshow = $langs->trans("Pcg_version"); }
			if ($fieldlist[$field] == 'account_parent') { $valuetoshow = $langs->trans("Accountsparent"); }
			if ($fieldlist[$field] == 'pcg_type') { $valuetoshow = $langs->trans("Pcg_type"); }
			if ($fieldlist[$field] == 'pcg_subtype') { $valuetoshow = $langs->trans("Pcg_subtype"); }
			if ($fieldlist[$field] == 'sortorder') { $valuetoshow = $langs->trans("SortOrder"); }
			if ($fieldlist[$field] == 'short_label') { $valuetoshow = $langs->trans("ShortLabel"); }
			if ($fieldlist[$field] == 'range_account') { $valuetoshow = $langs->trans("Range"); }
			if ($fieldlist[$field] == 'sens') { $valuetoshow = $langs->trans("Sens"); }
			if ($fieldlist[$field] == 'category_type') { $valuetoshow = $langs->trans("Calculated"); }
			if ($fieldlist[$field] == 'formula') { $valuetoshow = $langs->trans("Formula"); }
			if ($fieldlist[$field] == 'paper_size') { $valuetoshow = $langs->trans("PaperSize"); }
			if ($fieldlist[$field] == 'orientation') { $valuetoshow = $langs->trans("Orientation"); }
			if ($fieldlist[$field] == 'leftmargin') { $valuetoshow = $langs->trans("LeftMargin"); }
			if ($fieldlist[$field] == 'topmargin') { $valuetoshow = $langs->trans("TopMargin"); }
			if ($fieldlist[$field] == 'spacex') { $valuetoshow = $langs->trans("SpaceX"); }
			if ($fieldlist[$field] == 'spacey') { $valuetoshow = $langs->trans("SpaceY"); }
			if ($fieldlist[$field] == 'font_size') { $valuetoshow = $langs->trans("FontSize"); }
			if ($fieldlist[$field] == 'custom_x') { $valuetoshow = $langs->trans("CustomX"); }
			if ($fieldlist[$field] == 'custom_y') { $valuetoshow = $langs->trans("CustomY"); }
			if ($fieldlist[$field] == 'percent') { $valuetoshow = $langs->trans("Percentage"); }
			if ($fieldlist[$field] == 'affect') { $valuetoshow = $langs->trans("WithCounter"); }
			if ($fieldlist[$field] == 'delay') { $valuetoshow = $langs->trans("NoticePeriod"); }
			if ($fieldlist[$field] == 'newbymonth') { $valuetoshow = $langs->trans("NewByMonth"); }
			if ($fieldlist[$field] == 'fk_tva') { $valuetoshow = $langs->trans("VAT"); }
			if ($fieldlist[$field] == 'range_ik') { $valuetoshow = $langs->trans("RangeIk"); }
			if ($fieldlist[$field] == 'fk_c_exp_tax_cat') { $valuetoshow = $langs->trans("CarCategory"); }
			if ($fieldlist[$field] == 'revenuestamp_type') { $valuetoshow = $langs->trans('TypeOfRevenueStamp'); }
			if ($fieldlist[$field] == 'use_default') { $valuetoshow = $langs->trans('Default'); $cssprefix = 'center '; }
			if ($fieldlist[$field] == 'unit_type') { $valuetoshow = $langs->trans('TypeOfUnit'); }

			if ($fieldlist[$field] == 'region_id' || $fieldlist[$field] == 'country_id') { $showfield = 0; }

			// Show field title
			if ($showfield)
			{
				if (!empty($tabhelp[$id][$value]) && preg_match('/^http(s*):/i', $tabhelp[$id][$value])) $newvaluetoshow = '<a href="'.$tabhelp[$id][$value].'" target="_blank">'.$valuetoshow.' '.img_help(1, $valuetoshow).'</a>';
				elseif (!empty($tabhelp[$id][$value])) $newvaluetoshow = $form->textwithpicto($valuetoshow, $tabhelp[$id][$value]);
				else $newvaluetoshow = $valuetoshow;

				print getTitleFieldOfListLayout($newvaluetoshow, 0, $_SERVER["PHP_SELF"], ($sortable ? $fieldlist[$field] : ''), ($page ? 'page='.$page.'&' : ''), $param, '', $sortfield, $sortorder, $cssprefix);
			}
		}
		// Favorite - Only activated on country dictionary
		if ($id == 4) print getTitleFieldOfListLayout($langs->trans("Favorite"), 0, $_SERVER["PHP_SELF"], "favorite", ($page ? 'page='.$page.'&' : ''), $param, 'align="center"', $sortfield, $sortorder);

		print getTitleFieldOfListLayout($langs->trans("Status"), 0, $_SERVER["PHP_SELF"], "active", ($page ? 'page='.$page.'&' : ''), $param, 'align="center"', $sortfield, $sortorder);
		print getTitleFieldOfListLayout('');
		print getTitleFieldOfListLayout('');
		print '</tr>';

		if ($num)
		{
			// Lines with values
			while ($i < $num)
			{
				$obj = $db->fetch_object($resql);
				//print_r($obj);
				print '<tr class="oddeven" id="rowid-'.$obj->rowid.'">';
				if ($action == 'edit' && ($rowid == (!empty($obj->rowid) ? $obj->rowid : $obj->code)))
				{
					$tmpaction = 'edit';
					$parameters = array('fieldlist'=>$fieldlist, 'tabname'=>$tabname[$id]);
					$reshook = $hookmanager->executeHooks('editDictionaryFieldlist', $parameters, $obj, $tmpaction); // Note that $action and $object may have been modified by some hooks
					$error = $hookmanager->error; $errors = $hookmanager->errors;

					// Show fields
					if (empty($reshook)) {
						$withentity = fieldList($fieldlist, $obj, $tabname[$id], 'edit');
					}

					print '<td colspan="3" class="center">';
					print '<div name="'.(!empty($obj->rowid) ? $obj->rowid : $obj->code).'"></div>';
					print '<input type="hidden" name="page" value="'.dol_escape_htmltag($page).'">';
					print '<input type="hidden" name="rowid" value="'.dol_escape_htmltag($rowid).'">';
					if (!is_null($withentity))
						print '<input type="hidden" name="entity" value="'.$withentity.'">';
					print '<input type="submit" class="button" name="actionmodify" value="'.$langs->trans("Modify").'">';
					print '<input type="submit" class="button button-cancel" name="actioncancel" value="'.$langs->trans("Cancel").'">';
					print '</td>';
				} else {
				  	$tmpaction = 'view';
					$parameters = array('fieldlist'=>$fieldlist, 'tabname'=>$tabname[$id]);
					$reshook = $hookmanager->executeHooks('viewDictionaryFieldlist', $parameters, $obj, $tmpaction); // Note that $action and $object may have been modified by some hooks

					$error = $hookmanager->error; $errors = $hookmanager->errors;

					if (empty($reshook))
					{
						$withentity = null;

						foreach ($fieldlist as $field => $value)
						{
							//var_dump($fieldlist);
							$class = '';
							$showfield = 1;
							$valuetoshow = $obj->{$fieldlist[$field]};

							if ($fieldlist[$field] == 'entity') {
								$withentity = $valuetoshow;
								continue;
							}

							if ($value == 'element') {
								$valuetoshow = isset($elementList[$valuetoshow]) ? $elementList[$valuetoshow] : $valuetoshow;
							} elseif ($value == 'source') {
								$valuetoshow = isset($sourceList[$valuetoshow]) ? $sourceList[$valuetoshow] : $valuetoshow;
							} elseif ($valuetoshow == 'all') {
								$valuetoshow = $langs->trans('All');
							} elseif ($fieldlist[$field] == 'country') {
								if (empty($obj->country_code))
								{
									$valuetoshow = '-';
								} else {
									$key = $langs->trans("Country".strtoupper($obj->country_code));
									$valuetoshow = ($key != "Country".strtoupper($obj->country_code) ? $obj->country_code." - ".$key : $obj->country);
								}
							} elseif ($fieldlist[$field] == 'recuperableonly' || $fieldlist[$field] == 'deductible' || $fieldlist[$field] == 'category_type') {
								$valuetoshow = yn($valuetoshow);
								$class = "center";
							} elseif ($fieldlist[$field] == 'type_cdr') {
								if (empty($valuetoshow)) $valuetoshow = $langs->trans('None');
								elseif ($valuetoshow == 1) $valuetoshow = $langs->trans('AtEndOfMonth');
								elseif ($valuetoshow == 2) $valuetoshow = $langs->trans('CurrentNext');
								$class = "center";
							} elseif ($fieldlist[$field] == 'price' || preg_match('/^amount/i', $fieldlist[$field])) {
								$valuetoshow = price($valuetoshow);
							}
							if ($value == 'private')
							{
								$valuetoshow = yn($elementList[$valuetoshow]);
							} elseif ($fieldlist[$field] == 'libelle_facture') {
								$langs->load("bills");
								$key = $langs->trans("PaymentCondition".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "PaymentCondition".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
								$valuetoshow = nl2br($valuetoshow);
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_country') {
								$key = $langs->trans("Country".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "Country".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_availability') {
								$langs->load("propal");
								$key = $langs->trans("AvailabilityType".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "AvailabilityType".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_actioncomm') {
								$key = $langs->trans("Action".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "Action".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif (!empty($obj->code_iso) && $fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_currencies') {
								$key = $langs->trans("Currency".strtoupper($obj->code_iso));
								$valuetoshow = ($obj->code_iso && $key != "Currency".strtoupper($obj->code_iso) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_typent') {
								$key = $langs->trans(strtoupper($obj->code));
								$valuetoshow = ($key != strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_prospectlevel') {
								$key = $langs->trans(strtoupper($obj->code));
								$valuetoshow = ($key != strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_civility') {
								$key = $langs->trans("Civility".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "Civility".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_type_contact') {
								$langs->load('agenda');
								$key = $langs->trans("TypeContact_".$obj->element."_".$obj->source."_".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "TypeContact_".$obj->element."_".$obj->source."_".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_payment_term') {
								$langs->load("bills");
								$key = $langs->trans("PaymentConditionShort".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "PaymentConditionShort".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_paiement') {
								$langs->load("bills");
								$key = $langs->trans("PaymentType".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "PaymentType".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'type' && $tabname[$id] == MAIN_DB_PREFIX.'c_paiement') {
								$payment_type_list = array(0=>$langs->trans('PaymentTypeCustomer'), 1=>$langs->trans('PaymentTypeSupplier'), 2=>$langs->trans('PaymentTypeBoth'));
								$valuetoshow = $payment_type_list[$valuetoshow];
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_input_reason') {
								$key = $langs->trans("DemandReasonType".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "DemandReasonType".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_input_method') {
								$langs->load("orders");
								$key = $langs->trans($obj->code);
								$valuetoshow = ($obj->code && $key != $obj->code) ? $key : $obj->{$fieldlist[$field]};
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_shipment_mode') {
								$langs->load("sendings");
								$key = $langs->trans("SendingMethod".strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != "SendingMethod".strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'libelle' && $tabname[$id] == MAIN_DB_PREFIX.'c_paper_format')
							{
								$key = $langs->trans('PaperFormat'.strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != 'PaperFormat'.strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_type_fees')
							{
								$langs->load('trips');
								$key = $langs->trans(strtoupper($obj->code));
								$valuetoshow = ($obj->code && $key != strtoupper($obj->code) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'region_id' || $fieldlist[$field] == 'country_id') {
								$showfield = 0;
							} elseif ($fieldlist[$field] == 'unicode') {
								$valuetoshow = $langs->getCurrencySymbol($obj->code, 1);
							} elseif ($fieldlist[$field] == 'label' && $tabname[$_GET["id"]] == MAIN_DB_PREFIX.'c_units') {
								$langs->load("products");
								$valuetoshow = $langs->trans($obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'short_label' && $tabname[$_GET["id"]] == MAIN_DB_PREFIX.'c_units') {
								$langs->load("products");
								$valuetoshow = $langs->trans($obj->{$fieldlist[$field]});
							} elseif (($fieldlist[$field] == 'unit') && ($tabname[$id] == MAIN_DB_PREFIX.'c_paper_format'))
							{
								$key = $langs->trans('SizeUnit'.strtolower($obj->unit));
								$valuetoshow = ($obj->code && $key != 'SizeUnit'.strtolower($obj->unit) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'localtax1' || $fieldlist[$field] == 'localtax2') {
								$class = "center";
							} elseif ($fieldlist[$field] == 'localtax1_type') {
								if ($obj->localtax1 != 0)
									$valuetoshow = $localtax_typeList[$valuetoshow];
								else $valuetoshow = '';
								$class = "center";
							} elseif ($fieldlist[$field] == 'localtax2_type') {
								if ($obj->localtax2 != 0)
									$valuetoshow = $localtax_typeList[$valuetoshow];
								else $valuetoshow = '';
								$class = "center";
							} elseif ($fieldlist[$field] == 'taux') {
								$valuetoshow = price($valuetoshow, 0, $langs, 0, 0);
								$class = "center";
							} elseif (in_array($fieldlist[$field], array('recuperableonly'))) {
								$class = "center";
							} elseif ($fieldlist[$field] == 'accountancy_code' || $fieldlist[$field] == 'accountancy_code_sell' || $fieldlist[$field] == 'accountancy_code_buy') {
								$valuetoshow = length_accountg($valuetoshow);
							} elseif ($fieldlist[$field] == 'fk_tva')
							{
								foreach ($form->cache_vatrates as $key => $Tab)
								{
									if ($form->cache_vatrates[$key]['rowid'] == $valuetoshow)
									{
										$valuetoshow = $form->cache_vatrates[$key]['libtva'];
										break;
									}
								}
							} elseif ($fieldlist[$field] == 'fk_c_exp_tax_cat')
							{
								$valuetoshow = getDictvalue(MAIN_DB_PREFIX.'c_exp_tax_cat', 'label', $valuetoshow);
								$valuetoshow = $langs->trans($valuetoshow);
							} elseif ($tabname[$id] == MAIN_DB_PREFIX.'c_exp_tax_cat')
							{
								$valuetoshow = $langs->trans($valuetoshow);
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_units')
							{
								$langs->load('other');
								$key = $langs->trans($obj->label);
								$valuetoshow = ($obj->label && $key != strtoupper($obj->label) ? $key : $obj->{$fieldlist[$field]});
							} elseif ($fieldlist[$field] == 'code' && $id == 3) {
								$valuetoshow = $obj->state_code;
							} elseif ($fieldlist[$field] == 'label' && $tabname[$id] == MAIN_DB_PREFIX.'c_product_nature') {
								$langs->load("products");
								$valuetoshow = $langs->trans($obj->{$fieldlist[$field]});
							}
							$class .= ($class ? ' ' : '').'tddict';
							if ($fieldlist[$field] == 'note' && $id == 10) $class .= ' tdoverflowmax200';
							if ($fieldlist[$field] == 'tracking') $class .= ' tdoverflowauto';
							if ($fieldlist[$field] == 'position') $class .= ' right';
							if ($fieldlist[$field] == 'localtax1_type') $class .= ' nowrap';
							if ($fieldlist[$field] == 'localtax2_type') $class .= ' nowrap';
							if ($fieldlist[$field] == 'pos') $class .= ' right';
							if ($fieldlist[$field] == 'use_default') $class .= ' center';
							// Show value for field
							if ($showfield) print '<!-- '.$fieldlist[$field].' --><td class="'.$class.'">'.$valuetoshow.'</td>';
						}
					}

					// Can an entry be erased or disabled ?
					// all true by default
					$iserasable = 1;
					$canbedisabled = 1;
					$canbemodified = 1;
					if (isset($obj->code) && $id != 10 && $id != 42)
					{
						if (($obj->code == '0' || $obj->code == '' || preg_match('/unknown/i', $obj->code))) { $iserasable = 0; $canbedisabled = 0; } elseif ($obj->code == 'RECEP') { $iserasable = 0; $canbedisabled = 0; } elseif ($obj->code == 'EF0') { $iserasable = 0; $canbedisabled = 0; }
					}
					if ($id == 25 && in_array($obj->code, array('banner', 'blogpost', 'other', 'page')))
					{
						$iserasable = 0; $canbedisabled = 0;
						if (in_array($obj->code, array('banner'))) $canbedisabled = 1;
					}
					if (isset($obj->type) && in_array($obj->type, array('system', 'systemauto'))) { $iserasable = 0; }
					if (in_array($obj->code, array('AC_OTH', 'AC_OTH_AUTO')) || in_array($obj->type, array('systemauto'))) { $canbedisabled = 0; $canbedisabled = 0; }
					$canbemodified = $iserasable;

					if ($obj->code == 'RECEP') $canbemodified = 1;
					if ($tabname[$id] == MAIN_DB_PREFIX."c_actioncomm") $canbemodified = 1;

					// Build Url. The table is id=, the id of line is rowid=
					$rowidcol = $tabrowid[$id];
					// If rowidcol not defined
					if (empty($rowidcol) || in_array($id, array(6, 7, 8, 13, 17, 19, 27, 32))) $rowidcol = 'rowid';
					$url = $_SERVER["PHP_SELF"].'?'.($page ? 'page='.$page.'&' : '').'sortfield='.$sortfield.'&sortorder='.$sortorder.'&rowid='.((!empty($obj->{$rowidcol}) || $obj->{$rowidcol} == '0') ? $obj->{$rowidcol}:(!empty($obj->code) ?urlencode($obj->code) : '')).'&code='.(!empty($obj->code) ?urlencode($obj->code) : '');
					if (!empty($param)) $url .= '&'.$param;
					if (!is_null($withentity)) $url .= '&entity='.$withentity;
					$url .= '&';

					// Favorite
					// Only activated on country dictionary
					if ($id == 4)
					{
						print '<td class="nowrap center">';
						if ($iserasable) print '<a class="reposition" href="'.$url.'action='.$acts[$obj->favorite].'_favorite">'.$actl[$obj->favorite].'</a>';
						else print $langs->trans("AlwaysActive");
						print '</td>';
					}

					// Active
					print '<td class="nowrap center">';
					if ($canbedisabled) print '<a class="reposition" href="'.$url.'action='.$acts[$obj->active].'">'.$actl[$obj->active].'</a>';
					else {
				 		if (in_array($obj->code, array('AC_OTH', 'AC_OTH_AUTO'))) print $langs->trans("AlwaysActive");
				 		elseif (isset($obj->type) && in_array($obj->type, array('systemauto')) && empty($obj->active)) print $langs->trans("Deprecated");
				  		elseif (isset($obj->type) && in_array($obj->type, array('system')) && !empty($obj->active) && $obj->code != 'AC_OTH') print $langs->trans("UsedOnlyWithTypeOption");
						else print $langs->trans("AlwaysActive");
					}
					print "</td>";

					// Modify link
					if ($canbemodified) print '<td align="center"><a class="reposition editfielda btn btn-info" href="'.$url.'action=edit&token='.newToken().'">'.img_edit().'</a></td>';
					else print '<td>&nbsp;</td>';

					// Delete link
					if ($iserasable)
					{
						print '<td class="center">';
						if ($user->admin) print '<a class="btn btn-danger" href="'.$url.'action=delete&token='.newToken().'">'.img_delete().'</a>';
						//else print '<a href="#">'.img_delete().'</a>';    // Some dictionary can be edited by other profile than admin
						print '</td>';
					} else print '<td>&nbsp;</td>';

					print "</tr>\n";
				}
				$i++;
			}
		}

		print '</table>';
	} else {
		dol_print_error($db);
	}

	print '</form>';
} else {
	/*
     * Show list of dictionary to show
     */

	$lastlineisempty = false;

	print '<table class="table table-bordered">';
	print '<tr class="">';
	print '<td>'.$langs->trans("Dictionary").'</td>';
	print '<td>'.$langs->trans("Table").'</td>';
	print '</tr>';

	$showemptyline = '';
	foreach ($taborder as $i)
	{
		if (isset($tabname[$i]) && empty($tabcond[$i])) continue;

		if ($i)
		{
			if ($showemptyline)
			{
				print '<tr class=""><td width="50%">&nbsp;</td><td>&nbsp;</td></tr>';
				$showemptyline = 0;
			}


			$value = $tabname[$i];
			print '<tr class=""><td width="50%">';
			if (!empty($tabcond[$i]))
			{
				print '<a href="'.$_SERVER["PHP_SELF"].'?id='.$i.'">'.$langs->trans($tablib[$i]).'</a>';
			} else {
				print $langs->trans($tablib[$i]);
			}
			print '</td>';
			//print '<td>';
			/*if (empty($tabcond[$i]))
             {
             print info_admin($langs->trans("DictionaryDisabledSinceNoModuleNeedIt"),1);
             }*/
			//print '</td>';
			print '<td>'.$tabname[$i].'</td></tr>';
			$lastlineisempty = false;
		} else {
			if (!$lastlineisempty)
			{
				$showemptyline = 1;
				$lastlineisempty = true;
			}
		}
	}
	print '</table>';
}

print '</div></div>';

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


/**
 *	Show fields in insert/edit mode
 *
 * 	@param		array		$fieldlist		Array of fields
 * 	@param		Object		$obj			If we show a particular record, obj is filled with record fields
 *  @param		string		$tabname		Name of SQL table
 *  @param		string		$context		'add'=Output field for the "add form", 'edit'=Output field for the "edit form", 'hide'=Output field for the "add form" but we dont want it to be rendered
 *	@return		string						'' or value of entity into table
 */
function fieldList($fieldlist, $obj = '', $tabname = '', $context = '')
{
	global $conf, $langs, $db, $mysoc;
	global $form;
	global $region_id;
	global $elementList, $sourceList, $localtax_typeList;

	$formadmin = new FormAdmin($db);
	$formcompany = new FormCompany($db);
	$formaccounting = new FormAccounting($db);

	$withentity = '';

	foreach ($fieldlist as $field => $value)
	{
		if ($fieldlist[$field] == 'entity') {
			$withentity = $obj->{$fieldlist[$field]};
			continue;
		}

		if (in_array($fieldlist[$field], array('code', 'libelle', 'type')) && $tabname == MAIN_DB_PREFIX."c_actioncomm" && in_array($obj->type, array('system', 'systemauto')))
		{
			$hidden = (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'');
			print '<td>';
			print '<input type="hidden" name="'.$fieldlist[$field].'" value="'.$hidden.'">';
			print $langs->trans($hidden);
			print '</td>';
		} elseif ($fieldlist[$field] == 'country')
		{
			if (in_array('region_id', $fieldlist))
			{
				print '<td>';
				print '</td>';
				continue;
			}	// For state page, we do not show the country input (we link to region, not country)
			print '<td>';
			$fieldname = 'country';
			print $form->select_country((!empty($obj->country_code) ? $obj->country_code : (!empty($obj->country) ? $obj->country : '')), $fieldname, '', 28, 'maxwidth150 maxwidthonsmartphone');
			print '</td>';
		} elseif ($fieldlist[$field] == 'country_id')
		{
			if (!in_array('country', $fieldlist))	// If there is already a field country, we don't show country_id (avoid duplicate)
			{
				$country_id = (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]} : 0);
				print '<td class="tdoverflowmax100">';
				print '<input type="hidden" name="'.$fieldlist[$field].'" value="'.$country_id.'">';
				print '</td>';
			}
		} elseif ($fieldlist[$field] == 'region')
		{
			print '<td>';
			$formcompany->select_region($region_id, 'region');
			print '</td>';
		}elseif ($fieldlist[$field] == 'state')
		{
			print '<td>';
			$formcompany->select_departement($state_id, '0' ,'state');
			print '</td>';	
		}elseif ($fieldlist[$field] == 'city')
		{
			print '<td>';
			$formcompany->select_city($state_id, '0' ,'city');
			print '</td>';	
		}elseif ($fieldlist[$field] == 'brand')
		{
			
			print '<td>';
			$formcompany->select_brand($obj->fk_brand, '0' ,'brand');
			print '</td>';	
		}elseif ($fieldlist[$field] == 'category')
		{
			
			print '<script type="text/javascript">
						
						$(document).ready(function () {
	                        $("select[name=brand]").change(function() {
	                        	var brand = $(this).val();
	                        	
	                        	$.ajax({
								  dataType: "html",
								  url: "getcategorybybrand.php",
								  data: { brand: brand},
								  success: function(html) {
								  	//alert(html);
								  	$("select[name=category]").html(html)
									
									
								  }
							});
	                        });
	                    });    ';
	            print '</script>'."\n";  
			//print_r($obj);
			print '<td>';
			if($context == 'add'){
				print '<select class="form-control" id="category" name="category"><option value="">Select Brand</option></select>';
			}else{
				$formcompany->select_family($family_id, $obj->fk_brand ,'category');
			}
			print '</td>';
		}elseif ($fieldlist[$field] == 'subcategory')
		{
			print '<script type="text/javascript">
						
						$(document).ready(function () {
	                        
	                        $("select[name=brand]").change(function() {
	                        	var brand = $(this).val();
	                        	
	                        	$.ajax({
								  dataType: "html",
								  url: "getcategorybybrand.php",
								  data: { brand: brand},
								  success: function(html) {
								  	//alert(html);
								  	$("select[name=category]").html(html)
									
									
								  }
								});
	                        });

	                        $("select[name=category]").change(function() {
	                        	var category = $(this).val();
	                        	var brand = $("select[name=brand]").val();
	                        	$.ajax({
								  dataType: "html",
								  url: "getsubcategorybybrand.php",
								  data: { brand: brand, category: category},
								  success: function(html) {
								  //	alert(html);
								  	$("select[name=subcategory]").html(html)
									
									
								  }
							});
	                        });
	                    });    ';
	            print '</script>'."\n";  
	           // print_r($obj);
			print '<td>';
			if($context == 'add'){
				print '<select class="form-control" id="subcategory" name="subcategory"><option value="">Select Category</option></select>';
			}else{
				$formcompany->select_subfamily($obj->fk_subfamily, $obj->fk_brand, $obj->fk_family ,'subcategory');
			}
			print '</td>';				
		} elseif ($fieldlist[$field] == 'region_id')
		{
			$region_id = (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:0);
			print '<td>';
			print '<input type="hidden" name="'.$fieldlist[$field].'" value="'.$region_id.'">';
			print '</td>';
		} elseif ($fieldlist[$field] == 'lang')
		{
			print '<td>';
			print $formadmin->select_language($conf->global->MAIN_LANG_DEFAULT, 'lang');
			print '</td>';
		}
		// The type of the element (for contact types)
		elseif ($fieldlist[$field] == 'element')
		{
			print '<td>';
			print $form->selectarray('element', $elementList, (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''));
			print '</td>';
		}
		// The source of the element (for contact types)
		elseif ($fieldlist[$field] == 'source')
		{
			print '<td>';
			print $form->selectarray('source', $sourceList, (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''));
			print '</td>';
		} elseif ($fieldlist[$field] == 'private')
		{
			print '<td>';
			print $form->selectyesno("private", (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''));
			print '</td>';
		} elseif ($fieldlist[$field] == 'type' && $tabname == MAIN_DB_PREFIX."c_actioncomm")
		{
			$type = (!empty($obj->type) ? $obj->type : 'user'); // Check if type is different of 'user' (external module)
			print '<td>';
			print $type.'<input type="hidden" name="type" value="'.$type.'">';
			print '</td>';
		} elseif ($fieldlist[$field] == 'type' && $tabname == MAIN_DB_PREFIX.'c_paiement')
		{
			print '<td>';
			$select_list = array(0=>$langs->trans('PaymentTypeCustomer'), 1=>$langs->trans('PaymentTypeSupplier'), 2=>$langs->trans('PaymentTypeBoth'));
			print $form->selectarray($fieldlist[$field], $select_list, (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'2'));
			print '</td>';
		} elseif ($fieldlist[$field] == 'recuperableonly' || $fieldlist[$field] == 'type_cdr' || $fieldlist[$field] == 'deductible' || $fieldlist[$field] == 'category_type') {
			if ($fieldlist[$field] == 'type_cdr') print '<td class="center">';
			else print '<td>';
			if ($fieldlist[$field] == 'type_cdr') {
				print $form->selectarray($fieldlist[$field], array(0=>$langs->trans('None'), 1=>$langs->trans('AtEndOfMonth'), 2=>$langs->trans('CurrentNext')), (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''));
			} else {
				print $form->selectyesno($fieldlist[$field], (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''), 1);
			}
			print '</td>';
		} elseif (in_array($fieldlist[$field], array('nbjour', 'decalage', 'taux', 'localtax1', 'localtax2'))) {
			$class = "left";
			if (in_array($fieldlist[$field], array('taux', 'localtax1', 'localtax2'))) $class = "center"; // Fields aligned on right
			print '<td class="'.$class.'">';
			print '<input type="text" class="form-control" value="'.(isset($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]} : '').'" size="3" name="'.$fieldlist[$field].'">';
			print '</td>';
		} elseif (in_array($fieldlist[$field], array('libelle_facture'))) {
			print '<td>';
			$transfound = 0;
			$transkey = '';
			// Special case for labels
			if ($tabname == MAIN_DB_PREFIX.'c_payment_term')
			{
				$langs->load("bills");
				$transkey = "PaymentCondition".strtoupper($obj->code);
				if ($langs->trans($transkey) != $transkey)
				{
					$transfound = 1;
					print $form->textwithpicto($langs->trans($transkey), $langs->trans("GoIntoTranslationMenuToChangeThis"));
				}
			}
			if (!$transfound)
			{
				print '<textarea cols="30" rows="'.ROWS_2.'" class="form-control" name="'.$fieldlist[$field].'">'.(!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'').'</textarea>';
			} else {
				print '<input type="hidden" name="'.$fieldlist[$field].'" value="'.$transkey.'">';
			}
			print '</td>';
		} elseif ($fieldlist[$field] == 'price' || preg_match('/^amount/i', $fieldlist[$field])) {
			print '<td><input type="text" class="form-control" value="'.price((!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'')).'" name="'.$fieldlist[$field].'"></td>';
		} elseif ($fieldlist[$field] == 'code' && isset($obj->{$fieldlist[$field]})) {
			print '<td><input type="text" class="form-control " value="'.(!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'').'" name="'.$fieldlist[$field].'"></td>';
		} elseif ($fieldlist[$field] == 'unit') {
			print '<td>';
			$units = array(
					'mm' => $langs->trans('SizeUnitmm'),
					'cm' => $langs->trans('SizeUnitcm'),
					'point' => $langs->trans('SizeUnitpoint'),
					'inch' => $langs->trans('SizeUnitinch')
			);
			print $form->selectarray('unit', $units, (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''), 0, 0, 0);
			print '</td>';
		}
		// Le type de taxe locale
		elseif ($fieldlist[$field] == 'localtax1_type' || $fieldlist[$field] == 'localtax2_type')
		{
			print '<td class="center">';
			print $form->selectarray($fieldlist[$field], $localtax_typeList, (!empty($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:''));
			print '</td>';
		} elseif ($fieldlist[$field] == 'accountancy_code' || $fieldlist[$field] == 'accountancy_code_sell' || $fieldlist[$field] == 'accountancy_code_buy')
		{
			print '<td>';
			if (!empty($conf->accounting->enabled))
			{
				$fieldname = $fieldlist[$field];
				$accountancy_account = (!empty($obj->$fieldname) ? $obj->$fieldname : 0);
				print $formaccounting->select_account($accountancy_account, '.'.$fieldlist[$field], 1, '', 1, 1, 'maxwidth200 maxwidthonsmartphone');
			} else {
				$fieldname = $fieldlist[$field];
				print '<input type="text" size="10" class="form-control" value="'.(isset($obj->$fieldname) ? $obj->$fieldname : '').'" name="'.$fieldlist[$field].'">';
			}
			print '</td>';
		} elseif ($fieldlist[$field] == 'fk_tva')
		{
			print '<td>';
			print $form->load_tva('fk_tva', $obj->taux, $mysoc, new Societe($db), 0, 0, '', false, -1);
			print '</td>';
		} elseif ($fieldlist[$field] == 'fk_c_exp_tax_cat')
		{
			print '<td>';
			print $form->selectExpenseCategories($obj->fk_c_exp_tax_cat);
			print '</td>';
		} elseif ($fieldlist[$field] == 'fk_range')
		{
			print '<td>';
			print $form->selectExpenseRanges($obj->fk_range);
			print '</td>';
		} else {
			$fieldValue = isset($obj->{$fieldlist[$field]}) ? $obj->{$fieldlist[$field]}:'';

			if ($fieldlist[$field] == 'sortorder')
			{
				$fieldlist[$field] = 'position';
			}

			$classtd = ''; $class = '';
			if ($fieldlist[$field] == 'code') $class = '';
			if (in_array($fieldlist[$field], array('dayrule', 'day', 'month', 'year', 'pos', 'use_default', 'affect', 'delay', 'position', 'sortorder', 'sens', 'category_type'))) {
				$class = 'maxwidth50 center';
			}
			if (in_array($fieldlist[$field], array('use_default'))) {
				$classtd = 'center';
			}
			if (in_array($fieldlist[$field], array('libelle', 'label', 'tracking'))) $class = 'quatrevingtpercent';
			print '<td class="'.$classtd.'">';
			$transfound = 0;
			$transkey = '';
			if (in_array($fieldlist[$field], array('label', 'libelle')))		// For label
			{
				// Special case for labels
				if ($tabname == MAIN_DB_PREFIX.'c_civility') {
					$transkey = "Civility".strtoupper($obj->code);
				}
				if ($tabname == MAIN_DB_PREFIX.'c_payment_term') {
					$langs->load("bills");
					$transkey = "PaymentConditionShort".strtoupper($obj->code);
				}
				if ($transkey && $langs->trans($transkey) != $transkey)
				{
					$transfound = 1;
					print $form->textwithpicto($langs->trans($transkey), $langs->trans("GoIntoTranslationMenuToChangeThis"));
				}
			}
			if (!$transfound)
			{
				print '<input type="text" class="form-control'.($class ? ' '.$class : '').'" value="'.dol_escape_htmltag($fieldValue).'" name="'.$fieldlist[$field].'">';
			} else {
				print '<input type="hidden" name="'.$fieldlist[$field].'" value="'.$transkey.'">';
			}
			print '</td>';
		}
	}

	return $withentity;
}
