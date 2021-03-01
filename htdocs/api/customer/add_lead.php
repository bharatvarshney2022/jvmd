<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
	require_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
	require_once DOL_DOCUMENT_ROOT.'/projet/class/task.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/lib/project.lib.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/html.formprojet.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
	require_once DOL_DOCUMENT_ROOT.'/core/modules/project/modules_project.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
	require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
	
	$user_id = $socid = GETPOST('user_id', 'int');

	$defaultref = '';
	$modele = empty($conf->global->PROJECT_ADDON) ? 'mod_project_simple' : $conf->global->PROJECT_ADDON;

	$file = ''; $classname = ''; $filefound = 0;
	$dirmodels = array_merge(array('/'), (array) $conf->modules_parts['models']);
	foreach ($dirmodels as $reldir)
	{
		$file = dol_buildpath($reldir."core/modules/project/".$modele.'.php', 0);
		if (file_exists($file))
		{
			$filefound = 1;
			$classname = $modele;
			break;
		}
	}

	if ($filefound)
	{
		$thirdparty = new Societe($db);
		if ($user_id > 0) $thirdparty->fetch($user_id);

		$result = dol_include_once($reldir."core/modules/project/".$modele.'.php');
		$modProject = new $classname;

		$defaultref = $modProject->getNextValue($thirdparty, $object);
	}

	echo $defaultref; exit;

	$ref = $defaultref;
	$title = GETPOST('title', 'alphanohtml');

	$product_brand = GETPOST('product_brand', 'alpha');
	$fk_category = GETPOST('product_category', 'alpha');
	$fk_sub_category = GETPOST('product_sub_category', 'alpha');
	$fk_model = GETPOST('product_model', 'alpha');
	$fk_product = GETPOST('product_name', 'alpha');

	$ac_capacity = GETPOST('ac_capacity', 'alpha');
	$options_fk_call_source = GETPOST('call_source', 'alpha');
	$options_fk_service_type = GETPOST('service_type', 'alpha');

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$slider = array();

	if($userExists)
	{
		$objectPro1 = new Product($db);
		$brand_id = $objectPro1->getBrandByName($brand_name);
		$category_id = $objectPro1->getCategoryByName($brand_id, $product_category);
		$sub_category_id = $objectPro1->getSubCategoryByName($brand_id, $category_id, $sub_product_category);
		$model_id = $objectPro1->getModelByName($brand_id, $category_id, $sub_category_id, $product_model);

		//echo $brand_id.",".$category_id; exit;

		$product_id = $objectPro1->getProductListByName($product_model);

		$objectPro = new Product($db);


		// Component No
		$component_no = '1900000';
		$sqlcomponent_no = "SELECT MAX(component_no) as max";
		$sqlcomponent_no .= " FROM ".MAIN_DB_PREFIX."product_customer";
		$sqlcomponent_no .= " WHERE component_no != '' ";
		$resqlcomponent_no = $db->query($sqlcomponent_no);
		if ($resqlcomponent_no)
		{
			$objcomponent_no = $db->fetch_object($resqlcomponent_no);
			$component_no = intval($objcomponent_no->max)+1;
		}else{
			$component_no = $component_no+1;
		}

		if($brand_id > 0 && $category_id > 0 && $sub_category_id > 0 && $model_id > 0)
		{
			$objectProCust = new ProductCustomer($db);

			$objectProCust->fk_model = $model_id;
			$objectProCust->fk_soc = $user_id;
			$objectProCust->fk_brand = $brand_id;
			$objectProCust->fk_category = $category_id;
			$objectProCust->fk_subcategory = $sub_category_id;
			$objectProCust->fk_product = $product_id;
			$objectProCust->ac_capacity = $capacity;
			$objectProCust->component_no = $component_no;

			$newCustomerProduct = $objectProCust->addProduct($userRow, 1);

			if($newCustomerProduct == 0)
			{
				$status_code = '0';
				$message = 'Selected data already exists.';


				$json = array('status_code' => $status_code, 'message' => $message);
			}
			else
			{

				// Image Upload
				if (!empty($_FILES))
				{
					$error = 0;
					if (is_array($_FILES['product_images']['tmp_name'])) $images = $_FILES['product_images']['tmp_name'];
					else $images = array($_FILES['product_images']['tmp_name']);

					foreach ($images as $key => $image)
					{
						if (empty($_FILES['product_images']['tmp_name'][$key]))
						{
							$error++;
							if ($_FILES['product_images']['error'][$key] == 1 || $_FILES['product_images']['error'][$key] == 2) {
								setEventMessages($langs->trans('ErrorFileSizeTooLarge'), null, 'errors');
							} else {
								setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentitiesnoconv("File")), null, 'errors');
							}
						}
					}

					if (!$error)
					{
						// Define if we have to generate thumbs or not
						$generatethumbs = 1;
						$allowoverwrite = 0;

						$upload_dir = $conf->global->PRODUCT_CUSTOMER_MULTIDIR."/".$newCustomerProduct;
						
						if (!empty($upload_dir))
						{
							$result = dol_add_file_process($upload_dir, $allowoverwrite, 1, 'product_images', GETPOST('savingdocmask', 'alpha'), null, '', $generatethumbs, $objectPro);
						}
					}
				}

				$db->commit();
				$status_code = '1';
				$message = 'Product added successfully.';

				$json = array('status_code' => $status_code, 'message' => $message, 'product_id' => "".$newCustomerProduct);
			}
		}
		else
		{
			$status_code = '0';
			$message = 'Please choose all required field and try again.';

			$json = array('status_code' => $status_code, 'message' => $message);
		}
	}
	else
	{
		$status_code = '0';
		$message = 'Sorry! customer not exists!!';
		
		$json = array('status_code' => $status_code, 'message' => $message);
	}
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);