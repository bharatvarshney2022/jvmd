<?php
/* 
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
 *  \file       htdocs/product/card.php
 *  \ingroup    product
 *  \brief      Page to show product
 */



require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/canvas.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT.'/product_customer/class/productcustomer.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/html.formproduct.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/genericobject.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/modules/product/modules_product.class.php';

if (!empty($conf->propal->enabled))     require_once DOL_DOCUMENT_ROOT.'/comm/propal/class/propal.class.php';
if (!empty($conf->facture->enabled))    require_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
if (!empty($conf->commande->enabled))   require_once DOL_DOCUMENT_ROOT.'/commande/class/commande.class.php';
if (!empty($conf->accounting->enabled)) require_once DOL_DOCUMENT_ROOT.'/core/lib/accounting.lib.php';
if (!empty($conf->accounting->enabled)) require_once DOL_DOCUMENT_ROOT.'/core/class/html.formaccounting.class.php';
if (!empty($conf->accounting->enabled)) require_once DOL_DOCUMENT_ROOT.'/accountancy/class/accountingaccount.class.php';

// Load translation files required by the page
$langs->loadLangs(array('products', 'other'));
if (!empty($conf->stock->enabled)) $langs->load("stocks");
if (!empty($conf->facture->enabled)) $langs->load("bills");
if (!empty($conf->productbatch->enabled)) $langs->load("productbatch");

$mesg = ''; $error = 0; $errors = array();

$refalreadyexists = 0;

