<?php
/* Copyright (C) 2001-2007  Rodolphe Quiedeville    <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2014	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2005-2015	Regis Houssin			<regis.houssin@inodbox.com>
 * Copyright (C) 2006		Andre Cianfarani		<acianfa@free.fr>
 * Copyright (C) 2007-2011	Jean Heimburger			<jean@tiaris.info>
 * Copyright (C) 2010-2018	Juanjo Menent			<jmenent@2byte.es>
 * Copyright (C) 2012       Cedric Salvador         <csalvador@gpcsolutions.fr>
 * Copyright (C) 2013-2014	Cedric GROSS			<c.gross@kreiz-it.fr>
 * Copyright (C) 2013-2016	Marcos García			<marcosgdf@gmail.com>
 * Copyright (C) 2011-2020	Alexandre Spangaro		<aspangaro@open-dsi.fr>
 * Copyright (C) 2014		Henry Florian			<florian.henry@open-concept.pro>
 * Copyright (C) 2014-2016	Philippe Grand			<philippe.grand@atoo-net.com>
 * Copyright (C) 2014		Ion agorria			    <ion@agorria.com>
 * Copyright (C) 2016-2018	Ferran Marcet			<fmarcet@2byte.es>
 * Copyright (C) 2017		Gustavo Novaro
 * Copyright (C) 2019-2020  Frédéric France         <frederic.france@netlogic.fr>
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
 *    \file       htdocs/product/class/product.class.php
 *    \ingroup    produit
 *    \brief      File of class to manage predefined products or services
 */
require_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/commonobject.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/productbatch.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/stock/class/entrepot.class.php';

/**
 * Class to manage products or services
 */
class ProductCustomer extends CommonObject
{
	/**
	 * @var string ID to identify managed object
	 */
	public $element = 'product_customer';

	/**
	 * @var string Name of table without prefix where object is stored
	 */
	public $table_element = 'product_customer';

	/**
	 * @var string Field with ID of parent key if this field has a parent
	 */
	public $fk_element = 'fk_product_customer';

	/**
	 * @var array	List of child tables. To test if we can delete object.
	 */
	protected $childtables = array(
		'supplier_proposaldet',
	);

	/**
	 * 0=No test on entity, 1=Test with field entity, 2=Test with link by societe
	 *
	 * @var int
	 */
	public $ismultientitymanaged = 1;

	/**
	 * @var string picto
	 */
	public $picto = 'product_customer';

	/**
	 * {@inheritdoc}
	 */
	protected $table_ref_field = 'ref';
	// , , import_key

	public $regeximgext = '\.gif|\.jpg|\.jpeg|\.png|\.bmp|\.webp|\.xpm|\.xbm'; // See also into images.lib.php

	/*
    * @deprecated
    * @see label
    */
	public $fk_brand;

	/**
	 * Product label
	 *
	 * @var string
	 */
	public $fk_category;

	public $fk_subcategory;

	public $fk_model;
	public $fk_product;
	public $fk_soc;
	public $ac_capacity;

	public $component_no;

	public $fk_user;

	public $amc_start_date;
	public $amc_end_date;
	public $product_odu;

	/**
	 * Check TYPE constants
	 *
	 * @var int
	 */
	public $type = self::TYPE_PRODUCT;

	//! Size of image
	public $imgWidth;
	public $imgHeight;

	/**
	 * @var integer|string date_creation
	 */
	public $date_creation;

	/**
	 * @var integer|string date_modification
	 */
	public $date_modification;

	public $oldcopy;

	/**
	 * @var array fields of object product
	 */
	
	public $fields = array(
		'rowid' => array('type'=>'integer', 'label'=>'TechnicalID', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'index'=>1, 'position'=>1, 'comment'=>'Id'),
		'entity'        =>array('type'=>'integer', 'label'=>'Entity', 'enabled'=>1, 'visible'=>0, 'default'=>1, 'notnull'=>1, 'index'=>1, 'position'=>20),
		'datec'         =>array('type'=>'datetime', 'label'=>'DateCreation', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>500),
		'tms'           =>array('type'=>'timestamp', 'label'=>'DateModification', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>501),
		//'date_valid'    =>array('type'=>'datetime',     'label'=>'DateCreation',     'enabled'=>1, 'visible'=>-2, 'position'=>502),
		'fk_brand'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'fk_category'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'fk_subcategory'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'fk_model'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'fk_product'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'fk_soc'=>array('type'=>'integer', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510, 'foreignkey'=>'c_brand.rowid'),
		'entity'        =>array('type'=>'integer', 'label'=>'Entity', 'enabled'=>1, 'visible'=>0, 'default'=>1, 'notnull'=>1, 'index'=>1, 'position'=>20),
		'ac_capacity'=>array('type'=>'varchar', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510),
		'component_no'=>array('type'=>'varchar', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510),
		'fk_user' =>array('type'=>'integer', 'label'=>'UserModif', 'enabled'=>1, 'visible'=>-2, 'notnull'=>-1, 'position'=>511),
		//'fk_user_valid' =>array('type'=>'integer',      'label'=>'UserValidation',        'enabled'=>1, 'visible'=>-1, 'position'=>512),
		'amc_start_date'         =>array('type'=>'datetime', 'label'=>'DateCreation', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>500),
		'amc_end_date'           =>array('type'=>'timestamp', 'label'=>'DateModification', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>501),
		'product_odu'=>array('type'=>'varchar', 'label'=>'UserAuthor', 'enabled'=>1, 'visible'=>-2, 'notnull'=>1, 'position'=>510),
		'import_key'    =>array('type'=>'varchar(14)', 'label'=>'ImportId', 'enabled'=>1, 'visible'=>-2, 'notnull'=>-1, 'index'=>0, 'position'=>1000),
		//'tosell'       =>array('type'=>'integer',      'label'=>'Status',           'enabled'=>1, 'visible'=>1,  'notnull'=>1, 'default'=>0, 'index'=>1,  'position'=>1000, 'arrayofkeyval'=>array(0=>'Draft', 1=>'Active', -1=>'Cancel')),
		//'tobuy'        =>array('type'=>'integer',      'label'=>'Status',           'enabled'=>1, 'visible'=>1,  'notnull'=>1, 'default'=>0, 'index'=>1,  'position'=>1000, 'arrayofkeyval'=>array(0=>'Draft', 1=>'Active', -1=>'Cancel')),
	);

	/**
	 * Regular product
	 */
	const TYPE_PRODUCT = 0;
	/**
	 * Service
	 */
	const TYPE_SERVICE = 1;
	/**
	 * Advanced feature: assembly kit
	 */
	const TYPE_ASSEMBLYKIT = 2;
	/**
	 * Advanced feature: stock kit
	 */
	const TYPE_STOCKKIT = 3;


	/**
	 *  Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
		$this->canvas = '';
	}

	/**
	 *    Check that ref and label are ok
	 *
	 * @return int         >1 if OK, <=0 if KO
	 */
	public function check()
	{
		$err = 0;
		
		if ($err > 0) {
			return 0;
		} else {
			return 1;
		}
	}

	/**
	 *    Insert product into database
	 *
	 * @param  User $user      User making insert
	 * @param  int  $notrigger Disable triggers
	 * @return int                         Id of product/service if OK, < 0 if KO
	 */
	public function create($user, $notrigger = 0)
	{
		global $conf, $langs;

		$error = 0;

		// TO DO
		// Check parameters
		$this->fk_brand                		 = $this->fk_brand;
		$this->fk_category               	 = $this->fk_category;
		$this->fk_subcategory                = $this->fk_subcategory;
		$this->fk_model                		 = $this->fk_model;
		$this->fk_product                	 = $this->fk_product;
		$this->fk_soc                		 = $this->fk_soc;
		$this->ac_capacity                	 = $this->ac_capacity;
		$this->component_no                	 = $this->component_no;
		$this->fk_user                		 = $this->fk_user;

		$this->amc_start_date                = empty($this->amc_start_date) ? NULL : date('Y-m-d H:i:s', strtotime($this->amc_start_date));
		$this->amc_end_date               	 = empty($this->amc_end_date) ? NULL : date('Y-m-d H:i:s', strtotime($this->amc_end_date));
		$this->product_odu                	 = $this->product_odu;

		$now = dol_now();
		$entity = 1;
		$this->date_modification             = $now;
		
		$this->db->begin();

		$result = 0;
		// Check more parameters
		// If error, this->errors[] is filled
		$result = $this->verify();

		if ($result >= 0) {
			$sql = "SELECT rowid";
			$sql .= " FROM ".MAIN_DB_PREFIX."product_customer";
			$sql .= " WHERE fk_soc  = '".$this->db->escape($post['fk_soc'])."' ";
			$sql .= " AND fk_model = '".$this->db->escape($post['fk_model'])."'";

			$result = $this->db->query($sql);
			if ($result) {
				$obj = $this->db->fetch_object($result);
				if ($obj->nb == 0) {
					$component_no = $this->getCustomerProductcomponentNo(); 

					$sql = "INSERT INTO ".MAIN_DB_PREFIX."product_customer";
					$sql .= " SET datec = '".$this->db->idate($now)."'";
					$sql .= ", entity = '".$entity."'";
					$sql .= ", fk_brand = '".$this->db->escape($this->fk_brand)."'";
					$sql .= ", fk_category = '".$this->db->escape($this->fk_category)."'";
					$sql .= ", fk_subcategory = '".$this->db->escape($this->fk_subcategory)."'";
					$sql .= ", fk_model = '".$this->db->escape($this->fk_model)."'";
					$sql .= ", fk_product = '".$this->db->escape($this->fk_product)."'";
					$sql .= ", fk_soc = '".$this->db->escape($this->fk_soc)."'";
					$sql .= ", ac_capacity = '".$this->db->escape($this->ac_capacity)."'";
					$sql .= ", component_no = '".$this->db->escape($component_no)."'";
					$sql .= ", fk_user = '".$this->db->escape($this->fk_user)."'";
					if(empty($this->amc_start_date)){
						$sql .= ", amc_start_date = NULL";
					}else{
						$sql .= ", amc_start_date = '".$this->db->escape($this->amc_start_date)."'";
					}
					if(empty($this->amc_end_date)){
						$sql .= ", amc_end_date = NULL";
					}else{
						$sql .= ", amc_end_date = '".$this->db->escape($this->amc_end_date)."'";
					}
					$sql .= ", product_odu = '".$this->db->escape($this->product_odu)."'";


					// stock field is not here because it is a denormalized value from product_stock.
					
					dol_syslog(get_class($this)."::Create", LOG_DEBUG);
					$result = $this->db->query($sql);
					if ($result) {
						$id = $this->db->last_insert_id(MAIN_DB_PREFIX."product_customer");

						if ($id > 0) {
							$this->id = $id;
						} else {
							$error++;
							$this->error = 'ErrorFailedToGetInsertedId';
						}
					} else {
						$error++;
						$this->error = $this->db->lasterror();
					}
				} else {
					// Product already exists with this ref
					$langs->load("products");
					$error++;
					$this->error = "ErrorProductCustomerAlreadyExists";
				}
			} else {
				$error++;
				$this->error = $this->db->lasterror();
			}

			if (!$error && !$notrigger) {
				// Call trigger
				$result = $this->call_trigger('PRODUCTCUSTOMER_CREATE', $user);
				if ($result < 0) { $error++;
				}
				// End call triggers
			}

			if (!$error) {
				$this->db->commit();
				return $this->id;
			} else {
				$this->db->rollback();
				return -$error;
			}
		} else {
			$this->db->rollback();
			dol_syslog(get_class($this)."::Create fails verify ".join(',', $this->errors), LOG_WARNING);
			return -3;
		}
	}


