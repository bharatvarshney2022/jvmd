<?php
/* 
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
 *	\file       htdocs/projet/card.php
 *	\ingroup    projet
 *	\brief      Project card
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
require_once DOL_DOCUMENT_ROOT.'/projet/class/task.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/project.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formprojet.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/modules/project/modules_project.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/fcm_notify.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';

// Load translation files required by the page
$langs->loadLangs(array('projects', 'companies'));

$id = GETPOST('id', 'int');
$ref = GETPOST('ref', 'alpha');
$action = GETPOST('action', 'aZ09');
$backtopage = GETPOST('backtopage', 'alpha');
$cancel = GETPOST('cancel', 'alpha');
$confirm = GETPOST('confirm', 'aZ09');
$status = GETPOST('status', 'int');
$opp_status = GETPOST('opp_status', 'int');
$opp_percent = price2num(GETPOST('opp_percent', 'alpha'));



if ($id == '' && $ref == '' && ($action != "create" && $action != "add" && $action != "update" && !$_POST["cancel"])) accessforbidden();
//echo $action;
$mine = GETPOST('mode') == 'mine' ? 1 : 0;
//if (! $user->rights->projet->all->lire) $mine=1;	// Special for projects

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('projectcard', 'globalcard'));

$object = new Project($db);
$extrafields = new ExtraFields($db);

// Load object
//include DOL_DOCUMENT_ROOT.'/core/actions_fetchobject.inc.php';  // Can't use generic include because when creating a project, ref is defined and we dont want error if fetch fails from ref.
if ($id > 0 || !empty($ref))
{
	$ret = $object->fetch($id, $ref); // If we create project, ref may be defined into POST but record does not yet exists into database
	if ($ret > 0) {
		$object->fetch_thirdparty();
		if (!empty($conf->global->PROJECT_ALLOW_COMMENT_ON_PROJECT) && method_exists($object, 'fetchComments') && empty($object->comments)) $object->fetchComments();
		$id = $object->id;
	}
}

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

// Security check
$socid = GETPOST('socid', 'int');
//if ($user->socid > 0) $socid = $user->socid;    // For external user, no check is done on company because readability is managed by public status of project and assignement.
$result = restrictedArea($user, 'projet', $object->id, 'projet&project');

// fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

$date_start = dol_mktime(0, 0, 0, GETPOST('projectstartmonth', 'int'), GETPOST('projectstartday', 'int'), GETPOST('projectstartyear', 'int'));
$date_end = dol_mktime(0, 0, 0, GETPOST('projectendmonth', 'int'), GETPOST('projectendday', 'int'), GETPOST('projectendyear', 'int'));


/*
 * Actions
 */