$id = GETPOST('id', 'int');
$ref = GETPOST('ref', 'alpha');
$type = (GETPOST('type', 'int') !== '') ? GETPOST('type', 'int') : Product::TYPE_PRODUCT;
$action = (GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view');
$cancel = GETPOST('cancel', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');
$confirm = GETPOST('confirm', 'alpha');
$socid = GETPOST('socid', 'int');
$duration_value = GETPOST('duration_value', 'int');
$duration_unit = GETPOST('duration_unit', 'alpha');

$accountancy_code_sell = GETPOST('accountancy_code_sell', 'alpha');
$accountancy_code_sell_intra = GETPOST('accountancy_code_sell_intra', 'alpha');
$accountancy_code_sell_export = GETPOST('accountancy_code_sell_export', 'alpha');
$accountancy_code_buy = GETPOST('accountancy_code_buy', 'alpha');
$accountancy_code_buy_intra = GETPOST('accountancy_code_buy_intra', 'alpha');
$accountancy_code_buy_export = GETPOST('accountancy_code_buy_export', 'alpha');

// by default 'alphanohtml' (better security); hidden conf MAIN_SECURITY_ALLOW_UNSECURED_LABELS_WITH_HTML allows basic html
$label_security_check = empty($conf->global->MAIN_SECURITY_ALLOW_UNSECURED_LABELS_WITH_HTML) ? 'alphanohtml' : 'restricthtml';

if (!empty($user->socid)) $socid = $user->socid;

$object = new ProductCustomer($db);
$object->type = $type; // so test later to fill $usercancxxx is correct
$extrafields = new ExtraFields($db);

// fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

if ($id > 0)
{
	$result = $object->fetch($id);

	$upload_dir = $conf->global->PRODUCT_CUSTOMER_MULTIDIR.'/'.get_exdir(0, 0, 0, 0, $object, 'product').dol_sanitizeFileName($object->ref);
	
	if (!empty($conf->global->PRODUCT_USE_OLD_PATH_FOR_PHOTO))    // For backward compatiblity, we scan also old dirs
	{
		$upload_dirold = $conf->global->PRODUCT_CUSTOMER_MULTIDIR.'/'.substr(substr("000".$object->id, -2), 1, 1).'/'.substr(substr("000".$object->id, -2), 0, 1).'/'.$object->id."/photos";
	}
}

$modulepart = 'product';

// Get object canvas (By default, this is not defined, so standard usage of dolibarr)
$canvas = !empty($object->canvas) ? $object->canvas : GETPOST("canvas");
$objcanvas = null;
if (!empty($canvas))
{
	require_once DOL_DOCUMENT_ROOT.'/core/class/canvas.class.php';
	$objcanvas = new Canvas($db, $action);
	$objcanvas->getCanvas('product', 'card', $canvas);
}

// Security check
$fieldvalue = $id;
$fieldtype = 'rowid';
$result = restrictedArea($user, 'projet', $object->id, '');


// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('productcard', 'globalcard'));



/*
 * Actions
 */

if ($cancel) $action = '';

$usercanread = $user->rights->projet->creer;
$usercancreate = $user->rights->projet->creer;
$usercandelete = $user->rights->projet->supprimer;

$parameters = array('id'=>$id, 'ref'=>$ref, 'objcanvas'=>$objcanvas);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (empty($reshook))
{
	// Type
	if ($action == 'setfk_product_type' && $usercancreate)
	{
		$result = $object->setValueFrom('fk_product_type', GETPOST('fk_product_type'), '', null, 'text', '', $user, 'PRODUCT_MODIFY');
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$object->id);
		exit;
	}

	// Actions to build doc
	$upload_dir = $conf->product->dir_output;
	$permissiontoadd = $usercancreate;
	include DOL_DOCUMENT_ROOT.'/core/actions_builddoc.inc.php';

	include DOL_DOCUMENT_ROOT.'/core/actions_printing.inc.php';

	// Barcode type
	if ($action == 'setfk_barcode_type' && $createbarcode)
	{
		$result = $object->setValueFrom('fk_barcode_type', GETPOST('fk_barcode_type'), '', null, 'text', '', $user, 'PRODUCT_MODIFY');
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$object->id);
		exit;
	}

	// Barcode value
	if ($action == 'setbarcode' && $createbarcode)
	{
		$result = $object->check_barcode(GETPOST('barcode'), GETPOST('barcode_type_code'));

		if ($result >= 0)
		{
			$result = $object->setValueFrom('barcode', GETPOST('barcode'), '', null, 'text', '', $user, 'PRODUCT_MODIFY');
			header("Location: ".$_SERVER['PHP_SELF']."?id=".$object->id);
			exit;
		} else {
			$langs->load("errors");
			if ($result == -1) $errors[] = 'ErrorBadBarCodeSyntax';
			elseif ($result == -2) $errors[] = 'ErrorBarCodeRequired';
			elseif ($result == -3) $errors[] = 'ErrorBarCodeAlreadyUsed';
			else $errors[] = 'FailedToValidateBarCode';

			$error++;
			setEventMessages($errors, null, 'errors');
		}
	}

	// Add a product or service
	if ($action == 'add' && $usercancreate)
	{
		$error = 0;
		$fk_model = GETPOST('fk_model', 'int');
		$fk_brand = GETPOST('fk_brand', 'int');
		$fk_category = GETPOST('fk_category', 'int');
		$fk_sub_category = GETPOST('fk_sub_category', 'int');
		$fk_product = GETPOST('fk_product', 'int');
	
		/*if (empty($fk_model))
        {
            setEventMessages($langs->trans('ErrorFieldRequired', $langs->transnoentities('Model Required')), null, 'errors');
            $error++;
        }*/
        if (empty($fk_brand))
        {
            setEventMessages($langs->trans('ErrorFieldRequired', $langs->transnoentities('Brand Required')), null, 'errors');
            $error++;
        }
        /*if (empty($fk_category))
        {
            setEventMessages($langs->trans('ErrorFieldRequired', $langs->transnoentities('Category Required')), null, 'errors');
            $error++;
        }
        if (empty($fk_sub_category))
        {
            setEventMessages($langs->trans('ErrorFieldRequired', $langs->transnoentities('Sub Category Required')), null, 'errors');
            $error++;
        }
         if (empty($fk_product))
        {
            setEventMessages($langs->trans('ErrorFieldRequired', $langs->transnoentities('Product Required')), null, 'errors');
            $error++;
        }*/

        if (!$error)
		{
			// TO DO
			// Data Update
			$object->fk_soc = GETPOST('fk_soc', 'int');
			$object->custprodid = GETPOST('custprodid', 'int');
			$object->fk_brand = GETPOST('fk_brand', 'int');
			$object->fk_category = GETPOST('fk_category', 'int');
			$object->fk_subcategory = GETPOST('fk_sub_category', 'int');
			$object->fk_product = GETPOST('fk_product', 'int');

			$object->fk_model = GETPOST('fk_model', 'int');
			$object->ac_capacity   = GETPOST('ac_capacity');

			$object->amc_start_date   = GETPOST('amc_start_date');
			$object->amc_end_date   = GETPOST('amc_end_date');
			$object->product_odu   = GETPOST('product_odu');

			
			if (!$error && $object->check())
			{
				if ($object->create($user) > 0)
				{
					// Category association
					$categories = GETPOST('categories', 'array');

					$backtopage = preg_replace('/--IDFORBACKTOPAGE--/', $object->id, $backtopage);

					if (!empty($backtopage))
					{
						 // New method to autoselect project after a New on another form object creation
						if (preg_match('/\?/', $backtopage)) $backtopage; // Old method
						header("Location: ".$backtopage);
						exit;
					} else {

						$backurl = DOL_URL_ROOT.'/societe/products.php?socid='.GETPOST('fk_soc', 'int');

						header('location: '.$backurl);
						exit;
					}
				} else {
					if (count($object->errors)) setEventMessages($object->error, $object->errors, 'errors');
					else setEventMessages($langs->trans($object->error), null, 'errors');
					//$action = 'create';
					$backurl = DOL_URL_ROOT.'/product_customer/card.php?action=create&socid='.GETPOST('fk_soc', 'int');

					header('location: '.$backurl);
					exit;
				}
			} else {
				echo "c"; exit;
				if (count($object->errors)) setEventMessages($object->error, $object->errors, 'errors');
				else setEventMessages($langs->trans("ErrorProductBadRefOrLabel"), null, 'errors');
				//$action = 'create';
				$backurl = DOL_URL_ROOT.'/product_customer/card.php?action=create&socid='.GETPOST('fk_soc', 'int');

					header('location: '.$backurl);
					exit;
			}
		}else{
			$backurl = DOL_URL_ROOT.'/product_customer/card.php?action=create&socid='.GETPOST('fk_soc', 'int');

			header('location: '.$backurl);
			exit;
		}	

	}

	// Update a product or service
	if ($action == 'update' && $usercancreate)
	{
		if (GETPOST('cancel', 'alpha'))
		{
			$action = '';
		} else {
			if ($object->id > 0)
			{
				$error = 0;

				// Data Update
				$object->fk_soc = GETPOST('fk_soc', 'int');
				$object->custprodid = GETPOST('custprodid', 'int');
				$object->fk_brand = GETPOST('fk_brand', 'int');
				$object->fk_category = GETPOST('fk_category', 'int');
				$object->fk_subcategory = GETPOST('fk_sub_category', 'int');
				$object->fk_product = GETPOST('fk_product', 'int');

				$object->fk_model = GETPOST('fk_model', 'int');
				$object->ac_capacity   = GETPOST('ac_capacity');

				$object->amc_start_date   = GETPOST('amc_start_date');
				$object->amc_end_date   = GETPOST('amc_end_date');
				$object->product_odu   = GETPOST('product_odu');

				
				if (!$error && $object->check())
				{
					if ($object->update($object->id, $user) > 0)
					{
						// Category association
						$categories = GETPOST('categories', 'array');

						$backurl = DOL_URL_ROOT.'/societe/products.php?socid='.GETPOST('fk_soc', 'int');

						header('location: '.$backurl);
					} else {
						if (count($object->errors)) setEventMessages($object->error, $object->errors, 'errors');
						else setEventMessages($langs->trans($object->error), null, 'errors');
						$action = 'edit';
					}
				} else {
					echo "c"; exit;
					if (count($object->errors)) setEventMessages($object->error, $object->errors, 'errors');
					else setEventMessages($langs->trans("ErrorProductBadRefOrLabel"), null, 'errors');
					$action = 'edit';
				}
			}
		}
	}

	// Action clone object
	if ($action == 'confirm_clone' && $confirm != 'yes') { $action = ''; }
	if ($action == 'confirm_clone' && $confirm == 'yes' && $usercancreate)
	{
		if (!GETPOST('clone_content') && !GETPOST('clone_prices'))
		{
			setEventMessages($langs->trans("NoCloneOptionsSpecified"), null, 'errors');
		} else {
			$db->begin();

			$originalId = $id;
			if ($object->id > 0)
			{
				$object->ref = GETPOST('clone_ref', 'alphanohtml');
				$object->status = 0;
				$object->status_buy = 0;
				$object->id = null;
				$object->barcode = -1;

				if ($object->check())
				{
					$object->context['createfromclone'] = 'createfromclone';
					$id = $object->create($user);
					if ($id > 0)
					{
						if (GETPOST('clone_composition'))
						{
							$result = $object->clone_associations($originalId, $id);

							if ($result < 1)
							{
								$db->rollback();
								setEventMessages($langs->trans('ErrorProductClone'), null, 'errors');
								header("Location: ".$_SERVER["PHP_SELF"]."?id=".$originalId);
								exit;
							}
						}

						if (GETPOST('clone_categories'))
						{
							$result = $object->cloneCategories($originalId, $id);

							if ($result < 1)
							{
								$db->rollback();
								setEventMessages($langs->trans('ErrorProductClone'), null, 'errors');
								header("Location: ".$_SERVER["PHP_SELF"]."?id=".$originalId);
								exit;
							}
						}

						if (GETPOST('clone_prices')) {
							$result = $object->clone_price($originalId, $id);

							if ($result < 1) {
								$db->rollback();
								setEventMessages($langs->trans('ErrorProductClone'), null, 'errors');
								header('Location: '.$_SERVER['PHP_SELF'].'?id='.$originalId);
								exit();
							}
						}

						// $object->clone_fournisseurs($originalId, $id);

						$db->commit();
						$db->close();

						header("Location: ".$_SERVER["PHP_SELF"]."?id=".$id);
						exit;
					} else {
						$id = $originalId;

						if ($object->error == 'ErrorProductAlreadyExists')
						{
							$db->rollback();

							$refalreadyexists++;
							$action = "";

							$mesg = $langs->trans("ErrorProductAlreadyExists", $object->ref);
							$mesg .= ' <a href="'.$_SERVER["PHP_SELF"].'?ref='.$object->ref.'">'.$langs->trans("ShowCardHere").'</a>.';
							setEventMessages($mesg, null, 'errors');
							$object->fetch($id);
						} else {
							$db->rollback();
							if (count($object->errors))
							{
								setEventMessages($object->error, $object->errors, 'errors');
								dol_print_error($db, $object->errors);
							} else {
								setEventMessages($langs->trans($object->error), null, 'errors');
								dol_print_error($db, $object->error);
							}
						}
					}

					unset($object->context['createfromclone']);
				}
			} else {
				$db->rollback();
				dol_print_error($db, $object->error);
			}
		}
	}

	// Delete a product
	if ($action == 'confirm_delete' && $confirm != 'yes') { $action = ''; }
	if ($action == 'confirm_delete' && $confirm == 'yes' && $usercandelete)
	{
		$result = $object->delete($user);

		if ($result > 0)
		{
			header('Location: '.DOL_URL_ROOT.'/product/list.php?type='.$object->type.'&delprod='.urlencode($object->ref));
			exit;
		} else {
			setEventMessages($langs->trans($object->error), null, 'errors');
			$reload = 0;
			$action = '';
		}
	}


	// Add product into object
	if ($object->id > 0 && $action == 'addin')
	{
		$thirpdartyid = 0;
		if (GETPOST('propalid') > 0)
		{
			$propal = new Propal($db);
			$result = $propal->fetch(GETPOST('propalid'));
			if ($result <= 0)
			{
				dol_print_error($db, $propal->error);
				exit;
			}
			$thirpdartyid = $propal->socid;
		} elseif (GETPOST('commandeid') > 0)
		{
			$commande = new Commande($db);
			$result = $commande->fetch(GETPOST('commandeid'));
			if ($result <= 0)
			{
				dol_print_error($db, $commande->error);
				exit;
			}
			$thirpdartyid = $commande->socid;
		} elseif (GETPOST('factureid') > 0)
		{
			$facture = new Facture($db);
			$result = $facture->fetch(GETPOST('factureid'));
			if ($result <= 0)
			{
				dol_print_error($db, $facture->error);
				exit;
			}
			$thirpdartyid = $facture->socid;
		}

		if ($thirpdartyid > 0) {
			$soc = new Societe($db);
			$result = $soc->fetch($thirpdartyid);
			if ($result <= 0) {
				dol_print_error($db, $soc->error);
				exit;
			}

			$desc = $object->description;

			$tva_tx = get_default_tva($mysoc, $soc, $object->id);
			$tva_npr = get_default_npr($mysoc, $soc, $object->id);
			if (empty($tva_tx)) $tva_npr = 0;
			$localtax1_tx = get_localtax($tva_tx, 1, $soc, $mysoc, $tva_npr);
			$localtax2_tx = get_localtax($tva_tx, 2, $soc, $mysoc, $tva_npr);

			$pu_ht = $object->price;
			$pu_ttc = $object->price_ttc;
			$price_base_type = $object->price_base_type;

			// If multiprice
			if ($conf->global->PRODUIT_MULTIPRICES && $soc->price_level) {
				$pu_ht = $object->multiprices[$soc->price_level];
				$pu_ttc = $object->multiprices_ttc[$soc->price_level];
				$price_base_type = $object->multiprices_base_type[$soc->price_level];
			} elseif (!empty($conf->global->PRODUIT_CUSTOMER_PRICES)) {
				require_once DOL_DOCUMENT_ROOT.'/product/class/productcustomerprice.class.php';

				$prodcustprice = new Productcustomerprice($db);

				$filter = array('t.fk_product' => $object->id, 't.fk_soc' => $soc->id);

				$result = $prodcustprice->fetch_all('', '', 0, 0, $filter);
				if ($result) {
					if (count($prodcustprice->lines) > 0) {
						$pu_ht = price($prodcustprice->lines [0]->price);
						$pu_ttc = price($prodcustprice->lines [0]->price_ttc);
						$price_base_type = $prodcustprice->lines [0]->price_base_type;
						$tva_tx = $prodcustprice->lines [0]->tva_tx;
					}
				}
			}

			$tmpvat = price2num(preg_replace('/\s*\(.*\)/', '', $tva_tx));
			$tmpprodvat = price2num(preg_replace('/\s*\(.*\)/', '', $prod->tva_tx));

			// On reevalue prix selon taux tva car taux tva transaction peut etre different
			// de ceux du produit par defaut (par exemple si pays different entre vendeur et acheteur).
			if ($tmpvat != $tmpprodvat) {
				if ($price_base_type != 'HT') {
					$pu_ht = price2num($pu_ttc / (1 + ($tmpvat / 100)), 'MU');
				} else {
					$pu_ttc = price2num($pu_ht * (1 + ($tmpvat / 100)), 'MU');
				}
			}

			if (GETPOST('propalid') > 0) {
				// Define cost price for margin calculation
				$buyprice = 0;
				if (($result = $propal->defineBuyPrice($pu_ht, GETPOST('remise_percent'), $object->id)) < 0)
				{
					dol_syslog($langs->trans('FailedToGetCostPrice'));
					setEventMessages($langs->trans('FailedToGetCostPrice'), null, 'errors');
				} else {
					$buyprice = $result;
				}

				$result = $propal->addline(
					$desc,
					$pu_ht,
					GETPOST('qty'),
					$tva_tx,
					$localtax1_tx, // localtax1
					$localtax2_tx, // localtax2
					$object->id,
					GETPOST('remise_percent'),
					$price_base_type,
					$pu_ttc,
					0,
					0,
					-1,
					0,
					0,
					0,
					$buyprice,
					'',
					'',
					'',
					0,
					$object->fk_unit
				);
				if ($result > 0) {
					header("Location: ".DOL_URL_ROOT."/comm/propal/card.php?id=".$propal->id);
					return;
				}

				setEventMessages($langs->trans("ErrorUnknown").": $result", null, 'errors');
			} elseif (GETPOST('commandeid') > 0) {
				// Define cost price for margin calculation
				$buyprice = 0;
				if (($result = $commande->defineBuyPrice($pu_ht, GETPOST('remise_percent'), $object->id)) < 0)
				{
					dol_syslog($langs->trans('FailedToGetCostPrice'));
					setEventMessages($langs->trans('FailedToGetCostPrice'), null, 'errors');
				} else {
					$buyprice = $result;
				}

				$result = $commande->addline(
					$desc,
					$pu_ht,
					GETPOST('qty'),
					$tva_tx,
					$localtax1_tx, // localtax1
					$localtax2_tx, // localtax2
					$object->id,
					GETPOST('remise_percent'),
					'',
					'',
					$price_base_type,
					$pu_ttc,
					'',
					'',
					0,
					-1,
					0,
					0,
					null,
					$buyprice,
					'',
					0,
					$object->fk_unit
				);

				if ($result > 0) {
					header("Location: ".DOL_URL_ROOT."/commande/card.php?id=".$commande->id);
					exit;
				}
			} elseif (GETPOST('factureid') > 0) {
				// Define cost price for margin calculation
				$buyprice = 0;
				if (($result = $facture->defineBuyPrice($pu_ht, GETPOST('remise_percent'), $object->id)) < 0)
				{
					dol_syslog($langs->trans('FailedToGetCostPrice'));
					setEventMessages($langs->trans('FailedToGetCostPrice'), null, 'errors');
				} else {
					$buyprice = $result;
				}

				$result = $facture->addline(
					$desc,
					$pu_ht,
					GETPOST('qty'),
					$tva_tx,
					$localtax1_tx,
					$localtax2_tx,
					$object->id,
					GETPOST('remise_percent'),
					'',
					'',
					'',
					'',
					'',
					$price_base_type,
					$pu_ttc,
					Facture::TYPE_STANDARD,
					-1,
					0,
					'',
					0,
					0,
					null,
					$buyprice,
					'',
					0,
					100,
					'',
					$object->fk_unit
				);

				if ($result > 0) {
					header("Location: ".DOL_URL_ROOT."/compta/facture/card.php?facid=".$facture->id);
					exit;
				}
			}
		} else {
			$action = "";
			setEventMessages($langs->trans("WarningSelectOneDocument"), null, 'warnings');
		}
	}
}



