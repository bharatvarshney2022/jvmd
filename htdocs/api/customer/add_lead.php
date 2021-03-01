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

	$ref = $defaultref;
	$title = GETPOST('title', 'alphanohtml');

	$product_brand = GETPOST('brand_name', 'alpha');
	$fk_category = GETPOST('product_category', 'alpha');
	$fk_sub_category = GETPOST('sub_product_category', 'alpha');
	$fk_model = GETPOST('product_model', 'alpha');
	
	$ac_capacity = GETPOST('capacity', 'alpha');
	$options_fk_call_source = GETPOST('call_source', 'alpha');
	$options_fk_service_type = GETPOST('service_type', 'alpha');

	$description = 'Brand: '.$product_brand.'<br /> Category: '.$fk_category.'<br /> Sub-Category: '.$fk_sub_category.'<br /> Model: '.$fk_model.'<br />';

	global $db, $user, $conf, $langs;

	$json = array();
	
	$object = new Societe($db);
	
	$userExists = $object->fetch($user_id);
	$slider = array();

	if($userExists)
	{
		$objectPro1 = new Product($db);
		$brand_id = $objectPro1->getBrandByName($product_brand);
		$category_id = $objectPro1->getCategoryByName($brand_id, $fk_category);
		$sub_category_id = $objectPro1->getSubCategoryByName($brand_id, $category_id, $fk_sub_category);
		$model_id = $objectPro1->getModelByName($brand_id, $category_id, $sub_category_id, $fk_model);

		$product_id = $objectPro1->getProductListByName($fk_model);

		$call_source_id = $objectPro1->getCallSourceByName($options_fk_call_source);
		//c_call_source:label:rowid::active=1
		//c_service_type:label:rowid::active=1
		$service_type_id = $objectPro1->getServiceTypeByName($options_fk_service_type);

		if($brand_id > 0 && $category_id > 0 && $sub_category_id > 0 && $model_id > 0 && $call_source_id > 0 && $service_type_id > 0)
		{
			$objectProCust = new Project($db);

			$objectProCust->ref = $ref;
			$objectProCust->title = $title;
			$objectProCust->fk_soc = $user_id;
			$objectProCust->date_start = date('m/d/y');
			$objectProCust->date_end = '';
			$objectProCust->public = '1';
			$objectProCust->usage_opportunity = '1';
			$objectProCust->usage_task = '1';
			$objectProCust->usage_bill_time = '0';
			$objectProCust->description = $description;
			$objectProCust->note_private = '';
			$objectProCust->note_public = $description;

			$objectProCust->fk_brand = $brand_id;
			$objectProCust->fk_category = $category_id;
			$objectProCust->fk_subcategory = $sub_category_id;
			$objectProCust->fk_model = $model_id;
			$objectProCust->fk_product = $product_id;
			
			$objectProCust->ac_capacity = $capacity;
			
			$objectProCust->options_fk_call_source = $call_source_id;
			$objectProCust->options_fk_service_type = $service_type_id;
			
			$newCustomerProduct = $objectProCust->addLead($userRow, 1);

			if($newCustomerProduct == 0)
			{
				$status_code = '0';
				$message = 'Something went wrong.';
				$db->rollback();

				$json = array('status_code' => $status_code, 'message' => $message);
			}
			else
			{
				$db->commit();
				$status_code = '1';
				$message = 'Lead added successfully.';

				$json = array('status_code' => $status_code, 'message' => $message, 'lead_id' => "".$newCustomerProduct);
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