$parameters = array('id'=>$socid, 'objcanvas'=>$objcanvas);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (empty($reshook))
{
	// Cancel
	if ($cancel)
	{
		if (GETPOST("comefromclone") == 1)
		{
			$result = $object->delete($user);
			if ($result > 0)
			{
				header("Location: index.php");
				exit;
			} else {
				dol_syslog($object->error, LOG_DEBUG);
				setEventMessages($langs->trans("CantRemoveProject", $langs->transnoentitiesnoconv("ProjectOverview")), null, 'errors');
			}
		}
		if ($backtopage)
		{
			header("Location: ".$backtopage);
			exit;
		}

		$action = '';
	}

	if ($action == 'add' && $user->rights->projet->creer)
	{
		$error = 0;
		if (!GETPOST('ref'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Ref")), null, 'errors');
			$error++;
		}
		if (!GETPOST('title'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("ProjectLabel")), null, 'errors');
			$error++;
		}

		if (!GETPOST('socid'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Customer")), null, 'errors');
			$error++;
		}

		if (!GETPOST('fk_brand'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Brand")), null, 'errors');
			$error++;
		}

		/*if (!GETPOST('fk_category'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Category")), null, 'errors');
			$error++;
		}

		if (!GETPOST('fk_sub_category'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Sub Category")), null, 'errors');
			$error++;
		}

		if (!GETPOST('fk_model'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Model No")), null, 'errors');
			$error++;
		}

		if (!GETPOST('fk_product'))
		{
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Product")), null, 'errors');
			$error++;
		}*/

		/*if (GETPOST('opp_amount') != '' && !(GETPOST('opp_status') > 0))
		{
			$error++;
			setEventMessages($langs->trans("ErrorOppStatusRequiredIfAmount"), null, 'errors');
		}*/

		// Create with status validated immediatly
		if (!empty($conf->global->PROJECT_CREATE_NO_DRAFT))
		{
			$status = Project::STATUS_VALIDATED;
		}

		if (!$error)
		{
			$error = 0;

			$db->begin();

			$object->ref             = GETPOST('ref', 'alphanohtml');
			$object->title           = GETPOST('title', 'alphanohtml');
			
			$object->socid           = GETPOST('socid', 'int');

			// Address Data
			$object->address = (string) GETPOST("address", 'alpha');
			$object->zip = (string) GETPOST("zipcode", 'alpha');
			$object->town = (string) GETPOST("town", 'alpha');
			$object->country_id = (int) GETPOST("country_id", 'int');
			$object->state_id = (int) GETPOST("state_id", 'int');

			$object->fk_technician      = '0';
			$object->fk_customer_product  = GETPOST('fk_customer_product', 'int');
			$object->fk_brand      = GETPOST('fk_brand', 'int');
			$object->fk_category      = GETPOST('fk_category', 'int');
			$object->fk_sub_category      = GETPOST('fk_sub_category', 'int');
			$object->fk_model      = GETPOST('fk_model', 'int');
			$object->fk_product      = GETPOST('fk_product', 'int');
			

			$object->description     = GETPOST('description', 'restricthtml'); // Do not use 'alpha' here, we want field as it is
			$object->public          = GETPOST('public', 'alphanohtml');
			$object->opp_amount      = price2num(GETPOST('opp_amount', 'alphanohtml'));
			$object->budget_amount   = price2num(GETPOST('budget_amount', 'alphanohtml'));
			$object->date_c = dol_now();
			$object->date_start      = $date_start;
			$object->date_end        = $date_end;
			$object->statut          = $status;
			$object->opp_status      = $opp_status;
			$object->opp_percent     = $opp_percent;
			$object->usage_opportunity    = (GETPOST('usage_opportunity', 'alpha') == 'on' ? 1 : 0);
			$object->usage_task           = (GETPOST('usage_task', 'alpha') == 'on' ? 1 : 0);
			$object->usage_bill_time      = (GETPOST('usage_bill_time', 'alpha') == 'on' ? 1 : 0);
			$object->usage_organize_event = (GETPOST('usage_organize_event', 'alpha') == 'on' ? 1 : 0);

			// Fill array 'array_options' with data from add form
			$ret = $extrafields->setOptionalsFromPost(null, $object);
			if ($ret < 0) $error++;

			$result = $object->create($user);

			/* 
				Assign lead to vendor default by customer pincode
				// added by Ashok
			*/
				
				
			$ret = $object->zip;
				
			$sqlVendors = "SELECT u.rowid as rowid, u.firstname  from ".MAIN_DB_PREFIX."user as u, ".MAIN_DB_PREFIX."usergroup_user as u1, ".MAIN_DB_PREFIX."user_extrafields as uex where u.rowid = u1.fk_user and u.rowid = uex.fk_object and u1.fk_usergroup = '4' and u.statut = 1 and FIND_IN_SET('".$ret."',uex.apply_zipcode) > 0 ";
			$resqlVendor = $db->query($sqlVendors);
			$numvendor = $db->num_rows($resqlVendor);
			$objvendor = $resqlVendor->fetch_all();
			if($numvendor > 0){
				foreach ($objvendor as $rsvendor) {
					$vendorid = $rsvendor[0];
					$typeid = '160';
					$addvendor = $object->add_contact($vendorid, $typeid, 'internal');
				}
			}
				//print_r($objvendor);
				//echo $selected_input_value = $societetmp->fk_pincode;
				//exit;
			/* End */	
			if (!$error && $result > 0)
			{
				// Add myself as project leader
				$typeofcontact = 'PROJECTLEADER';	// TODO If use rename this code in dictionary, the add_contact will generate an error.
				$result = $object->add_contact($user->id, $typeofcontact, 'internal');
				if ($result < 0)
				{
					$langs->load("errors");
					setEventMessages($object->error, $object->errors, 'errors');
					$error++;
				}
			} else {
				$langs->load("errors");
				setEventMessages($object->error, $object->errors, 'errors');
				$error++;
			}
			if (!$error && !empty($object->id) > 0)
			{
				// Category association
				$categories = GETPOST('categories', 'array');
				$result = $object->setCategories($categories);
				if ($result < 0) {
					$langs->load("errors");
					setEventMessages($object->error, $object->errors, 'errors');
					$error++;
				}
			}

			if (!$error)
			{
				$db->commit();

				if (!empty($backtopage))
				{
					$backtopage = preg_replace('/--IDFORBACKTOPAGE--/', $object->id, $backtopage); // New method to autoselect project after a New on another form object creation
					$backtopage = $backtopage.'&projectid='.$object->id; // Old method
					header("Location: ".$backtopage);
					exit;
				} else {
					header("Location:card.php?id=".$object->id);
					exit;
				}
			} else {
				$db->rollback();

				$action = 'create';
			}
		} else {
			$action = 'create';
		}
	}

	if ($action == 'update' && !$_POST["cancel"] && $user->rights->projet->creer)
	{
		$error = 0;

		if (empty($ref))
		{
			$error++;
			//$_GET["id"]=$_POST["id"]; // We return on the project card
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Ref")), null, 'errors');
		}
		if (empty($_POST["title"]))
		{
			$error++;
			//$_GET["id"]=$_POST["id"]; // We return on the project card
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("ProjectLabel")), null, 'errors');
		}

		$db->begin();

		if (!$error)
		{
			$object->oldcopy = clone $object;

			$old_start_date = $object->date_start;

			$object->ref          = GETPOST('ref', 'alpha');
			$object->title        = GETPOST('title', 'alphanohtml'); // Do not use 'alpha' here, we want field as it is
			//$object->statut       = GETPOST('status', 'int');
			if($user_group_id == 4){
				$object->statut       = $object->statut;
			}else{
				$object->statut       = GETPOST('status', 'int');
			}
			$object->socid        = GETPOST('socid', 'int');

			// Address Data
			$object->address = (string) GETPOST("address", 'alpha');
			$object->zip = (string) GETPOST("zipcode", 'alpha');
			$object->town = (string) GETPOST("town", 'alpha');
			$object->country_id = (int) GETPOST("country_id", 'int');
			$object->state_id = (int) GETPOST("state_id", 'int');

			$object->fk_technician        = GETPOST('fk_technician', 'int');
			/*if($object->fk_technician > 0){
				$object->tech_assigndatetime   = dol_now();
			}*/
			$object->tech_assigndatetime   =  dol_mktime(GETPOST("tech_assigndatetimehour"), GETPOST("tech_assigndatetimemin"), date('s'), GETPOST("tech_assigndatetimemonth"), GETPOST("tech_assigndatetimeday"), GETPOST("tech_assigndatetimeyear"));
			
			 $object->response_reschedule   = dol_mktime(GETPOST("response_reschedulehour"), GETPOST("response_reschedulemin"), date('s'), GETPOST("response_reschedulemonth"), GETPOST("response_rescheduleday"), GETPOST("response_rescheduleyear"))
			;

			$object->response_reschedule   = dol_mktime(GETPOST("response_reschedulehour"), GETPOST("response_reschedulemin"), date('s'), GETPOST("response_reschedulemonth"), GETPOST("response_rescheduleday"), GETPOST("response_rescheduleyear"))
			;

			$object->fk_customer_product  = GETPOST('fk_customer_product', 'int');
			$object->fk_brand      = GETPOST('fk_brand', 'int');
			$object->fk_category      = GETPOST('fk_category', 'int');
			$object->fk_sub_category      = GETPOST('fk_sub_category', 'int');
			$object->fk_model      = GETPOST('fk_model', 'int');
			$object->fk_product      = GETPOST('fk_product', 'int');

			$object->description  = GETPOST('description', 'restricthtml'); // Do not use 'alpha' here, we want field as it is
			$object->public       = GETPOST('public', 'alpha');
			$object->date_start   = (!GETPOST('projectstart')) ? '' : $date_start;
			$object->date_end     = (!GETPOST('projectend')) ? '' : $date_end;
			if (GETPOSTISSET('opp_amount'))    $object->opp_amount   = price2num(GETPOST('opp_amount', 'alpha'));
			if (GETPOSTISSET('budget_amount')) $object->budget_amount = price2num(GETPOST('budget_amount', 'alpha'));
			if (GETPOSTISSET('opp_status'))    $object->opp_status   = $opp_status;
			if (GETPOSTISSET('opp_percent'))   $object->opp_percent  = $opp_percent;
			$object->usage_opportunity    = (GETPOST('usage_opportunity', 'alpha') == 'on' ? 1 : 0);
			$object->usage_task           = (GETPOST('usage_task', 'alpha') == 'on' ? 1 : 0);
			$object->usage_bill_time      = (GETPOST('usage_bill_time', 'alpha') == 'on' ? 1 : 0);
			$object->usage_organize_event = (GETPOST('usage_organize_event', 'alpha') == 'on' ? 1 : 0);

			
			
			// Fill array 'array_options' with data from add form
			
			$ret = $extrafields->setOptionalsFromPost(null, $object);
			if ($ret < 0) $error++;
			
		}

		/*if ($object->opp_amount && ($object->opp_status <= 0))
		{
		   	$error++;
			setEventMessages($langs->trans("ErrorOppStatusRequiredIfAmount"), null, 'errors');
		}*/

		if (!$error)
		{
			$result = $object->update($user);
			
			
			if ($result < 0)
			{
				$error++;
				if ($result == -4) setEventMessages($langs->trans("ErrorRefAlreadyExists"), null, 'errors');
				else setEventMessages($object->error, $object->errors, 'errors');
			} else {
				$objectSoc = new Societe($db);
				$contactData = $objectSoc->societe_contact($object->socid);

				$contactRow = array_keys($contactData);

				$contact_id = 0;
				if($contactRow)
				{
					$contact_id = $contactRow[0];
				}


				// Create Notification
				$sqlNotify = "INSERT INTO ".MAIN_DB_PREFIX."fcm_notify_def (datec, fk_action, fk_soc, fk_contact, fk_user, fk_projet)";
				$sqlNotify .= " VALUES ('".$db->idate(dol_now())."', 110, ".$object->socid.", ".$contact_id.", '".$user->id."', '".$object->id."')";
				$resqlVendor = $db->query($sqlNotify);

				$sqlNotify = "INSERT INTO ".MAIN_DB_PREFIX."fcm_notify_def (datec, fk_action, fk_soc, fk_contact, fk_user, fk_projet)";
				$sqlNotify .= " VALUES ('".$db->idate(dol_now())."', 111, ".$object->socid.", ".$contact_id.", '".$user->id."', '".$object->id."')";
				$resqlVendor = $db->query($sqlNotify);

				$objectNot = new FCMNotify($db);

				$notifyData = $objectNot->getNotificationsArray('', $object->socid, $objectNot, 0);
				
				if($notifyData)
				{
					foreach($notifyData as $rowid => $notifyRow)
					{
						$objectNot->send($notifyRow['code'], $object);	
					}
				}

				// Update Vendor
				// Remove old entry

				$ret = $object->zip;
				
				$sqlVendors = "SELECT u.rowid as rowid, u.firstname  from ".MAIN_DB_PREFIX."user as u, ".MAIN_DB_PREFIX."usergroup_user as u1, ".MAIN_DB_PREFIX."user_extrafields as uex where u.rowid = u1.fk_user and u.rowid = uex.fk_object and u1.fk_usergroup = '4' and u.statut = 1 and FIND_IN_SET('".$ret."',uex.apply_zipcode) > 0 ";
				$resqlVendor = $db->query($sqlVendors);
				$numvendor = $db->num_rows($resqlVendor);
				$objvendor = $resqlVendor->fetch_all();
				if($numvendor > 0){
					foreach ($objvendor as $rsvendor) {
						$vendorid = $rsvendor[0];
						$sqlCustpincode1 = "DELETE from ".MAIN_DB_PREFIX."element_contact WHERE fk_socpeople = '".$vendorid."' ";
							$db->query($sqlCustpincode1);
							
						$typeid = '160';
						$addvendor = $object->add_contact($vendorid, $typeid, 'internal');
					}
				}

				if($user_group_id == 17){
					$vendorid = $user->id;
					$typeid = 160;
					$addvendor = $object->add_contact($vendorid, $typeid, 'internal');
				}
				if($object->statut =='3' && $user_group_id == 17){
					$cloneURL = DOL_URL_ROOT.'/projet/card.php?id='.$object->id.'&action=confirm_clone&confirm=yes&token='.$token.'&socid='.$object->socid;
					header('location: '.$cloneURL);
					exit;
					//$result = $object->oldcopy->create($user);
				}
				// Category association
				$categories = GETPOST('categories', 'array');
				$result1 = $object->setCategories($categories);
				if ($result1 < 0)
				{
					$error++;
					setEventMessages($object->error, $object->errors, 'errors');
					$action = 'edit';
				}

				$action = 'view';
				/*$backurl = DOL_URL_ROOT.'/projet/card.php?id='.$id;
				header("Location: ".$backurl);
				exit;*/
			}
		}

		if (!$error)
		{
			if (GETPOST("reportdate") && ($object->date_start != $old_start_date))
			{
				$result = $object->shiftTaskDate($old_start_date);
				if ($result < 0)
				{
					$error++;
					setEventMessages($langs->trans("ErrorShiftTaskDate").':'.$object->error, $object->errors, 'errors');
					$action = 'edit';
				}
			}
		}

		// Check if we must change status
		if (GETPOST('closeproject'))
		{
			$resclose = $object->setClose($user);
			if ($resclose < 0)
			{
				$error++;
				setEventMessages($langs->trans("FailedToCloseProject").':'.$object->error, $object->errors, 'errors');
			}
			$action = 'edit';
		}


		if ($error)
		{
			$db->rollback();
			$action = 'edit';
		} else {
			$db->commit();

			if (GETPOST('socid', 'int') > 0) $object->fetch_thirdparty(GETPOST('socid', 'int'));
			else unset($object->thirdparty);
		}
	}


	if ($action == 'close_form_update' && !$_POST["cancel"] && $user->rights->projet->creer)
	{
		$error = 0;
		$ticket_otp = GETPOST('ticket_otp');
		if (empty($ref))
		{
			$error++;
			//$_GET["id"]=$_POST["id"]; // We return on the project card
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("Ref")), null, 'errors');
		}

		if (empty($ticket_otp))
		{
			$error++;
			//$_GET["id"]=$_POST["id"]; // We return on the project card
			setEventMessages($langs->trans("ErrorFieldRequired", $langs->transnoentities("OTP")), null, 'errors');
		}
		
		$db->begin();

		if (!$error)
		{
			$object->ref          = GETPOST('ref', 'alpha');
			$object->title        = GETPOST('title', 'alphanohtml'); // Do not use 'alpha' here, 
			$object->problem     = GETPOST('problem', 'alphanohtml');
			$object->solution     = GETPOST('solution', 'alphanohtml');
			$object->ticket_otp     = $ticket_otp;
			$object->customer_response     = GETPOST('customer_response', 'alphanohtml');
			$object->customer_sign     = GETPOST('customer_sign', 'restricthtml');
			$object->customer_remark     = GETPOST('customer_remark', 'alphanohtml');
			
			$result1 = $object->close_form_update($user);


			if ($result1 < 0)
			{
				$error++;
				if ($result == -4) setEventMessages($langs->trans("ErrorRefAlreadyExists"), null, 'errors');
				else setEventMessages($object->error, $object->errors, 'errors');
			} else {
				$resclose = $object->setClose($user);
				if ($resclose < 0)
				{
					$error++;
					setEventMessages($langs->trans("FailedToCloseProject").':'.$object->error, $object->errors, 'errors');
				}
				/*$backurl = DOL_URL_ROOT.'/projet/card.php?id='.$id;
				header("Location: ".$backurl);
				exit;*/

				// notifications
				// Create Notification
				$objectSoc = new Societe($db);
				$contactData = $objectSoc->societe_contact($object->socid);

				$contactRow = array_keys($contactData);

				$contact_id = 0;
				if($contactRow)
				{
					$contact_id = $contactRow[0];
				}
				
				$sqlNotify = "INSERT INTO ".MAIN_DB_PREFIX."fcm_notify_def (datec, fk_action, fk_soc, fk_contact, fk_user, fk_projet)";
				$sqlNotify .= " VALUES ('".$db->idate(dol_now())."', 112, ".$object->socid.", ".$contact_id.", '".$user->id."', '".$object->id."')";
				$resqlVendor = $db->query($sqlNotify);

				$objectNot = new FCMNotify($db);

				$notifyData = $objectNot->getNotificationsArray('', $object->socid, $objectNot, 0);

				if($notifyData)
				{
					foreach($notifyData as $rowid => $notifyRow)
					{
						$objectNot->send($notifyRow['code'], $object);	
					}
				}
				
				if ($error)
				{
					$db->rollback();
					//$action = 'view';
					$backurl = DOL_URL_ROOT.'/projet/card.php?id='.$id;
					header("Location: ".$backurl);
					exit;
				} else {
					$db->commit();
					//$action = 'view';
					$backurl = DOL_URL_ROOT.'/projet/card.php?id='.$id;
					header("Location: ".$backurl);
					exit;
					if (GETPOST('socid', 'int') > 0) $object->fetch_thirdparty(GETPOST('socid', 'int'));
					else unset($object->thirdparty);

				}
			}
		}

		
	}

	// Build doc
	if ($action == 'builddoc' && $user->rights->projet->creer)
	{
		// Save last template used to generate document
		if (GETPOST('model')) $object->setDocModel($user, GETPOST('model', 'alpha'));

		$outputlangs = $langs;
		if (GETPOST('lang_id', 'aZ09'))
		{
			$outputlangs = new Translate("", $conf);
			$outputlangs->setDefaultLang(GETPOST('lang_id', 'aZ09'));
		}
		$result = $object->generateDocument($object->model_pdf, $outputlangs);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
			$action = '';
		}
	}

	// Delete file in doc form
	if ($action == 'remove_file' && $user->rights->projet->creer)
	{
		if ($object->id > 0)
		{
			require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';

			$langs->load("other");
			$upload_dir = $conf->projet->dir_output;
			$file = $upload_dir.'/'.GETPOST('file');
			$ret = dol_delete_file($file, 0, 0, 0, $object);
			if ($ret)
				setEventMessages($langs->trans("FileWasRemoved", GETPOST('file')), null, 'mesgs');
			else setEventMessages($langs->trans("ErrorFailToDeleteFile", GETPOST('file')), null, 'errors');
			$action = '';
		}
	}


	if ($action == 'confirm_validate' && $confirm == 'yes')
	{
		$result = $object->setValid($user);

		$objectSoc = new Societe($db);
		$contactData = $objectSoc->societe_contact($object->socid);

		$contactRow = array_keys($contactData);

		$contact_id = 0;
		if($contactRow)
		{
			$contact_id = $contactRow[0];
		}


		// Create Notification
		$sqlNotify = "INSERT INTO ".MAIN_DB_PREFIX."fcm_notify_def (datec, fk_action, fk_soc, fk_contact, fk_user, fk_projet)";
		$sqlNotify .= " VALUES ('".$db->idate(dol_now())."', 109, ".$object->socid.", ".$contact_id.", '".$user->id."', '".$object->id."')";
		$resqlVendor = $db->query($sqlNotify);

		$objectNot = new FCMNotify($db);

		$notifyData = $objectNot->getNotificationsArray('', $object->socid, $objectNot, 0);

		if($notifyData)
		{
			foreach($notifyData as $rowid => $notifyRow)
			{
				$objectNot->send($notifyRow['code'], $object);	
			}
		}

		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	if ($action == 'confirm_invalidate' && $confirm == 'yes')
	{
		$result = $object->setInValid($user);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	

	if ($action == 'confirm_close' && $confirm == 'yes')
	{
		$result = $object->setClose($user);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	if ($action == 'confirm_reopen' && $confirm == 'yes')
	{
		$result = $object->setValid($user);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	if ($action == 'confirm_reject' && $confirm == 'yes')
	{
		$result = $object->setReject($user);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	if ($action == 'confirm_delete' && GETPOST("confirm") == "yes" && $user->rights->projet->supprimer)
	{
		$object->fetch($id);
		$result = $object->delete($user);
		if ($result > 0)
		{
			setEventMessages($langs->trans("RecordDeleted"), null, 'mesgs');
			header("Location: list.php?restore_lastsearch_values=1");
			exit;
		} else {
			dol_syslog($object->error, LOG_DEBUG);
			setEventMessages($object->error, $object->errors, 'errors');
		}
	}

	if ($action == 'confirm_clone' && $user->rights->projet->creer && $confirm == 'yes')
	{
		$clone_contacts = GETPOST('clone_contacts') ? 1 : 0;
		$clone_tasks = GETPOST('clone_tasks') ? 1 : 0;
		$clone_project_files = GETPOST('clone_project_files') ? 1 : 0;
		$clone_task_files = GETPOST('clone_task_files') ? 1 : 0;
		$clone_notes = GETPOST('clone_notes') ? 1 : 0;
		$move_date = GETPOST('move_date') ? 1 : 0;
		$clone_thirdparty = GETPOST('socid', 'int') ?GETPOST('socid', 'int') : 0;

		$result = $object->createFromClone($user, $object->id, $clone_contacts, $clone_tasks, $clone_project_files, $clone_task_files, $clone_notes, $move_date, 0, $clone_thirdparty);
		if ($result <= 0)
		{
			setEventMessages($object->error, $object->errors, 'errors');
		} else {
			// Load new object
			$newobject = new Project($db);
			$newobject->fetch($result);
			$newobject->fetch_optionals();
			$newobject->fetch_thirdparty(); // Load new object
			$object = $newobject;
			$action = 'edit';
			$comefromclone = true;
		}
	}

	// Actions to send emails
	$triggersendname = 'PROJECT_SENTBYMAIL';
	$paramname = 'id';
	$autocopy = 'MAIN_MAIL_AUTOCOPY_PROJECT_TO'; // used to know the automatic BCC to add
	$trackid = 'proj'.$object->id;
	include DOL_DOCUMENT_ROOT.'/core/actions_sendmails.inc.php';
}


/*
 *	View
 */

$form = new Form($db);
$formcompany = new FormCompany($db);

$formfile = new FormFile($db);
$formproject = new FormProjets($db);
$userstatic = new User($db);

$title = $langs->trans("Project").' - '.$object->ref.($object->thirdparty->name ? ' - '.$object->thirdparty->name : '').($object->title ? ' - '.$object->title : '');
if (!empty($conf->global->MAIN_HTML_TITLE) && preg_match('/projectnameonly/', $conf->global->MAIN_HTML_TITLE)) $title = $object->ref.($object->thirdparty->name ? ' - '.$object->thirdparty->name : '').($object->title ? ' - '.$object->title : '');
$help_url = "EN:Module_Projects|FR:Module_Projets|ES:M&oacute;dulo_Proyectos";

llxHeaderLayout("", $title, $title, $help_url);

$titleboth = $langs->trans("Support Tickets");
$titlenew = $langs->trans("New Support Ticket"); // Leads and opportunities by default
if ($conf->global->PROJECT_USE_OPPORTUNITIES == 0) {
	$titleboth = $langs->trans("Support Tickets");
	$titlenew = $langs->trans("New Support Ticket");
}
if ($conf->global->PROJECT_USE_OPPORTUNITIES == 2) {	// 2 = leads only
	$titleboth = $langs->trans("Support Tickets");
	$titlenew = $langs->trans("New Support Ticket");
}

if ($action == 'create' && $user->rights->projet->creer)
{
	/*
     * Create
     */

	$thirdparty = new Societe($db);
	if ($socid > 0) $thirdparty->fetch($socid);

	$object->state_id = GETPOST("state_id");
	// We set country_id, country_code and label for the selected country
	$object->country_id = $_POST["country_id"] ?GETPOST("country_id") : (empty($thirdparty->country_id) ? $mysoc->country_id : $thirdparty->country_id);
	if ($object->country_id)
	{
		$tmparray = getCountry($object->country_id, 'all');
		$object->country_code = $tmparray['code'];
		$object->country      = $tmparray['label'];
	}


	print '<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<!--begin::Card-->
									<div class="card card-custom gutter-b">
										'.
											load_fiche_titre_layout($titlenew, '', '').

										'<div class="card-body">';

										if ($conf->use_javascript_ajax)
										{
											print "\n".'<script type="text/javascript" language="javascript">'."\n";
											print 'jQuery(document).ready(function () {
														jQuery("#selectcountry_id").change(function() {
															document.formsoc.action.value="create";
															document.formsoc.submit();
														});

														
													})'."\n";
											print '</script>'."\n";
										}

										print '<form action="'.$_SERVER["PHP_SELF"].'" name="formsoc" method="POST">';
										print '<input type="hidden" name="token" value="'.newToken().'">';
										print '<input type="hidden" name="action" value="add">';
										print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
										print '<input type="hidden" name="fk_customer_product" id="fk_customer_product" value="">';

									print dol_get_fiche_head_layout();

									print '<table class="table table-bordered">';

									$defaultref = '';
									$modele = empty($conf->global->PROJECT_ADDON) ? 'mod_project_simple' : $conf->global->PROJECT_ADDON;

									// Search template files
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
										$result = dol_include_once($reldir."core/modules/project/".$modele.'.php');
										$modProject = new $classname;

										$defaultref = $modProject->getNextValue($thirdparty, $object);
									}

									if (is_numeric($defaultref) && $defaultref <= 0) $defaultref = '';

									// Ref
									$suggestedref = ($_POST["ref"] ? $_POST["ref"] : $defaultref);
									print '<tr><td class=""><span class="fieldrequired">'.$langs->trans("Ref").'</span></td><td><input class="form-control" readonly size="20" type="text" name="ref" value="'.dol_escape_htmltag($suggestedref).'">';
									print ' '.$form->textwithpicto('', $langs->trans("YouCanCompleteRef", $suggestedref));
									print '</td>';

									// Label
									print '<td><span class="fieldrequired">'.$langs->trans("Label").'</span></td><td><input class="form-control" type="text" name="title" value="'.dol_escape_htmltag(GETPOST("title", 'alphanohtml')).'" autofocus></td></tr>';

									// Usage (opp, task, bill time, ...)
									print '<tr style="display:none;"><td class="tdtop">';
									print $langs->trans("Usage");
									print '</td>';
									print '<td>';
									if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES)) {
										print '<input type="checkbox" id="usage_opportunity" name="usage_opportunity"'.(GETPOSTISSET('usage_opportunity') ? (GETPOST('usage_opportunity', 'alpha') != '' ? ' checked="checked"' : '') : ' checked="checked"').'"> ';
										$htmltext = $langs->trans("ProjectFollowOpportunity");
										print '<label for="usage_opportunity">'.$form->textwithpicto($langs->trans("ProjectFollowOpportunity"), $htmltext).'</label>';
										print '<script>';
										print '$( document ).ready(function() {
												jQuery("#usage_opportunity").change(function() {
													if (jQuery("#usage_opportunity").prop("checked")) {
														console.log("Show opportunities fields");
														jQuery(".classuseopportunity").show();
													} else {
														console.log("Hide opportunities fields "+jQuery("#usage_opportunity").prop("checked"));
														jQuery(".classuseopportunity").hide();
													}
												});


												

											});';
										print '</script>';
										print '<br>';
									}
									if (empty($conf->global->PROJECT_HIDE_TASKS))
									{
										print '<input type="checkbox" id="usage_task" name="usage_task"'.(GETPOSTISSET('usage_task') ? (GETPOST('usage_task', 'alpha') != '' ? ' checked="checked"' : '') : ' checked="checked"').'"> ';
										$htmltext = $langs->trans("ProjectFollowTasks");
										print '<label for="usage_task">'.$form->textwithpicto($langs->trans("ProjectFollowTasks"), $htmltext).'</label>';
										print '<br>';
									}
									if (empty($conf->global->PROJECT_HIDE_TASKS) && !empty($conf->global->PROJECT_BILL_TIME_SPENT))
									{
										print '<input type="checkbox" id="usage_bill_time" name="usage_bill_time"'.(GETPOST('usage_bill_time', 'alpha') != '' ? ' checked="checked"' : '').'"> ';
										$htmltext = $langs->trans("ProjectBillTimeDescription");
										print '<label for="usage_bill_time">'.$form->textwithpicto($langs->trans("BillTime"), $htmltext).'</label>';
										print '<br>';
									}
									/*
									print '<input type="checkbox" name="usage_organize_event"'.(GETPOST('usage_organize_event', 'alpha')!=''?' checked="checked"':'').'"> ';
									$htmltext = $langs->trans("OrganizeEvent");
									print $form->textwithpicto($langs->trans("OrganizeEvent"), $htmltext);*/
									print '</td>';
									print '</tr>';

									print '<script>';
										print '$( document ).ready(function() {

												// get customer data
												$("#copyaddressfromsoc").click(function() {
													var socid = jQuery("#socid").val();

													$.ajax({
														  dataType: "html",
														  url: "customer_info.php",
														  data: {socid: socid},
														  dataType: "json",
														  success: function(response) {
														  	//alert(html);
															$("#address").val(response.address);
															$("#zipcode").val(response.zip);
															$("#town").val(response.town);
															$("select[name=\"state_id\"]").val(response.state_id).trigger("change");
															$("select[name=\"country_id\"]").val(response.country_id).trigger("change");
														  }
													});
					                            });

												

												jQuery("#socid").change(function() {
													var socid = $(this).val();
								                	$.ajax({
														  dataType: "html",
														  url: "customerproductBrand_data.php",
														  data: {socid: socid},
														  success: function(html) {
														  	//alert(html);
															$("#fk_brand").html(html);
														  }
													});

													
												});


												jQuery("#fk_brand").change(function() {
													var brandid = $(this).val();
													var socid = $("#socid").val();
								                	$.ajax({
														  dataType: "html",
														  url: "customerproductCategory_data.php",
														  data: {socid: socid,brandid: brandid},
														  success: function(html) {
														  	//alert(html);
															$("#fk_category").html(html);
														  }
													});
												});

												jQuery("#fk_category").change(function() {
													var catid = $(this).val();
													var brandid = $("#fk_brand").val();
													var socid = $("#socid").val();
								                	$.ajax({
														  dataType: "html",
														  url: "customerproductSubCategory_data.php",
														  data: {socid: socid,brandid: brandid ,catid: catid},
														  success: function(html) {
														  	//alert(html);
															$("#fk_sub_category").html(html);
														  }
													});
												});

												jQuery("#fk_sub_category").change(function() {
													var scatid = $(this).val();
													var catid = $("#fk_category").val();
													var brandid = $("#fk_brand").val();
													var socid = $("#socid").val();
								                	$.ajax({
														  dataType: "html",
														  url: "customerproductmodeldata.php",
														  data: {socid: socid,brandid: brandid ,catid: catid,scatid: scatid},
														  success: function(html) {
														  	//alert(html);
															$("#fk_model").html(html);
														  }
													});
												});

												jQuery("#fk_model").change(function() {
													var model = $(this).val();
													var scatid = $("#fk_sub_category").val();
													var catid = $("#fk_category").val();
													var brandid = $("#fk_brand").val();
													var socid = $("#socid").val();
								                	$.ajax({
														  dataType: "json",
														  url: "productmodeldata.php",
														  data: {socid: socid,brandid: brandid ,catid: catid,scatid: scatid,model: model},
														  success: function(data) {
														  	$("#fk_product").html(data.prdstr);
														  	$("#ac_capacity").val(data.ac_capacity);
														  	$("#fk_customer_product").val(data.id);
														  }
													});
												});

											});

											';


										print '</script>';
									// Thirdparty
									if ($conf->societe->enabled)
									{
										print '<tr><td class="fieldrequired">';
										print (empty($conf->global->PROJECT_THIRDPARTY_REQUIRED) ? '' : '<span class="fieldrequired">');
										print $langs->trans("ThirdParty");
										print (empty($conf->global->PROJECT_THIRDPARTY_REQUIRED) ? '' : '</span>');
										print '</td><td class="maxwidthonsmartphone">';
										$filteronlist = '';
										if (!empty($conf->global->PROJECT_FILTER_FOR_THIRDPARTY_LIST)) $filteronlist = $conf->global->PROJECT_FILTER_FOR_THIRDPARTY_LIST;
									   	$text = img_picto('', 'company').$form->select_company(GETPOST('socid', 'int'), 'socid', $filteronlist, 'SelectThirdParty', 1, 0, array(), 0, 'minwidth300 widthcentpercentminusxx');
										if (empty($conf->global->PROJECT_CAN_ALWAYS_LINK_TO_ALL_SUPPLIERS) && empty($conf->dol_use_jmobile))
										{
											$texthelp = $langs->trans("IfNeedToUseOtherObjectKeepEmpty");
											print $form->textwithtooltip($text.' '.img_help(), $texthelp, 1);
										} else print $text;
										if($user_group_id != 4){
											if (!GETPOSTISSET('backtopage')) print ' <a href="'.DOL_URL_ROOT.'/societe/card.php?action=create&backtopage='.urlencode($_SERVER["PHP_SELF"].'?action=create').'"><span class="fa fa-plus-circle valignmiddle paddingleft" title="'.$langs->trans("AddThirdParty").'"></span></a>';
										}
										print '</td>';
									}

									// Date start
									print '<td>'.$langs->trans("DateStart").'</td><td>';
									print $form->selectDate(($date_start ? $date_start : ''), 'projectstart', 0, 0, 0, '', 1, 0);
									print '</td></tr>';
									// Status
									if ($status != '')
									{
										print '<tr><td>'.$langs->trans("Status").'</td><td>';
										print '<input type="hidden" name="status" value="'.$status.'">';
										print $object->LibStatut($status, 4);
										print '</td></tr>';
									}

									// Address
									if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->address)) == 0) $object->address = $thirdparty->address; // Predefined with third party
									print '<tr><td><label for="address">'.$langs->trans("Address").'</label></td>';
									print '<td colspan="'.$colspan.'"><textarea class="form-control" name="address" id="address" rows="'.ROWS_2.'">'.(GETPOST("address", 'alpha') ?GETPOST("address", 'alpha') : $object->address).'</textarea></td>';

									if ($conf->use_javascript_ajax)
									{
										$rowspan = 0;
										if (empty($conf->global->SOCIETE_DISABLE_STATE)) $rowspan++;

										print '<td class="" rowspan="'.$rowspan.'">';
										print '<a href="#" id="copyaddressfromsoc">'.$langs->trans('CopyAddressFromSoc').'</a>';
										print '</td>';
									}
									print '</tr>';

									// Zip / Town
									if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->zip)) == 0) $object->zip = $thirdparty->zip; // Predefined with third party
									if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->town)) == 0) $object->town = $thirdparty->town; // Predefined with third party
									print '<tr><td><label for="zipcode">'.$langs->trans("Zip").'</label></td><td  class="">';
									print $formcompany->select_ziptown((GETPOST("zipcode", 'alpha') ? GETPOST("zipcode", 'alpha') : $object->zip), 'zipcode', array('town', 'selectcountry_id', 'state_id'), 6).'&nbsp;';
									print '</td><td><label for="town">'.$langs->trans("Town").'</label></td><td  class="">';
									print $formcompany->select_ziptown((GETPOST("town", 'alpha') ? GETPOST("town", 'alpha') : $object->town), 'town', array('zipcode', 'selectcountry_id', 'state_id'));
									print '</td></tr>';

									// Country
									print '<tr><td><label for="selectcountry_id">'.$langs->trans("Country").'</label></td><td class="">';
									print img_picto('', 'globe-americas', 'class=""');
									print $form->select_country((GETPOST("country_id", 'alpha') ? GETPOST("country_id", 'alpha') : $object->country_id), 'country_id');
									/*if ($user->admin) print info_admin($langs->trans("YouCanChangeValuesForThisListFromDictionarySetup"), 1);*/
									print '</td>';
									// State
									if (empty($conf->global->SOCIETE_DISABLE_STATE))
									{
										if (!empty($conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT) && ($conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT == 1 || $conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT == 2))
										{
											print '<td><label for="state_id">'.$langs->trans('Region-State').'</label></td><td class="">';
										} else {
											print '<td><label for="state_id">'.$langs->trans('State').'</label></td><td class="">';
										}

										if ($object->country_id)
										{
											print $formcompany->select_state(GETPOST("state_id", 'alpha') ? GETPOST("state_id", 'alpha') : $object->state_id, $object->country_code, 'state_id');
										} else {
											print $countrynotdefined;
										}
										print '</td>';
									}
									print '</tr>';

									// Visibility
									print '<tr style="display:none;"><td>'.$langs->trans("Visibility").'</td><td class="maxwidthonsmartphone">';
									$array = array();
									if (empty($conf->global->PROJECT_DISABLE_PRIVATE_PROJECT)) $array[0] = $langs->trans("PrivateProject");
									if (empty($conf->global->PROJECT_DISABLE_PUBLIC_PROJECT)) $array[1] = $langs->trans("SharedProject");
									print $form->selectarray('public', $array, GETPOST('public') ?GETPOST('public') : $object->public, 0, 0, 0, '', 0, 0, 0, '', '', 1);
									print '</td></tr>';

									

									// Date end
									print '<tr style="display:none;"><td>'.$langs->trans("DateEnd").'</td><td>';
									print $form->selectDate(($date_end ? $date_end : -1), 'projectend', 0, 0, 0, '', 1, 0);
									print '</td></tr>';

									if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
									{
										// Opportunity status
										print '<tr style="display:none;" class="classuseopportunity"><td>'.$langs->trans("OpportunityStatus").'</td>';
										print '<td class="maxwidthonsmartphone">';
										print $formproject->selectOpportunityStatus('opp_status', GETPOST('opp_status') ?GETPOST('opp_status') : $object->opp_status, 1, 0, 0, 0, '', 0, 1);
										print '</tr>';

										// Opportunity probability
										print '<tr style="display:none;" class="classuseopportunity"><td>'.$langs->trans("OpportunityProbability").'</td>';
										print '<td><input size="5" type="text" id="opp_percent" name="opp_percent" value="'.dol_escape_htmltag(GETPOSTISSET('opp_percent') ? GETPOST('opp_percent') : '').'"><span class="hideonsmartphone"> %</span>';
										print '<input type="hidden" name="opp_percent_not_set" id="opp_percent_not_set" value="'.dol_escape_htmltag(GETPOSTISSET('opp_percent') ? '0' : '1').'">';
										print '</td>';
										print '</tr>';

										// Opportunity amount
										print '<tr style="display:none;" class="classuseopportunity"><td>'.$langs->trans("OpportunityAmount").'</td>';
										print '<td><input size="5" type="text" name="opp_amount" value="'.dol_escape_htmltag(GETPOSTISSET('opp_amount') ? GETPOST('opp_amount') : '').'"></td>';
										print '</tr>';
									}

									// Budget
									print '<tr style="display:none;"><td>'.$langs->trans("Budget").'</td>';
									print '<td><input size="5" type="text" name="budget_amount" value="'.dol_escape_htmltag(GETPOSTISSET('budget_amount') ? GETPOST('budget_amount') : '').'"></td>';
									print '</tr>';

									// Description
									print '<tr><td class="tdtop">'.$langs->trans("Description").'</td>';
									print '<td colspan="3">';
									$doleditor = new DolEditor('description', GETPOST("description", 'restricthtml'), '', 90, 'dolibarr_notes', '', false, true, $conf->global->FCKEDITOR_ENABLE_SOCIETE, ROWS_3, '90%');
									$doleditor->Create();
									print '</td></tr>';

									require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
									$prdobject = new Product($db);
									
									// Brand
									print '<tr><td class="fieldrequired">'.$langs->trans("Brand").'</td><td>';
									print '<select class="form-control" id="fk_brand" name="fk_brand">';
									if(GETPOST('socid', 'int')){
										print $prdobject->getCustomerProductBrand(GETPOST('socid', 'int'));
									}else{
										print '<option value="0">Select Brand</option>';
									}
									print '</select>';
									print '</td>';
									
									// Product Category

									print '<td >'.$langs->trans("Category").'</td><td>';
									print '<select class="form-control" id="fk_category" name="fk_category">';
									print '<option value="0">Select Category</option>';
									print '</select>';
									print '</td></tr>';

									// Product sub Category
									print '<tr><td >'.$langs->trans("Sub Category").'</td><td>';
									print '<select class="form-control" id="fk_sub_category" name="fk_sub_category">';
									print '<option value="0">Select Sub Category</option>';
									print '</select>';
									print '</td>';
									// Model
									print '<td>'.$langs->trans("Model No.").'</td><td>';
									print '<select class="form-control" id="fk_model" name="fk_model">';
									print '<option value="0">Select Model</option>';
									print '</select>';
									print '</td></tr>';

									// Label
									print '<tr><td>'.$langs->trans("Product Name").'</td><td>';
									print '<select class="form-control" id="fk_product" name="fk_product">';
									print '<option value="0">Select Product</option>';
									print '</select>';
									print '</td>';
									// Ac Capacity
									print '<td>'.$langs->trans("AC Capacity").'</td><td><input name="ac_capacity" id="ac_capacity" class="form-control " readonly maxlength="255" value="'.dol_escape_htmltag(GETPOST('ac_capacity')).'"></td></tr>';

									if ($conf->categorie->enabled) {
										// Categories
										print '<tr><td>'.$langs->trans("Categories").'</td><td colspan="3">';
										$cate_arbo = $form->select_all_categories(Categorie::TYPE_PROJECT, '', 'parent', 64, 0, 1);
										$arrayselected = GETPOST('categories', 'array');
										print img_picto('', 'category').$form->multiselectarray('categories', $cate_arbo, $arrayselected, '', 0, 'quatrevingtpercent widthcentpercentminusx', 0, 0);
										print "</td></tr>";
									}

									// Other options
									$parameters = array();
									$reshook = $hookmanager->executeHooks('formObjectOptions', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
									print $hookmanager->resPrint;
									if (empty($reshook))
									{
										
										print $object->showOptionals($extrafields, 'create');
									}

									print '</table>';

									print '<div class="center">';
									print '<input type="submit" class="btn btn-info button-save" value="'.$langs->trans("Create Lead").'">';
									if (!empty($backtopage))
									{
										print ' &nbsp; &nbsp; ';
										print '<input type="submit" class="btn btn-warning button-cancel" name="cancel" value="'.$langs->trans("Cancel").'">';
									} else {
										print ' &nbsp; &nbsp; ';
										print '<input type="button" class="btn btn-warning button-cancel" value="'.$langs->trans("Cancel").'" onClick="javascript:history.go(-1)">';
									}
									print '</div>';

									print '</form>'."\n";

									print '</div>';
								print '</div>';
							print '</div>';
						print '</div>';
					print '</div>';

	// Change probability from status
	print '<script type="text/javascript" language="javascript">
        jQuery(document).ready(function() {
        	function change_percent()
        	{
                var element = jQuery("#opp_status option:selected");
                var defaultpercent = element.attr("defaultpercent");
                /*if (jQuery("#opp_percent_not_set").val() == "") */
                jQuery("#opp_percent").val(defaultpercent);
        	}
        	/*init_myfunc();*/
        	jQuery("#opp_status").change(function() {
        		change_percent();
        	});

        	jQuery("#usage_task").change(function() {
        		console.log("We click on usage task "+jQuery("#usage_task").is(":checked"));
                if (! jQuery("#usage_task").is(":checked")) {
                    jQuery("#usage_bill_time").prop("checked", false);
                }
        	});

        	jQuery("#usage_bill_time").change(function() {
        		console.log("We click on usage to bill time");
                if (jQuery("#usage_bill_time").is(":checked")) {
                    jQuery("#usage_task").prop("checked", true);
                }
        	});
        });
        </script>';
} elseif ($object->id > 0)
{
	/*
     * Show or edit
     */

	$res = $object->fetch_optionals();

	// To verify role of users
	$userAccess = $object->restrictedProjectArea($user, 'read');
	$userWrite  = $object->restrictedProjectArea($user, 'write');
	$userDelete = $object->restrictedProjectArea($user, 'delete');
	//print "userAccess=".$userAccess." userWrite=".$userWrite." userDelete=".$userDelete;


	// Confirmation validation
	if ($action == 'validate')
	{
		print $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('ValidateProject'), $langs->trans('ConfirmValidateProject'), 'confirm_validate', '', 0, 1);
	}
	if ($action == 'invalidate')
	{
		print $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('InValidateProject'), $langs->trans('ConfirmInValidateProject'), 'confirm_invalidate', '', 0, 1);
	}
	// Confirmation close
	if ($action == 'close')
	{
		if($user_group_id == 4 || $user->admin == 1){
			print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("CloseAProject"), $langs->trans("ConfirmCloseAProject"), "close_form", '', '', 1);
			//$action = 'close_form';	
		}else{
			print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("CloseAProject"), $langs->trans("ConfirmCloseAProject"), "confirm_close", '', '', 1);	
		}
		
	}
	// Confirmation reopen
	if ($action == 'reopen')
	{
		print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("ReOpenAProject"), $langs->trans("ConfirmReOpenAProject"), "confirm_reopen", '', '', 1);
	}
	if ($action == 'reject')
	{
		print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("Rehect A Ticket"), $langs->trans("Confirm Reject This Ticket"), "confirm_reject", '', '', 3);
	}
	// Confirmation delete
	if ($action == 'delete')
	{
		$text = $langs->trans("ConfirmDeleteAProject");
		$task = new Task($db);
		$taskarray = $task->getTasksArray(0, 0, $object->id, 0, 0);
		$nboftask = count($taskarray);
		if ($nboftask) $text .= '<br>'.img_warning().' '.$langs->trans("ThisWillAlsoRemoveTasks", $nboftask);
		print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("DeleteAProject"), $text, "confirm_delete", '', '', 1);
	}

	// Clone confirmation
	if ($action == 'clone')
	{
		$formquestion = array(
			'text' => $langs->trans("ConfirmClone"),
			array('type' => 'other', 'name' => 'socid', 'label' => $langs->trans("SelectThirdParty"), 'value' => $form->select_company(GETPOST('socid', 'int') > 0 ?GETPOST('socid', 'int') : $object->socid, 'socid', '', "None", 0, 0, null, 0, 'minwidth200')),
			array('type' => 'checkbox', 'name' => 'clone_contacts', 'label' => $langs->trans("CloneContacts"), 'value' => true),
			array('type' => 'checkbox', 'name' => 'clone_tasks', 'label' => $langs->trans("CloneTasks"), 'value' => true),
			array('type' => 'checkbox', 'name' => 'move_date', 'label' => $langs->trans("CloneMoveDate"), 'value' => true),
			array('type' => 'checkbox', 'name' => 'clone_notes', 'label' => $langs->trans("CloneNotes"), 'value' => true),
			array('type' => 'checkbox', 'name' => 'clone_project_files', 'label' => $langs->trans("CloneProjectFiles"), 'value' => false),
			array('type' => 'checkbox', 'name' => 'clone_task_files', 'label' => $langs->trans("CloneTaskFiles"), 'value' => false)
		);

		print $form->formconfirm($_SERVER["PHP_SELF"]."?id=".$object->id, $langs->trans("ToClone"), $langs->trans("ConfirmCloneProject"), "confirm_clone", $formquestion, '', 1, 300, 590);
	}

	print '<div class="d-flex flex-column-fluid">
					<!--begin::Container-->
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<!--begin::Card-->
								<div class="card card-custom gutter-b">
									<div class="card-footer">';


	$head = project_prepare_head($object);
	
	if ($action == 'close_form' && $userWrite > 0)
	{
		print '<input type="hidden" name="close_action" value="close_form">';
		print '<input type="hidden" name="ref" value="'.$object->ref.'">';
		print '<input type="hidden" name="title" value="'.$object->title.'">';

		print dol_get_fiche_head_layout($head, 'project', $langs->trans("Support Tickets"), 0, ($object->public ? 'projectpub' : 'project'));
		print '<h3>'.$langs->trans("Close Support Tickets").'</h3>';
		print '<table class="table table-bordered">';
		print '<tr><td colspan="4"><h5>'.$langs->trans("Lead Detail").'</h5></td></tr>';
		// Ref
		$suggestedref = $object->ref;
		print '<tr><td style="width:25%">'.$langs->trans("Ref").'</td>';
		print '<td style="width:25%">'.$suggestedref.'</td>';

		// Label
		print '<td style="width:25%" >'.$langs->trans("ProjectLabel").'</td>';
		print '<td style="width:25%">'.dol_escape_htmltag($object->title).'</td></tr>';
		

		// Date start
		print '<tr><td>'.$langs->trans("DateStart").'</td><td>';
		print dol_print_date($object->date_c, 'dayhoursec');
		print '</td>';

		// Description
		print '<td class="tdtop">'.$langs->trans("Description").'</td>';
		print '<td colspan="3">'.$object->description.'</td></tr>';
		
		// Brand name
		print '<tr><td class="tdtop">'.$langs->trans("Brand").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_brand,'c_brands','nom'));
		print '</td>';

		// Category name
		print '<td class="tdtop">'.$langs->trans("Category").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_category,'c_product_family','nom'));
		print '</td></tr>';

		// Sub Category name
		print '<tr><td class="tdtop">'.$langs->trans("Sub Category").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_sub_category,'c_product_subfamily','nom'));
		print '</td>';

		// Model name
		print '<td class="tdtop">'.$langs->trans("Model No.").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_model,'c_product_model','code'));
		print '</td></tr>';

		require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
		$prdobject = new Product($db);
		$productjson =  $prdobject->getCustomerProductModelInfo($object->thirdparty->id,$object->fk_brand,$object->fk_category,$object->fk_sub_category,$object->fk_model);
		$prdarr = json_decode($productjson);
		
		// Label
		print '<tr><td>'.$langs->trans("Product Name").'</td><td>';
			print dol_htmlentitiesbr($object->getValuebyid($object->fk_model,'c_product_model','nom'));
		print '</td>';
		// Ac Capacity
		print '<td>'.$langs->trans("AC Capacity").'</td><td>'.dol_escape_htmltag($prdarr->ac_capacity).'</td></tr>';

		print '<tr><td colspan="4"><h5>'.$langs->trans("Action Taking").'</h5></td></tr>';
			
		// Problem
		print '<tr><td class="tdtop">'.$langs->trans("Problem Detail").'</td>';
		print '<td><textarea row="5" class="form-control" name="problem">'.dol_escape_htmltag($object->problem).'</textarea></td>';
		print '<td class="tdtop">'.$langs->trans("Problem Solution").'</td>';
		print '<td><textarea row="5" class="form-control" name="solution">'.dol_escape_htmltag($object->solution).'</textarea></td>';
		print '</tr>';

		print '<tr><td colspan="4"><h5>'.$langs->trans("Detect Code").'</h5></td></tr>';
			
		// OTP
		print '<tr><td class="tdtop">'.$langs->trans("OTP").'</td>';
		print '<td><input type="text" class="form-control" name="ticket_otp" value="'.dol_escape_htmltag($object->ticket_otp).'" /></td>';
		print '<td class="tdtop">'.$langs->trans("Signature").'</td>';
		print '<td>';
	require_once DOL_DOCUMENT_ROOT.'/core/class/doleditor.class.php';
	$doleditor = new DolEditor('customer_sign', GETPOST('customer_sign', 'restricthtml'), '', 138, 'dolibarr_notes', 'In', true, true, empty($conf->global->FCKEDITOR_ENABLE_USERSIGN) ? 0 : 1, ROWS_4, '90%');
	print $doleditor->Create(1);
	print '</td></tr>';



		// Response
		print '<tr><td class="tdtop">'.$langs->trans("Ticket Customer Response").'</td>';
		print '<td><select class="form-control" name="customer_response">
					<option value="Satisfied">Satisfied</option>
					<option value="UnSatisfied">Un-Satisfied</option>
					<option value="OK">OK</option>
				</select>
		</td>';
		print '<td class="tdtop">'.$langs->trans("Customer Remark").'</td>';
		print '<td><textarea row="5" class="form-control" name="customer_remark">'.dol_escape_htmltag($object->customer_remark).'</textarea></td>';
		print '</tr>';
	
		print '</table>';
	
	}elseif ($action == 'edit' && $userWrite > 0)
	{
		
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
		$readonly = '';
		if($user_group_id == '4'){
			//$readonly = 'readonly';
		}	

		print dol_get_fiche_head_layout($head, 'project', $langs->trans("Support Tickets"), 0, ($object->public ? 'projectpub' : 'project'));

		print '</div>
			<div class="card-body">';

		print '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
	
		print '<input type="hidden" name="token" value="'.newToken().'">';
		
		if ($action == 'close_form' && $userWrite > 0)
		{
			print '<input type="hidden" name="action" value="close_form_update">';
		}else{
			print '<input type="hidden" name="action" value="update">';	
		}	
		
		print '<input type="hidden" name="id" value="'.$object->id.'">';
		print '<input type="hidden" name="comefromclone" value="'.$comefromclone.'">';
		print '<input type="hidden" name="fk_customer_product" id="fk_customer_product" value="'.$object->fk_customer_product.'">';

		print '<table class="table table-bordered">';

		// Ref
		$suggestedref = $object->ref;
		print '<tr><td class="fieldrequired">'.$langs->trans("Ref").'</td>';
		print '<td><input size="12" class="form-control" readonly name="ref" value="'.$suggestedref.'">';
		print ' '.$form->textwithpicto('', $langs->trans("YouCanCompleteRef", $suggestedref));
		print '</td>';

		// Label
		print '<td class="fieldrequired">'.$langs->trans("ProjectLabel").'</td>';
		print '<td><input class="form-control" '.$readonly.' class="form-control" name="title" value="'.dol_escape_htmltag($object->title).'"></td></tr>';
		if($user_group_id == 4){
			$disabled = 'disabled';
		}else{
			$disabled = '';
		}
		// Status
		print '<tr><td class="fieldrequired">'.$langs->trans("Status").'</td><td>';
		print '<select class="form-control" name="status" '.$disabled.'>';
		foreach ($object->statuts_short as $key => $val)
		{
			print '<option value="'.$key.'"'.((GETPOSTISSET('status') ?GETPOST('status') : $object->statut) == $key ? ' selected="selected"' : '').'>'.$langs->trans($val).'</option>';
		}
		print '</select>';
		print '</td>';
		// fetch optionals attributes and labels
		$leadextrafields = new ExtraFields($db);
		$leadextrafields = $extrafields->fetch_name_optionals_label($object->table_element);
		$modelid = $object->fetch_optionals($object->id,$leadextrafields);
		
		print '<script>';
		print '
		
		$( document ).ready(function() {

			
			';
			/*if($user_group_id == '4'){
				print '$("#socid").attr("readonly", "readonly");';
			}	*/
		if($object->thirdparty->id > 0 && $object->fk_brand > 0){
			print 'jQuery("#fk_brand").val('.$object->fk_brand.');
			';	
		}
		if($object->thirdparty->id > 0 && $object->fk_category > 0){
			print '   
				
			jQuery("#fk_category").val('.$object->fk_category.');
			';	
		}
		if($object->thirdparty->id > 0 && $object->fk_sub_category > 0){
			print '   
			jQuery("#fk_sub_category").val('.$object->fk_sub_category.');
			
			';	
		}
		if($object->thirdparty->id > 0 && $object->fk_model > 0){
			print '   
			jQuery("#fk_model").val('.$object->fk_model.');
			';	
		}
		print '	jQuery("#socid").change(function() {
					var socid = $(this).val();
					//alert(socid);
                	$.ajax({
						  dataType: "html",
						  url: "customerproductBrand_data.php",
						  data: {socid: socid},
						  success: function(html) {
						  	//alert(html);
							$("#fk_brand").html(html);
							
						 }
					});
				});


				jQuery("#fk_brand").change(function() {
					var brandid = $(this).val();
					var socid = $("#socid").val();
                	$.ajax({
						  dataType: "html",
						  url: "customerproductCategory_data.php",
						  data: {socid: socid,brandid: brandid},
						  success: function(html) {
						  	//alert(html);
							$("#fk_category").html(html);
						  }
					});
				});

				jQuery("#fk_category").change(function() {
					var catid = $(this).val();
					var brandid = $("#fk_brand").val();
					var socid = $("#socid").val();
                	$.ajax({
						  dataType: "html",
						  url: "customerproductSubCategory_data.php",
						  data: {socid: socid,brandid: brandid ,catid: catid},
						  success: function(html) {
						  	//alert(html);
							$("#fk_sub_category").html(html);
						  }
					});
				});

				jQuery("#fk_sub_category").change(function() {
					var scatid = $(this).val();
					var catid = $("#fk_category").val();
					var brandid = $("#fk_brand").val();
					var socid = $("#socid").val();
                	$.ajax({
						  dataType: "html",
						  url: "customerproductmodeldata.php",
						  data: {socid: socid,brandid: brandid ,catid: catid,scatid: scatid},
						  success: function(html) {
						  	//alert(html);
							$("#fk_model").html(html);
						  }
					});
				});

				jQuery("#fk_model").change(function() {
					var model = $(this).val();
					var scatid = $("#fk_sub_category").val();
					var catid = $("#fk_category").val();
					var brandid = $("#fk_brand").val();
					var socid = $("#socid").val();
                	$.ajax({
						  dataType: "json",
						  url: "productmodeldata.php",
						  data: {socid: socid,brandid: brandid ,catid: catid,scatid: scatid,model: model},
						  success: function(data) {
						  	$("#fk_product").html(data.prdstr);
						  	$("#ac_capacity").val(data.ac_capacity);
						  	$("#fk_customer_product").val(data.id);
						  }
					});
				});

								

			});

			

			';


		print '</script>';

		// Thirdparty
		if ($conf->societe->enabled)
		{
			print '<td>';
			print (empty($conf->global->PROJECT_THIRDPARTY_REQUIRED) ? '' : '<span class="fieldrequired">');
			print $langs->trans("ThirdParty");
			print (empty($conf->global->PROJECT_THIRDPARTY_REQUIRED) ? '' : '</span>');
			print '</td><td>';
			$filteronlist = '';
			if (!empty($conf->global->PROJECT_FILTER_FOR_THIRDPARTY_LIST)) $filteronlist = $conf->global->PROJECT_FILTER_FOR_THIRDPARTY_LIST;
			$text = $form->select_company($object->thirdparty->id, 'socid', $filteronlist, 'None', 1, 0, array(), 0, 'minwidth300');
			if (empty($conf->global->PROJECT_CAN_ALWAYS_LINK_TO_ALL_SUPPLIERS) && empty($conf->dol_use_jmobile))
			{
				$texthelp = $langs->trans("IfNeedToUseOtherObjectKeepEmpty");
				print $form->textwithtooltip($text.' '.img_help(), $texthelp, 1, 0, '', '', 2);
			} else print $text;
			print '</td></tr>';
		}


		// Usage
		print '<tr style="display:none;"><td class="tdtop">';
		print $langs->trans("Usage");
		print '</td>';
		print '<td>';
		if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
		{
			print '<input type="checkbox" id="usage_opportunity" name="usage_opportunity"'.(GETPOSTISSET('usage_opportunity') ? (GETPOST('usage_opportunity', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_opportunity ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectFollowOpportunity");
			print $form->textwithpicto($langs->trans("ProjectFollowOpportunity"), $htmltext);
			print '<script>';
			print '$( document ).ready(function() {
				jQuery("#usage_opportunity").change(function() {
					if (jQuery("#usage_opportunity").prop("checked")) {
						console.log("Show opportunities fields");
						jQuery(".classuseopportunity").show();
					} else {
						console.log("Hide opportunities fields "+jQuery("#usage_opportunity").prop("checked"));
						jQuery(".classuseopportunity").hide();
					}
				});
			});';
			print '</script>';
			print '<br>';
		}
		if (empty($conf->global->PROJECT_HIDE_TASKS))
		{
			print '<input type="checkbox" name="usage_task"'.(GETPOSTISSET('usage_task') ? (GETPOST('usage_task', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_task ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectFollowTasks");
			print $form->textwithpicto($langs->trans("ProjectFollowTasks"), $htmltext);
			print '<br>';
		}
		if (empty($conf->global->PROJECT_HIDE_TASKS) && !empty($conf->global->PROJECT_BILL_TIME_SPENT))
		{
			print '<input type="checkbox" name="usage_bill_time"'.(GETPOSTISSET('usage_bill_time') ? (GETPOST('usage_bill_time', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_bill_time ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectBillTimeDescription");
			print $form->textwithpicto($langs->trans("BillTime"), $htmltext);
			print '<br>';
		}
		print '</td></tr>';

		
		// Visibility
		print '<tr style="display:none;"><td>'.$langs->trans("Visibility").'</td><td>';
		$array = array();
		if (empty($conf->global->PROJECT_DISABLE_PRIVATE_PROJECT)) $array[0] = $langs->trans("PrivateProject");
		if (empty($conf->global->PROJECT_DISABLE_PUBLIC_PROJECT)) $array[1] = $langs->trans("SharedProject");
		print $form->selectarray('public', $array, $object->public, 0, 0, 0, '', 0, 0, 0, '', '', 1);
		print '</td></tr>';

		if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
		{
			$classfortr = ($object->usage_opportunity ? '' : ' hideobject');
			// Opportunity status
			print '<tr class="classuseopportunity'.$classfortr.'"><td>'.$langs->trans("OpportunityStatus").'</td>';
			print '<td>';
			print $formproject->selectOpportunityStatus('opp_status', $object->opp_status, 1, 0, 0, 0, 'inline-block valignmiddle', 0, 1);
			print '<div id="divtocloseproject" class="inline-block valign" style="display: none;"> &nbsp; &nbsp; ';
			print '<input type="checkbox" id="inputcloseproject" name="closeproject" /> ';
			print $langs->trans("AlsoCloseAProject");
			print '</div>';
			print '</td>';
			print '</tr>';

			// Opportunity probability
			print '<tr class="classuseopportunity'.$classfortr.'"><td>'.$langs->trans("OpportunityProbability").'</td>';
			print '<td><input size="5" type="text" id="opp_percent" name="opp_percent" value="'.(GETPOSTISSET('opp_percent') ? GETPOST('opp_percent') : (strcmp($object->opp_percent, '') ?vatrate($object->opp_percent) : '')).'"> %';
			print '<span id="oldopppercent"></span>';
			print '</td>';
			print '</tr>';

			// Opportunity amount
			print '<tr class="classuseopportunity'.$classfortr.'"><td>'.$langs->trans("OpportunityAmount").'</td>';
			print '<td><input size="5" type="text" name="opp_amount" value="'.(GETPOSTISSET('opp_amount') ? GETPOST('opp_amount') : (strcmp($object->opp_amount, '') ? price2num($object->opp_amount) : '')).'"></td>';
			print '</tr>';
		}

		// Date start
		print '<tr><td>'.$langs->trans("DateStart").'</td><td>';
		if($user_group_id == '4'){
			print dol_print_date($object->date_c, 'dayhoursec');
		}else{
			print $form->selectDate($object->date_start ? $object->date_start : -1, 'projectstart', 0, 0, 0, '', 1, 0);
			//print $form->selectDate($object->date_start ? $object->date_start : -1, 'projectstart', ($conf->browser->layout == 'phone' ? 2 : 1), 1, 2, "timespent_date", 1, 0);
			
		}

		/*print ' &nbsp; &nbsp; <input type="checkbox" class="valignmiddle" name="reportdate" value="yes" ';
		if ($comefromclone) {print ' checked '; }
		print '/> '.$langs->trans("ProjectReportDate");*/
		print '</td>';

		// Technician 
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
		if($user_group_id == '4'){
			print '<td class="fieldrequired">'.$langs->trans("Assign Technician").'</td><td>';
			print '<select class="form-control" name="fk_technician"><option value="">Select </option>';
			
			$sqlTechnician = "SELECT rowid, firstname,lastname FROM ".MAIN_DB_PREFIX."user WHERE fk_user = '".$user->id."'  ";
			$resqlTech = $db->query($sqlTechnician);
			$numtech = $db->num_rows($resqlTech);
			if($numtech > 0){
				while ($objtech = $db -> fetch_object($resqlTech))
				{
					print '<option value="'.$objtech->rowid.'"'.((GETPOSTISSET('fk_technician') ?GETPOST('fk_technician') : $object->fk_technician) == $objtech->rowid ? ' selected="selected"' : '').'>'.$objtech->firstname." ".$objtech->lastname.'</option>';
				}
			}	
			print '</select>';
			print '</td></tr>';
		}

		// Address
		if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->address)) == 0) $object->address = $thirdparty->address; // Predefined with third party
		print '<tr><td><label for="address">'.$langs->trans("Address").'</label></td>';
		print '<td colspan="'.$colspan.'"><textarea class="form-control" name="address" id="address" rows="'.ROWS_2.'">'.(GETPOST("address", 'alpha') ?GETPOST("address", 'alpha') : $object->address).'</textarea></td>';

		if ($conf->use_javascript_ajax)
		{
			$rowspan = 0;
			if (empty($conf->global->SOCIETE_DISABLE_STATE)) $rowspan++;

			print '<td class="" rowspan="'.$rowspan.'">';
			print '<a href="#" id="copyaddressfromsoc">'.$langs->trans('CopyAddressFromSoc').'</a>';
			print '</td>';
		}
		print '</tr>';

		// Zip / Town
		if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->zip)) == 0) $object->zip = $thirdparty->zip; // Predefined with third party
		if (($thirdparty->typent_code == 'TE_PRIVATE' || !empty($conf->global->CONTACT_USE_COMPANY_ADDRESS)) && dol_strlen(trim($object->town)) == 0) $object->town = $thirdparty->town; // Predefined with third party
		print '<tr><td><label for="zipcode">'.$langs->trans("Zip").'</label></td><td  class="">';
		print $formcompany->select_ziptown((GETPOST("zipcode", 'alpha') ? GETPOST("zipcode", 'alpha') : $object->zip), 'zipcode', array('town', 'selectcountry_id', 'state_id'), 6).'&nbsp;';
		print '</td><td><label for="town">'.$langs->trans("Town").'</label></td><td  class="">';
		print $formcompany->select_ziptown((GETPOST("town", 'alpha') ? GETPOST("town", 'alpha') : $object->town), 'town', array('zipcode', 'selectcountry_id', 'state_id'));
		print '</td></tr>';

		// Country
		print '<tr><td><label for="selectcountry_id">'.$langs->trans("Country").'</label></td><td class="">';
		print img_picto('', 'globe-americas', 'class=""');
		print $form->select_country((GETPOST("country_id", 'alpha') ? GETPOST("country_id", 'alpha') : $object->country_id), 'country_id');
		/*if ($user->admin) print info_admin($langs->trans("YouCanChangeValuesForThisListFromDictionarySetup"), 1);*/
		print '</td>';
		// State
		if (empty($conf->global->SOCIETE_DISABLE_STATE))
		{
			if (!empty($conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT) && ($conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT == 1 || $conf->global->MAIN_SHOW_REGION_IN_STATE_SELECT == 2))
			{
				print '<td><label for="state_id">'.$langs->trans('Region-State').'</label></td><td class="">';
			} else {
				print '<td><label for="state_id">'.$langs->trans('State').'</label></td><td class="">';
			}

			if ($object->country_id)
			{
				print $formcompany->select_state(GETPOST("state_id", 'alpha') ? GETPOST("state_id", 'alpha') : $object->state_id, $object->country_code, 'state_id');
			} else {
				print $countrynotdefined;
			}
			print '</td>';
		}
		print '</tr>';

		// Scheduled Time
		print '<tr><td>'.$langs->trans("Scheduled Time").'</td><td>';
		print $form->selectDate($object->tech_assigndatetime ? $object->tech_assigndatetime : -1, 'tech_assigndatetime', ($conf->browser->layout == 'phone' ? 2 : 1), 1, 2, "timespent_date", 1, 0);
		print '</td>';

		print '<td>'.$langs->trans("Re-Scheduled Time").'</td><td>';
		print $form->selectDate($object->response_reschedule ? $object->response_reschedule : -1, 'response_reschedule', ($conf->browser->layout == 'phone' ? 2 : 1), 1, 2, "timespent_date", 1, 0);
		print '</td></tr>';
 
		// End Time
		/*print '<tr><td>'.$langs->trans("DateEnd").'</td><td>';
		print $form->selectDate($object->date_end ? $object->date_end : -1, 'projectend', 0, 0, 0, '', 1, 0);
		print '</td></tr>';*/
 
		// Budget
		print '<tr style="display:none;"><td>'.$langs->trans("Budget").'</td>';
		print '<td><input size="5" type="text" name="budget_amount" value="'.(GETPOSTISSET('budget_amount') ? GETPOST('budget_amount') : (strcmp($object->budget_amount, '') ? price2num($object->budget_amount) : '')).'"></td>';
		print '</tr>';

		// Description
		print '<tr><td class="tdtop">'.$langs->trans("Description").'</td>';
		print '<td colspan="3">';
		$doleditor = new DolEditor('description', $object->description, '', 90, 'dolibarr_notes', '', false, true, $conf->global->FCKEDITOR_ENABLE_SOCIETE, ROWS_3, '90%');
		$doleditor->Create();
		print '</td></tr>';
		require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
		$prdobject = new Product($db);
		// Brand
		print '<tr><td class="fieldrequired">'.$langs->trans("Brand").'</td><td>';
		print '<select class="form-control" id="fk_brand" name="fk_brand">';
		print $prdobject->getCustomerProductBrand($object->thirdparty->id);
		print '</select>';
		print '</td>';
		
		// Product Category

		print '<td >'.$langs->trans("Category").'</td><td>';
		print '<select class="form-control" id="fk_category" name="fk_category">';
		print $prdobject->getCustomerProductCategory($object->thirdparty->id,$object->fk_brand);
		print '</select>';
		print '</td></tr>';

		// Product sub Category
		print '<tr><td >'.$langs->trans("Sub Category").'</td><td>';
		print '<select class="form-control" id="fk_sub_category" name="fk_sub_category">';
		print $prdobject->getCustomerProductSubCategory($object->thirdparty->id,$object->fk_brand,$object->fk_category);
		print '</select>';
		print '</td>';
		// Model
		print '<td>'.$langs->trans("Model No.").'</td><td>';
		print '<select class="form-control" id="fk_model" name="fk_model">';
		print $prdobject->getCustomerProductModel($object->thirdparty->id,$object->fk_brand,$object->fk_category,$object->fk_sub_category,$object->fk_model);
		print '</select>';
		print '</td></tr>';
		$productjson =  $prdobject->getCustomerProductModelInfo($object->thirdparty->id,$object->fk_brand,$object->fk_category,$object->fk_sub_category,$object->fk_model);
		$prdarr = json_decode($productjson);
		
		// Label
		print '<tr><td>'.$langs->trans("Product Name").'</td><td>';
		print '<select class="form-control" id="fk_product" name="fk_product">';
		print $prdarr->prdstr;
		print '</select>';
		print '</td>';
		// Ac Capacity
		print '<td>'.$langs->trans("AC Capacity").'</td><td><input name="ac_capacity" id="ac_capacity" class="form-control" readonly maxlength="255" value="'.dol_escape_htmltag($prdarr->ac_capacity).'"></td></tr>';

		// Tags-Categories
		if ($conf->categorie->enabled)
		{
			print '<tr><td>'.$langs->trans("Categories").'</td><td>';
			$cate_arbo = $form->select_all_categories(Categorie::TYPE_PROJECT, '', 'parent', 64, 0, 1);
			$c = new Categorie($db);
			$cats = $c->containing($object->id, Categorie::TYPE_PROJECT);
			foreach ($cats as $cat) {
				$arrayselected[] = $cat->id;
			}
			print img_picto('', 'category').$form->multiselectarray('categories', $cate_arbo, $arrayselected, 0, 0, 'quatrevingtpercent widthcentpercentminusx', 0, '0');
			print "</td></tr>";
		}

		
		// Other options
		$parameters = array();
		$reshook = $hookmanager->executeHooks('formObjectOptions', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
		print $hookmanager->resPrint;
		if (empty($reshook))
		{
			print $object->showOptionals($extrafields, 'edit');
		}

		print '</table>';

		print '</div>';
	} else {
		print dol_get_fiche_head_layout($head, 'project', $langs->trans("Support Tickets"), -1, ($object->public ? 'projectpub' : 'project'));

		print '</div>
		<div class="card-body">';



		// Project card

		$linkback = '<a href="'.DOL_URL_ROOT.'/projet/list.php?restore_lastsearch_values=1">'.$langs->trans("BackToList").'</a>';

		$morehtmlref = '<div class="refidno">';
		// Title
		$morehtmlref .= dol_escape_htmltag($object->title);
		// Thirdparty
		$morehtmlref .= '<br>'.$langs->trans('ThirdParty').' : ';
		if ($object->thirdparty->id > 0)
		{
			$morehtmlref .= $object->thirdparty->getNomUrl(1, 'project');
		}
		$morehtmlref .= '</div>';

		// Define a complementary filter for search of next/prev ref.
		if (!$user->rights->projet->all->lire)
		{
			$objectsListId = $object->getProjectsAuthorizedForUser($user, 0, 0);
			$object->next_prev_filter = " rowid in (".(count($objectsListId) ?join(',', array_keys($objectsListId)) : '0').")";
		}

		dol_banner_tab_layout($object, 'ref', $linkback, 1, 'ref', 'ref', $morehtmlref);

		print '</div>
		</div>';

		print '<div class="card card-custom gutter-b"><div class="card-body">';

		print '<div class="row">';
		print '<div class="col-sm-6">
		<div class="table-responsive">';

		print '<table class="table table-bordered">';

		// Usage
		print '<tr style="display:none;"><td class="tdtop">';
		print $langs->trans("Usage");
		print '</td>';
		print '<td>';
		if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
		{
			print '<input type="checkbox" disabled name="usage_opportunity"'.(GETPOSTISSET('usage_opportunity') ? (GETPOST('usage_opportunity', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_opportunity ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectFollowOpportunity");
			print $form->textwithpicto($langs->trans("ProjectFollowOpportunity"), $htmltext);
			print '<br>';
		}
		if (empty($conf->global->PROJECT_HIDE_TASKS))
		{
			print '<input type="checkbox" disabled name="usage_task"'.(GETPOSTISSET('usage_task') ? (GETPOST('usage_task', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_task ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectFollowTasks");
			print $form->textwithpicto($langs->trans("ProjectFollowTasks"), $htmltext);
			print '<br>';
		}
		if (!empty($conf->global->PROJECT_BILL_TIME_SPENT))
		{
			print '<input type="checkbox" disabled name="usage_bill_time"'.(GETPOSTISSET('usage_bill_time') ? (GETPOST('usage_bill_time', 'alpha') != '' ? ' checked="checked"' : '') : ($object->usage_bill_time ? ' checked="checked"' : '')).'"> ';
			$htmltext = $langs->trans("ProjectBillTimeDescription");
			print $form->textwithpicto($langs->trans("BillTime"), $htmltext);
			print '<br>';
		}
		print '</td></tr>';

		// Visibility
		print '<tr style="display:none;"><td class="titlefield">'.$langs->trans("Visibility").'</td><td>';
		if ($object->public) print $langs->trans('SharedProject');
		else print $langs->trans('PrivateProject');
		print '</td></tr>';

		if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES) && !empty($object->usage_opportunity))
		{
			// Opportunity status
			print '<tr><td>'.$langs->trans("OpportunityStatus").'</td><td>';
			$code = dol_getIdFromCode($db, $object->opp_status, 'c_lead_status', 'rowid', 'code');
			if ($code) print $langs->trans("OppStatus".$code);
			print '</td></tr>';

			// Opportunity percent
			print '<tr><td>'.$langs->trans("OpportunityProbability").'</td><td>';
			if (strcmp($object->opp_percent, '')) print price($object->opp_percent, 0, $langs, 1, 0).' %';
			print '</td></tr>';

			// Opportunity Amount
			print '<tr><td>'.$langs->trans("OpportunityAmount").'</td><td>';
			/*if ($object->opp_status)
	        {
	           print price($obj->opp_amount, 1, $langs, 1, 0, -1, $conf->currency);
	        }*/
			if (strcmp($object->opp_amount, '')) print price($object->opp_amount, 0, $langs, 1, 0, -1, $conf->currency);
			print '</td></tr>';

			// Opportunity Weighted Amount
			print '<tr><td>'.$langs->trans('OpportunityWeightedAmount').'</td><td>';
			if (strcmp($object->opp_amount, '') && strcmp($object->opp_percent, '')) print price($object->opp_amount * $object->opp_percent / 100, 0, $langs, 1, 0, -1, $conf->currency);
			print '</td></tr>';
		}

		// Date start - end
		//print '<tr><td>'.$langs->trans("DateStart").' - '.$langs->trans("DateEnd").'</td><td colspan="4">';
		print '<tr><td>'.$langs->trans("Start Date and Time").'</td><td colspan="4">';
		$start = dol_print_date($object->date_c, 'dayhoursec');
		print ($start ? $start : '?');
		$end = dol_print_date($object->date_end, 'day');
		/*print ' - ';
		print ($end ? $end : '?');
		if ($object->hasDelay()) print img_warning("Late");
		print '</td></tr>';*/

		// Technician name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Technician name").'</td><td>';
		print $object->getValuebyid($object->fk_technician,'user','firstname').' '.$object->getValuebyid($object->fk_technician,'user','lastname');
		print '</td></tr>';

		// Technician Assigne Date and time
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Technician Assign Time").'</td><td>';
		print dol_print_date($object->tech_assigndatetime, 'dayhoursec');
		print '</td></tr>';
		if($object->response_reschedule != ''){
			// Technician Re-assigne Date and time
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Re-Scheduled Time").'</td><td>';
			print dol_print_date($object->response_reschedule, 'dayhoursec');
			print '</td></tr>';
		}
		if($object->problem){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Problem").'</td><td>';
			print $object->problem;
			print '</td></tr>';
		}
		if($object->solution){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Solution").'</td><td>';
			print $object->solution;
			print '</td></tr>';
		}
		if($object->ticket_otp){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Ticket OTP").'</td><td>';
			print $object->ticket_otp;
			print '</td></tr>';
		}
		if($object->customer_response){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Customer Response").'</td><td>';
			print $object->customer_response;
			print '</td></tr>';
		}
		if($object->customer_sign){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Signature").'</td><td>';
			print dol_htmlentitiesbr($object->customer_sign);
			print '</td></tr>';
		}
		if($object->customer_remark){
			print '<tr><td class="titlefield tdtop">'.$langs->trans("Customer Remark").'</td><td>';
			print $object->customer_remark;
			print '</td></tr>';
		}
		// Budget
		print '<tr style="display:none;"><td>'.$langs->trans("Budget").'</td><td>';
		if (strcmp($object->budget_amount, '')) print price($object->budget_amount, 0, $langs, 1, 0, 0, $conf->currency);
		print '</td></tr>';

		print '</table>';

		print '</div>';
		print '</div>';
		print '<div class="col-sm-6">
		<table class="table-responsive">';

		print '<table class="table table-bordered">';

		// Title
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Title").'</td><td>';
		print dol_htmlentitiesbr($object->title);
		print '</td></tr>';


		// Description
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Description").'</td><td>';
		print dol_htmlentitiesbr($object->description);
		print '</td></tr>';

		// Brand name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Brand").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_brand,'c_brands','nom'));
		print '</td></tr>';

		// Category name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Category").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_category,'c_product_family','nom'));
		print '</td></tr>';

		// Sub Category name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Sub Category").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_sub_category,'c_product_subfamily','nom'));
		print '</td></tr>';

		// Model name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Model No.").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_model,'c_product_model','code'));
		print '</td></tr>';

		// Product name
		print '<tr><td class="titlefield tdtop">'.$langs->trans("Product name").'</td><td>';
		print dol_htmlentitiesbr($object->getValuebyid($object->fk_model,'c_product_model','nom'));
		print '</td></tr>';

		// Categories
		if ($conf->categorie->enabled) {
			print '<tr><td class="valignmiddle">'.$langs->trans("Categories").'</td><td>';
			print $form->showCategories($object->id, Categorie::TYPE_PROJECT, 1);
			print "</td></tr>";
		}

		print "</table>\n";
		print '</div>';

		print '</div>';
		print '</div>';

		// Other attributes
		print '<div class="card-body">';
		print '<table class="table table-bordered"><tbody>';
		$cols = 1;
		include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_view_layout.tpl.php';
		print '</tbody></table>';
	}

	if ($action == 'edit' && $userWrite > 0)
	{
		print '<div class="card-body"><div class="center">';
		print '<input name="update" class="btn btn-info" type="submit" value="'.$langs->trans("Modify").'">&nbsp; &nbsp; &nbsp;';
		print '<input type="submit" class="btn btn-danger" name="cancel" value="'.$langs->trans("Cancel").'">';
		print '</div>';
		print '</div>';
	}

	if ($action == 'close_form' && $userWrite > 0)
	{
		print '<div class="card-body"><div class="center">';
		print '<input name="update" class="btn btn-info" type="submit" value="'.$langs->trans("Modify").'">&nbsp; &nbsp; &nbsp;';
		print '<input type="submit" class="btn btn-danger" name="cancel" value="'.$langs->trans("Cancel").'">';
		print '</div>';
		print '</div>';
	}

	print '</form>';

	print "</div>\n";

	// Change probability from status
	if (!empty($conf->use_javascript_ajax) && !empty($conf->global->PROJECT_USE_OPPORTUNITIES))
	{
		// Default value to close or not when we set opp to 'WON'.
		$defaultcheckedwhenoppclose = 1;
		if (empty($conf->global->PROJECT_HIDE_TASKS)) $defaultcheckedwhenoppclose = 0;

		print '<!-- Javascript to manage opportunity status change -->';
		print '<script type="text/javascript" language="javascript">
            jQuery(document).ready(function() {
            	function change_percent()
            	{
                    var element = jQuery("#opp_status option:selected");
                    var defaultpercent = element.attr("defaultpercent");
                    var defaultcloseproject = '.$defaultcheckedwhenoppclose.';
                    var elemcode = element.attr("elemcode");
                    var oldpercent = \''.dol_escape_js($object->opp_percent).'\';

                    console.log("We select "+elemcode);

                    /* Define if checkbox to close is checked or not */
                    var closeproject = 0;
                    if (elemcode == \'LOST\') closeproject = 1;
                    if (elemcode == \'WON\') closeproject = defaultcloseproject;
                    if (closeproject) jQuery("#inputcloseproject").prop("checked", true);
                    else jQuery("#inputcloseproject").prop("checked", false);

                    /* Make the close project checkbox visible or not */
                    console.log("closeproject="+closeproject);
                    if (elemcode == \'WON\' || elemcode == \'LOST\')
                    {
                        jQuery("#divtocloseproject").show();
                    }
                    else
                    {
                        jQuery("#divtocloseproject").hide();
                    }

                    /* Change percent with default percent (defaultpercent) if new status (defaultpercent) is higher than current (jQuery("#opp_percent").val()) */
                    console.log("oldpercent="+oldpercent);
                    if (oldpercent != \'\' && (parseFloat(defaultpercent) < parseFloat(oldpercent)))
                    {
                        if (jQuery("#opp_percent").val() != \'\' && oldpercent != \'\') jQuery("#oldopppercent").text(\' - '.dol_escape_js($langs->transnoentities("PreviousValue")).': \'+oldpercent+\' %\');
                        if (parseFloat(oldpercent) != 100) { jQuery("#opp_percent").val(oldpercent); }
                        else { jQuery("#opp_percent").val(defaultpercent); }
                    }
                    else
                    {
                    	if ((parseFloat(jQuery("#opp_percent").val()) < parseFloat(defaultpercent)));
                    	{
                        	if (jQuery("#opp_percent").val() != \'\' && oldpercent != \'\') jQuery("#oldopppercent").text(\' - '.dol_escape_js($langs->transnoentities("PreviousValue")).': \'+oldpercent+\' %\');
                        	jQuery("#opp_percent").val(defaultpercent);
                    	}
                    }
            	}

            	jQuery("#opp_status").change(function() {
            		change_percent();
            	});
        });
        </script>';
	}

	/*
     * Actions Buttons
     */

	print '<div class="card-body">';
	print '<div class="tabsAction">';
	$parameters = array();
	$reshook = $hookmanager->executeHooks('addMoreActionsButtons', $parameters, $object, $action); // Note that $action and $object may have been
																							  // modified by hook
	if (empty($reshook))
	{
		if ($action != "edit" && $action != "close_form" && $action != 'presend')
		{
			// Create event
			/*if ($conf->agenda->enabled && ! empty($conf->global->MAIN_ADD_EVENT_ON_ELEMENT_CARD)) 				// Add hidden condition because this is not a
				// "workflow" action so should appears somewhere else on
				// page.
			{
				print '<a class="butAction" href="'.DOL_URL_ROOT.'/comm/action/card.php?action=create&amp;origin=' . $object->element . '&amp;originid=' . $object->id . '&amp;socid=' . $object->socid . '&amp;projectid=' . $object->id . '">' . $langs->trans("AddAction") . '</a>';
			}*/

			// Send
			if (empty($user->socid)) {
				if ($object->statut != 2)
				{
					print '<a class="btn btn-info" href="card.php?id='.$object->id.'&amp;action=presend&mode=init#formmailbeforetitle">'.$langs->trans('SendMail').'</a> &nbsp;&nbsp;';
				}
			}

			// Modify
			if ($object->statut != 2 && $object->statut != 3 && $user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					
					print '<a class="btn btn-info" href="card.php?id='.$object->id.'&amp;action=edit">'.$langs->trans("Modify").'</a> &nbsp;&nbsp;';
					
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('Modify').'</a>';
				}
			}

			// Validate
			if (($object->statut == 0 || $object->statut == 3) && $user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					print '<a class="btn btn-info" href="card.php?id='.$object->id.'&action=validate">'.$langs->trans("Accept").'</a> &nbsp;&nbsp;';
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('Accept').'</a>';
				}
			}

			// Close
			if ($object->statut == 1 && $user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					print '<a class="btn btn-danger" href="card.php?id='.$object->id.'&amp;action=close">'.$langs->trans("Close").'</a> &nbsp;&nbsp;';
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('Close').'</a>';
				}
			}

			// Reopen
			if ($object->statut == 2 && $user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					print '<a class="btn btn-info" href="card.php?id='.$object->id.'&amp;action=reopen">'.$langs->trans("ReOpen").'</a> &nbsp;&nbsp;';
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('ReOpen').'</a>';
				}
			}

			if (($object->statut == 0 || $object->statut == 1) && $user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					print '<a class="btn btn-danger" href="card.php?id='.$object->id.'&amp;action=reject">'.$langs->trans("Reject").'</a> &nbsp;&nbsp;';
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('Reject').'</a>';
				}
			}

			// Add button to create objects from project
			if (!empty($conf->global->PROJECT_SHOW_CREATE_OBJECT_BUTTON))
			{
				if (!empty($conf->propal->enabled) && $user->rights->propal->creer)
				{
					$langs->load("propal");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/comm/propal/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddProp").'</a>';
				}
				if (!empty($conf->commande->enabled) && $user->rights->commande->creer)
				{
					$langs->load("orders");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/commande/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("CreateOrder").'</a>';
				}
				if (!empty($conf->facture->enabled) && $user->rights->facture->creer)
				{
					$langs->load("bills");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/compta/facture/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("CreateBill").'</a>';
				}
				if (!empty($conf->supplier_proposal->enabled) && $user->rights->supplier_proposal->creer)
				{
					$langs->load("supplier_proposal");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/supplier_proposal/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddSupplierProposal").'</a>';
				}
				if (!empty($conf->supplier_order->enabled) && $user->rights->fournisseur->commande->creer)
				{
					$langs->load("suppliers");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/fourn/commande/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddSupplierOrder").'</a>';
				}
				if (!empty($conf->supplier_invoice->enabled) && $user->rights->fournisseur->facture->creer)
				{
					$langs->load("suppliers");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/fourn/facture/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddSupplierInvoice").'</a>';
				}
				if (!empty($conf->ficheinter->enabled) && $user->rights->ficheinter->creer)
				{
					$langs->load("interventions");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/fichinter/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddIntervention").'</a>';
				}
				if (!empty($conf->contrat->enabled) && $user->rights->contrat->creer)
				{
					$langs->load("contracts");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/contrat/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddContract").'</a>';
				}
				if (!empty($conf->expensereport->enabled) && $user->rights->expensereport->creer)
				{
					$langs->load("trips");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/expensereport/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddTrip").'</a>';
				}
				if (!empty($conf->don->enabled) && $user->rights->don->creer)
				{
					$langs->load("donations");
					print '<a class="butAction" href="'.DOL_URL_ROOT.'/don/card.php?action=create&projectid='.$object->id.'&socid='.$object->socid.'">'.$langs->trans("AddDonation").'</a>';
				}
			}

			// Clone
			if ($user->rights->projet->creer)
			{
				if ($userWrite > 0)
				{
					if($user_group_id != '4'){
						print '<a class="btn btn-info" href="card.php?id='.$object->id.'&action=clone">'.$langs->trans('ToClone').'</a> &nbsp;&nbsp;';
					}
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('ToClone').'</a>';
				}
			}

			
			// Delete
			if ($user->rights->projet->supprimer || ($object->statut == 0 && $user->rights->projet->creer))
			{
				if ($userDelete > 0 || ($object->statut == 0 && $user->rights->projet->creer))
				{
					print '<a class="btn btn-danger" href="card.php?id='.$object->id.'&amp;action=delete&amp;token='.newToken().'">'.$langs->trans("Delete").'</a>';
				} else {
					print '<a class="butActionRefused classfortooltip" href="#" title="'.$langs->trans("NotOwnerOfProject").'">'.$langs->trans('Delete').'</a>';
				}
			}
		}
	}

	print "</div>";
	print "</div>";

	if (GETPOST('modelselected')) {
		$action = 'presend';
	}

	if ($action != 'presend')
	{
		print '<div class="row"><div class="col-sm-6">';
		print '<a name="builddoc"></a>'; // ancre

		/*
         * Documents generes
         */
		$filename = dol_sanitizeFileName($object->ref);
		$filedir = $conf->projet->dir_output."/".dol_sanitizeFileName($object->ref);
		$urlsource = $_SERVER["PHP_SELF"]."?id=".$object->id;
		$genallowed = ($user->rights->projet->lire && $userAccess > 0);
		$delallowed = ($user->rights->projet->creer && $userWrite > 0);

		//print $formfile->showdocuments('project', $filename, $filedir, $urlsource, $genallowed, $delallowed, $object->model_pdf);

		print '</div><div class="col-sm-6">';

		$MAXEVENT = 10;

		$morehtmlright = '<a href="'.DOL_URL_ROOT.'/projet/info.php?id='.$object->id.'">';
		$morehtmlright .= $langs->trans("SeeAll");
		$morehtmlright .= '</a>';

		// List of actions on element
		include_once DOL_DOCUMENT_ROOT.'/core/class/html.formactions.class.php';
		$formactions = new FormActions($db);
		//$somethingshown = $formactions->showactions($object, 'project', 0, 1, '', $MAXEVENT, '', $morehtmlright);

		print '</div></div>';
	}

	// Presend form
	$modelmail = 'project';
	$defaulttopic = 'SendProjectRef';
	$diroutput = $conf->projet->dir_output;
	$autocopy = 'MAIN_MAIL_AUTOCOPY_PROJECT_TO'; // used to know the automatic BCC to add
	$trackid = 'proj'.$object->id;

	include DOL_DOCUMENT_ROOT.'/core/tpl/card_presend.tpl.php';

	// Hook to add more things on page
	$parameters = array();
	$reshook = $hookmanager->executeHooks('mainCardTabAddMore', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
} else {
	print $langs->trans("RecordNotFound");
}

// End of page
llxFooterLayout();

print '<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<!--end::Page Vendors-->';

print "	</body>\n";
print "</html>\n";

$db->close();