/*
 * View
 */

$title = $langs->trans('ProductServiceCard');
$helpurl = '';
$shortlabel = dol_trunc($object->label, 16);
if (GETPOST("type") == '0' || ($object->type == Product::TYPE_PRODUCT))
{
	$title = $langs->trans('Product')." ".$shortlabel." - ".$langs->trans('Card');
	$helpurl = 'EN:Module_Products|FR:Module_Produits|ES:M&oacute;dulo_Productos';
}
if (GETPOST("type") == '1' || ($object->type == Product::TYPE_SERVICE))
{
	$title = $langs->trans('Service')." ".$shortlabel." - ".$langs->trans('Card');
	$helpurl = 'EN:Module_Services_En|FR:Module_Services|ES:M&oacute;dulo_Servicios';
}

llxHeader('', $title, $helpurl);

$form = new Form($db);
$formfile = new FormFile($db);
$formproduct = new FormProduct($db);
$formcompany = new FormCompany($db);
if (!empty($conf->accounting->enabled)) $formaccounting = new FormAccounting($db);

// Load object modBarCodeProduct
$res = 0;
if (!empty($conf->barcode->enabled) && !empty($conf->global->BARCODE_PRODUCT_ADDON_NUM))
{
	$module = strtolower($conf->global->BARCODE_PRODUCT_ADDON_NUM);
	$dirbarcode = array_merge(array('/core/modules/barcode/'), $conf->modules_parts['barcode']);
	foreach ($dirbarcode as $dirroot)
	{
		$res = dol_include_once($dirroot.$module.'.php');
		if ($res) break;
	}
	if ($res > 0)
	{
			$modBarCodeProduct = new $module();
	}
}