	/**
	 *    Check properties of product are ok (like name, barcode, ...).
	 *    All properties must be already loaded on object (this->barcode, this->barcode_type_code, ...).
	 *
	 * @return int        0 if OK, <0 if KO
	 */
	public function verify()
	{
		$this->errors = array();

		$result = 0;
		
		return $result;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Check barcode
	 *
	 * @param  string $valuetotest Value to test
	 * @param  string $typefortest Type of barcode (ISBN, EAN, ...)
	 * @return int                        0 if OK
	 *                                     -1 ErrorBadBarCodeSyntax
	 *                                     -2 ErrorBarCodeRequired
	 *                                     -3 ErrorBarCodeAlreadyUsed
	 */
	public function check_barcode($valuetotest, $typefortest)
	{
		// phpcs:enable
		global $conf;
		if (!empty($conf->barcode->enabled) && !empty($conf->global->BARCODE_PRODUCT_ADDON_NUM)) {
			$module = strtolower($conf->global->BARCODE_PRODUCT_ADDON_NUM);

			$dirsociete = array_merge(array('/core/modules/barcode/'), $conf->modules_parts['barcode']);
			foreach ($dirsociete as $dirroot)
			{
				$res = dol_include_once($dirroot.$module.'.php');
				if ($res) { break;
				}
			}

			$mod = new $module();

			dol_syslog(get_class($this)."::check_barcode value=".$valuetotest." type=".$typefortest." module=".$module);
			$result = $mod->verif($this->db, $valuetotest, $this, 0, $typefortest);
			return $result;
		} else {
			return 0;
		}
	}

	/**
	 *  Update a record into database.
	 *  If batch flag is set to on, we create records into llx_product_batch
	 *
	 * @param  int     $id          Id of product
	 * @param  User    $user        Object user making update
	 * @param  int     $notrigger   Disable triggers
	 * @param  string  $action      Current action for hookmanager ('add' or 'update')
	 * @param  boolean $updatetype  Update product type
	 * @return int                  1 if OK, -1 if ref already exists, -2 if other error
	 */
	public function update($id, $user, $notrigger = false, $action = 'update', $updatetype = false)
	{
		global $langs, $conf, $hookmanager;

		$error = 0;

		// Check parameters
		$this->fk_brand                		 = $this->fk_brand;
		$this->fk_category               	 = $this->fk_category;
		$this->fk_subcategory                = $this->fk_subcategory;
		$this->fk_model                		 = $this->fk_model;
		$this->fk_product                	 = $this->fk_product;
		$this->fk_soc                		 = $this->fk_soc;
		$this->ac_capacity                	 = $this->ac_capacity;
		$this->component_no                	 = $this->component_no;
		$this->fk_user                		 = $this->fk_user;

		$this->amc_start_date                = empty($this->amc_start_date) ? NULL : date('Y-m-d H:i:s', strtotime($this->amc_start_date));
		$this->amc_end_date               	 = empty($this->amc_end_date) ? NULL : date('Y-m-d H:i:s', strtotime($this->amc_end_date));
		$this->product_odu                	 = $this->product_odu;

		$now = dol_now();
		$this->date_modification             = $now;
		
		$this->db->begin();

		$result = 0;
		// Check name is required and codes are ok or unique. If error, this->errors[] is filled
		if ($action != 'add') {
			$result = $this->verify(); // We don't check when update called during a create because verify was already done
		} else {
			// we can continue
			$result = 0;
		}

		if ($result >= 0) {
			if (empty($this->oldcopy)) {
				$org = new self($this->db);
				$org->fetch($this->id);
				$this->oldcopy = $org;
			}

			

			$sql = "UPDATE ".MAIN_DB_PREFIX."product_customer";
			$sql .= " SET fk_brand = '".$this->db->escape($this->fk_brand)."'";
			$sql .= ", fk_category = '".$this->db->escape($this->fk_category)."'";
			$sql .= ", fk_subcategory = '".$this->db->escape($this->fk_subcategory)."'";
			$sql .= ", fk_model = '".$this->db->escape($this->fk_model)."'";
			$sql .= ", fk_product = '".$this->db->escape($this->fk_product)."'";
			$sql .= ", fk_soc = '".$this->db->escape($this->fk_soc)."'";
			$sql .= ", ac_capacity = '".$this->db->escape($this->ac_capacity)."'";
			$sql .= ", component_no = '".$this->db->escape($this->component_no)."'";
			$sql .= ", fk_user = '".$this->db->escape($this->fk_user)."'";
			if(empty($this->amc_start_date)){
				$sql .= ", amc_start_date = NULL";
			}else{
				$sql .= ", amc_start_date = '".$this->db->escape($this->amc_start_date)."'";
			}
			if(empty($this->amc_end_date)){
				$sql .= ", amc_end_date = NULL";
			}else{
				$sql .= ", amc_end_date = '".$this->db->escape($this->amc_end_date)."'";
			}
					
			$sql .= ", product_odu = '".$this->db->escape($this->product_odu)."'";



			// stock field is not here because it is a denormalized value from product_stock.
			$sql .= " WHERE rowid = ".$id;
			
			dol_syslog(get_class($this)."::update", LOG_DEBUG);

			$resql = $this->db->query($sql);
			if ($resql) {
				$this->id = $id;

				$action = 'update';

				
				if (!$error) {
					$this->db->commit();
					return 1;
				} else {
					$this->db->rollback();
					return -$error;
				}
			} else {
				if ($this->db->errno() == 'DB_ERROR_RECORD_ALREADY_EXISTS') {
					$langs->load("errors");
					$this->errors[] = $this->error;
					$this->db->rollback();
					return -1;
				} else {
					$this->error = $langs->trans("Error")." : ".$this->db->error()." - ".$sql;
					$this->errors[] = $this->error;
					$this->db->rollback();
					return -2;
				}
			}
		} else {
			$this->db->rollback();
			dol_syslog(get_class($this)."::Update fails verify ".join(',', $this->errors), LOG_WARNING);
			return -3;
		}
	}

	/**
	 *  Delete a product from database (if not used)
	 *
	 * @param  User $user      User (object) deleting product
	 * @param  int  $notrigger Do not execute trigger
	 * @return int                    < 0 if KO, 0 = Not possible, > 0 if OK
	 */
	public function delete(User $user, $notrigger = 0)
	{
		global $conf, $langs;
		include_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';

		$error = 0;

		// Check parameters
		if (empty($this->id)) {
			$this->error = "Object must be fetched before calling delete";
			return -1;
		}
		if (($this->type == Product::TYPE_PRODUCT && empty($user->rights->produit->supprimer)) || ($this->type == Product::TYPE_SERVICE && empty($user->rights->service->supprimer))) {
			$this->error = "ErrorForbidden";
			return 0;
		}

		$objectisused = $this->isObjectUsed($this->id);
		if (empty($objectisused)) {
			$this->db->begin();

			if (!$error && empty($notrigger)) {
				// Call trigger
				$result = $this->call_trigger('PRODUCT_DELETE', $user);
				if ($result < 0) {
					$error++;
				}
				// End call triggers
			}

			// Delete from product_batch on product delete
			if (!$error) {
				$sql = "DELETE FROM ".MAIN_DB_PREFIX.'product_batch';
				$sql .= " WHERE fk_product_stock IN (";
				$sql .= "SELECT rowid FROM ".MAIN_DB_PREFIX.'product_stock';
				$sql .= " WHERE fk_product = ".(int) $this->id.")";

				$result = $this->db->query($sql);
				if (!$result) {
					$error++;
					$this->errors[] = $this->db->lasterror();
				}
			}

			// Delete all child tables
			if (!$error) {
				$elements = array('product_fournisseur_price', 'product_price', 'product_lang', 'categorie_product', 'product_stock', 'product_customer_price', 'product_lot'); // product_batch is done before
				foreach ($elements as $table)
				{
					if (!$error) {
						$sql = "DELETE FROM ".MAIN_DB_PREFIX.$table;
						$sql .= " WHERE fk_product = ".(int) $this->id;

						$result = $this->db->query($sql);
						if (!$result) {
							$error++;
							$this->errors[] = $this->db->lasterror();
						}
					}
				}
			}

			if (!$error) {
				include_once DOL_DOCUMENT_ROOT.'/variants/class/ProductCombination.class.php';
				include_once DOL_DOCUMENT_ROOT.'/variants/class/ProductCombination2ValuePair.class.php';

				//If it is a parent product, then we remove the association with child products
				$prodcomb = new ProductCombination($this->db);

				if ($prodcomb->deleteByFkProductParent($user, $this->id) < 0) {
					$error++;
					$this->errors[] = 'Error deleting combinations';
				}

				//We also check if it is a child product
				if (!$error && ($prodcomb->fetchByFkProductChild($this->id) > 0) && ($prodcomb->delete($user) < 0)) {
					$error++;
					$this->errors[] = 'Error deleting child combination';
				}
			}

			// Delete from product_association
			if (!$error) {
				$sql = "DELETE FROM ".MAIN_DB_PREFIX."product_association";
				$sql .= " WHERE fk_product_pere = ".(int) $this->id." OR fk_product_fils = ".(int) $this->id;

				$result = $this->db->query($sql);
				if (!$result) {
					$error++;
					$this->errors[] = $this->db->lasterror();
				}
			}

			// Remove extrafields
			if (!$error) {
				$result = $this->deleteExtraFields();
				if ($result < 0) {
					$error++;
					dol_syslog(get_class($this)."::delete error -4 ".$this->error, LOG_ERR);
				}
			}

			// Delete product
			if (!$error) {
				$sqlz = "DELETE FROM ".MAIN_DB_PREFIX."product";
				$sqlz .= " WHERE rowid = ".(int) $this->id;

				$resultz = $this->db->query($sqlz);
				if (!$resultz) {
					$error++;
					$this->errors[] = $this->db->lasterror();
				}
			}

			if (!$error) {
				// We remove directory
				$ref = dol_sanitizeFileName($this->ref);
				if ($conf->product->dir_output) {
					$dir = $conf->product->dir_output."/".$ref;
					if (file_exists($dir)) {
						$res = @dol_delete_dir_recursive($dir);
						if (!$res) {
							$this->errors[] = 'ErrorFailToDeleteDir';
							$error++;
						}
					}
				}
			}

			if (!$error) {
				$this->db->commit();
				return 1;
			} else {
				foreach ($this->errors as $errmsg)
				{
					dol_syslog(get_class($this)."::delete ".$errmsg, LOG_ERR);
					$this->error .= ($this->error ? ', '.$errmsg : $errmsg);
				}
				$this->db->rollback();
				return -$error;
			}
		} else {
			$this->error = "ErrorRecordIsUsedCantDelete";
			return 0;
		}
	}

	/**
	 *    Update or add a translation for a product
	 *
	 * @param  User $user Object user making update
	 * @return int        <0 if KO, >0 if OK
	 */
	public function setMultiLangs($user)
	{
		global $conf, $langs;

		$langs_available = $langs->get_available_languages(DOL_DOCUMENT_ROOT, 0, 2);
		$current_lang = $langs->getDefaultLang();

		foreach ($langs_available as $key => $value)
		{
			if ($key == $current_lang) {
				$sql = "SELECT rowid";
				$sql .= " FROM ".MAIN_DB_PREFIX."product_lang";
				$sql .= " WHERE fk_product=".$this->id;
				$sql .= " AND lang='".$this->db->escape($key)."'";

				$result = $this->db->query($sql);

				if ($this->db->num_rows($result)) // if there is already a description line for this language
				{
					$sql2 = "UPDATE ".MAIN_DB_PREFIX."product_lang";
					$sql2 .= " SET ";
					$sql2 .= " label='".$this->db->escape($this->label)."',";
					$sql2 .= " description='".$this->db->escape($this->description)."'";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) { $sql2 .= ", note='".$this->db->escape($this->other)."'";
					}
					$sql2 .= " WHERE fk_product=".$this->id." AND lang='".$this->db->escape($key)."'";
				} else {
					$sql2 = "INSERT INTO ".MAIN_DB_PREFIX."product_lang (fk_product, lang, label, description";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) { $sql2 .= ", note";
					}
					$sql2 .= ")";
					$sql2 .= " VALUES(".$this->id.",'".$this->db->escape($key)."','".$this->db->escape($this->label)."',";
					$sql2 .= " '".$this->db->escape($this->description)."'";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) {
						$sql2 .= ", '".$this->db->escape($this->other)."'";
					}
					$sql2 .= ")";
				}
				dol_syslog(get_class($this).'::setMultiLangs key = current_lang = '.$key);
				if (!$this->db->query($sql2)) {
					$this->error = $this->db->lasterror();
					return -1;
				}
			} elseif (isset($this->multilangs[$key])) {
				$sql = "SELECT rowid";
				$sql .= " FROM ".MAIN_DB_PREFIX."product_lang";
				$sql .= " WHERE fk_product=".$this->id;
				$sql .= " AND lang='".$this->db->escape($key)."'";

				$result = $this->db->query($sql);

				if ($this->db->num_rows($result)) // if there is already a description line for this language
				{
					$sql2 = "UPDATE ".MAIN_DB_PREFIX."product_lang";
					$sql2 .= " SET ";
					$sql2 .= " label='".$this->db->escape($this->multilangs["$key"]["label"])."',";
					$sql2 .= " description='".$this->db->escape($this->multilangs["$key"]["description"])."'";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) {
						$sql2 .= ", note='".$this->db->escape($this->multilangs["$key"]["other"])."'";
					}
					$sql2 .= " WHERE fk_product=".$this->id." AND lang='".$this->db->escape($key)."'";
				} else {
					$sql2 = "INSERT INTO ".MAIN_DB_PREFIX."product_lang (fk_product, lang, label, description";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) { $sql2 .= ", note";
					}
					$sql2 .= ")";
					$sql2 .= " VALUES(".$this->id.",'".$this->db->escape($key)."','".$this->db->escape($this->multilangs["$key"]["label"])."',";
					$sql2 .= " '".$this->db->escape($this->multilangs["$key"]["description"])."'";
					if (!empty($conf->global->PRODUCT_USE_OTHER_FIELD_IN_TRANSLATION)) {
						$sql2 .= ", '".$this->db->escape($this->multilangs["$key"]["other"])."'";
					}
					$sql2 .= ")";
				}

				// We do not save if main fields are empty
				if ($this->multilangs["$key"]["label"] || $this->multilangs["$key"]["description"]) {
					if (!$this->db->query($sql2)) {
						$this->error = $this->db->lasterror();
						return -1;
					}
				}
			} else {
				// language is not current language and we didn't provide a multilang description for this language
			}
		}

		// Call trigger
		$result = $this->call_trigger('PRODUCT_SET_MULTILANGS', $user);
		if ($result < 0) {
			$this->error = $this->db->lasterror();
			return -1;
		}
		// End call triggers

		return 1;
	}

	/**
	 *    Delete a language for this product
	 *
	 * @param string $langtodelete Language code to delete
	 * @param User   $user         Object user making delete
	 *
	 * @return int                            <0 if KO, >0 if OK
	 */
	public function delMultiLangs($langtodelete, $user)
	{
		$sql = "DELETE FROM ".MAIN_DB_PREFIX."product_lang";
		$sql .= " WHERE fk_product=".$this->id." AND lang='".$this->db->escape($langtodelete)."'";

		dol_syslog(get_class($this).'::delMultiLangs', LOG_DEBUG);
		$result = $this->db->query($sql);
		if ($result) {
			// Call trigger
			$result = $this->call_trigger('PRODUCT_DEL_MULTILANGS', $user);
			if ($result < 0) {
				$this->error = $this->db->lasterror();
				dol_syslog(get_class($this).'::delMultiLangs error='.$this->error, LOG_ERR);
				return -1;
			}
			// End call triggers
			return 1;
		} else {
			$this->error = $this->db->lasterror();
			dol_syslog(get_class($this).'::delMultiLangs error='.$this->error, LOG_ERR);
			return -1;
		}
	}

	/**
	 * Sets an accountancy code for a product.
	 * Also calls PRODUCT_MODIFY trigger when modified
	 *
	 * @param 	string $type 	It can be 'buy', 'buy_intra', 'buy_export', 'sell', 'sell_intra' or 'sell_export'
	 * @param 	string $value 	Accountancy code
	 * @return 	int 			<0 KO >0 OK
	 */
	public function setAccountancyCode($type, $value)
	{
		global $user, $langs, $conf;

		$error = 0;

		$this->db->begin();

		if ($type == 'buy') {
			$field = 'accountancy_code_buy';
		} elseif ($type == 'buy_intra') {
			$field = 'accountancy_code_buy_intra';
		} elseif ($type == 'buy_export') {
			$field = 'accountancy_code_buy_export';
		} elseif ($type == 'sell') {
			$field = 'accountancy_code_sell';
		} elseif ($type == 'sell_intra') {
			$field = 'accountancy_code_sell_intra';
		} elseif ($type == 'sell_export') {
			$field = 'accountancy_code_sell_export';
		} else {
			return -1;
		}

		$sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET ";
		$sql .= "$field = '".$this->db->escape($value)."'";
		$sql .= " WHERE rowid = ".$this->id;

		dol_syslog(__METHOD__." sql=".$sql, LOG_DEBUG);
		$resql = $this->db->query($sql);

		if ($resql) {
			// Call trigger
			$result = $this->call_trigger('PRODUCT_MODIFY', $user);
			if ($result < 0) $error++;
			// End call triggers

			if ($error) {
				$this->db->rollback();
				return -1;
			}

			$this->$field = $value;

			$this->db->commit();
			return 1;
		} else {
			$this->error = $this->db->lasterror();
			$this->db->rollback();
			return -1;
		}
	}

	/**
	 *    Load array this->multilangs
	 *
	 * @return int        <0 if KO, >0 if OK
	 */
	public function getMultiLangs()
	{
		global $langs;

		$current_lang = $langs->getDefaultLang();

		$sql = "SELECT lang, label, description, note as other";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_lang";
		$sql .= " WHERE fk_product=".$this->id;

		$result = $this->db->query($sql);
		if ($result) {
			while ($obj = $this->db->fetch_object($result))
			{
				//print 'lang='.$obj->lang.' current='.$current_lang.'<br>';
				if ($obj->lang == $current_lang)  // si on a les traduct. dans la langue courante on les charge en infos principales.
				{
					$this->label        = $obj->label;
					$this->description = $obj->description;
					$this->other        = $obj->other;
				}
				$this->multilangs["$obj->lang"]["label"]        = $obj->label;
				$this->multilangs["$obj->lang"]["description"] = $obj->description;
				$this->multilangs["$obj->lang"]["other"]        = $obj->other;
			}
			return 1;
		} else {
			$this->error = "Error: ".$this->db->lasterror()." - ".$sql;
			return -1;
		}
	}



	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Insert a track that we changed a customer price
	 *
	 * @param  User $user  User making change
	 * @param  int  $level price level to change
	 * @return int                    <0 if KO, >0 if OK
	 */
	private function _log_price($user, $level = 0)
	{
		// phpcs:enable
		global $conf;

		$now = dol_now();

		// Clean parameters
		if (empty($this->price_by_qty)) {
			$this->price_by_qty = 0;
		}

		// Add new price
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."product_price(price_level,date_price, fk_product, fk_user_author, price, price_ttc, price_base_type,tosell, tva_tx, default_vat_code, recuperableonly,";
		$sql .= " localtax1_tx, localtax2_tx, localtax1_type, localtax2_type, price_min,price_min_ttc,price_by_qty,entity,fk_price_expression) ";
		$sql .= " VALUES(".($level ? $level : 1).", '".$this->db->idate($now)."',".$this->id.",".$user->id.",".$this->price.",".$this->price_ttc.",'".$this->db->escape($this->price_base_type)."',".$this->status.",".$this->tva_tx.", ".($this->default_vat_code ? ("'".$this->db->escape($this->default_vat_code)."'") : "null").",".$this->tva_npr.",";
		$sql .= " ".$this->localtax1_tx.", ".$this->localtax2_tx.", '".$this->db->escape($this->localtax1_type)."', '".$this->db->escape($this->localtax2_type)."', ".$this->price_min.",".$this->price_min_ttc.",".$this->price_by_qty.",".$conf->entity.",".($this->fk_price_expression > 0 ? $this->fk_price_expression : 'null');
		$sql .= ")";
		
		dol_syslog(get_class($this)."::_log_price", LOG_DEBUG);
		$resql = $this->db->query($sql);
		if (!$resql) {
			$this->error = $this->db->lasterror();
			dol_print_error($this->db);
			return -1;
		} else {
			return 1;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Delete a price line
	 *
	 * @param  User $user  Object user
	 * @param  int  $rowid Line id to delete
	 * @return int                <0 if KO, >0 if OK
	 */
	public function log_price_delete($user, $rowid)
	{
		// phpcs:enable
		$sql = "DELETE FROM ".MAIN_DB_PREFIX."product_price_by_qty";
		$sql .= " WHERE fk_product_price=".$rowid;
		$resql = $this->db->query($sql);

		$sql = "DELETE FROM ".MAIN_DB_PREFIX."product_price";
		$sql .= " WHERE rowid=".$rowid;
		$resql = $this->db->query($sql);
		if ($resql) {
			return 1;
		} else {
			$this->error = $this->db->lasterror();
			return -1;
		}
	}


	/**
	 * Return price of sell of a product for a seller/buyer/product.
	 *
	 * @param	Societe		$thirdparty_seller		Seller
	 * @param	Societe		$thirdparty_buyer		Buyer
	 * @param	int			$pqp					Id of product price per quantity if a selection was done of such a price
	 * @return	array								Array of price information array('pu_ht'=> , 'pu_ttc'=> , 'tva_tx'=>'X.Y (code)', ...), 'tva_npr'=>0, ...)
	 * @see get_buyprice(), find_min_price_product_fournisseur()
	 */
	public function getSellPrice($thirdparty_seller, $thirdparty_buyer, $pqp = 0)
	{
		global $conf, $db;

		// Update if prices fields are defined
		$tva_tx = get_default_tva($thirdparty_seller, $thirdparty_buyer, $this->id);
		$tva_npr = get_default_npr($thirdparty_seller, $thirdparty_buyer, $this->id);
		if (empty($tva_tx)) $tva_npr = 0;

		$pu_ht = $this->price;
		$pu_ttc = $this->price_ttc;
		$price_min = $this->price_min;
		$price_base_type = $this->price_base_type;

		// If price per segment
		if (!empty($conf->global->PRODUIT_MULTIPRICES) && !empty($thirdparty_buyer->price_level)) {
			$pu_ht = $this->multiprices[$thirdparty_buyer->price_level];
			$pu_ttc = $this->multiprices_ttc[$thirdparty_buyer->price_level];
			$price_min = $this->multiprices_min[$thirdparty_buyer->price_level];
			$price_base_type = $this->multiprices_base_type[$thirdparty_buyer->price_level];
			if (!empty($conf->global->PRODUIT_MULTIPRICES_USE_VAT_PER_LEVEL))  // using this option is a bug. kept for backward compatibility
			{
				if (isset($this->multiprices_tva_tx[$thirdparty_buyer->price_level])) $tva_tx = $this->multiprices_tva_tx[$thirdparty_buyer->price_level];
				if (isset($this->multiprices_recuperableonly[$thirdparty_buyer->price_level])) $tva_npr = $this->multiprices_recuperableonly[$thirdparty_buyer->price_level];
				if (empty($tva_tx)) $tva_npr = 0;
			}
		} elseif (!empty($conf->global->PRODUIT_CUSTOMER_PRICES)) {
			// If price per customer
			require_once DOL_DOCUMENT_ROOT.'/product/class/productcustomerprice.class.php';

			$prodcustprice = new Productcustomerprice($this->db);

			$filter = array('t.fk_product' => $this->id, 't.fk_soc' => $thirdparty_buyer->id);

			$result = $prodcustprice->fetch_all('', '', 0, 0, $filter);
			if ($result) {
				if (count($prodcustprice->lines) > 0) {
					$pu_ht = price($prodcustprice->lines[0]->price);
					$pu_ttc = price($prodcustprice->lines[0]->price_ttc);
					$price_base_type = $prodcustprice->lines[0]->price_base_type;
					$tva_tx = $prodcustprice->lines[0]->tva_tx;
					if ($prodcustprice->lines[0]->default_vat_code && !preg_match('/\(.*\)/', $tva_tx)) $tva_tx .= ' ('.$prodcustprice->lines[0]->default_vat_code.')';
					$tva_npr = $prodcustprice->lines[0]->recuperableonly;
					if (empty($tva_tx)) $tva_npr = 0;
				}
			}
		} elseif (!empty($conf->global->PRODUIT_CUSTOMER_PRICES_BY_QTY)) {
			// If price per quantity
			if ($this->prices_by_qty[0]) {
				// yes, this product has some prices per quantity
				// Search price into product_price_by_qty from $this->id
				foreach ($this->prices_by_qty_list[0] as $priceforthequantityarray) {
					if ($priceforthequantityarray['rowid'] != $pqp) continue;
					// We found the price
					if ($priceforthequantityarray['price_base_type'] == 'HT')
					{
						$pu_ht = $priceforthequantityarray['unitprice'];
					} else {
						$pu_ttc = $priceforthequantityarray['unitprice'];
					}
					break;
				}
			}
		} elseif (!empty($conf->global->PRODUIT_CUSTOMER_PRICES_BY_QTY_MULTIPRICES)) {
			// If price per quantity and customer
			if ($this->prices_by_qty[$thirdparty_buyer->price_level]) {
				// yes, this product has some prices per quantity
				// Search price into product_price_by_qty from $this->id
				foreach ($this->prices_by_qty_list[$thirdparty_buyer->price_level] as $priceforthequantityarray)
				{
					if ($priceforthequantityarray['rowid'] != $pqp) continue;
					// We found the price
					if ($priceforthequantityarray['price_base_type'] == 'HT')
					{
						$pu_ht = $priceforthequantityarray['unitprice'];
					} else {
						$pu_ttc = $priceforthequantityarray['unitprice'];
					}
					break;
				}
			}
		}

		return array('pu_ht'=>$pu_ht, 'pu_ttc'=>$pu_ttc, 'price_min'=>$price_min, 'price_base_type'=>$price_base_type, 'tva_tx'=>$tva_tx, 'tva_npr'=>$tva_npr);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Read price used by a provider.
	 * We enter as input couple prodfournprice/qty or triplet qty/product_id/fourn_ref.
	 * This also set some properties on product like ->buyprice, ->fourn_pu, ...
	 *
	 * @param  int    $prodfournprice Id du tarif = rowid table product_fournisseur_price
	 * @param  double $qty            Quantity asked or -1 to get first entry found
	 * @param  int    $product_id     Filter on a particular product id
	 * @param  string $fourn_ref      Filter on a supplier price ref. 'none' to exclude ref in search.
	 * @param  int    $fk_soc         If of supplier
	 * @return int                    <-1 if KO, -1 if qty not enough, 0 if OK but nothing found, id_product if OK and found. May also initialize some properties like (->ref_supplier, buyprice, fourn_pu, vatrate_supplier...)
	 * @see getSellPrice(), find_min_price_product_fournisseur()
	 */
	public function get_buyprice($prodfournprice, $qty, $product_id = 0, $fourn_ref = '', $fk_soc = 0)
	{
		// phpcs:enable
		global $conf;
		$result = 0;

		// We do a first seach with a select by searching with couple prodfournprice and qty only (later we will search on triplet qty/product_id/fourn_ref)
		$sql = "SELECT pfp.rowid, pfp.price as price, pfp.quantity as quantity, pfp.remise_percent,";
		$sql .= " pfp.fk_product, pfp.ref_fourn, pfp.desc_fourn, pfp.fk_soc, pfp.tva_tx, pfp.fk_supplier_price_expression,";
		$sql .= " pfp.default_vat_code,";
		$sql .= " pfp.multicurrency_price, pfp.multicurrency_unitprice, pfp.multicurrency_tx, pfp.fk_multicurrency, pfp.multicurrency_code";
		if (!empty($conf->global->PRODUCT_USE_SUPPLIER_PACKAGING)) $sql .= ", pfp.packaging";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price as pfp";
		$sql .= " WHERE pfp.rowid = ".$prodfournprice;
		if ($qty > 0) { $sql .= " AND pfp.quantity <= ".$qty;
		}
		$sql .= " ORDER BY pfp.quantity DESC";

		dol_syslog(get_class($this)."::get_buyprice first search by prodfournprice/qty", LOG_DEBUG);
		$resql = $this->db->query($sql);
		if ($resql) {
			$obj = $this->db->fetch_object($resql);
			if ($obj && $obj->quantity > 0)        // If we found a supplier prices from the id of supplier price
			{
				if (!empty($conf->dynamicprices->enabled) && !empty($obj->fk_supplier_price_expression)) {
					include_once DOL_DOCUMENT_ROOT.'/product/dynamic_price/class/price_parser.class.php';
					$prod_supplier = new ProductFournisseur($this->db);
					$prod_supplier->product_fourn_price_id = $obj->rowid;
					$prod_supplier->id = $obj->fk_product;
					$prod_supplier->fourn_qty = $obj->quantity;
					$prod_supplier->fourn_tva_tx = $obj->tva_tx;
					$prod_supplier->fk_supplier_price_expression = $obj->fk_supplier_price_expression;
					$priceparser = new PriceParser($this->db);
					$price_result = $priceparser->parseProductSupplier($prod_supplier);
					if ($price_result >= 0) {
						$obj->price = $price_result;
					}
				}
				$this->product_fourn_price_id = $obj->rowid;
				$this->buyprice = $obj->price; // deprecated
				$this->fourn_pu = $obj->price / $obj->quantity; // Unit price of product of supplier
				$this->fourn_price_base_type = 'HT'; // Price base type
				$this->fourn_socid = $obj->fk_soc; // Company that offer this price
				$this->ref_fourn = $obj->ref_fourn; // deprecated
				$this->ref_supplier = $obj->ref_fourn; // Ref supplier
				$this->desc_supplier = $obj->desc_fourn; // desc supplier
				$this->remise_percent = $obj->remise_percent; // remise percent if present and not typed
				$this->vatrate_supplier = $obj->tva_tx; // Vat ref supplier
				$this->default_vat_code = $obj->default_vat_code; // Vat code supplier
				$this->fourn_multicurrency_price       = $obj->multicurrency_price;
				$this->fourn_multicurrency_unitprice   = $obj->multicurrency_unitprice;
				$this->fourn_multicurrency_tx          = $obj->multicurrency_tx;
				$this->fourn_multicurrency_id          = $obj->fk_multicurrency;
				$this->fourn_multicurrency_code        = $obj->multicurrency_code;
				if (!empty($conf->global->PRODUCT_USE_SUPPLIER_PACKAGING)) $this->packaging = $obj->packaging;
				$result = $obj->fk_product;
				return $result;
			} else { // If not found
				// We do a second search by doing a select again but searching with less reliable criteria: couple qty/id product, and if set fourn_ref or fk_soc.
				$sql = "SELECT pfp.rowid, pfp.price as price, pfp.quantity as quantity, pfp.remise_percent, pfp.fk_soc,";
				$sql .= " pfp.fk_product, pfp.ref_fourn as ref_supplier, pfp.desc_fourn as desc_supplier, pfp.tva_tx, pfp.fk_supplier_price_expression,";
				$sql .= " pfp.default_vat_code,";
				$sql .= " pfp.multicurrency_price, pfp.multicurrency_unitprice, pfp.multicurrency_tx, pfp.fk_multicurrency, pfp.multicurrency_code,";
				$sql .= " pfp.packaging";
				$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price as pfp";
				$sql .= " WHERE pfp.fk_product = ".$product_id;
				if ($fourn_ref != 'none') { $sql .= " AND pfp.ref_fourn = '".$this->db->escape($fourn_ref)."'";
				}
				if ($fk_soc > 0) { $sql .= " AND pfp.fk_soc = ".$fk_soc;
				}
				if ($qty > 0) { $sql .= " AND pfp.quantity <= ".$qty;
				}
				$sql .= " ORDER BY pfp.quantity DESC";
				$sql .= " LIMIT 1";

				dol_syslog(get_class($this)."::get_buyprice second search from qty/ref/product_id", LOG_DEBUG);
				$resql = $this->db->query($sql);
				if ($resql) {
					$obj = $this->db->fetch_object($resql);
					if ($obj && $obj->quantity > 0)        // If found
					{
						if (!empty($conf->dynamicprices->enabled) && !empty($obj->fk_supplier_price_expression)) {
							include_once DOL_DOCUMENT_ROOT.'/product/dynamic_price/class/price_parser.class.php';
							$prod_supplier = new ProductFournisseur($this->db);
							$prod_supplier->product_fourn_price_id = $obj->rowid;
							$prod_supplier->id = $obj->fk_product;
							$prod_supplier->fourn_qty = $obj->quantity;
							$prod_supplier->fourn_tva_tx = $obj->tva_tx;
							$prod_supplier->fk_supplier_price_expression = $obj->fk_supplier_price_expression;
							$priceparser = new PriceParser($this->db);
							$price_result = $priceparser->parseProductSupplier($prod_supplier);
							if ($result >= 0) {
								$obj->price = $price_result;
							}
						}
						$this->product_fourn_price_id = $obj->rowid;
						$this->buyprice = $obj->price; // deprecated
						$this->fourn_qty = $obj->quantity; // min quantity for price for a virtual supplier
						$this->fourn_pu = $obj->price / $obj->quantity; // Unit price of product for a virtual supplier
						$this->fourn_price_base_type = 'HT'; // Price base type for a virtual supplier
						$this->fourn_socid = $obj->fk_soc; // Company that offer this price
						$this->ref_fourn = $obj->ref_supplier; // deprecated
						$this->ref_supplier = $obj->ref_supplier; // Ref supplier
						$this->desc_supplier = $obj->desc_supplier; // desc supplier
						$this->remise_percent = $obj->remise_percent; // remise percent if present and not typed
						$this->vatrate_supplier = $obj->tva_tx; // Vat ref supplier
						$this->default_vat_code = $obj->default_vat_code; // Vat code supplier
						$this->fourn_multicurrency_price       = $obj->multicurrency_price;
						$this->fourn_multicurrency_unitprice   = $obj->multicurrency_unitprice;
						$this->fourn_multicurrency_tx          = $obj->multicurrency_tx;
						$this->fourn_multicurrency_id          = $obj->fk_multicurrency;
						$this->fourn_multicurrency_code        = $obj->multicurrency_code;
						if (!empty($conf->global->PRODUCT_USE_SUPPLIER_PACKAGING)) $this->packaging = $obj->packaging;
						$result = $obj->fk_product;
						return $result;
					} else {
						return -1; // Ce produit n'existe pas avec cet id tarif fournisseur ou existe mais qte insuffisante, ni pour le couple produit/ref fournisseur dans la quantité.
					}
				} else {
					$this->error = $this->db->lasterror();
					return -3;
				}
			}
		} else {
			$this->error = $this->db->lasterror();
			return -2;
		}
	}


	/**
	 *    Modify customer price of a product/Service
	 *
	 * @param  double $newprice          New price
	 * @param  string $newpricebase      HT or TTC
	 * @param  User   $user              Object user that make change
	 * @param  double $newvat            New VAT Rate (For example 8.5. Should not be a string)
	 * @param  double $newminprice       New price min
	 * @param  int    $level             0=standard, >0 = level if multilevel prices
	 * @param  int    $newnpr            0=Standard vat rate, 1=Special vat rate for French NPR VAT
	 * @param  int    $newpbq            1 if it has price by quantity
	 * @param  int    $ignore_autogen    Used to avoid infinite loops
	 * @param  array  $localtaxes_array  Array with localtaxes info array('0'=>type1,'1'=>rate1,'2'=>type2,'3'=>rate2) (loaded by getLocalTaxesFromRate(vatrate, 0, ...) function).
	 * @param  string $newdefaultvatcode Default vat code
	 * @return int                            <0 if KO, >0 if OK
	 */
	public function updatePrice($newprice, $newpricebase, $user, $newvat = '', $newminprice = 0, $level = 0, $newnpr = 0, $newpbq = 0, $ignore_autogen = 0, $localtaxes_array = array(), $newdefaultvatcode = '')
	{
		global $conf, $langs;

		$id = $this->id;

		dol_syslog(get_class($this)."::update_price id=".$id." newprice=".$newprice." newpricebase=".$newpricebase." newminprice=".$newminprice." level=".$level." npr=".$newnpr." newdefaultvatcode=".$newdefaultvatcode);

		// Clean parameters
		if (empty($this->tva_tx)) {
			$this->tva_tx = 0;
		}
		if (empty($newnpr)) {
			$newnpr = 0;
		}
		if (empty($newminprice)) {
			$newminprice = 0;
		}
		if (empty($newminprice)) {
			$newminprice = 0;
		}

		// Check parameters
		if ($newvat == '') {
			$newvat = $this->tva_tx;
		}

		// If multiprices are enabled, then we check if the current product is subject to price autogeneration
		// Price will be modified ONLY when the first one is the one that is being modified
		if ((!empty($conf->global->PRODUIT_MULTIPRICES) || !empty($conf->global->PRODUIT_CUSTOMER_PRICES_BY_QTY_MULTIPRICES)) && !$ignore_autogen && $this->price_autogen && ($level == 1)) {
			return $this->generateMultiprices($user, $newprice, $newpricebase, $newvat, $newnpr, $newpbq);
		}

		if (!empty($newminprice) && ($newminprice > $newprice)) {
			$this->error = 'ErrorPriceCantBeLowerThanMinPrice';
			return -1;
		}

		if ($newprice !== '' || $newprice === 0) {
			if ($newpricebase == 'TTC') {
				$price_ttc = price2num($newprice, 'MU');
				$price = price2num($newprice) / (1 + ($newvat / 100));
				$price = price2num($price, 'MU');

				if ($newminprice != '' || $newminprice == 0) {
					$price_min_ttc = price2num($newminprice, 'MU');
					$price_min = price2num($newminprice) / (1 + ($newvat / 100));
					$price_min = price2num($price_min, 'MU');
				} else {
					$price_min = 0;
					$price_min_ttc = 0;
				}
			} else {
				$price = price2num($newprice, 'MU');
				$price_ttc = ($newnpr != 1) ? price2num($newprice) * (1 + ($newvat / 100)) : $price;
				$price_ttc = price2num($price_ttc, 'MU');

				if ($newminprice !== '' || $newminprice === 0) {
					$price_min = price2num($newminprice, 'MU');
					$price_min_ttc = price2num($newminprice) * (1 + ($newvat / 100));
					$price_min_ttc = price2num($price_min_ttc, 'MU');
					//print 'X'.$newminprice.'-'.$price_min;
				} else {
					$price_min = 0;
					$price_min_ttc = 0;
				}
			}
			//print 'x'.$id.'-'.$newprice.'-'.$newpricebase.'-'.$price.'-'.$price_ttc.'-'.$price_min.'-'.$price_min_ttc;

			if (count($localtaxes_array) > 0) {
				$localtaxtype1 = $localtaxes_array['0'];
				$localtax1 = $localtaxes_array['1'];
				$localtaxtype2 = $localtaxes_array['2'];
				$localtax2 = $localtaxes_array['3'];
			} else // old method. deprecated because ot can't retrieve type
			{
				$localtaxtype1 = '0';
				$localtax1 = get_localtax($newvat, 1);
				$localtaxtype2 = '0';
				$localtax2 = get_localtax($newvat, 2);
			}
			if (empty($localtax1)) {
				$localtax1 = 0; // If = '' then = 0
			}
			if (empty($localtax2)) {
				$localtax2 = 0; // If = '' then = 0
			}

			$this->db->begin();

			// Ne pas mettre de quote sur les numeriques decimaux.
			// Ceci provoque des stockages avec arrondis en base au lieu des valeurs exactes.
			$sql = "UPDATE ".MAIN_DB_PREFIX."product SET";
			$sql .= " price_base_type='".$this->db->escape($newpricebase)."',";
			$sql .= " price=".$price.",";
			$sql .= " price_ttc=".$price_ttc.",";
			$sql .= " price_min=".$price_min.",";
			$sql .= " price_min_ttc=".$price_min_ttc.",";
			$sql .= " localtax1_tx=".($localtax1 >= 0 ? $localtax1 : 'NULL').",";
			$sql .= " localtax2_tx=".($localtax2 >= 0 ? $localtax2 : 'NULL').",";
			$sql .= " localtax1_type=".($localtaxtype1 != '' ? "'".$this->db->escape($localtaxtype1)."'" : "'0'").",";
			$sql .= " localtax2_type=".($localtaxtype2 != '' ? "'".$this->db->escape($localtaxtype2)."'" : "'0'").",";
			$sql .= " default_vat_code=".($newdefaultvatcode ? "'".$this->db->escape($newdefaultvatcode)."'" : "null").",";
			$sql .= " tva_tx='".price2num($newvat)."',";
			$sql .= " recuperableonly='".$this->db->escape($newnpr)."'";
			$sql .= " WHERE rowid = ".$id;

			dol_syslog(get_class($this)."::update_price", LOG_DEBUG);
			$resql = $this->db->query($sql);
			if ($resql) {
				$this->multiprices[$level] = $price;
				$this->multiprices_ttc[$level] = $price_ttc;
				$this->multiprices_min[$level] = $price_min;
				$this->multiprices_min_ttc[$level] = $price_min_ttc;
				$this->multiprices_base_type[$level] = $newpricebase;
				$this->multiprices_default_vat_code[$level] = $newdefaultvatcode;
				$this->multiprices_tva_tx[$level] = $newvat;
				$this->multiprices_recuperableonly[$level] = $newnpr;

				$this->price = $price;
				$this->price_ttc = $price_ttc;
				$this->price_min = $price_min;
				$this->price_min_ttc = $price_min_ttc;
				$this->price_base_type = $newpricebase;
				$this->default_vat_code = $newdefaultvatcode;
				$this->tva_tx = $newvat;
				$this->tva_npr = $newnpr;
				//Local taxes
				$this->localtax1_tx = $localtax1;
				$this->localtax2_tx = $localtax2;
				$this->localtax1_type = $localtaxtype1;
				$this->localtax2_type = $localtaxtype2;

				// Price by quantity
				$this->price_by_qty = $newpbq;

				$this->_log_price($user, $level); // Save price for level into table product_price

				$this->level = $level; // Store level of price edited for trigger

				// Call trigger
				$result = $this->call_trigger('PRODUCT_PRICE_MODIFY', $user);
				if ($result < 0) {
					$this->db->rollback();
					return -1;
				}
				// End call triggers

				$this->db->commit();
			} else {
				$this->db->rollback();
				dol_print_error($this->db);
			}
		}

		return 1;
	}

	/**
	 *  Sets the supplier price expression
	 *
	 * @param      int $expression_id Expression
	 * @return     int                     <0 if KO, >0 if OK
	 * @deprecated Use Product::update instead
	 */
	public function setPriceExpression($expression_id)
	{
		global $user;

		$this->fk_price_expression = $expression_id;

		return $this->update($this->id, $user);
	}

	/**
	 *  Load a product in memory from database
	 *
	 * @param  int    $id                Id of product/service to load
	 * @param  string $ref               Ref of product/service to load
	 * @param  string $ref_ext           Ref ext of product/service to load
	 * @param  string $barcode           Barcode of product/service to load
	 * @param  int    $ignore_expression Ignores the math expression for calculating price and uses the db value instead
	 * @param  int    $ignore_price_load Load product without loading prices arrays (when we are sure we don't need them)
	 * @param  int    $ignore_lang_load  Load product without loading language arrays (when we are sure we don't need them)
	 * @return int                       <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetch($id = '', $ref = '', $ref_ext = '', $barcode = '', $ignore_expression = 0, $ignore_price_load = 0, $ignore_lang_load = 0)
	{
		include_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';

		global $langs, $conf;

		dol_syslog(get_class($this)."::fetch id=".$id." ref_ext=".$ref_ext);

		// Check parameters
		if (!$id && !$ref_ext && !$barcode) {
			$this->error = 'ErrorWrongParameters';
			dol_syslog(get_class($this)."::fetch ".$this->error);
			return -1;
		}

		$sql = "SELECT rowid, entity, datec, tms, fk_brand, fk_category, fk_subcategory, fk_model, fk_product, fk_soc, ac_capacity, component_no, fk_user, import_key, amc_start_date, amc_end_date, product_odu";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_customer";
		if ($id) {
			$sql .= " WHERE rowid = ".(int) $id;
		} else {
			$sql .= " WHERE entity IN (".getEntity($this->element).")";
			if ($ref) {
				$sql .= " AND ref = '".$this->db->escape($ref)."'";
			} elseif ($ref_ext) {
				$sql .= " AND ref_ext = '".$this->db->escape($ref_ext)."'";
			} elseif ($barcode) {
				$sql .= " AND barcode = '".$this->db->escape($barcode)."'";
			}
		}

		$resql = $this->db->query($sql);
		if ($resql) {
			unset($this->oldcopy);

			if ($this->db->num_rows($resql) > 0) {
				$obj = $this->db->fetch_object($resql);

				$this->id = $obj->rowid;

				$this->fk_brand                		 = $obj->fk_brand;
				$this->fk_category               	 = $obj->fk_category;
				$this->fk_subcategory                = $obj->fk_subcategory;
				$this->fk_model                		 = $obj->fk_model;
				$this->fk_product                	 = $obj->fk_product;
				$this->fk_soc                		 = $obj->fk_soc;
				$this->ac_capacity                	 = $obj->ac_capacity;
				$this->component_no                	 = $obj->component_no;
				$this->fk_user                		 = $obj->fk_user;

				$this->date_creation                 = $obj->datec;
				$this->date_modification             = $obj->tms;
				$this->import_key                    = $obj->import_key;
				$this->entity                        = $obj->entity;

				$this->amc_start_date                = $obj->amc_start_date;
				$this->amc_end_date                  = $obj->amc_end_date;
				$this->product_odu                   = $obj->product_odu;

				$this->db->free($resql);

				return 1;
			} else {
				return 0;
			}
		} else {
			$this->error = $this->db->lasterror;
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats OF pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_mo, <0 if ko or >0 if ok
	 */
	public function load_stats_mo($socid = 0)
	{
		// phpcs:enable
		global $user, $hookmanager, $action;

		$error = 0;

		foreach (array('toconsume', 'consumed', 'toproduce', 'produced') as $role) {
			$this->stats_mo['customers_'.$role] = 0;
			$this->stats_mo['nb_'.$role] = 0;
			$this->stats_mo['qty_'.$role] = 0;

			$sql = "SELECT COUNT(DISTINCT c.fk_soc) as nb_customers, COUNT(DISTINCT c.rowid) as nb,";
			$sql .= " SUM(mp.qty) as qty";
			$sql .= " FROM ".MAIN_DB_PREFIX."mrp_mo as c";
			$sql .= " INNER JOIN ".MAIN_DB_PREFIX."mrp_production as mp ON mp.fk_mo=c.rowid";
			if (empty($user->rights->societe->client->voir) && !$socid) {
				$sql .= "INNER JOIN ".MAIN_DB_PREFIX."societe_commerciaux as sc ON sc.fk_soc=c.fk_soc AND sc.fk_user = ".$user->id;
			}
			$sql .= " WHERE ";
			$sql .= " c.entity IN (".getEntity('mo').")";

			$sql .= " AND mp.fk_product =".$this->id;
			$sql .= " AND mp.role ='".$this->db->escape($role)."'";
			if ($socid > 0) {
				$sql .= " AND c.fk_soc = ".$socid;
			}

			$result = $this->db->query($sql);
			if ($result) {
				$obj = $this->db->fetch_object($result);
				$this->stats_mo['customers_'.$role] = $obj->nb_customers ? $obj->nb_customers : 0;
				$this->stats_mo['nb_'.$role] = $obj->nb ? $obj->nb : 0;
				$this->stats_mo['qty_'.$role] = $obj->qty ? $obj->qty : 0;
			} else {
				$this->error = $this->db->error();
				$error++;
			}
		}

		if (!empty($error)) {
			return -1;
		}

		$parameters = array('socid' => $socid);
		$reshook = $hookmanager->executeHooks('loadStatsCustomerMO', $parameters, $this, $action);
		if ($reshook > 0) $this->stats_mo = $hookmanager->resArray['stats_mo'];

		return 1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats OF pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_bom, <0 if ko or >0 if ok
	 */
	public function load_stats_bom($socid = 0)
	{
		// phpcs:enable
		global $user, $hookmanager;

		$error = 0;

		$this->stats_bom['nb_toproduce'] = 0;
		$this->stats_bom['nb_toconsume'] = 0;
		$this->stats_bom['qty_toproduce'] = 0;
		$this->stats_bom['qty_toconsume'] = 0;

		$sql = "SELECT COUNT(DISTINCT b.rowid) as nb_toproduce,";
		$sql .= " b.qty as qty_toproduce";
		$sql .= " FROM ".MAIN_DB_PREFIX."bom_bom as b";
		$sql .= " INNER JOIN ".MAIN_DB_PREFIX."bom_bomline as bl ON bl.fk_bom=b.rowid";
		$sql .= " WHERE ";
		$sql .= " b.entity IN (".getEntity('bom').")";
		$sql .= " AND b.fk_product =".$this->id;
		$sql .= " GROUP BY b.rowid";

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_bom['nb_toproduce'] = $obj->nb_toproduce ? $obj->nb_toproduce : 0;
			$this->stats_bom['qty_toproduce'] = $obj->qty_toproduce ? price2num($obj->qty_toproduce) : 0;
		} else {
			$this->error = $this->db->error();
			$error++;
		}

		$sql = "SELECT COUNT(DISTINCT bl.rowid) as nb_toconsume,";
		$sql .= " SUM(bl.qty) as qty_toconsume";
		$sql .= " FROM ".MAIN_DB_PREFIX."bom_bom as b";
		$sql .= " INNER JOIN ".MAIN_DB_PREFIX."bom_bomline as bl ON bl.fk_bom=b.rowid";
		$sql .= " WHERE ";
		$sql .= " b.entity IN (".getEntity('bom').")";
		$sql .= " AND bl.fk_product =".$this->id;

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_bom['nb_toconsume'] = $obj->nb_toconsume ? $obj->nb_toconsume : 0;
			$this->stats_bom['qty_toconsume'] = $obj->qty_toconsume ? price2num($obj->qty_toconsume) : 0;
		} else {
			$this->error = $this->db->error();
			$error++;
		}

		if (!empty($error)) {
			return -1;
		}

		$parameters = array('socid' => $socid);
		$reshook = $hookmanager->executeHooks('loadStatsCustomerMO', $parameters, $this, $action);
		if ($reshook > 0) $this->stats_bom = $hookmanager->resArray['stats_bom'];

		return 1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats propale pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_propale, <0 if ko or >0 if ok
	 */
	public function load_stats_propale($socid = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT p.fk_soc) as nb_customers, COUNT(DISTINCT p.rowid) as nb,";
		$sql .= " COUNT(pd.rowid) as nb_rows, SUM(pd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."propaldet as pd";
		$sql .= ", ".MAIN_DB_PREFIX."propal as p";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE p.rowid = pd.fk_propal";
		$sql .= " AND p.fk_soc = s.rowid";
		$sql .= " AND p.entity IN (".getEntity('propal').")";
		$sql .= " AND pd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND p.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		//$sql.= " AND pr.fk_statut != 0";
		if ($socid > 0) {
			$sql .= " AND p.fk_soc = ".$socid;
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_propale['customers'] = $obj->nb_customers;
			$this->stats_propale['nb'] = $obj->nb;
			$this->stats_propale['rows'] = $obj->nb_rows;
			$this->stats_propale['qty'] = $obj->qty ? $obj->qty : 0;

			// if it's a virtual product, maybe it is in proposal by extension
			if (!empty($conf->global->PRODUCT_STATS_WITH_PARENT_PROD_IF_INCDEC)) {
				$TFather = $this->getFather();
				if (is_array($TFather) && !empty($TFather)) {
					foreach ($TFather as &$fatherData) {
						$pFather = new Product($this->db);
						$pFather->id = $fatherData['id'];
						$qtyCoef = $fatherData['qty'];

						if ($fatherData['incdec']) {
							$pFather->load_stats_propale($socid);

							$this->stats_propale['customers'] += $pFather->stats_propale['customers'];
							$this->stats_propale['nb'] += $pFather->stats_propale['nb'];
							$this->stats_propale['rows'] += $pFather->stats_propale['rows'];
							$this->stats_propale['qty'] += $pFather->stats_propale['qty'] * $qtyCoef;
						}
					}
				}
			}

			$parameters = array('socid' => $socid);
			$reshook = $hookmanager->executeHooks('loadStatsCustomerProposal', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_propale = $hookmanager->resArray['stats_propale'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats propale pour le produit/service
	 *
	 * @param  int $socid Id thirdparty
	 * @return int                     Array of stats in $this->stats_proposal_supplier, <0 if ko or >0 if ok
	 */
	public function load_stats_proposal_supplier($socid = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager, $action;

		$sql = "SELECT COUNT(DISTINCT p.fk_soc) as nb_suppliers, COUNT(DISTINCT p.rowid) as nb,";
		$sql .= " COUNT(pd.rowid) as nb_rows, SUM(pd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."supplier_proposaldet as pd";
		$sql .= ", ".MAIN_DB_PREFIX."supplier_proposal as p";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE p.rowid = pd.fk_supplier_proposal";
		$sql .= " AND p.fk_soc = s.rowid";
		$sql .= " AND p.entity IN (".getEntity('supplier_proposal').")";
		$sql .= " AND pd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND p.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		//$sql.= " AND pr.fk_statut != 0";
		if ($socid > 0) {
			$sql .= " AND p.fk_soc = ".$socid;
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_proposal_supplier['suppliers'] = $obj->nb_suppliers;
			$this->stats_proposal_supplier['nb'] = $obj->nb;
			$this->stats_proposal_supplier['rows'] = $obj->nb_rows;
			$this->stats_proposal_supplier['qty'] = $obj->qty ? $obj->qty : 0;

			$parameters = array('socid' => $socid);
			$reshook = $hookmanager->executeHooks('loadStatsSupplierProposal', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_proposal_supplier = $hookmanager->resArray['stats_proposal_supplier'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats commande client pour le produit/service
	 *
	 * @param  int    $socid           Id societe pour filtrer sur une societe
	 * @param  string $filtrestatut    Id statut pour filtrer sur un statut
	 * @param  int    $forVirtualStock Ignore rights filter for virtual stock calculation.
	 * @return integer                 Array of stats in $this->stats_commande (nb=nb of order, qty=qty ordered), <0 if ko or >0 if ok
	 */
	public function load_stats_commande($socid = 0, $filtrestatut = '', $forVirtualStock = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT c.fk_soc) as nb_customers, COUNT(DISTINCT c.rowid) as nb,";
		$sql .= " COUNT(cd.rowid) as nb_rows, SUM(cd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."commandedet as cd";
		$sql .= ", ".MAIN_DB_PREFIX."commande as c";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE c.rowid = cd.fk_commande";
		$sql .= " AND c.fk_soc = s.rowid";
		$sql .= " AND c.entity IN (".getEntity($forVirtualStock && !empty($conf->global->STOCK_CALCULATE_VIRTUAL_STOCK_TRANSVERSE_MODE) ? 'stock' : 'commande').")";
		$sql .= " AND cd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}
		if ($filtrestatut <> '') {
			$sql .= " AND c.fk_statut in (".$this->db->sanitize($filtrestatut).")";
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_commande['customers'] = $obj->nb_customers;
			$this->stats_commande['nb'] = $obj->nb;
			$this->stats_commande['rows'] = $obj->nb_rows;
			$this->stats_commande['qty'] = $obj->qty ? $obj->qty : 0;

			// if it's a virtual product, maybe it is in order by extension
			if (!empty($conf->global->PRODUCT_STATS_WITH_PARENT_PROD_IF_INCDEC)) {
				$TFather = $this->getFather();
				if (is_array($TFather) && !empty($TFather)) {
					foreach ($TFather as &$fatherData) {
						$pFather = new Product($this->db);
						$pFather->id = $fatherData['id'];
						$qtyCoef = $fatherData['qty'];

						if ($fatherData['incdec']) {
							$pFather->load_stats_commande($socid, $filtrestatut);

							$this->stats_commande['customers'] += $pFather->stats_commande['customers'];
							$this->stats_commande['nb'] += $pFather->stats_commande['nb'];
							$this->stats_commande['rows'] += $pFather->stats_commande['rows'];
							$this->stats_commande['qty'] += $pFather->stats_commande['qty'] * $qtyCoef;
						}
					}
				}
			}

			// If stock decrease is on invoice validation, the theorical stock continue to
			// count the orders to ship in theorical stock when some are already removed b invoice validation.
			// If option DECREASE_ONLY_UNINVOICEDPRODUCTS is on, we make a compensation.
			if (!empty($conf->global->STOCK_CALCULATE_ON_BILL)) {
				if (!empty($conf->global->DECREASE_ONLY_UNINVOICEDPRODUCTS)) {
					$adeduire = 0;
					$sql = "SELECT sum(fd.qty) as count FROM ".MAIN_DB_PREFIX."facturedet fd ";
					$sql .= " JOIN ".MAIN_DB_PREFIX."facture f ON fd.fk_facture = f.rowid ";
					$sql .= " JOIN ".MAIN_DB_PREFIX."element_element el ON el.fk_target = f.rowid and el.targettype = 'facture' and sourcetype = 'commande'";
					$sql .= " JOIN ".MAIN_DB_PREFIX."commande c ON el.fk_source = c.rowid ";
					$sql .= " WHERE c.fk_statut IN (".$filtrestatut.") AND c.facture = 0 AND fd.fk_product = ".$this->id;
					dol_syslog(__METHOD__.":: sql $sql", LOG_NOTICE);

					$resql = $this->db->query($sql);
					if ($resql) {
						if ($this->db->num_rows($resql) > 0) {
							$obj = $this->db->fetch_object($resql);
							$adeduire += $obj->count;
						}
					}

					$this->stats_commande['qty'] -= $adeduire;
				}
			}

			$parameters = array('socid' => $socid, 'filtrestatut' => $filtrestatut, 'forVirtualStock' => $forVirtualStock);
			$reshook = $hookmanager->executeHooks('loadStatsCustomerOrder', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_commande = $hookmanager->resArray['stats_commande'];
			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats commande fournisseur pour le produit/service
	 *
	 * @param  int    $socid           Id societe pour filtrer sur une societe
	 * @param  string $filtrestatut    Id des statuts pour filtrer sur des statuts
	 * @param  int    $forVirtualStock Ignore rights filter for virtual stock calculation.
	 * @return int                     Array of stats in $this->stats_commande_fournisseur, <0 if ko or >0 if ok
	 */
	public function load_stats_commande_fournisseur($socid = 0, $filtrestatut = '', $forVirtualStock = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager, $action;

		$sql = "SELECT COUNT(DISTINCT c.fk_soc) as nb_suppliers, COUNT(DISTINCT c.rowid) as nb,";
		$sql .= " COUNT(cd.rowid) as nb_rows, SUM(cd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."commande_fournisseurdet as cd";
		$sql .= ", ".MAIN_DB_PREFIX."commande_fournisseur as c";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE c.rowid = cd.fk_commande";
		$sql .= " AND c.fk_soc = s.rowid";
		$sql .= " AND c.entity IN (".getEntity($forVirtualStock && !empty($conf->global->STOCK_CALCULATE_VIRTUAL_STOCK_TRANSVERSE_MODE) ? 'stock' : 'supplier_order').")";
		$sql .= " AND cd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}
		if ($filtrestatut != '') {
			$sql .= " AND c.fk_statut in (".$this->db->sanitize($filtrestatut).")"; // Peut valoir 0
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_commande_fournisseur['suppliers'] = $obj->nb_suppliers;
			$this->stats_commande_fournisseur['nb'] = $obj->nb;
			$this->stats_commande_fournisseur['rows'] = $obj->nb_rows;
			$this->stats_commande_fournisseur['qty'] = $obj->qty ? $obj->qty : 0;

			$parameters = array('socid' => $socid, 'filtrestatut' => $filtrestatut, 'forVirtualStock' => $forVirtualStock);
			$reshook = $hookmanager->executeHooks('loadStatsSupplierOrder', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_commande_fournisseur = $hookmanager->resArray['stats_commande_fournisseur'];

			return 1;
		} else {
			$this->error = $this->db->error().' sql='.$sql;
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats expedition client pour le produit/service
	 *
	 * @param   int         $socid                  Id societe pour filtrer sur une societe
	 * @param   string      $filtrestatut           [=''] Ids order status separated by comma
	 * @param   int         $forVirtualStock        Ignore rights filter for virtual stock calculation.
	 * @param   string      $filterShipmentStatus   [=''] Ids shipment status separated by comma
	 * @return  int                                 Array of stats in $this->stats_expedition, <0 if ko or >0 if ok
	 */
	public function load_stats_sending($socid = 0, $filtrestatut = '', $forVirtualStock = 0, $filterShipmentStatus = '')
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT e.fk_soc) as nb_customers, COUNT(DISTINCT e.rowid) as nb,";
		$sql .= " COUNT(ed.rowid) as nb_rows, SUM(ed.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."expeditiondet as ed";
		$sql .= ", ".MAIN_DB_PREFIX."commandedet as cd";
		$sql .= ", ".MAIN_DB_PREFIX."commande as c";
		$sql .= ", ".MAIN_DB_PREFIX."expedition as e";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE e.rowid = ed.fk_expedition";
		$sql .= " AND c.rowid = cd.fk_commande";
		$sql .= " AND e.fk_soc = s.rowid";
		$sql .= " AND e.entity IN (".getEntity($forVirtualStock && !empty($conf->global->STOCK_CALCULATE_VIRTUAL_STOCK_TRANSVERSE_MODE) ? 'stock' : 'expedition').")";
		$sql .= " AND ed.fk_origin_line = cd.rowid";
		$sql .= " AND cd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= " AND e.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND e.fk_soc = ".$socid;
		}
		if ($filtrestatut <> '') {
			$sql .= " AND c.fk_statut IN (".$this->db->sanitize($filtrestatut).")";
		}
		if (!empty($filterShipmentStatus)) $sql .= " AND e.fk_statut IN (".$this->db->sanitize($filterShipmentStatus).")";

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_expedition['customers'] = $obj->nb_customers;
			$this->stats_expedition['nb'] = $obj->nb;
			$this->stats_expedition['rows'] = $obj->nb_rows;
			$this->stats_expedition['qty'] = $obj->qty ? $obj->qty : 0;

			// if it's a virtual product, maybe it is in sending by extension
			if (!empty($conf->global->PRODUCT_STATS_WITH_PARENT_PROD_IF_INCDEC)) {
				$TFather = $this->getFather();
				if (is_array($TFather) && !empty($TFather)) {
					foreach ($TFather as &$fatherData) {
						$pFather = new Product($this->db);
						$pFather->id = $fatherData['id'];
						$qtyCoef = $fatherData['qty'];

						if ($fatherData['incdec']) {
							$pFather->load_stats_sending($socid, $filtrestatut, $forVirtualStock);

							$this->stats_expedition['customers'] += $pFather->stats_expedition['customers'];
							$this->stats_expedition['nb'] += $pFather->stats_expedition['nb'];
							$this->stats_expedition['rows'] += $pFather->stats_expedition['rows'];
							$this->stats_expedition['qty'] += $pFather->stats_expedition['qty'] * $qtyCoef;
						}
					}
				}
			}

			$parameters = array('socid' => $socid, 'filtrestatut' => $filtrestatut, 'forVirtualStock' => $forVirtualStock, 'filterShipmentStatus' => $filterShipmentStatus);
			$reshook = $hookmanager->executeHooks('loadStatsSending', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_expedition = $hookmanager->resArray['stats_expedition'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats réception fournisseur pour le produit/service
	 *
	 * @param  int    $socid           Id societe pour filtrer sur une societe
	 * @param  string $filtrestatut    Id statut pour filtrer sur un statut
	 * @param  int    $forVirtualStock Ignore rights filter for virtual stock calculation.
	 * @return int                     Array of stats in $this->stats_reception, <0 if ko or >0 if ok
	 */
	public function load_stats_reception($socid = 0, $filtrestatut = '', $forVirtualStock = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager, $action;

		$sql = "SELECT COUNT(DISTINCT cf.fk_soc) as nb_suppliers, COUNT(DISTINCT cf.rowid) as nb,";
		$sql .= " COUNT(fd.rowid) as nb_rows, SUM(fd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."commande_fournisseur_dispatch as fd";
		$sql .= ", ".MAIN_DB_PREFIX."commande_fournisseur as cf";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE cf.rowid = fd.fk_commande";
		$sql .= " AND cf.fk_soc = s.rowid";
		$sql .= " AND cf.entity IN (".getEntity($forVirtualStock && !empty($conf->global->STOCK_CALCULATE_VIRTUAL_STOCK_TRANSVERSE_MODE) ? 'stock' : 'supplier_order').")";
		$sql .= " AND fd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= " AND cf.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND cf.fk_soc = ".$socid;
		}
		if ($filtrestatut <> '') {
			$sql .= " AND cf.fk_statut IN (".$this->db->sanitize($filtrestatut).")";
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_reception['suppliers'] = $obj->nb_suppliers;
			$this->stats_reception['nb'] = $obj->nb;
			$this->stats_reception['rows'] = $obj->nb_rows;
			$this->stats_reception['qty'] = $obj->qty ? $obj->qty : 0;

			$parameters = array('socid' => $socid, 'filtrestatut' => $filtrestatut, 'forVirtualStock' => $forVirtualStock);
			$reshook = $hookmanager->executeHooks('loadStatsReception', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_reception = $hookmanager->resArray['stats_reception'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats production pour le produit/service
	 *
	 * @param  int    $socid           Id societe pour filtrer sur une societe
	 * @param  string $filtrestatut    Id statut pour filtrer sur un statut
	 * @param  int    $forVirtualStock Ignore rights filter for virtual stock calculation.
	 * @return integer                 Array of stats in $this->stats_mrptoproduce (nb=nb of order, qty=qty ordered), <0 if ko or >0 if ok
	 */
	public function load_stats_inproduction($socid = 0, $filtrestatut = '', $forVirtualStock = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT m.fk_soc) as nb_customers, COUNT(DISTINCT m.rowid) as nb,";
		$sql .= " COUNT(mp.rowid) as nb_rows, SUM(mp.qty) as qty, role";
		$sql .= " FROM ".MAIN_DB_PREFIX."mrp_production as mp";
		$sql .= ", ".MAIN_DB_PREFIX."mrp_mo as m";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s ON s.rowid = m.fk_soc";
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE m.rowid = mp.fk_mo";
		$sql .= " AND m.entity IN (".getEntity($forVirtualStock && !empty($conf->global->STOCK_CALCULATE_VIRTUAL_STOCK_TRANSVERSE_MODE) ? 'stock' : 'mrp').")";
		$sql .= " AND mp.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid && !$forVirtualStock) {
			$sql .= " AND m.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND m.fk_soc = ".$socid;
		}
		if ($filtrestatut <> '') {
			$sql .= " AND m.status IN (".$this->db->sanitize($filtrestatut).")";
		}
		$sql .= " GROUP BY role";

		$this->stats_mrptoconsume['customers'] = 0;
		$this->stats_mrptoconsume['nb'] = 0;
		$this->stats_mrptoconsume['rows'] = 0;
		$this->stats_mrptoconsume['qty'] = 0;
		$this->stats_mrptoproduce['customers'] = 0;
		$this->stats_mrptoproduce['nb'] = 0;
		$this->stats_mrptoproduce['rows'] = 0;
		$this->stats_mrptoproduce['qty'] = 0;

		$result = $this->db->query($sql);
		if ($result) {
			while ($obj = $this->db->fetch_object($result)) {
				if ($obj->role == 'toconsume') {
					$this->stats_mrptoconsume['customers'] += $obj->nb_customers;
					$this->stats_mrptoconsume['nb'] += $obj->nb;
					$this->stats_mrptoconsume['rows'] += $obj->nb_rows;
					$this->stats_mrptoconsume['qty'] += ($obj->qty ? $obj->qty : 0);
				}
				if ($obj->role == 'consumed') {
					//$this->stats_mrptoconsume['customers'] += $obj->nb_customers;
					//$this->stats_mrptoconsume['nb'] += $obj->nb;
					//$this->stats_mrptoconsume['rows'] += $obj->nb_rows;
					$this->stats_mrptoconsume['qty'] -= ($obj->qty ? $obj->qty : 0);
				}
				if ($obj->role == 'toproduce') {
					$this->stats_mrptoproduce['customers'] += $obj->nb_customers;
					$this->stats_mrptoproduce['nb'] += $obj->nb;
					$this->stats_mrptoproduce['rows'] += $obj->nb_rows;
					$this->stats_mrptoproduce['qty'] += ($obj->qty ? $obj->qty : 0);
				}
				if ($obj->role == 'produced') {
					//$this->stats_mrptoproduce['customers'] += $obj->nb_customers;
					//$this->stats_mrptoproduce['nb'] += $obj->nb;
					//$this->stats_mrptoproduce['rows'] += $obj->nb_rows;
					$this->stats_mrptoproduce['qty'] -= ($obj->qty ? $obj->qty : 0);
				}
			}

			// Clean data
			if ($this->stats_mrptoconsume['qty'] < 0) $this->stats_mrptoconsume['qty'] = 0;
			if ($this->stats_mrptoproduce['qty'] < 0) $this->stats_mrptoproduce['qty'] = 0;

			$parameters = array('socid' => $socid, 'filtrestatut' => $filtrestatut, 'forVirtualStock' => $forVirtualStock);
			$reshook = $hookmanager->executeHooks('loadStatsInProduction', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_mrptoproduce = $hookmanager->resArray['stats_mrptoproduce'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats contrat pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_contrat, <0 if ko or >0 if ok
	 */
	public function load_stats_contrat($socid = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT c.fk_soc) as nb_customers, COUNT(DISTINCT c.rowid) as nb,";
		$sql .= " COUNT(cd.rowid) as nb_rows, SUM(cd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."contratdet as cd";
		$sql .= ", ".MAIN_DB_PREFIX."contrat as c";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE c.rowid = cd.fk_contrat";
		$sql .= " AND c.fk_soc = s.rowid";
		$sql .= " AND c.entity IN (".getEntity('contract').")";
		$sql .= " AND cd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		//$sql.= " AND c.statut != 0";
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_contrat['customers'] = $obj->nb_customers;
			$this->stats_contrat['nb'] = $obj->nb;
			$this->stats_contrat['rows'] = $obj->nb_rows;
			$this->stats_contrat['qty'] = $obj->qty ? $obj->qty : 0;

			// if it's a virtual product, maybe it is in contract by extension
			if (!empty($conf->global->PRODUCT_STATS_WITH_PARENT_PROD_IF_INCDEC)) {
				$TFather = $this->getFather();
				if (is_array($TFather) && !empty($TFather)) {
					foreach ($TFather as &$fatherData) {
						$pFather = new Product($this->db);
						$pFather->id = $fatherData['id'];
						$qtyCoef = $fatherData['qty'];

						if ($fatherData['incdec']) {
							$pFather->load_stats_contrat($socid);

							$this->stats_contrat['customers'] += $pFather->stats_contrat['customers'];
							$this->stats_contrat['nb'] += $pFather->stats_contrat['nb'];
							$this->stats_contrat['rows'] += $pFather->stats_contrat['rows'];
							$this->stats_contrat['qty'] += $pFather->stats_contrat['qty'] * $qtyCoef;
						}
					}
				}
			}

			$parameters = array('socid' => $socid);
			$reshook = $hookmanager->executeHooks('loadStatsContract', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_contrat = $hookmanager->resArray['stats_contrat'];

			return 1;
		} else {
			$this->error = $this->db->error().' sql='.$sql;
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats facture pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_facture, <0 if ko or >0 if ok
	 */
	public function load_stats_facture($socid = 0)
	{
		// phpcs:enable
		global $db, $conf, $user, $hookmanager;

		$sql = "SELECT COUNT(DISTINCT f.fk_soc) as nb_customers, COUNT(DISTINCT f.rowid) as nb,";
		$sql .= " COUNT(fd.rowid) as nb_rows, SUM(".$this->db->ifsql('f.type != 2', 'fd.qty', 'fd.qty * -1').") as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."facturedet as fd";
		$sql .= ", ".MAIN_DB_PREFIX."facture as f";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE f.rowid = fd.fk_facture";
		$sql .= " AND f.fk_soc = s.rowid";
		$sql .= " AND f.entity IN (".getEntity('invoice').")";
		$sql .= " AND fd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND f.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		//$sql.= " AND f.fk_statut != 0";
		if ($socid > 0) {
			$sql .= " AND f.fk_soc = ".$socid;
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_facture['customers'] = $obj->nb_customers;
			$this->stats_facture['nb'] = $obj->nb;
			$this->stats_facture['rows'] = $obj->nb_rows;
			$this->stats_facture['qty'] = $obj->qty ? $obj->qty : 0;

			// if it's a virtual product, maybe it is in invoice by extension
			if (!empty($conf->global->PRODUCT_STATS_WITH_PARENT_PROD_IF_INCDEC)) {
				$TFather = $this->getFather();
				if (is_array($TFather) && !empty($TFather)) {
					foreach ($TFather as &$fatherData) {
						$pFather = new Product($this->db);
						$pFather->id = $fatherData['id'];
						$qtyCoef = $fatherData['qty'];

						if ($fatherData['incdec']) {
							$pFather->load_stats_facture($socid);

							$this->stats_facture['customers'] += $pFather->stats_facture['customers'];
							$this->stats_facture['nb'] += $pFather->stats_facture['nb'];
							$this->stats_facture['rows'] += $pFather->stats_facture['rows'];
							$this->stats_facture['qty'] += $pFather->stats_facture['qty'] * $qtyCoef;
						}
					}
				}
			}

			$parameters = array('socid' => $socid);
			$reshook = $hookmanager->executeHooks('loadStatsCustomerInvoice', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_facture = $hookmanager->resArray['stats_facture'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Charge tableau des stats facture pour le produit/service
	 *
	 * @param  int $socid Id societe
	 * @return int                     Array of stats in $this->stats_facture_fournisseur, <0 if ko or >0 if ok
	 */
	public function load_stats_facture_fournisseur($socid = 0)
	{
		// phpcs:enable
		global $conf, $user, $hookmanager, $action;

		$sql = "SELECT COUNT(DISTINCT f.fk_soc) as nb_suppliers, COUNT(DISTINCT f.rowid) as nb,";
		$sql .= " COUNT(fd.rowid) as nb_rows, SUM(fd.qty) as qty";
		$sql .= " FROM ".MAIN_DB_PREFIX."facture_fourn_det as fd";
		$sql .= ", ".MAIN_DB_PREFIX."facture_fourn as f";
		$sql .= ", ".MAIN_DB_PREFIX."societe as s";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE f.rowid = fd.fk_facture_fourn";
		$sql .= " AND f.fk_soc = s.rowid";
		$sql .= " AND f.entity IN (".getEntity('facture_fourn').")";
		$sql .= " AND fd.fk_product = ".$this->id;
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND f.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		//$sql.= " AND f.fk_statut != 0";
		if ($socid > 0) {
			$sql .= " AND f.fk_soc = ".$socid;
		}

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->fetch_object($result);
			$this->stats_facture_fournisseur['suppliers'] = $obj->nb_suppliers;
			$this->stats_facture_fournisseur['nb'] = $obj->nb;
			$this->stats_facture_fournisseur['rows'] = $obj->nb_rows;
			$this->stats_facture_fournisseur['qty'] = $obj->qty ? $obj->qty : 0;

			$parameters = array('socid' => $socid);
			$reshook = $hookmanager->executeHooks('loadStatsSupplierInvoice', $parameters, $this, $action);
			if ($reshook > 0) $this->stats_facture_fournisseur = $hookmanager->resArray['stats_facture_fournisseur'];

			return 1;
		} else {
			$this->error = $this->db->error();
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return an array formated for showing graphs
	 *
	 * @param  string $sql  		Request to execute
	 * @param  string $mode 		'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $year 		Year (0=current year, -1=all years)
	 * @return array|int           	<0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	private function _get_stats($sql, $mode, $year = 0)
	{
		// phpcs:enable
		$tab = array();

		$resql = $this->db->query($sql);
		if ($resql) {
			$num = $this->db->num_rows($resql);
			$i = 0;
			while ($i < $num)
			{
				$arr = $this->db->fetch_array($resql);
				$keyfortab = (string) $arr[1];
				if ($year == -1) {
					$keyfortab = substr($keyfortab, -2);
				}

				if ($mode == 'byunit') {
					$tab[$keyfortab] = (empty($tab[$keyfortab]) ? 0 : $tab[$keyfortab]) + $arr[0]; // 1st field
				} elseif ($mode == 'bynumber') {
					$tab[$keyfortab] = (empty($tab[$keyfortab]) ? 0 : $tab[$keyfortab]) + $arr[2]; // 3rd field
				}
				$i++;
			}
		} else {
			$this->error = $this->db->error().' sql='.$sql;
			return -1;
		}

		if (empty($year)) {
			$year = strftime('%Y', time());
			$month = strftime('%m', time());
		} elseif ($year == -1) {
			$year = '';
			$month = 12; // We imagine we are at end of year, so we get last 12 month before, so all correct year.
		} else {
			$month = 12; // We imagine we are at end of year, so we get last 12 month before, so all correct year.
		}

		$result = array();

		for ($j = 0; $j < 12; $j++)
		{
			// $ids is 'D', 'N', 'O', 'S', ... (First letter of month in user language)
			$idx = ucfirst(dol_trunc(dol_print_date(dol_mktime(12, 0, 0, $month, 1, 1970), "%b"), 1, 'right', 'UTF-8', 1));

			//print $idx.'-'.$year.'-'.$month.'<br>';
			$result[$j] = array($idx, isset($tab[$year.$month]) ? $tab[$year.$month] : 0);
			//            $result[$j] = array($monthnum,isset($tab[$year.$month])?$tab[$year.$month]:0);

			$month = "0".($month - 1);
			if (dol_strlen($month) == 3) {
				$month = substr($month, 1);
			}
			if ($month == 0) {
				$month = 12;
				$year = $year - 1;
			}
		}

		return array_reverse($result);
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units or customers invoices in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_vente($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf;
		global $user;

		$sql = "SELECT sum(d.qty), date_format(f.datef, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT f.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."facturedet as d, ".MAIN_DB_PREFIX."facture as f, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE f.rowid = d.fk_facture";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND f.fk_soc = s.rowid";
		$sql .= " AND f.entity IN (".getEntity('invoice').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND f.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND f.fk_soc = $socid";
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(f.datef,'%Y%m')";
		$sql .= " ORDER BY date_format(f.datef,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units or supplier invoices in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_achat($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf;
		global $user;

		$sql = "SELECT sum(d.qty), date_format(f.datef, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT f.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."facture_fourn_det as d, ".MAIN_DB_PREFIX."facture_fourn as f, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE f.rowid = d.fk_facture_fourn";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND f.fk_soc = s.rowid";
		$sql .= " AND f.entity IN (".getEntity('facture_fourn').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND f.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND f.fk_soc = $socid";
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(f.datef,'%Y%m')";
		$sql .= " ORDER BY date_format(f.datef,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Return nb of units in proposals in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_propal($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf, $user;

		$sql = "SELECT sum(d.qty), date_format(p.datep, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT p.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."propaldet as d, ".MAIN_DB_PREFIX."propal as p, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as prod";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE p.rowid = d.fk_propal";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND prod.rowid = d.fk_product AND prod.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND p.fk_soc = s.rowid";
		$sql .= " AND p.entity IN (".getEntity('propal').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND p.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND p.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(p.datep,'%Y%m')";
		$sql .= " ORDER BY date_format(p.datep,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units in proposals in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_propalsupplier($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf;
		global $user;

		$sql = "SELECT sum(d.qty), date_format(p.date_valid, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT p.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."supplier_proposaldet as d, ".MAIN_DB_PREFIX."supplier_proposal as p, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as prod";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE p.rowid = d.fk_supplier_proposal";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND prod.rowid = d.fk_product AND prod.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND p.fk_soc = s.rowid";
		$sql .= " AND p.entity IN (".getEntity('supplier_proposal').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND p.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND p.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(p.date_valid,'%Y%m')";
		$sql .= " ORDER BY date_format(p.date_valid,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units in orders in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_order($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf, $user;

		$sql = "SELECT sum(d.qty), date_format(c.date_commande, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT c.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."commandedet as d, ".MAIN_DB_PREFIX."commande as c, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE c.rowid = d.fk_commande";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND c.fk_soc = s.rowid";
		$sql .= " AND c.entity IN (".getEntity('commande').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(c.date_commande,'%Y%m')";
		$sql .= " ORDER BY date_format(c.date_commande,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units in orders in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_ordersupplier($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf, $user;

		$sql = "SELECT sum(d.qty), date_format(c.date_commande, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT c.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."commande_fournisseurdet as d, ".MAIN_DB_PREFIX."commande_fournisseur as c, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}
		$sql .= " WHERE c.rowid = d.fk_commande";
		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND c.fk_soc = s.rowid";
		$sql .= " AND c.entity IN (".getEntity('supplier_order').")";
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(c.date_commande,'%Y%m')";
		$sql .= " ORDER BY date_format(c.date_commande,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units in orders in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_contract($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf, $user;

		$sql = "SELECT sum(d.qty), date_format(c.date_contrat, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT c.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."contratdet as d, ".MAIN_DB_PREFIX."contrat as c, ".MAIN_DB_PREFIX."societe as s";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}

		$sql .= " WHERE c.entity IN (".getEntity('contract').")";
		$sql .= " AND c.rowid = d.fk_contrat";

		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}
		$sql .= " AND c.fk_soc = s.rowid";

		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND c.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND c.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(c.date_contrat,'%Y%m')";
		$sql .= " ORDER BY date_format(c.date_contrat,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return nb of units in orders in which product is included
	 *
	 * @param  int    $socid               Limit count on a particular third party id
	 * @param  string $mode                'byunit'=number of unit, 'bynumber'=nb of entities
	 * @param  int    $filteronproducttype 0=To filter on product only, 1=To filter on services only
	 * @param  int    $year                Year (0=last 12 month, -1=all years)
	 * @param  string $morefilter          More sql filters
	 * @return array                       <0 if KO, result[month]=array(valuex,valuey) where month is 0 to 11
	 */
	public function get_nb_mos($socid, $mode, $filteronproducttype = -1, $year = 0, $morefilter = '')
	{
		// phpcs:enable
		global $conf, $user;

		$sql = "SELECT sum(d.qty), date_format(d.date_valid, '%Y%m')";
		if ($mode == 'bynumber') {
			$sql .= ", count(DISTINCT d.rowid)";
		}
		$sql .= " FROM ".MAIN_DB_PREFIX."mrp_mo as d LEFT JOIN  ".MAIN_DB_PREFIX."societe as s ON d.fk_soc = s.rowid";
		if ($filteronproducttype >= 0) {
			$sql .= ", ".MAIN_DB_PREFIX."product as p";
		}
		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
		}

		$sql .= " WHERE d.entity IN (".getEntity('mo').")";
		$sql .= " AND d.status > 0";

		if ($this->id > 0) {
			$sql .= " AND d.fk_product =".$this->id;
		} else {
			$sql .= " AND d.fk_product > 0";
		}
		if ($filteronproducttype >= 0) {
			$sql .= " AND p.rowid = d.fk_product AND p.fk_product_type = ".((int) $filteronproducttype);
		}

		if (empty($user->rights->societe->client->voir) && !$socid) {
			$sql .= " AND d.fk_soc = sc.fk_soc AND sc.fk_user = ".$user->id;
		}
		if ($socid > 0) {
			$sql .= " AND d.fk_soc = ".$socid;
		}
		$sql .= $morefilter;
		$sql .= " GROUP BY date_format(d.date_valid,'%Y%m')";
		$sql .= " ORDER BY date_format(d.date_valid,'%Y%m') DESC";

		return $this->_get_stats($sql, $mode, $year);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Link a product/service to a parent product/service
	 *
	 * @param  int $id_pere Id of parent product/service
	 * @param  int $id_fils Id of child product/service
	 * @param  int $qty     Quantity
	 * @param  int $incdec  1=Increase/decrease stock of child when parent stock increase/decrease
	 * @return int                < 0 if KO, > 0 if OK
	 */
	public function add_sousproduit($id_pere, $id_fils, $qty, $incdec = 1)
	{
		// phpcs:enable
		// Clean parameters
		if (!is_numeric($id_pere)) {
			$id_pere = 0;
		}
		if (!is_numeric($id_fils)) {
			$id_fils = 0;
		}
		if (!is_numeric($incdec)) {
			$incdec = 0;
		}

		$result = $this->del_sousproduit($id_pere, $id_fils);
		if ($result < 0) {
			return $result;
		}

		// Check not already father of id_pere (to avoid father -> child -> father links)
		$sql = 'SELECT fk_product_pere from '.MAIN_DB_PREFIX.'product_association';
		$sql .= ' WHERE fk_product_pere  = '.$id_fils.' AND fk_product_fils = '.$id_pere;
		if (!$this->db->query($sql)) {
			dol_print_error($this->db);
			return -1;
		} else {
			$result = $this->db->query($sql);
			if ($result) {
				$num = $this->db->num_rows($result);
				if ($num > 0) {
					$this->error = "isFatherOfThis";
					return -1;
				} else {
					$sql = 'INSERT INTO '.MAIN_DB_PREFIX.'product_association(fk_product_pere,fk_product_fils,qty,incdec)';
					$sql .= ' VALUES ('.$id_pere.', '.$id_fils.', '.$qty.', '.$incdec.')';
					if (!$this->db->query($sql)) {
						 dol_print_error($this->db);
						 return -1;
					} else {
						 return 1;
					}
				}
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Modify composed product
	 *
	 * @param  int $id_pere Id of parent product/service
	 * @param  int $id_fils Id of child product/service
	 * @param  int $qty     Quantity
	 * @param  int $incdec  1=Increase/decrease stock of child when parent stock increase/decrease
	 * @return int                < 0 if KO, > 0 if OK
	 */
	public function update_sousproduit($id_pere, $id_fils, $qty, $incdec = 1)
	{
		// phpcs:enable
		// Clean parameters
		if (!is_numeric($id_pere)) {
			$id_pere = 0;
		}
		if (!is_numeric($id_fils)) {
			$id_fils = 0;
		}
		if (!is_numeric($incdec)) {
			$incdec = 1;
		}
		if (!is_numeric($qty)) {
			$qty = 1;
		}

		$sql = 'UPDATE '.MAIN_DB_PREFIX.'product_association SET ';
		$sql .= 'qty='.$qty;
		$sql .= ',incdec='.$incdec;
		$sql .= ' WHERE fk_product_pere='.$id_pere.' AND fk_product_fils='.$id_fils;

		if (!$this->db->query($sql)) {
			dol_print_error($this->db);
			return -1;
		} else {
			return 1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Retire le lien entre un sousproduit et un produit/service
	 *
	 * @param  int $fk_parent Id du produit auquel ne sera plus lie le produit lie
	 * @param  int $fk_child  Id du produit a ne plus lie
	 * @return int                    < 0 if KO, > 0 if OK
	 */
	public function del_sousproduit($fk_parent, $fk_child)
	{
		// phpcs:enable
		if (!is_numeric($fk_parent)) {
			$fk_parent = 0;
		}
		if (!is_numeric($fk_child)) {
			$fk_child = 0;
		}

		$sql = "DELETE FROM ".MAIN_DB_PREFIX."product_association";
		$sql .= " WHERE fk_product_pere  = ".$fk_parent;
		$sql .= " AND fk_product_fils = ".$fk_child;

		dol_syslog(get_class($this).'::del_sousproduit', LOG_DEBUG);
		if (!$this->db->query($sql)) {
			dol_print_error($this->db);
			return -1;
		}

		return 1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Check if it is a sub-product into a kit
	 *
	 * @param  int 	$fk_parent 		Id of parent kit product
	 * @param  int 	$fk_child  		Id of child product
	 * @return int                  <0 if KO, >0 if OK
	 */
	public function is_sousproduit($fk_parent, $fk_child)
	{
		// phpcs:enable
		$sql = "SELECT fk_product_pere, qty, incdec";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_association";
		$sql .= " WHERE fk_product_pere  = ".((int) $fk_parent);
		$sql .= " AND fk_product_fils = ".((int) $fk_child);

		$result = $this->db->query($sql);
		if ($result) {
			$num = $this->db->num_rows($result);

			if ($num > 0) {
				$obj = $this->db->fetch_object($result);

				$this->is_sousproduit_qty = $obj->qty;
				$this->is_sousproduit_incdec = $obj->incdec;

				return true;
			} else {
				return false;
			}
		} else {
			dol_print_error($this->db);
			return -1;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Add a supplier price for the product.
	 *  Note: Duplicate ref is accepted for different quantity only, or for different companies.
	 *
	 * @param  User   $user      User that make link
	 * @param  int    $id_fourn  Supplier id
	 * @param  string $ref_fourn Supplier ref
	 * @param  float  $quantity  Quantity minimum for price
	 * @return int               < 0 if KO, 0 if link already exists for this product, > 0 if OK
	 */
	public function add_fournisseur($user, $id_fourn, $ref_fourn, $quantity)
	{
		// phpcs:enable
		global $conf;

		$now = dol_now();

		dol_syslog(get_class($this)."::add_fournisseur id_fourn = ".$id_fourn." ref_fourn=".$ref_fourn." quantity=".$quantity, LOG_DEBUG);

		// Clean parameters
		$quantity = price2num($quantity, 'MS');

		if ($ref_fourn) {
			$sql = "SELECT rowid, fk_product";
			$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price";
			$sql .= " WHERE fk_soc = ".((int) $id_fourn);
			$sql .= " AND ref_fourn = '".$this->db->escape($ref_fourn)."'";
			$sql .= " AND fk_product <> ".((int) $this->id);
			$sql .= " AND entity IN (".getEntity('productsupplierprice').")";

			$resql = $this->db->query($sql);
			if ($resql) {
				$obj = $this->db->fetch_object($resql);
				if ($obj) {
					// If the supplier ref already exists but for another product (duplicate ref is accepted for different quantity only or different companies)
					$this->product_id_already_linked = $obj->fk_product;
					return -3;
				}
				$this->db->free($resql);
			}
		}

		$sql = "SELECT rowid";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price";
		$sql .= " WHERE fk_soc = ".$id_fourn;
		if ($ref_fourn) { $sql .= " AND ref_fourn = '".$this->db->escape($ref_fourn)."'";
		} else { $sql .= " AND (ref_fourn = '' OR ref_fourn IS NULL)";
		}
		$sql .= " AND quantity = ".$quantity;
		$sql .= " AND fk_product = ".$this->id;
		$sql .= " AND entity IN (".getEntity('productsupplierprice').")";

		$resql = $this->db->query($sql);
		if ($resql) {
			$obj = $this->db->fetch_object($resql);

			// The reference supplier does not exist, we create it for this product.
			if (empty($obj)) {
				$sql = "INSERT INTO ".MAIN_DB_PREFIX."product_fournisseur_price(";
				$sql .= "datec";
				$sql .= ", entity";
				$sql .= ", fk_product";
				$sql .= ", fk_soc";
				$sql .= ", ref_fourn";
				$sql .= ", quantity";
				$sql .= ", fk_user";
				$sql .= ", tva_tx";
				$sql .= ") VALUES (";
				$sql .= "'".$this->db->idate($now)."'";
				$sql .= ", ".$conf->entity;
				$sql .= ", ".$this->id;
				$sql .= ", ".$id_fourn;
				$sql .= ", '".$this->db->escape($ref_fourn)."'";
				$sql .= ", ".$quantity;
				$sql .= ", ".$user->id;
				$sql .= ", 0";
				$sql .= ")";

				if ($this->db->query($sql)) {
					$this->product_fourn_price_id = $this->db->last_insert_id(MAIN_DB_PREFIX."product_fournisseur_price");
					return 1;
				} else {
					$this->error = $this->db->lasterror();
					return -1;
				}
			} else {
				 // If the supplier price already exists for this product and quantity
				$this->product_fourn_price_id = $obj->rowid;
				return 0;
			}
		} else {
			$this->error = $this->db->lasterror();
			return -2;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Return list of suppliers providing the product or service
	 *
	 * @return array        Array of vendor ids
	 */
	public function list_suppliers()
	{
		// phpcs:enable
		global $conf;

		$list = array();

		$sql = "SELECT DISTINCT p.fk_soc";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price as p";
		$sql .= " WHERE p.fk_product = ".$this->id;
		$sql .= " AND p.entity = ".$conf->entity;

		$result = $this->db->query($sql);
		if ($result) {
			$num = $this->db->num_rows($result);
			$i = 0;
			while ($i < $num)
			{
				$obj = $this->db->fetch_object($result);
				$list[$i] = $obj->fk_soc;
				$i++;
			}
		}

		return $list;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Recopie les prix d'un produit/service sur un autre
	 *
	 * @param  int $fromId Id product source
	 * @param  int $toId   Id product target
	 * @return int                     < 0 if KO, > 0 if OK
	 */
	public function clone_price($fromId, $toId)
	{
		global $conf, $user;

		$now = dol_now();

		$this->db->begin();

		// prices
		$sql  = "INSERT INTO ".MAIN_DB_PREFIX."product_price (";
		$sql .= " entity";
		$sql .= ", fk_product";
		$sql .= ", date_price";
		$sql .= ", price_level";
		$sql .= ", price";
		$sql .= ", price_ttc";
		$sql .= ", price_min";
		$sql .= ", price_min_ttc";
		$sql .= ", price_base_type";
		$sql .= ", default_vat_code";
		$sql .= ", tva_tx";
		$sql .= ", recuperableonly";
		$sql .= ", localtax1_tx";
		$sql .= ", localtax1_type";
		$sql .= ", localtax2_tx";
		$sql .= ", localtax2_type";
		$sql .= ", fk_user_author";
		$sql .= ", tosell";
		$sql .= ", price_by_qty";
		$sql .= ", fk_price_expression";
		$sql .= ", fk_multicurrency";
		$sql .= ", multicurrency_code";
		$sql .= ", multicurrency_tx";
		$sql .= ", multicurrency_price";
		$sql .= ", multicurrency_price_ttc";
		$sql .= ")";
		$sql .= " SELECT";
		$sql .= " entity";
		$sql .= ", ".$toId;
		$sql .= ", '".$this->db->idate($now)."'";
		$sql .= ", price_level";
		$sql .= ", price";
		$sql .= ", price_ttc";
		$sql .= ", price_min";
		$sql .= ", price_min_ttc";
		$sql .= ", price_base_type";
		$sql .= ", default_vat_code";
		$sql .= ", tva_tx";
		$sql .= ", recuperableonly";
		$sql .= ", localtax1_tx";
		$sql .= ", localtax1_type";
		$sql .= ", localtax2_tx";
		$sql .= ", localtax2_type";
		$sql .= ", ".$user->id;
		$sql .= ", tosell";
		$sql .= ", price_by_qty";
		$sql .= ", fk_price_expression";
		$sql .= ", fk_multicurrency";
		$sql .= ", multicurrency_code";
		$sql .= ", multicurrency_tx";
		$sql .= ", multicurrency_price";
		$sql .= ", multicurrency_price_ttc";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_price";
		$sql .= " WHERE fk_product = ".$fromId;
		$sql .= " ORDER BY date_price DESC";
		if ($conf->global->PRODUIT_MULTIPRICES_LIMIT > 0) {
			$sql .= " LIMIT ".$conf->global->PRODUIT_MULTIPRICES_LIMIT;
		}

		dol_syslog(__METHOD__, LOG_DEBUG);
		$resql = $this->db->query($sql);
		if (!$resql) {
			$this->db->rollback();
			return -1;
		}

		$this->db->commit();
		return 1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Clone links between products
	 *
	 * @param  int $fromId Product id
	 * @param  int $toId   Product id
	 * @return int                  <0 if KO, >0 if OK
	 */
	public function clone_associations($fromId, $toId)
	{
		// phpcs:enable
		$this->db->begin();

		$sql = 'INSERT INTO '.MAIN_DB_PREFIX.'product_association (fk_product_pere, fk_product_fils, qty)';
		$sql .= " SELECT ".$toId.", fk_product_fils, qty FROM ".MAIN_DB_PREFIX."product_association";
		$sql .= " WHERE fk_product_pere = ".$fromId;

		dol_syslog(get_class($this).'::clone_association', LOG_DEBUG);
		if (!$this->db->query($sql)) {
			$this->db->rollback();
			return -1;
		}

		$this->db->commit();
		return 1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Recopie les fournisseurs et prix fournisseurs d'un produit/service sur un autre
	 *
	 * @param  int $fromId Id produit source
	 * @param  int $toId   Id produit cible
	 * @return int                 < 0 si erreur, > 0 si ok
	 */
	public function clone_fournisseurs($fromId, $toId)
	{
		// phpcs:enable
		$this->db->begin();

		$now = dol_now();

		// les fournisseurs
		/*$sql = "INSERT ".MAIN_DB_PREFIX."product_fournisseur ("
        . " datec, fk_product, fk_soc, ref_fourn, fk_user_author )"
        . " SELECT '".$this->db->idate($now)."', ".$toId.", fk_soc, ref_fourn, fk_user_author"
        . " FROM ".MAIN_DB_PREFIX."product_fournisseur"
        . " WHERE fk_product = ".$fromId;

        if ( ! $this->db->query($sql ) )
        {
        $this->db->rollback();
        return -1;
        }*/

		// les prix de fournisseurs.
		$sql = "INSERT ".MAIN_DB_PREFIX."product_fournisseur_price (";
		$sql .= " datec, fk_product, fk_soc, price, quantity, fk_user)";
		$sql .= " SELECT '".$this->db->idate($now)."', ".$toId.", fk_soc, price, quantity, fk_user";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_fournisseur_price";
		$sql .= " WHERE fk_product = ".$fromId;

		dol_syslog(get_class($this).'::clone_fournisseurs', LOG_DEBUG);
		$resql = $this->db->query($sql);
		if (!$resql) {
			$this->db->rollback();
			return -1;
		} else {
			$this->db->commit();
			return 1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Fonction recursive uniquement utilisee par get_arbo_each_prod, recompose l'arborescence des sousproduits
	 *  Define value of this->res
	 *
	 * @param  array  $prod       Products array
	 * @param  string $compl_path Directory path of parents to add before
	 * @param  int    $multiply   Because each sublevel must be multiplicated by parent nb
	 * @param  int    $level      Init level
	 * @param  int    $id_parent  Id parent
	 * @return void
	 */
	public function fetch_prod_arbo($prod, $compl_path = "", $multiply = 1, $level = 1, $id_parent = 0)
	{
		// phpcs:enable
		global $conf, $langs;

		$tmpproduct = null;
		//var_dump($prod);
		foreach ($prod as $id_product => $desc_pere)    // $id_product is 0 (first call starting with root top) or an id of a sub_product
		{
			if (is_array($desc_pere))    // If desc_pere is an array, this means it's a child
			{
				$id = (!empty($desc_pere[0]) ? $desc_pere[0] : '');
				$nb = (!empty($desc_pere[1]) ? $desc_pere[1] : '');
				$type = (!empty($desc_pere[2]) ? $desc_pere[2] : '');
				$label = (!empty($desc_pere[3]) ? $desc_pere[3] : '');
				$incdec = !empty($desc_pere[4]) ? $desc_pere[4] : 0;

				if ($multiply < 1) { $multiply = 1;
				}

				//print "XXX We add id=".$id." - label=".$label." - nb=".$nb." - multiply=".$multiply." fullpath=".$compl_path.$label."\n";
				if (is_null($tmpproduct)) $tmpproduct = new Product($this->db); // So we initialize tmpproduct only once for all loop.
				$tmpproduct->fetch($id); // Load product to get ->ref
				$tmpproduct->load_stock('nobatch,novirtual'); // Load stock to get true ->stock_reel
				//$this->fetch($id);        				   // Load product to get ->ref
				//$this->load_stock('nobatch,novirtual');    // Load stock to get true ->stock_reel
				$this->res[] = array(
					'id'=>$id, // Id product
					'id_parent'=>$id_parent,
					'ref'=>$tmpproduct->ref, // Ref product
					'nb'=>$nb, // Nb of units that compose parent product
					'nb_total'=>$nb * $multiply, // Nb of units for all nb of product
					'stock'=>$tmpproduct->stock_reel, // Stock
					'stock_alert'=>$tmpproduct->seuil_stock_alerte, // Stock alert
					'label'=>$label,
					'fullpath'=>$compl_path.$label, // Label
					'type'=>$type, // Nb of units that compose parent product
					'desiredstock'=>$tmpproduct->desiredstock,
					'level'=>$level,
					'incdec'=>$incdec,
					'entity'=>$tmpproduct->entity
				);

				// Recursive call if there is childs to child
				if (is_array($desc_pere['childs'])) {
					   //print 'YYY We go down for '.$desc_pere[3]." -> \n";
					   $this->fetch_prod_arbo($desc_pere['childs'], $compl_path.$desc_pere[3]." -> ", $desc_pere[1] * $multiply, $level + 1, $id);
				}
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Build the tree of subproducts into an array
	 *  this->sousprods is loaded by this->get_sousproduits_arbo()
	 *
	 * @param  int $multiply Because each sublevel must be multiplicated by parent nb
	 * @return array                     $this->res
	 */
	public function get_arbo_each_prod($multiply = 1)
	{
		// phpcs:enable
		$this->res = array();
		if (isset($this->sousprods) && is_array($this->sousprods)) {
			foreach ($this->sousprods as $prod_name => $desc_product) {
				if (is_array($desc_product)) {
					$this->fetch_prod_arbo($desc_product, "", $multiply, 1, $this->id);
				}
			}
		}
		//var_dump($this->res);
		return $this->res;
	}

	/**
	 * Count all parent and children products for current product (first level only)
	 *
	 * @param	int		$mode	0=Both parent and child, -1=Parents only, 1=Children only
	 * @return 	int            	Nb of father + child
	 * @see getFather(), get_sousproduits_arbo()
	 */
	public function hasFatherOrChild($mode = 0)
	{
		$nb = 0;

		$sql = "SELECT COUNT(pa.rowid) as nb";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_association as pa";
		if ($mode == 0) {
			$sql .= " WHERE pa.fk_product_fils = ".$this->id." OR pa.fk_product_pere = ".$this->id;
		} elseif ($mode == -1) {
			$sql .= " WHERE pa.fk_product_fils = ".$this->id; // We are a child, so we found lines that link to parents (can have several parents)
		} elseif ($mode == 1) {
			$sql .= " WHERE pa.fk_product_pere = ".$this->id; // We are a parent, so we found lines that link to children (can have several children)
		}

		$resql = $this->db->query($sql);
		if ($resql) {
			$obj = $this->db->fetch_object($resql);
			if ($obj) { $nb = $obj->nb; }
		} else {
			return -1;
		}

		return $nb;
	}

	/**
	 * Return if a product has variants or not
	 *
	 * @return int        Number of variants
	 */
	public function hasVariants()
	{
		$nb = 0;
		$sql = "SELECT count(rowid) as nb FROM ".MAIN_DB_PREFIX."product_attribute_combination WHERE fk_product_parent = ".$this->id;
		$sql .= " AND entity IN (".getEntity('product').")";

		$resql = $this->db->query($sql);
		if ($resql) {
			$obj = $this->db->fetch_object($resql);
			if ($obj) { $nb = $obj->nb;
			}
		}

		return $nb;
	}


	/**
	 * Return if loaded product is a variant
	 *
	 * @return int
	 */
	public function isVariant()
	{
		global $conf;
		if (!empty($conf->variants->enabled)) {
			$sql = "SELECT rowid FROM ".MAIN_DB_PREFIX."product_attribute_combination WHERE fk_product_child = ".$this->id." AND entity IN (".getEntity('product').")";

			$query = $this->db->query($sql);

			if ($query) {
				if (!$this->db->num_rows($query)) {
					return false;
				}
				return true;
			} else {
				dol_print_error($this->db);
				return -1;
			}
		} else {
			return false;
		}
	}

	/**
	 *  Return all parent products for current product (first level only)
	 *
	 * @return array         Array of product
	 * @see hasFatherOrChild()
	 */
	public function getFather()
	{
		$sql = "SELECT p.rowid, p.label as label, p.ref as ref, pa.fk_product_pere as id, p.fk_product_type, pa.qty, pa.incdec, p.entity";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_association as pa,";
		$sql .= " ".MAIN_DB_PREFIX."product as p";
		$sql .= " WHERE p.rowid = pa.fk_product_pere";
		$sql .= " AND pa.fk_product_fils = ".$this->id;

		$res = $this->db->query($sql);
		if ($res) {
			$prods = array();
			while ($record = $this->db->fetch_array($res))
			{
				// $record['id'] = $record['rowid'] = id of father
				$prods[$record['id']]['id'] = $record['rowid'];
				$prods[$record['id']]['ref'] = $record['ref'];
				$prods[$record['id']]['label'] = $record['label'];
				$prods[$record['id']]['qty'] = $record['qty'];
				$prods[$record['id']]['incdec'] = $record['incdec'];
				$prods[$record['id']]['fk_product_type'] = $record['fk_product_type'];
				$prods[$record['id']]['entity'] = $record['entity'];
			}
			return $prods;
		} else {
			dol_print_error($this->db);
			return -1;
		}
	}


	/**
	 *  Return childs of product $id
	 *
	 * @param  int $id             		Id of product to search childs of
	 * @param  int $firstlevelonly 		Return only direct child
	 * @param  int $level          		Level of recursing call (start to 1)
	 * @return array                    Return array(prodid=>array(0=prodid, 1=>qty, 2=>product type, 3=>label, 4=>incdec, 5=>product ref)
	 */
	public function getChildsArbo($id, $firstlevelonly = 0, $level = 1)
	{
		global $alreadyfound;

		$sql = "SELECT p.rowid, p.ref, p.label as label, p.fk_product_type,";
		$sql .= " pa.qty as qty, pa.fk_product_fils as id, pa.incdec";
		$sql .= " FROM ".MAIN_DB_PREFIX."product as p,";
		$sql .= " ".MAIN_DB_PREFIX."product_association as pa";
		$sql .= " WHERE p.rowid = pa.fk_product_fils";
		$sql .= " AND pa.fk_product_pere = ".$id;
		$sql .= " AND pa.fk_product_fils != ".$id; // This should not happens, it is to avoid infinite loop if it happens

		dol_syslog(get_class($this).'::getChildsArbo id='.$id.' level='.$level, LOG_DEBUG);

		if ($level == 1) { $alreadyfound = array($id=>1); // We init array of found object to start of tree, so if we found it later (should not happened), we stop immediatly
		}
		// Protection against infinite loop
		if ($level > 30) { return array();
		}

		$res = $this->db->query($sql);
		if ($res) {
			$prods = array();
			while ($rec = $this->db->fetch_array($res))
			{
				if (!empty($alreadyfound[$rec['rowid']])) {
					dol_syslog(get_class($this).'::getChildsArbo the product id='.$rec['rowid'].' was already found at a higher level in tree. We discard to avoid infinite loop', LOG_WARNING);
					continue;
				}
				$alreadyfound[$rec['rowid']] = 1;
				$prods[$rec['rowid']] = array(
				 0=>$rec['rowid'],
				 1=>$rec['qty'],
				 2=>$rec['fk_product_type'],
				 3=>$this->db->escape($rec['label']),
				 4=>$rec['incdec'],
				 5=>$rec['ref']
				);
				//$prods[$this->db->escape($rec['label'])]= array(0=>$rec['id'],1=>$rec['qty'],2=>$rec['fk_product_type']);
				//$prods[$this->db->escape($rec['label'])]= array(0=>$rec['id'],1=>$rec['qty']);
				if (empty($firstlevelonly)) {
					   $listofchilds = $this->getChildsArbo($rec['rowid'], 0, $level + 1);
					foreach ($listofchilds as $keyChild => $valueChild)
					   {
						$prods[$rec['rowid']]['childs'][$keyChild] = $valueChild;
					}
				}
			}

			return $prods;
		} else {
			dol_print_error($this->db);
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *     Return tree of all subproducts for product. Tree contains array of array(0=prodid, 1=>qty, 2=>product type, 3=>label, 4=>incdec, 5=>product ref)
	 *     Set this->sousprods
	 *
	 * @return void
	 */
	public function get_sousproduits_arbo()
	{
		// phpcs:enable
		$parent = array();

		foreach ($this->getChildsArbo($this->id) as $keyChild => $valueChild)    // Warning. getChildsArbo can call getChildsArbo recursively. Starting point is $value[0]=id of product
		{
			$parent[$this->label][$keyChild] = $valueChild;
		}
		foreach ($parent as $key => $value)        // key=label, value is array of childs
		{
			$this->sousprods[$key] = $value;
		}
	}

	/**
	 *    Return clicable link of object (with eventually picto)
	 *
	 * @param  int    $withpicto             Add picto into link
	 * @param  string $option                Where point the link ('stock', 'composition', 'category', 'supplier', '')
	 * @param  int    $maxlength             Maxlength of ref
	 * @param  int    $save_lastsearch_value -1=Auto, 0=No save of lastsearch_values when clicking, 1=Save lastsearch_values whenclicking
	 * @param  int    $notooltip			 No tooltip
	 * @return string                                String with URL
	 */
	public function getNomUrl($withpicto = 0, $option = '', $maxlength = 0, $save_lastsearch_value = -1, $notooltip = 0)
	{
		global $conf, $langs, $hookmanager;
		include_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';

		$result = ''; $label = '';

		$newref = $this->ref;
		if ($maxlength) {
			$newref = dol_trunc($newref, $maxlength, 'middle');
		}

		if (!empty($this->entity)) {
			$tmpphoto = $this->show_photos('product', $conf->product->multidir_output[$this->entity], 1, 1, 0, 0, 0, 80);
			if ($this->nbphoto > 0) {
				$label .= '<div class="photointooltip">';
				$label .= $tmpphoto;
				$label .= '</div><div style="clear: both;"></div>';
			}
		}

		if ($this->type == Product::TYPE_PRODUCT) {
			$label .= img_picto('', 'product').' <u class="paddingrightonly">'.$langs->trans("Product").'</u>';
		} elseif ($this->type == Product::TYPE_SERVICE) {
			$label .= img_picto('', 'service').' <u class="paddingrightonly">'.$langs->trans("Service").'</u>';
		}
		if (isset($this->status) && isset($this->status_buy)) {
			$label .= ' '.$this->getLibStatut(5, 0);
			$label .= ' '.$this->getLibStatut(5, 1);
		}

		if (!empty($this->ref)) {
			$label .= '<br><b>'.$langs->trans('ProductRef').':</b> '.$this->ref;
		}
		if (!empty($this->label)) {
			$label .= '<br><b>'.$langs->trans('ProductLabel').':</b> '.$this->label;
		}
		if ($this->type == Product::TYPE_PRODUCT || !empty($conf->global->STOCK_SUPPORTS_SERVICES)) {
			if (!empty($conf->productbatch->enabled)) {
				$langs->load("productbatch");
				$label .= "<br><b>".$langs->trans("ManageLotSerial").'</b>: '.$this->getLibStatut(0, 2);
			}
		}
		if (!empty($conf->barcode->enabled)) {
			$label .= '<br><b>'.$langs->trans('BarCode').':</b> '.$this->barcode;
		}

		if ($this->type == Product::TYPE_PRODUCT)
		{
			if ($this->weight) {
				$label .= "<br><b>".$langs->trans("Weight").'</b>: '.$this->weight.' '.measuringUnitString(0, "weight", $this->weight_units);
			}
			$labelsize = "";
			if ($this->length) {
				$labelsize .= ($labelsize ? " - " : "")."<b>".$langs->trans("Length").'</b>: '.$this->length.' '.measuringUnitString(0, 'size', $this->length_units);
			}
			if ($this->width) {
				$labelsize .= ($labelsize ? " - " : "")."<b>".$langs->trans("Width").'</b>: '.$this->width.' '.measuringUnitString(0, 'size', $this->width_units);
			}
			if ($this->height) {
				$labelsize .= ($labelsize ? " - " : "")."<b>".$langs->trans("Height").'</b>: '.$this->height.' '.measuringUnitString(0, 'size', $this->height_units);
			}
			if ($labelsize) $label .= "<br>".$labelsize;

			$labelsurfacevolume = "";
			if ($this->surface) {
				$labelsurfacevolume .= ($labelsurfacevolume ? " - " : "")."<b>".$langs->trans("Surface").'</b>: '.$this->surface.' '.measuringUnitString(0, 'surface', $this->surface_units);
			}
			if ($this->volume) {
				$labelsurfacevolume .= ($labelsurfacevolume ? " - " : "")."<b>".$langs->trans("Volume").'</b>: '.$this->volume.' '.measuringUnitString(0, 'volume', $this->volume_units);
			}
			if ($labelsurfacevolume) $label .= "<br>".$labelsurfacevolume;
		}

		if (!empty($conf->accounting->enabled) && $this->status) {
			include_once DOL_DOCUMENT_ROOT.'/core/lib/accounting.lib.php';
			$label .= '<br><b>'.$langs->trans('ProductAccountancySellCode').':</b> '.length_accountg($this->accountancy_code_sell);
			$label .= '<br><b>'.$langs->trans('ProductAccountancySellIntraCode').':</b> '.length_accountg($this->accountancy_code_sell_intra);
			$label .= '<br><b>'.$langs->trans('ProductAccountancySellExportCode').':</b> '.length_accountg($this->accountancy_code_sell_export);
		}
		if (!empty($conf->accounting->enabled) && $this->status_buy) {
			include_once DOL_DOCUMENT_ROOT.'/core/lib/accounting.lib.php';
			$label .= '<br><b>'.$langs->trans('ProductAccountancyBuyCode').':</b> '.length_accountg($this->accountancy_code_buy);
			$label .= '<br><b>'.$langs->trans('ProductAccountancyBuyIntraCode').':</b> '.length_accountg($this->accountancy_code_buy_intra);
			$label .= '<br><b>'.$langs->trans('ProductAccountancyBuyExportCode').':</b> '.length_accountg($this->accountancy_code_buy_export);
		}

		$linkclose = '';
		if (empty($notooltip)) {
			if (!empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER)) {
				$label = $langs->trans("ShowProduct");
				$linkclose .= ' alt="'.dol_escape_htmltag($label, 1).'"';
			}

			$linkclose .= ' title="'.dol_escape_htmltag($label, 1, 1).'"';
			$linkclose .= ' class="nowraponall classfortooltip"';
		} else {
			$linkclose = ' class="nowraponall"';
		}

		if ($option == 'supplier' || $option == 'category') {
			$url = DOL_URL_ROOT.'/product/fournisseurs.php?id='.$this->id;
		} elseif ($option == 'stock') {
			$url = DOL_URL_ROOT.'/product/stock/product.php?id='.$this->id;
		} elseif ($option == 'composition') {
			$url = DOL_URL_ROOT.'/product/composition/card.php?id='.$this->id;
		} else {
			$url = DOL_URL_ROOT.'/product/card.php?id='.$this->id;
		}

		if ($option !== 'nolink') {
			// Add param to save lastsearch_values or not
			$add_save_lastsearch_values = ($save_lastsearch_value == 1 ? 1 : 0);
			if ($save_lastsearch_value == -1 && preg_match('/list\.php/', $_SERVER["PHP_SELF"])) { $add_save_lastsearch_values = 1;
			}
			if ($add_save_lastsearch_values) { $url .= '&save_lastsearch_values=1';
			}
		}

		$linkstart = '<a href="'.$url.'"';
		$linkstart .= $linkclose.'>';
		$linkend = '</a>';

		$result .= $linkstart;
		if ($withpicto)
		{
			if ($this->type == Product::TYPE_PRODUCT) {
				$result .= (img_object(($notooltip ? '' : $label), 'product', ($notooltip ? 'class="paddingright"' : 'class="paddingright classfortooltip"'), 0, 0, $notooltip ? 0 : 1));
			}
			if ($this->type == Product::TYPE_SERVICE) {
				$result .= (img_object(($notooltip ? '' : $label), 'service', ($notooltip ? 'class="paddinright"' : 'class="paddingright classfortooltip"'), 0, 0, $notooltip ? 0 : 1));
			}
		}
		$result .= $newref;
		$result .= $linkend;

		global $action;
		$hookmanager->initHooks(array('productdao'));
		$parameters = array('id'=>$this->id, 'getnomurl'=>$result);
		$reshook = $hookmanager->executeHooks('getNomUrl', $parameters, $this, $action); // Note that $action and $object may have been modified by some hooks
		if ($reshook > 0) {
			$result = $hookmanager->resPrint;
		} else {
			$result .= $hookmanager->resPrint;
		}

		return $result;
	}


	/**
	 *  Create a document onto disk according to template module.
	 *
	 * @param  string    $modele      Force model to use ('' to not force)
	 * @param  Translate $outputlangs Object langs to use for output
	 * @param  int       $hidedetails Hide details of lines
	 * @param  int       $hidedesc    Hide description
	 * @param  int       $hideref     Hide ref
	 * @return int                         0 if KO, 1 if OK
	 */
	public function generateDocument($modele, $outputlangs, $hidedetails = 0, $hidedesc = 0, $hideref = 0)
	{
		global $conf, $user, $langs;

		$langs->load("products");
		$outputlangs->load("products");

		// Positionne le modele sur le nom du modele a utiliser
		if (!dol_strlen($modele)) {
			if (!empty($conf->global->PRODUCT_ADDON_PDF)) {
				$modele = $conf->global->PRODUCT_ADDON_PDF;
			} else {
				$modele = 'strato';
			}
		}

		$modelpath = "core/modules/product/doc/";

		return $this->commonGenerateDocument($modelpath, $modele, $outputlangs, $hidedetails, $hidedesc, $hideref);
	}

	/**
	 *    Return label of status of object
	 *
	 * @param  int $mode 0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto
	 * @param  int $type 0=Sell, 1=Buy, 2=Batch Number management
	 * @return string          Label of status
	 */
	public function getLibStatut($mode = 0, $type = 0)
	{
		switch ($type)
		{
			case 0:
			return $this->LibStatut($this->status, $mode, $type);
			case 1:
			return $this->LibStatut($this->status_buy, $mode, $type);
			case 2:
			return $this->LibStatut($this->status_batch, $mode, $type);
			default:
				//Simulate previous behavior but should return an error string
			return $this->LibStatut($this->status_buy, $mode, $type);
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *    Return label of a given status
	 *
	 * @param  int 		$status 	Statut
	 * @param  int		$mode       0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto, 6=Long label + Picto
	 * @param  int 		$type   	0=Status "to sell", 1=Status "to buy", 2=Status "to Batch"
	 * @return string              	Label of status
	 */
	public function LibStatut($status, $mode = 0, $type = 0)
	{
		// phpcs:enable
		global $conf, $langs;

		$labelStatus = $labelStatusShort = '';

		$langs->load('products');
		if (!empty($conf->productbatch->enabled)) { $langs->load("productbatch");
		}

		if ($type == 2) {
			switch ($mode)
			{
				case 0:
					$label = ($status == 0 ? $langs->trans('ProductStatusNotOnBatch') : $langs->trans('ProductStatusOnBatch'));
					return dolGetStatus($label);
				case 1:
					$label = ($status == 0 ? $langs->trans('ProductStatusNotOnBatchShort') : $langs->trans('ProductStatusOnBatchShort'));
					return dolGetStatus($label);
				case 2:
					return $this->LibStatut($status, 3, 2).' '.$this->LibStatut($status, 1, 2);
				case 3:
					return dolGetStatus($langs->trans('ProductStatusNotOnBatch'), '', '', empty($status) ? 'status5' : 'status4', 3, 'dot');
				case 4:
					return $this->LibStatut($status, 3, 2).' '.$this->LibStatut($status, 0, 2);
				case 5:
					return $this->LibStatut($status, 1, 2).' '.$this->LibStatut($status, 3, 2);
				default:
					return dolGetStatus($langs->trans('Unknown'));
			}
		}

		$statuttrans = empty($status) ? 'status5' : 'status4';

		if ($status == 0) {
			// $type   0=Status "to sell", 1=Status "to buy", 2=Status "to Batch"
			if ($type == 0) {
				$labelStatus = $langs->trans('ProductStatusNotOnSellShort');
				$labelStatusShort = $langs->trans('ProductStatusNotOnSell');
			} elseif ($type == 1) {
				$labelStatus = $langs->trans('ProductStatusNotOnBuyShort');
				$labelStatusShort = $langs->trans('ProductStatusNotOnBuy');
			} elseif ($type == 2) {
				$labelStatus = $langs->trans('ProductStatusNotOnBatch');
				$labelStatusShort = $langs->trans('ProductStatusNotOnBatchShort');
			}
		} elseif ($status == 1) {
			// $type   0=Status "to sell", 1=Status "to buy", 2=Status "to Batch"
			if ($type == 0) {
				$labelStatus = $langs->trans('ProductStatusOnSellShort');
				$labelStatusShort = $langs->trans('ProductStatusOnSell');
			} elseif ($type == 1) {
				$labelStatus = $langs->trans('ProductStatusOnBuyShort');
				$labelStatusShort = $langs->trans('ProductStatusOnBuy');
			} elseif ($type == 2) {
				$labelStatus = $langs->trans('ProductStatusOnBatch');
				$labelStatusShort = $langs->trans('ProductStatusOnBatchShort');
			}
		}


		if ($mode > 6) {
			return dolGetStatus($langs->trans('Unknown'), '', '', 'status0', 0);
		} else {
			return dolGetStatus($labelStatus, $labelStatusShort, '', $statuttrans, $mode);
		}
	}


	/**
	 *  Retour label of nature of product
	 *
	 * @return string        Label
	 */
	public function getLibFinished()
	{
		global $langs;
		$langs->load('products');

		if (isset($this->finished) && $this->finished >= 0) {
			$sql = 'SELECT label, code FROM '.MAIN_DB_PREFIX.'c_product_nature where code='.((int) $this->finished).' AND active=1';
			$resql = $this->db->query($sql);
			if ($resql && $this->db->num_rows($resql) > 0) {
				$res = $this->db->fetch_array($resql);
				$label = $langs->trans($res['label']);
				$this->db->free($resql);
				return $label;
			} else {
				$this->error = $this->db->error().' sql='.$sql;
				dol_syslog(__METHOD__.' Error '.$this->error, LOG_ERR);
				return -1;
			}
		}

		return '';
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Adjust stock in a warehouse for product
	 *
	 * @param  User   $user           user asking change
	 * @param  int    $id_entrepot    id of warehouse
	 * @param  double $nbpiece        nb of units
	 * @param  int    $movement       0 = add, 1 = remove
	 * @param  string $label          Label of stock movement
	 * @param  double $price          Unit price HT of product, used to calculate average weighted price (PMP in french). If 0, average weighted price is not changed.
	 * @param  string $inventorycode  Inventory code
	 * @param  string $origin_element Origin element type
	 * @param  int    $origin_id      Origin id of element
	 * @param  int	  $disablestockchangeforsubproduct	Disable stock change for sub-products of kit (usefull only if product is a subproduct)
	 * @return int                     <0 if KO, >0 if OK
	 */
	public function correct_stock($user, $id_entrepot, $nbpiece, $movement, $label = '', $price = 0, $inventorycode = '', $origin_element = '', $origin_id = null, $disablestockchangeforsubproduct = 0)
	{
		// phpcs:enable
		if ($id_entrepot) {
			$this->db->begin();

			include_once DOL_DOCUMENT_ROOT.'/product/stock/class/mouvementstock.class.php';

			$op[0] = "+".trim($nbpiece);
			$op[1] = "-".trim($nbpiece);

			$movementstock = new MouvementStock($this->db);
			$movementstock->setOrigin($origin_element, $origin_id); // Set ->origin and ->origin->id
			$result = $movementstock->_create($user, $this->id, $id_entrepot, $op[$movement], $movement, $price, $label, $inventorycode, '', '', '', '', false, 0, $disablestockchangeforsubproduct);

			if ($result >= 0) {
				$this->db->commit();
				return 1;
			} else {
				$this->error = $movementstock->error;
				$this->errors = $movementstock->errors;

				$this->db->rollback();
				return -1;
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Adjust stock in a warehouse for product with batch number
	 *
	 * @param  User     $user           user asking change
	 * @param  int      $id_entrepot    id of warehouse
	 * @param  double   $nbpiece        nb of units
	 * @param  int      $movement       0 = add, 1 = remove
	 * @param  string   $label          Label of stock movement
	 * @param  double   $price          Price to use for stock eval
	 * @param  integer  $dlc            eat-by date
	 * @param  integer  $dluo           sell-by date
	 * @param  string   $lot            Lot number
	 * @param  string   $inventorycode  Inventory code
	 * @param  string   $origin_element Origin element type
	 * @param  int      $origin_id      Origin id of element
	 * @param  int	    $disablestockchangeforsubproduct	Disable stock change for sub-products of kit (usefull only if product is a subproduct)
	 * @return int                      <0 if KO, >0 if OK
	 */
	public function correct_stock_batch($user, $id_entrepot, $nbpiece, $movement, $label = '', $price = 0, $dlc = '', $dluo = '', $lot = '', $inventorycode = '', $origin_element = '', $origin_id = null, $disablestockchangeforsubproduct = 0)
	{
		// phpcs:enable
		if ($id_entrepot) {
			$this->db->begin();

			include_once DOL_DOCUMENT_ROOT.'/product/stock/class/mouvementstock.class.php';

			$op[0] = "+".trim($nbpiece);
			$op[1] = "-".trim($nbpiece);

			$movementstock = new MouvementStock($this->db);
			$movementstock->setOrigin($origin_element, $origin_id);
			$result = $movementstock->_create($user, $this->id, $id_entrepot, $op[$movement], $movement, $price, $label, $inventorycode, '', $dlc, $dluo, $lot, false, 0, $disablestockchangeforsubproduct);

			if ($result >= 0) {
				$this->db->commit();
				return 1;
			} else {
				$this->error = $movementstock->error;
				$this->errors = $movementstock->errors;

				$this->db->rollback();
				return -1;
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Load information about stock of a product into ->stock_reel, ->stock_warehouse[] (including stock_warehouse[idwarehouse]->detail_batch for batch products)
	 * This function need a lot of load. If you use it on list, use a cache to execute it once for each product id.
	 * If ENTREPOT_EXTRA_STATUS set, filtering on warehouse status possible.
	 *
	 * @param  	string 	$option 					'' = Load all stock info, also from closed and internal warehouses, 'nobatch', 'novirtual'
	 * @param	int		$includedraftpoforvirtual	Include draft status of PO for virtual stock calculation
	 * @return 	int                  				< 0 if KO, > 0 if OK
	 * @see    	load_virtual_stock(), loadBatchInfo()
	 */
	public function load_stock($option = '', $includedraftpoforvirtual = null)
	{
		// phpcs:enable
		global $conf;

		$this->stock_reel = 0;
		$this->stock_warehouse = array();
		$this->stock_theorique = 0;

		$warehouseStatus = array();

		if (preg_match('/warehouseclosed/', $option)) {
			$warehouseStatus[] = Entrepot::STATUS_CLOSED;
		}
		if (preg_match('/warehouseopen/', $option)) {
			$warehouseStatus[] = Entrepot::STATUS_OPEN_ALL;
		}
		if (preg_match('/warehouseinternal/', $option)) {
			$warehouseStatus[] = Entrepot::STATUS_OPEN_INTERNAL;
		}

		$sql = "SELECT ps.rowid, ps.reel, ps.fk_entrepot";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_stock as ps";
		$sql .= ", ".MAIN_DB_PREFIX."entrepot as w";
		$sql .= " WHERE w.entity IN (".getEntity('stock').")";
		$sql .= " AND w.rowid = ps.fk_entrepot";
		$sql .= " AND ps.fk_product = ".$this->id;
		if (!empty($conf->global->ENTREPOT_EXTRA_STATUS) && count($warehouseStatus)) {
			$sql .= " AND w.statut IN (".$this->db->sanitize($this->db->escape(implode(',', $warehouseStatus))).")";
		}

		dol_syslog(get_class($this)."::load_stock", LOG_DEBUG);
		$result = $this->db->query($sql);
		if ($result) {
			$num = $this->db->num_rows($result);
			$i = 0;
			if ($num > 0) {
				while ($i < $num)
				{
					$row = $this->db->fetch_object($result);
					$this->stock_warehouse[$row->fk_entrepot] = new stdClass();
					$this->stock_warehouse[$row->fk_entrepot]->real = $row->reel;
					$this->stock_warehouse[$row->fk_entrepot]->id = $row->rowid;
					if ((!preg_match('/nobatch/', $option)) && $this->hasbatch()) {
						$this->stock_warehouse[$row->fk_entrepot]->detail_batch = Productbatch::findAll($this->db, $row->rowid, 1, $this->id);
					}
					$this->stock_reel += $row->reel;
					$i++;
				}
			}
			$this->db->free($result);

			if (!preg_match('/novirtual/', $option)) {
				$this->load_virtual_stock($includedraftpoforvirtual); // This also load all arrays stats_xxx...
			}

			return 1;
		} else {
			$this->error = $this->db->lasterror();
			return -1;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Load value ->stock_theorique of a product. Property this->id must be defined.
	 *  This function need a lot of load. If you use it on list, use a cache to execute it one for each product id.
	 *
	 * 	@param	int		$includedraftpoforvirtual	Include draft status of PO for virtual stock calculation
	 *  @return int     							< 0 if KO, > 0 if OK
	 *  @see	load_stock(), loadBatchInfo()
	 */
	public function load_virtual_stock($includedraftpoforvirtual = null)
	{
		// phpcs:enable
		global $conf, $hookmanager, $action;

		$stock_commande_client = 0;
		$stock_commande_fournisseur = 0;
		$stock_sending_client = 0;
		$stock_reception_fournisseur = 0;
		$stock_inproduction = 0;

		//dol_syslog("load_virtual_stock");

		if (!empty($conf->commande->enabled))
		{
			$result = $this->load_stats_commande(0, '1,2', 1);
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_commande_client = $this->stats_commande['qty'];
		}
		if (!empty($conf->expedition->enabled))
		{
			require_once DOL_DOCUMENT_ROOT.'/expedition/class/expedition.class.php';
			$filterShipmentStatus = '';
			if (!empty($conf->global->STOCK_CALCULATE_ON_SHIPMENT)) {
				$filterShipmentStatus = Expedition::STATUS_VALIDATED.','.Expedition::STATUS_CLOSED;
			} elseif (!empty($conf->global->STOCK_CALCULATE_ON_SHIPMENT_CLOSE)) {
				$filterShipmentStatus = Expedition::STATUS_CLOSED;
			}
			$result = $this->load_stats_sending(0, '1,2', 1, $filterShipmentStatus);
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_sending_client = $this->stats_expedition['qty'];
		}
		if (!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled))
		{
			$filterStatus = '1,2,3,4';
			if (isset($includedraftpoforvirtual)) $filterStatus = '0,'.$filterStatus;
			$result = $this->load_stats_commande_fournisseur(0, $filterStatus, 1);
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_commande_fournisseur = $this->stats_commande_fournisseur['qty'];
		}
		if ((!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled) || !empty($conf->supplier_invoice->enabled)) && empty($conf->reception->enabled))
		{
			$filterStatus = '4';
			if (isset($includedraftpoforvirtual)) $filterStatus = '0,'.$filterStatus;
			$result = $this->load_stats_reception(0, $filterStatus, 1);
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_reception_fournisseur = $this->stats_reception['qty'];
		}
		if ((!empty($conf->fournisseur->enabled) && empty($conf->global->MAIN_USE_NEW_SUPPLIERMOD) || !empty($conf->supplier_order->enabled) || !empty($conf->supplier_invoice->enabled)) && empty($conf->reception->enabled))
		{
			$filterStatus = '4';
			if (isset($includedraftpoforvirtual)) $filterStatus = '0,'.$filterStatus;
			$result = $this->load_stats_reception(0, $filterStatus, 1); // Use same tables than when module reception is not used.
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_reception_fournisseur = $this->stats_reception['qty'];
		}
		if (!empty($conf->mrp->enabled))
		{
			$result = $this->load_stats_inproduction(0, '1,2', 1);
			if ($result < 0) dol_print_error($this->db, $this->error);
			$stock_inproduction = $this->stats_mrptoproduce['qty'] - $this->stats_mrptoconsume['qty'];
		}

		$this->stock_theorique = $this->stock_reel + $stock_inproduction;

		// Stock decrease mode
		if (!empty($conf->global->STOCK_CALCULATE_ON_SHIPMENT) || !empty($conf->global->STOCK_CALCULATE_ON_SHIPMENT_CLOSE)) {
			$this->stock_theorique -= ($stock_commande_client - $stock_sending_client);
		} elseif (!empty($conf->global->STOCK_CALCULATE_ON_VALIDATE_ORDER)) {
			$this->stock_theorique += 0;
		} elseif (!empty($conf->global->STOCK_CALCULATE_ON_BILL)) {
			$this->stock_theorique -= $stock_commande_client;
		}
		// Stock Increase mode
		if (!empty($conf->global->STOCK_CALCULATE_ON_RECEPTION) || !empty($conf->global->STOCK_CALCULATE_ON_RECEPTION_CLOSE)) {
			$this->stock_theorique += ($stock_commande_fournisseur - $stock_reception_fournisseur);
		} elseif (!empty($conf->global->STOCK_CALCULATE_ON_SUPPLIER_DISPATCH_ORDER)) {
			$this->stock_theorique += ($stock_commande_fournisseur - $stock_reception_fournisseur);
		} elseif (!empty($conf->global->STOCK_CALCULATE_ON_SUPPLIER_VALIDATE_ORDER)) {
			$this->stock_theorique -= $stock_reception_fournisseur;
		} elseif (!empty($conf->global->STOCK_CALCULATE_ON_SUPPLIER_BILL)) {
			$this->stock_theorique += ($stock_commande_fournisseur - $stock_reception_fournisseur);
		}

		if (!is_object($hookmanager)) {
			include_once DOL_DOCUMENT_ROOT.'/core/class/hookmanager.class.php';
			$hookmanager = new HookManager($this->db);
		}
		$hookmanager->initHooks(array('productdao'));
		$parameters = array('id'=>$this->id, 'includedraftpoforvirtual' => $includedraftpoforvirtual);
		// Note that $action and $object may have been modified by some hooks
		$reshook = $hookmanager->executeHooks('loadvirtualstock', $parameters, $this, $action);
		if ($reshook > 0) $this->stock_theorique = $hookmanager->resArray['stock_theorique'];

		return 1;
	}


	/**
	 *  Load existing information about a serial
	 *
	 * @param  string $batch Lot/serial number
	 * @return array                    Array with record into product_batch
	 * @see    load_stock(), load_virtual_stock()
	 */
	public function loadBatchInfo($batch)
	{
		$result = array();

		$sql = "SELECT pb.batch, pb.eatby, pb.sellby, SUM(pb.qty) AS qty FROM ".MAIN_DB_PREFIX."product_batch as pb, ".MAIN_DB_PREFIX."product_stock as ps";
		$sql .= " WHERE pb.fk_product_stock = ps.rowid AND ps.fk_product = ".$this->id." AND pb.batch = '".$this->db->escape($batch)."'";
		$sql .= " GROUP BY pb.batch, pb.eatby, pb.sellby";
		dol_syslog(get_class($this)."::loadBatchInfo load first entry found for lot/serial = ".$batch, LOG_DEBUG);
		$resql = $this->db->query($sql);
		if ($resql) {
			$num = $this->db->num_rows($resql);
			$i = 0;
			while ($i < $num)
			{
				$obj = $this->db->fetch_object($resql);
				$result[] = array('batch'=>$batch, 'eatby'=>$this->db->jdate($obj->eatby), 'sellby'=>$this->db->jdate($obj->sellby), 'qty'=>$obj->qty);
				$i++;
			}
			return $result;
		} else {
			dol_print_error($this->db);
			$this->db->rollback();
			return array();
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Move an uploaded file described into $file array into target directory $sdir.
	 *
	 * @param  string $sdir Target directory
	 * @param  string $file Array of file info of file to upload: array('name'=>..., 'tmp_name'=>...)
	 * @return int                    <0 if KO, >0 if OK
	 */
	public function add_photo($sdir, $file)
	{
		// phpcs:enable
		global $conf;

		include_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';

		$result = 0;

		$dir = $sdir;
		if (!empty($conf->global->PRODUCT_USE_OLD_PATH_FOR_PHOTO)) {
			$dir .= '/'.get_exdir($this->id, 2, 0, 0, $this, 'product').$this->id."/photos";
		} else {
			$dir .= '/'.get_exdir(0, 0, 0, 0, $this, 'product').dol_sanitizeFileName($this->ref);
		}

		dol_mkdir($dir);

		$dir_osencoded = $dir;

		if (is_dir($dir_osencoded)) {
			$originImage = $dir.'/'.$file['name'];

			// Cree fichier en taille origine
			$result = dol_move_uploaded_file($file['tmp_name'], $originImage, 1);

			if (file_exists(dol_osencode($originImage))) {
				// Create thumbs
				$this->addThumbs($originImage);
			}
		}

		if (is_numeric($result) && $result > 0) {
			return 1;
		} else {
			return -1;
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Return if at least one photo is available
	 *
	 * @param  string $sdir Directory to scan
	 * @return boolean                 True if at least one photo is available, False if not
	 */
	public function is_photo_available($sdir)
	{
		// phpcs:enable
		include_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
		include_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';

		global $conf;

		$dir = $sdir;
		if (!empty($conf->global->PRODUCT_USE_OLD_PATH_FOR_PHOTO)) {
			$dir .= '/'.get_exdir($this->id, 2, 0, 0, $this, 'product').$this->id."/photos/";
		} else {
			$dir .= '/'.get_exdir(0, 0, 0, 0, $this, 'product');
		}

		$nbphoto = 0;

		$dir_osencoded = dol_osencode($dir);
		if (file_exists($dir_osencoded)) {
			$handle = opendir($dir_osencoded);
			if (is_resource($handle)) {
				while (($file = readdir($handle)) !== false)
				{
					if (!utf8_check($file)) {
						$file = utf8_encode($file); // To be sure data is stored in UTF8 in memory
					}
					if (dol_is_file($dir.$file) && image_format_supported($file) >= 0) {
						return true;
					}
				}
			}
		}
		return false;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Retourne tableau de toutes les photos du produit
	 *
	 * @param  string $dir   Repertoire a scanner
	 * @param  int    $nbmax Nombre maximum de photos (0=pas de max)
	 * @return array                   Tableau de photos
	 */
	public function liste_photos($dir, $nbmax = 0)
	{
		// phpcs:enable
		include_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
		include_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';

		$nbphoto = 0;
		$tabobj = array();

		$dir_osencoded = dol_osencode($dir);
		$handle = @opendir($dir_osencoded);
		if (is_resource($handle)) {
			while (($file = readdir($handle)) !== false)
			{
				if (!utf8_check($file)) { $file = utf8_encode($file); // readdir returns ISO
				}
				if (dol_is_file($dir.$file) && image_format_supported($file) >= 0) {
					$nbphoto++;

					// On determine nom du fichier vignette
					$photo = $file;
					$photo_vignette = '';
					if (preg_match('/('.$this->regeximgext.')$/i', $photo, $regs)) {
						$photo_vignette = preg_replace('/'.$regs[0].'/i', '', $photo).'_small'.$regs[0];
					}

					$dirthumb = $dir.'thumbs/';

					// Objet
					$obj = array();
					$obj['photo'] = $photo;
					if ($photo_vignette && dol_is_file($dirthumb.$photo_vignette)) { $obj['photo_vignette'] = 'thumbs/'.$photo_vignette;
					} else { $obj['photo_vignette'] = "";
					}

					$tabobj[$nbphoto - 1] = $obj;

					// On continue ou on arrete de boucler ?
					if ($nbmax && $nbphoto >= $nbmax) { break;
					}
				}
			}

			closedir($handle);
		}

		return $tabobj;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Efface la photo du produit et sa vignette
	 *
	 * @param  string $file Chemin de l'image
	 * @return void
	 */
	public function delete_photo($file)
	{
		// phpcs:enable
		include_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
		include_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';

		$dir = dirname($file).'/'; // Chemin du dossier contenant l'image d'origine
		$dirthumb = $dir.'/thumbs/'; // Chemin du dossier contenant la vignette
		$filename = preg_replace('/'.preg_quote($dir, '/').'/i', '', $file); // Nom du fichier

		// On efface l'image d'origine
		dol_delete_file($file, 0, 0, 0, $this); // For triggers

		// Si elle existe, on efface la vignette
		if (preg_match('/('.$this->regeximgext.')$/i', $filename, $regs)) {
			$photo_vignette = preg_replace('/'.$regs[0].'/i', '', $filename).'_small'.$regs[0];
			if (file_exists(dol_osencode($dirthumb.$photo_vignette))) {
				dol_delete_file($dirthumb.$photo_vignette);
			}

			$photo_vignette = preg_replace('/'.$regs[0].'/i', '', $filename).'_mini'.$regs[0];
			if (file_exists(dol_osencode($dirthumb.$photo_vignette))) {
				dol_delete_file($dirthumb.$photo_vignette);
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Load size of image file
	 *
	 * @param  string $file Path to file
	 * @return void
	 */
	public function get_image_size($file)
	{
		// phpcs:enable
		$file_osencoded = dol_osencode($file);
		$infoImg = getimagesize($file_osencoded); // Get information on image
		$this->imgWidth = $infoImg[0]; // Largeur de l'image
		$this->imgHeight = $infoImg[1]; // Hauteur de l'image
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Load indicators this->nb for the dashboard
	 *
	 * @return int                 <0 if KO, >0 if OK
	 */
	public function load_state_board()
	{
		// phpcs:enable
		global $conf, $user, $hookmanager;

		$this->nb = array();

		$sql = "SELECT count(p.rowid) as nb, fk_product_type";
		$sql .= " FROM ".MAIN_DB_PREFIX."product as p";
		$sql .= ' WHERE p.entity IN ('.getEntity($this->element, 1).')';
		// Add where from hooks
		if (is_object($hookmanager)) {
			$parameters = array();
			$reshook = $hookmanager->executeHooks('printFieldListWhere', $parameters); // Note that $action and $object may have been modified by hook
			$sql .= $hookmanager->resPrint;
		}
		$sql .= ' GROUP BY fk_product_type';

		$resql = $this->db->query($sql);
		if ($resql) {
			while ($obj = $this->db->fetch_object($resql))
			{
				if ($obj->fk_product_type == 1) { $this->nb["services"] = $obj->nb;
				} else { $this->nb["products"] = $obj->nb;
				}
			}
			$this->db->free($resql);
			return 1;
		} else {
			dol_print_error($this->db);
			$this->error = $this->db->error();
			return -1;
		}
	}

	/**
	 * Return if object is a product
	 *
	 * @return boolean     True if it's a product
	 */
	public function isProduct()
	{
		return ($this->type == Product::TYPE_PRODUCT ? true : false);
	}

	/**
	 * Return if object is a product
	 *
	 * @return boolean     True if it's a service
	 */
	public function isService()
	{
		return ($this->type == Product::TYPE_SERVICE ? true : false);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Get a barcode from the module to generate barcode values.
	 *  Return value is stored into this->barcode
	 *
	 * @param  Product $object Object product or service
	 * @param  string  $type   Barcode type (ean, isbn, ...)
	 * @return string
	 */
	public function get_barcode($object, $type = '')
	{
		// phpcs:enable
		global $conf;

		$result = '';
		if (!empty($conf->global->BARCODE_PRODUCT_ADDON_NUM)) {
			$dirsociete = array_merge(array('/core/modules/barcode/'), $conf->modules_parts['barcode']);
			foreach ($dirsociete as $dirroot)
			{
				$res = dol_include_once($dirroot.$conf->global->BARCODE_PRODUCT_ADDON_NUM.'.php');
				if ($res) { break;
				}
			}
			$var = $conf->global->BARCODE_PRODUCT_ADDON_NUM;
			$mod = new $var;

			$result = $mod->getNextValue($object, $type);

			dol_syslog(get_class($this)."::get_barcode barcode=".$result." module=".$var);
		}
		return $result;
	}

	/**
	 *  Initialise an instance with random values.
	 *  Used to build previews or test instances.
	 *    id must be 0 if object instance is a specimen.
	 *
	 * @return void
	 */
	public function initAsSpecimen()
	{
		global $user, $langs, $conf, $mysoc;

		$now = dol_now();

		// Initialize parameters
		$this->specimen = 1;
		$this->id = 0;
		$this->ref = 'PRODUCT_SPEC';
		$this->label = 'PRODUCT SPECIMEN';
		$this->description = 'This is description of this product specimen that was created the '.dol_print_date($now, 'dayhourlog').'.';
		$this->specimen = 1;
		$this->country_id = 1;
		$this->tosell = 1;
		$this->tobuy = 1;
		$this->tobatch = 0;
		$this->note = 'This is a comment (private)';
		$this->date_creation = $now;
		$this->date_modification = $now;

		$this->weight = 4;
		$this->weight_units = 3;

		$this->length = 5;
		$this->length_units = 1;
		$this->width = 6;
		$this->width_units = 0;
		$this->height = null;
		$this->height_units = null;

		$this->surface = 30;
		$this->surface_units = 0;
		$this->volume = 300;
		$this->volume_units = 0;

		$this->barcode = -1; // Create barcode automatically
	}

	/**
	 *    Returns the text label from units dictionary
	 *
	 * @param  string $type Label type (long or short)
	 * @return string|int <0 if ko, label if ok
	 */
	public function getLabelOfUnit($type = 'long')
	{
		global $langs;

		if (!$this->fk_unit) {
			return '';
		}

		$langs->load('products');

		$label_type = 'label';
		if ($type == 'short') {
			$label_type = 'short_label';
		}

		$sql = 'select '.$label_type.', code from '.MAIN_DB_PREFIX.'c_units where rowid='.$this->fk_unit;
		$resql = $this->db->query($sql);
		if ($resql && $this->db->num_rows($resql) > 0) {
			$res = $this->db->fetch_array($resql);
			$label = ($label_type == 'short_label' ? $res[$label_type] : 'unit'.$res['code']);
			$this->db->free($resql);
			return $label;
		} else {
			$this->error = $this->db->error().' sql='.$sql;
			dol_syslog(get_class($this)."::getLabelOfUnit Error ".$this->error, LOG_ERR);
			return -1;
		}
	}

	/**
	 * Return if object has a sell-by date or eat-by date
	 *
	 * @return boolean     True if it's has
	 */
	public function hasbatch()
	{
		return ($this->status_batch == 1 ? true : false);
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 * Return minimum product recommended price
	 *
	 * @return int            Minimum recommanded price that is higher price among all suppliers * PRODUCT_MINIMUM_RECOMMENDED_PRICE
	 */
	public function min_recommended_price()
	{
		// phpcs:enable
		global $conf;

		$maxpricesupplier = 0;

		if (!empty($conf->global->PRODUCT_MINIMUM_RECOMMENDED_PRICE)) {
			include_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.product.class.php';
			$product_fourn = new ProductFournisseur($this->db);
			$product_fourn_list = $product_fourn->list_product_fournisseur_price($this->id, '', '');

			if (is_array($product_fourn_list) && count($product_fourn_list) > 0) {
				foreach ($product_fourn_list as $productfourn)
				{
					if ($productfourn->fourn_unitprice > $maxpricesupplier) {
						$maxpricesupplier = $productfourn->fourn_unitprice;
					}
				}

				$maxpricesupplier *= $conf->global->PRODUCT_MINIMUM_RECOMMENDED_PRICE;
			}
		}

		return $maxpricesupplier;
	}


	/**
	 * Sets object to supplied categories.
	 *
	 * Deletes object from existing categories not supplied.
	 * Adds it to non existing supplied categories.
	 * Existing categories are left untouch.
	 *
	 * @param  int[]|int $categories Category or categories IDs
	 * @return void
	 */
	public function setCategories($categories)
	{
		// Handle single category
		if (!is_array($categories)) {
			$categories = array($categories);
		}

		// Get current categories
		include_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
		$c = new Categorie($this->db);
		$existing = $c->containing($this->id, Categorie::TYPE_PRODUCT, 'id');

		// Diff
		if (is_array($existing)) {
			$to_del = array_diff($existing, $categories);
			$to_add = array_diff($categories, $existing);
		} else {
			$to_del = array(); // Nothing to delete
			$to_add = $categories;
		}

		// Process
		foreach ($to_del as $del) {
			if ($c->fetch($del) > 0) {
				$c->del_type($this, Categorie::TYPE_PRODUCT);
			}
		}
		foreach ($to_add as $add) {
			if ($c->fetch($add) > 0) {
				$c->add_type($this, Categorie::TYPE_PRODUCT);
			}
		}

		return;
	}

	/**
	 * Function used to replace a thirdparty id with another one.
	 *
	 * @param  DoliDB $db        Database handler
	 * @param  int    $origin_id Old thirdparty id
	 * @param  int    $dest_id   New thirdparty id
	 * @return bool
	 */
	public static function replaceThirdparty(DoliDB $db, $origin_id, $dest_id)
	{
		$tables = array(
		'product_customer_price',
		'product_customer_price_log'
		);

		return CommonObject::commonReplaceThirdparty($db, $origin_id, $dest_id, $tables);
	}

	/**
	 * Generates prices for a product based on product multiprice generation rules
	 *
	 * @param  User   $user       User that updates the prices
	 * @param  float  $baseprice  Base price
	 * @param  string $price_type Base price type
	 * @param  float  $price_vat  VAT % tax
	 * @param  int    $npr        NPR
	 * @param  string $psq        ¿?
	 * @return int -1 KO, 1 OK
	 */
	public function generateMultiprices(User $user, $baseprice, $price_type, $price_vat, $npr, $psq)
	{
		global $conf, $db;

		$sql = "SELECT rowid, level, fk_level, var_percent, var_min_percent FROM ".MAIN_DB_PREFIX."product_pricerules";
		$query = $this->db->query($sql);

		$rules = array();

		while ($result = $this->db->fetch_object($query)) {
			$rules[$result->level] = $result;
		}

		//Because prices can be based on other level's prices, we temporarily store them
		$prices = array(
			1 => $baseprice
		);

		for ($i = 1; $i <= $conf->global->PRODUIT_MULTIPRICES_LIMIT; $i++) {
			$price = $baseprice;
			$price_min = $baseprice;

			//We have to make sure it does exist and it is > 0
			//First price level only allows changing min_price
			if ($i > 1 && isset($rules[$i]->var_percent) && $rules[$i]->var_percent) {
				$price = $prices[$rules[$i]->fk_level] * (1 + ($rules[$i]->var_percent / 100));
			}

			$prices[$i] = $price;

			//We have to make sure it does exist and it is > 0
			if (isset($rules[$i]->var_min_percent) && $rules[$i]->var_min_percent) {
				$price_min = $price * (1 - ($rules[$i]->var_min_percent / 100));
			}

			//Little check to make sure the price is modified before triggering generation
			$check_amount = (($price == $this->multiprices[$i]) && ($price_min == $this->multiprices_min[$i]));
			$check_type = ($baseprice == $this->multiprices_base_type[$i]);

			if ($check_amount && $check_type) {
				continue;
			}

			if ($this->updatePrice($price, $price_type, $user, $price_vat, $price_min, $i, $npr, $psq, true) < 0) {
				return -1;
			}
		}

		return 1;
	}

	/**
	 * Returns the rights used for this class
	 *
	 * @return Object
	 */
	public function getRights()
	{
		global $user;

		if ($this->isProduct()) {
			return $user->rights->produit;
		} else {
			return $user->rights->service;
		}
	}

	/**
	 *  Load information for tab info
	 *
	 * @param  int $id Id of thirdparty to load
	 * @return void
	 */
	public function info($id)
	{
		$sql = "SELECT p.rowid, p.ref, p.datec as date_creation, p.tms as date_modification,";
		$sql .= " p.fk_user_author, p.fk_user_modif";
		$sql .= " FROM ".MAIN_DB_PREFIX.$this->table_element." as p";
		$sql .= " WHERE p.rowid = ".$id;

		$result = $this->db->query($sql);
		if ($result) {
			if ($this->db->num_rows($result)) {
				$obj = $this->db->fetch_object($result);

				$this->id = $obj->rowid;

				if ($obj->fk_user_author) {
					$cuser = new User($this->db);
					$cuser->fetch($obj->fk_user_author);
					$this->user_creation = $cuser;
				}

				if ($obj->fk_user_modif) {
					$muser = new User($this->db);
					$muser->fetch($obj->fk_user_modif);
					$this->user_modification = $muser;
				}

				$this->ref = $obj->ref;
				$this->date_creation     = $this->db->jdate($obj->date_creation);
				$this->date_modification = $this->db->jdate($obj->date_modification);
			}

			$this->db->free($result);
		} else {
			dol_print_error($this->db);
		}
	}

	public function addProduct($user, $api = 0)
	{
		$now = dol_now();
		$entity = 1;
		$sql = "SELECT rowid";
		$sql .= " FROM ".MAIN_DB_PREFIX."product_customer";
		$sql .= " WHERE fk_soc  = '".$this->db->escape($this->fk_soc)."' ";
		$sql .= " AND fk_product = '".$this->db->escape($this->fk_product)."'";
		$sql .= " AND ac_capacity = '".$this->db->escape($this->ac_capacity)."'";

		$result = $this->db->query($sql);
		if ($result) {
			$obj = $this->db->num_rows($result);
			if ($obj == 0) {
				// Produit non deja existant
				$sql = "INSERT INTO ".MAIN_DB_PREFIX."product_customer";
				$sql .= " SET datec = '".$this->db->idate($now)."'";
				$sql .= ", entity = '".$this->db->escape($entity)."'";
				$sql .= ", fk_brand = '".$this->db->escape($this->fk_brand)."'";
				$sql .= ", fk_category = '".$this->db->escape($this->fk_category)."'";
				$sql .= ", fk_subcategory = '".$this->db->escape($this->fk_subcategory)."'";
				$sql .= ", fk_model = '".$this->db->escape($this->fk_model)."'";
				$sql .= ", fk_product = '".$this->db->escape($this->fk_product)."'";
				$sql .= ", fk_soc = '".$this->db->escape($this->fk_soc)."'";
				$sql .= ", ac_capacity = '".$this->db->escape($this->ac_capacity)."'";
				$sql .= ", component_no = '".$this->db->escape($this->component_no)."'";
				$sql .= ", fk_user = '1'";
				//dol_syslog(get_class($this)."::Create Customer Product", LOG_DEBUG);
				$result = $this->db->query($sql);
				if ($result) {
					$id = $this->db->last_insert_id(MAIN_DB_PREFIX."product_customer");
					return $id;
				}
			}
			else
			{
				$data = $this->db->fetch_object($result);
				return 0;//$data->rowid;
			}
		}
	}	

	/* Get model info by model id*/
	public function getProductModel($model_id)
	{
		$outjson = array();
		$sql = "SELECT pm.rowid as rowid, pm.code as modelno, pm.nom as name, sf.nom as subfamily, f.nom as family, b.nom as brand, pm.is_installable, pm.active, b.rowid as brandid, f.rowid as categoryid, sf.rowid as subcategoryid, p.rowid as productid FROM ".MAIN_DB_PREFIX."product as p, ".MAIN_DB_PREFIX."c_product_model as pm, ".MAIN_DB_PREFIX."c_product_subfamily as sf,".MAIN_DB_PREFIX."c_product_family as f,".MAIN_DB_PREFIX."c_brands as b WHERE p.fk_model = pm.rowid and pm.fk_family = f.rowid and pm.fk_subfamily = sf.rowid AND pm.fk_brand = b.rowid AND pm.rowid = '".$model_id."' ";

		$result = $this->db->query($sql);
		if ($result) {
			if ($this->db->num_rows($result)) {
				$obj = $this->db->fetch_object($result);

				$id = $obj->rowid;

				$outjson = array('id' => $obj->rowid, 'brand' => $obj->brand, 'family' => $obj->family, 'subfamily' => $obj->subfamily, 'name' => $obj->name, 'model' => $obj->modelno, 'product_id' => $obj->productid, 'subcategoryid' => $obj->subcategoryid, 'categoryid' => $obj->categoryid, 'brandid' => $obj->brandid);
			}
		}	
		return json_encode($outjson);
	}

	/* Get model info by model id*/
	public function getCustomerProductModelInfo($model_id,$socid)
	{
		$outjson = array();
		$sql = "SELECT p.rowid as rowid, p.fk_model as modelid, m.code as modelno, p.fk_brand,p.fk_category, p.fk_subcategory, p.fk_product FROM ".MAIN_DB_PREFIX."product_customer as p LEFT JOIN ".MAIN_DB_PREFIX."c_product_model as m on p.fk_model = m.rowid AND p.fk_model = '".$model_id."' AND p.fk_soc = '".$socid."' ";
		$result = $this->db->query($sql);
		if ($result) {
			$num = $this->db->num_rows($result);
			if ($this->db->num_rows($result)) {
				$i = 0;
				
				while ($i < $num) {
					$obj = $this->db->fetch_object($result);

					$id = $obj->rowid;

					$outjson = array('id' => $obj->rowid, 'branid' => $obj->fk_brand, 'category' => $obj->fk_category, 'subcategory' => $obj->fk_subcategory, 'product_id' => $obj->fk_product, 'model' => $obj->modelno);
					$i++;
				}
			}
		}	
		return json_encode($outjson);
	}

	/* Get product info by customer id*/
	public function getCustomerProductModel($socid)
	{
		$outjson = array();
		$sql = "SELECT p.rowid as rowid, p.fk_model as modelid, m.code as modelno FROM ".MAIN_DB_PREFIX."product_customer as p, ".MAIN_DB_PREFIX."LEFT JOIN ".MAIN_DB_PREFIX."c_product_model as m on p.fk_model = m.rowid AND p.fk_soc = '".$socid."' ";

		$result = $this->db->query($sql);
		$str = '<option value="0">Select Model No</option>';
		if ($result) {
			$num = $this->db->num_rows($result);
			
			if ($this->db->num_rows($result)) {
				$i = 0;
				
				while ($i < $num) {
					
					$obj = $this->db->fetch_object($result);

					$id = $obj->rowid;
					$str .= '<option value="'.$obj->modelid.'">'.$obj->modelno.'</option>';
					//$outjson = array('id' => $obj->modelid, 'code' => $obj->modelno);
					$i++;
				}
			}
		}	
		return $str;
	}

	public function getCustomerProductcomponentNo()
	{
		$component_no = '1900000';
		$sqlcomponent_no = "SELECT MAX(component_no) as max";
		$sqlcomponent_no .= " FROM ".MAIN_DB_PREFIX."product_customer";
		$sqlcomponent_no .= " WHERE component_no != '' ";
		$resqlcomponent_no = $this->db->query($sqlcomponent_no);
		if ($resqlcomponent_no)
		{
			$objcomponent_no = $this->db->fetch_object($resqlcomponent_no);
			$component_no = intval($objcomponent_no->max)+1;
		}else{
			$component_no = $component_no+1;
		}

		return $component_no;
	}
}