if (is_object($objcanvas) && $objcanvas->displayCanvasExists($action))
{
	// -----------------------------------------
	// When used with CANVAS
	// -----------------------------------------
	if (empty($object->error) && $id)
	{
		$object = new Product($db);
		$result = $object->fetch($id);
		if ($result <= 0) dol_print_error('', $object->error);
	}
	$objcanvas->assign_values($action, $object->id, $object->ref); // Set value for templates
	$objcanvas->display_canvas($action); // Show template
} else {
	// -----------------------------------------
	// When used in standard mode
	// -----------------------------------------
	$head = array();
	if ($id > 0)
	{
		// Si edition contact deja existant
		$object = new ProductCustomer($db);
		$res = $object->fetch($id, $user);
		if ($res < 0) {
			setEventMessages($object->error, $object->errors, 'errors');
		}

		//$object->fetchRoles();

		// Show tabs
		//$head = contact_prepare_head($object);

		$title = (!empty($conf->global->SOCIETE_ADDRESSES_MANAGEMENT) ? $langs->trans("Contacts") : $langs->trans("ContactsAddresses"));
	}

	if ($action == 'create')
	{
		//WYSIWYG Editor
		require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';

		print '<script type="text/javascript">'."\n";
				print '$(document).ready(function () {
                        $("#selectcountry_id").change(function() {
                        	document.formprod.action.value="create";
                        	document.formprod.submit();
                        });
                     });'."\n";

        print '$(document).ready(function () {
                        $("#fk_brand").change(function() {
                        	var brand = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getcategorybybrand.php",
								  data: { brand: brand},
								  success: function(html) {
								  	//alert(html);
									$("#fk_category").html(html);
									$("#fk_sub_category").html("<option>Select Sub Category</option>");
									$("#fk_model").html("<option>Select Model</option>");
									$("#label").val("");
								  }
							});
                        });

                       $("#fk_category").change(function() {
                        	var brand = $("#fk_brand").val();
                        	var category = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getsubcategorybybrand.php",
								  data: { brand: brand, category: category},
								  success: function(html) {
								  	//alert(html);
									$("#fk_sub_category").html(html);
									$("#fk_model").html("<option>Select Model</option>");
									$("#label").val("");
								  }
							});
                        }); 

                        $("#fk_sub_category").change(function() {
                        	var brand = $("#fk_brand").val();
                        	var category = $("#fk_category").val();
                        	var subcategory = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getproductmodel.php",
								  data: { brand: brand, category: category , subcategory: subcategory},
								  success: function(html) {
								  	//alert(html);
									$("#fk_model").html(html);
									$("#label").val("");
								  }
							});
                        }); 


                        $("#fk_model").change(function() {
                        	var model = $(this).val();
                        	var brand = $("#fk_brand").val();
                        	var category = $("#fk_category").val();
                        	var subcategory = $("#fk_sub_category").val();
                        	
                        	$.ajax({
								  dataType: "html",
								  url: "productlistbymodel.php",
								  data: {brand: brand, category: category , subcategory: subcategory, model: model},
								  success: function(data) {
								  	//alert(data);
									$("#fk_product").html(data);
								  }
							});
                        }); 

	               });'; 

        print '$(document).ready(function () {
                $("#modelname").change(function() {
                	var model = $(this).val();
                	$.ajax({
						  dataType: "json",
						  url: "productmodeldata.php",
						  data: { model: model},
						  success: function(data) {
							$("#label").val(data.name);
							$("#brand").val(data.brand);
							$("#c_product_family").val(data.family);
							$("#c_product_subfamily").val(data.subfamily);

							$("#fk_brand").val(data.brandid);
							$("#fk_category").val(data.categoryid);
							$("#fk_subcategory").val(data.subcategoryid);
							$("#fk_product").val(data.product_id);
						  }
					});
                });
             });'."\n";     
		print '</script>'."\n";

		// Load object modCodeProduct
		$module = (!empty($conf->global->PRODUCT_CODEPRODUCT_ADDON) ? $conf->global->PRODUCT_CODEPRODUCT_ADDON : 'mod_codeproduct_leopard');
		if (substr($module, 0, 16) == 'mod_codeproduct_' && substr($module, -3) == 'php')
		{
			$module = substr($module, 0, dol_strlen($module) - 4);
		}
		$result = dol_include_once('/core/modules/product/'.$module.'.php');
		if ($result > 0)
		{
			$modCodeProduct = new $module();
		}

		//dol_set_focus('select[name="family"]');
		$socid = GETPOST('socid');
		print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST" name="formprod">';
		print '<input type="hidden" name="token" value="'.newToken().'">';
		print '<input type="hidden" name="action" value="add">';
		print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
		print '<input type="hidden" name="fk_soc" value="'.$socid.'">';

		
		$picto = 'product';
		$title = $langs->trans("Add Customer Product");
		
		$linkback = "";
		print load_fiche_titre($title, $linkback, $picto);
		print "<h3>Product Information</h3>";

		print dol_get_fiche_head($head, 'card', '', 0, '');
		print '<table class="border centpercent">';

		// Brand
		print '<tr><td class="fieldrequired">'.$langs->trans("Brand").'</td><td>';
		print $formcompany->select_brand('', '0' ,'fk_brand');
		print '</td>';
		
		// Product Category

		print '<td >'.$langs->trans("Category").'</td><td>';
		print '<select class="flat" id="fk_category" name="fk_category">';
		print '<option value="0">Select Category</option>';
		print '</select>';
		print '</td></tr>';

		// Product sub Category
		print '<tr><td >'.$langs->trans("Sub Category").'</td><td>';
		print '<select class="flat" id="fk_sub_category" name="fk_sub_category">';
		print '<option value="0">Select Sub Category</option>';
		print '</select>';
		print '</td>';
		// Model
		print '<td >'.$langs->trans("Model No.").'</td><td>';
		print '<select class="flat" id="fk_model" name="fk_model">';
		print '<option value="0">Select Model</option>';
		print '</select>';
		print '</td></tr>';

		// Label
		print '<tr><td >'.$langs->trans("Product Name").'</td><td>';
		print '<select class="flat" id="fk_product" name="fk_product">';
		print '<option value="0">Select Product</option>';
		print '</select>';
		print '</td>';

		// Ac Capacity
		print '<td>'.$langs->trans("AC Capacity").'</td><td>';
		print $form->select_ac_capacity(GETPOSTISSET("ac_capacity") ? GETPOST("ac_capacity") : $object->ac_capacity, 'ac_capacity');
		print '</td></tr>';

		// Date
		print '<tr><td >'.$langs->trans("AMC Start Date").'</td><td>';
		print $form->selectDate($object->amc_start_date ? $object->amc_start_date : -1, 'amc_start_date', 0, 0, 0, '', 1, 0);;
		print '</td>';
		// Ac Capacity
		print '<td>'.$langs->trans("AMC End Date").'</td><td>';
		print $form->selectDate($object->amc_end_date ? $object->amc_end_date : -1, 'amc_end_date', 0, 0, 0, '', 1, 0);
		print '</td></tr>';

		// Date
		print '<tr><td >'.$langs->trans("Product ODU").'</td><td>';
		print '<input type="text" name="product_odu" value= "'.($object->product_odu ? $object->product_odu : "").'" />';
		print '</td></tr>';

		
		print '</table>';
		print dol_get_fiche_end();

		print '<div class="center">';
		print '<input type="submit" class="button" value="'.$langs->trans("Create").'">';
		print ' &nbsp; &nbsp; ';
		print '<input type="button" class="button button-cancel" value="'.$langs->trans("Cancel").'" onClick="javascript:history.go(-1)">';
		print '</div>';

		print '</form>';
	} elseif ($object->id > 0) {
		/*
         * Product card
         */
		// Fiche en mode edition
		if ($action == 'edit')
		{
			//WYSIWYG Editor
			require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';

			$fk_soc = GETPOST('fk_soc', 'int');
			$custprodid = GETPOST('id', 'int');
			$formcompany = new FormCompany($db);
			$custprdobject = $object->fetch($custprodid);


			print '<script type="text/javascript">';
				
				print '$(document).ready(function () {';
					if($object->fk_product > 0 && $object->fk_model > 0){
						print 'getproductinfo('.$object->fk_model.');
							
						';
					}	
						
                        print '$("#fk_brand").change(function() {
                        	var brand = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getcategorybybrand.php",
								  data: { brand: brand},
								  success: function(html) {
								  	//alert(html);
									$("#fk_category").html(html);
									$("#fk_sub_category").html("<option>Select Sub Category</option>");
									$("#fk_model").html("<option>Select Model</option>");
									$("#label").val("");
								  }
							});
                        });

                       $("#fk_category").change(function() {
                        	var brand = $("#fk_brand").val();
                        	var category = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getsubcategorybybrand.php",
								  data: { brand: brand, category: category},
								  success: function(html) {
								  	//alert(html);
									$("#fk_sub_category").html(html);
									$("#fk_model").html("<option>Select Model</option>");
									$("#label").val("");
								  }
							});
                        }); 

                        $("#fk_sub_category").change(function() {
                        	var brand = $("#fk_brand").val();
                        	var category = $("#fk_category").val();
                        	var subcategory = $(this).val();
                        	$.ajax({
								  dataType: "html",
								  url: "getproductmodel.php",
								  data: { brand: brand, category: category , subcategory: subcategory},
								  success: function(html) {
								  	//alert(html);
									$("#fk_model").html(html);
									$("#label").val("");
								  }
							});
                        }); 


                       $("#fk_model").change(function() {
                        	var model = $(this).val();
                        	var brand = $("#fk_brand").val();
                        	var category = $("#fk_category").val();
                        	var subcategory = $("#fk_sub_category").val();
                        	
                        	$.ajax({
								  dataType: "html",
								  url: "productlistbymodel.php",
								  data: {brand: brand, category: category , subcategory: subcategory, model: model},
								  success: function(data) {
								  	//alert(data);
									$("#fk_product").html(data);
								  }
							});
                        }); 


                     });

                     	function getproductinfo(id){
                     		//alert(id);
                     		var model = id;
                        	var brand = $("#fk_brand").val();
                        	var category = $("#fk_category").val();
                        	var subcategory = $("#fk_sub_category").val();
                        	
                        	$.ajax({
								  dataType: "html",
								  url: "productlistbymodel.php",
								  data: {brand: brand, category: category , subcategory: subcategory, model: model},
								  success: function(data) {
								  	//alert(data);
									$("#fk_product").html(data);
									$("#fk_product option[value='.$object->fk_product.']").attr("selected", "selected"); 
								  }
							});
                     	}
                     ';  


			print '</script>'."\n";

			print '<form action="'.$_SERVER['PHP_SELF'].'?id='.$object->id.'" method="POST" name="formprod">'."\n";
			print '<input type="hidden" name="token" value="'.newToken().'">';
			print '<input type="hidden" name="action" value="update">';
			print '<input type="hidden" name="fk_soc" value="'.$fk_soc.'">';
			print '<input type="hidden" name="id" value="'.$id.'">';
			print '<input type="hidden" name="canvas" value="'.$object->canvas.'">';

			$head = product_customer_prepare_head($object);
			$title = $langs->trans("CardProductCustomer");
			$picto = 'product_customer';
			print dol_get_fiche_head($head, 'card', $title, 0, 'product_customer');

			//print "<h3>Edit Product Information</h3>";
			print "<h3>Customer Product Information</h3>";
			print '<table class="border allwidth">';

			// Brand
			print '<tr><td class="fieldrequired">'.$langs->trans("Brand").'</td><td>';
			print $formcompany->select_brand($object->fk_brand, '0' ,'fk_brand');
			print '</td>';
			
			// Product Category

			print '<td >'.$langs->trans("Category").'</td><td>';
			if($object->fk_brand > 0){
				print $formcompany->select_family($object->fk_category, $object->fk_brand ,'fk_category');
				//print $object->getCategoryByBrand($object->fk_brand);
			}else{
				print '<select class="flat" id="fk_category" name="fk_category">';
				print '<option value="0">Select Sub Category</option>';
				print '</select>';
			}
			print '</td></tr>';

			// Product sub Category
			print '<tr><td >'.$langs->trans("Sub Category").'</td><td>';
			if($object->fk_brand > 0 && $object->fk_category > 0){
				print $formcompany->select_subfamily($object->fk_subcategory  , $object->fk_brand,$object->fk_category,'fk_sub_category');
			}else{
				print '<select class="flat" id="fk_sub_category" name="fk_sub_category">';
				print '<option value="0">Select Sub Category</option>';
				print '</select>';
			}
			print '</td>';
			
			// Model
			print '<td >'.$langs->trans("Model No.").'</td><td>';
			if($object->fk_brand > 0 && $object->fk_category > 0 && $object->fk_subcategory  > 0){
				print $formcompany->select_modelName($object->fk_model , $object->fk_brand, $object->fk_category, $object->fk_subcategory , 'fk_model');
			}else{
				print '<select class="flat" id="fk_model" name="fk_model">'; 
				print '<option value="0">Select Model</option>';
				print '</select>';
			}
			print '</td></tr>';

			// Label
			print '<tr><td >'.$langs->trans("Product Name").'</td><td>';
			print '<select class="flat" id="fk_product" name="fk_product">';
			print '<option value="0">Select Product</option>';
			print '</select>';
			print '</td>';
			// Ac Capacity
			print '<td>'.$langs->trans("AC Capacity").'</td><td>';
			print $form->select_ac_capacity(GETPOSTISSET("ac_capacity") ? GETPOST("ac_capacity") : $object->ac_capacity, 'ac_capacity');
			print '</td></tr>';

			// Date
			print '<tr><td class="fieldrequired">'.$langs->trans("AMC Start Date").'</td><td>';
			print $form->selectDate($object->amc_start_date ? $object->amc_start_date : -1, 'amc_start_date', 0, 0, 0, '', 1, 0);;
			print '</td>';
			// Ac Capacity
			print '<td>'.$langs->trans("AMC End Date").'</td><td>';
			print $form->selectDate($object->amc_end_date ? $object->amc_end_date : -1, 'amc_end_date', 0, 0, 0, '', 1, 0);
			print '</td></tr>';

			// Date
			print '<tr><td class="fieldrequired">'.$langs->trans("Product ODU").'</td><td>';
			print '<input type="text" name="product_odu" value= "'.($object->product_odu ? $object->product_odu : "").'" />';
			print '</td></tr>';
			
			print '</table>';
			print dol_get_fiche_end();
			$backurl = DOL_URL_ROOT.'/societe/products.php?socid='.GETPOST('fk_soc', 'int');
			print '<div class="center">';
			print '<input type="submit" class="button" value="'.$langs->trans("Save").'">';
			print ' &nbsp; &nbsp; ';
			print '<a href = "'.$backurl.'" class="button button-cancel">'.$langs->trans("Cancel").'</a>';
			print '</div>';

			print '</form>';

			print '<div style="clear:both"></div>';


			print dol_get_fiche_end();
		}
	} elseif ($action != 'create')
	{
		exit;
	}
}

// Load object modCodeProduct
$module = (!empty($conf->global->PRODUCT_CODEPRODUCT_ADDON) ? $conf->global->PRODUCT_CODEPRODUCT_ADDON : 'mod_codeproduct_leopard');
if (substr($module, 0, 16) == 'mod_codeproduct_' && substr($module, -3) == 'php')
{
	$module = substr($module, 0, dol_strlen($module) - 4);
}
$result = dol_include_once('/core/modules/product/'.$module.'.php');
if ($result > 0)
{
	$modCodeProduct = new $module();
}

$tmpcode = '';
if (!empty($modCodeProduct->code_auto)) $tmpcode = $modCodeProduct->getNextValue($object, $object->type);

$formconfirm = '';

// Confirm delete product
if (($action == 'delete' && (empty($conf->use_javascript_ajax) || !empty($conf->dol_use_jmobile)))	// Output when action = clone if jmobile or no js
	|| (!empty($conf->use_javascript_ajax) && empty($conf->dol_use_jmobile)))							// Always output when not jmobile nor js
{
	$formconfirm = $form->formconfirm("card.php?id=".$object->id, $langs->trans("DeleteProduct"), $langs->trans("ConfirmDeleteProduct"), "confirm_delete", '', 0, "action-delete");
}

// Clone confirmation
if (($action == 'clone' && (empty($conf->use_javascript_ajax) || !empty($conf->dol_use_jmobile)))		// Output when action = clone if jmobile or no js
	|| (!empty($conf->use_javascript_ajax) && empty($conf->dol_use_jmobile)))							// Always output when not jmobile nor js
{
	// Define confirmation messages
	$formquestionclone = array(
		'text' => $langs->trans("ConfirmClone"),
		array('type' => 'text', 'name' => 'clone_ref', 'label' => $langs->trans("NewRefForClone"), 'value' => empty($tmpcode) ? $langs->trans("CopyOf").' '.$object->ref : $tmpcode, 'size'=>24),
		array('type' => 'checkbox', 'name' => 'clone_content', 'label' => $langs->trans("CloneContentProduct"), 'value' => 1),
		array('type' => 'checkbox', 'name' => 'clone_categories', 'label' => $langs->trans("CloneCategoriesProduct"), 'value' => 1),
	);
	if (!empty($conf->global->PRODUIT_MULTIPRICES)) {
		$formquestionclone[] = array('type' => 'checkbox', 'name' => 'clone_prices', 'label' => $langs->trans("ClonePricesProduct").' ('.$langs->trans("CustomerPrices").')', 'value' => 0);
	}
	if (!empty($conf->global->PRODUIT_SOUSPRODUITS))
	{
		$formquestionclone[] = array('type' => 'checkbox', 'name' => 'clone_composition', 'label' => $langs->trans('CloneCompositionProduct'), 'value' => 1);
	}

	$formconfirm .= $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('ToClone'), $langs->trans('ConfirmCloneProduct', $object->ref), 'confirm_clone', $formquestionclone, 'yes', 'action-clone', 350, 600);
}

// Call Hook formConfirm
$parameters = array('formConfirm' => $formconfirm, 'object' => $object);
$reshook = $hookmanager->executeHooks('formConfirm', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
if (empty($reshook)) $formconfirm .= $hookmanager->resPrint;
elseif ($reshook > 0) $formconfirm = $hookmanager->resPrint;

// Print form confirm
print $formconfirm;

/* ************************************************************************** */
/*                                                                            */
/* Barre d'action                                                             */
/*                                                                            */
/* ************************************************************************** */
if ($action != 'create' && $action != 'edit')
{
	print "\n".'<div class="tabsAction">'."\n";

	$parameters = array();
	$reshook = $hookmanager->executeHooks('addMoreActionsButtons', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
	if (empty($reshook))
	{
		if ($usercancreate)
		{
			if (!isset($object->no_button_edit) || $object->no_button_edit <> 1) print '<a class="butAction" href="'.$_SERVER["PHP_SELF"].'?action=edit&amp;id='.$object->id.'">'.$langs->trans("Modify").'</a>';

			if (!isset($object->no_button_copy) || $object->no_button_copy <> 1)
			{
				if (!empty($conf->use_javascript_ajax) && empty($conf->dol_use_jmobile))
				{
					print '<span id="action-clone" class="butAction">'.$langs->trans('ToClone').'</span>'."\n";
				} else {
					print '<a class="butAction" href="'.$_SERVER["PHP_SELF"].'?action=clone&amp;id='.$object->id.'">'.$langs->trans("ToClone").'</a>';
				}
			}
		}
		$object_is_used = $object->isObjectUsed($object->id);

		if ($usercandelete)
		{
			if (empty($object_is_used) && (!isset($object->no_button_delete) || $object->no_button_delete <> 1))
			{
				if (!empty($conf->use_javascript_ajax) && empty($conf->dol_use_jmobile))
				{
					print '<span id="action-delete" class="butActionDelete">'.$langs->trans('Delete').'</span>'."\n";
				} else {
					print '<a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?action=delete&amp;token='.newToken().'&amp;id='.$object->id.'">'.$langs->trans("Delete").'</a>';
				}
			} else {
				print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("ProductIsUsed").'">'.$langs->trans("Delete").'</a>';
			}
		} else {
			print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotEnoughPermissions").'">'.$langs->trans("Delete").'</a>';
		}
	}

	print "\n</div>\n";
}

/*
 * All the "Add to" areas
 */

if (!empty($conf->global->PRODUCT_ADD_FORM_ADD_TO) && $object->id && ($action == '' || $action == 'view') && $object->status)
{
	//Variable used to check if any text is going to be printed
	$html = '';
	//print '<div class="fichecenter"><div class="fichehalfleft">';

	// Propals
	if (!empty($conf->propal->enabled) && $user->rights->propale->creer)
	{
		$propal = new Propal($db);

		$langs->load("propal");

		$otherprop = $propal->liste_array(2, 1, 0);

		if (is_array($otherprop) && count($otherprop))
		{
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftProposals").'</td><td>';
			$html .= $form->selectarray("propalid", $otherprop, 0, 1);
			$html .= '</td></tr>';
		} else {
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftProposals").'</td><td>';
			$html .= $langs->trans("NoDraftProposals");
			$html .= '</td></tr>';
		}
	}

	// Commande
	if (!empty($conf->commande->enabled) && $user->rights->commande->creer)
	{
		$commande = new Commande($db);

		$langs->load("orders");

		$othercom = $commande->liste_array(2, 1, null);
		if (is_array($othercom) && count($othercom))
		{
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftOrders").'</td><td>';
			$html .= $form->selectarray("commandeid", $othercom, 0, 1);
			$html .= '</td></tr>';
		} else {
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftOrders").'</td><td>';
			$html .= $langs->trans("NoDraftOrders");
			$html .= '</td></tr>';
		}
	}

	// Factures
	if (!empty($conf->facture->enabled) && $user->rights->facture->creer)
	{
		$invoice = new Facture($db);

		$langs->load("bills");

		$otherinvoice = $invoice->liste_array(2, 1, null);
		if (is_array($otherinvoice) && count($otherinvoice))
		{
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftInvoices").'</td><td>';
			$html .= $form->selectarray("factureid", $otherinvoice, 0, 1);
			$html .= '</td></tr>';
		} else {
			$html .= '<tr><td style="width: 200px;">';
			$html .= $langs->trans("AddToDraftInvoices").'</td><td>';
			$html .= $langs->trans("NoDraftInvoices");
			$html .= '</td></tr>';
		}
	}

	//If any text is going to be printed, then we show the table
	if (!empty($html))
	{
		print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'?id='.$object->id.'">';
		print '<input type="hidden" name="token" value="'.newToken().'">';
		print '<input type="hidden" name="action" value="addin">';

		print load_fiche_titre($langs->trans("AddToDraft"), '', '');

		print dol_get_fiche_head('');

		$html .= '<tr><td class="nowrap">'.$langs->trans("Quantity").' ';
		$html .= '<input type="text" class="flat" name="qty" size="1" value="1"></td>';
		$html .= '<td class="nowrap">'.$langs->trans("ReductionShort").'(%) ';
		$html .= '<input type="text" class="flat" name="remise_percent" size="1" value="0">';
		$html .= '</td></tr>';

		print '<table width="100%" class="border">';
		print $html;
		print '</table>';

		print '<div class="center">';
		print '<input type="submit" class="button" value="'.$langs->trans("Add").'">';
		print '</div>';

		print dol_get_fiche_end();

		print '</form>';
	}
}


/*
 * Documents generes
 */

if ($action != 'create' && $action != 'edit' && $action != 'delete')
{
	print '<div class="fichecenter"><div class="fichehalfleft">';
	print '<a name="builddoc"></a>'; // ancre

	// Documents
	$objectref = dol_sanitizeFileName($object->ref);
	$relativepath = $comref.'/'.$objectref.'.pdf';
	if (!empty($conf->product->multidir_output[$object->entity])) {
		$filedir = $conf->product->multidir_output[$object->entity].'/'.$objectref; //Check repertories of current entities
	} else {
		$filedir = $conf->product->dir_output.'/'.$objectref;
	}
	$urlsource = $_SERVER["PHP_SELF"]."?id=".$object->id;
	$genallowed = $usercanread;
	$delallowed = $usercancreate;

	print $formfile->showdocuments($modulepart, $object->ref, $filedir, $urlsource, $genallowed, $delallowed, '', 0, 0, 0, 28, 0, '', 0, '', $object->default_lang, '', $object);
	$somethingshown = $formfile->numoffiles;

	print '</div><div class="fichehalfright"><div class="ficheaddleft">';

	$MAXEVENT = 10;

	$morehtmlright = '<a href="'.DOL_URL_ROOT.'/product/agenda.php?id='.$object->id.'">';
	$morehtmlright .= $langs->trans("SeeAll");
	$morehtmlright .= '</a>';

	// List of actions on element
	include_once DOL_DOCUMENT_ROOT.'/core/class/html.formactions.class.php';
	$formactions = new FormActions($db);
	$somethingshown = $formactions->showactions($object, 'product', 0, 1, '', $MAXEVENT, '', $morehtmlright); // Show all action for product

	print '</div></div></div>';
}

// End of page
llxFooter();
$db->close();
