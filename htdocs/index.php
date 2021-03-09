<?php
/* Copyright (C) 2001-2004	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2004-2020	Laurent Destailleur		<eldy@users.sourceforge.net>
 * 
 * Copyright (C) 2011-2012	Juanjo Menent			<jmenent@2byte.es>
 * Copyright (C) 2015		Marcos García			<marcosgdf@gmail.com>
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
 *	\file       htdocs/index.php
 *	\brief      Dolibarr home page
 */

define('NOCSRFCHECK', 1); // This is main home and login page. We must be able to go on it from another web site.

require 'main.inc.php';

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formother.class.php';

// If not defined, we select menu "home"
$_GET['mainmenu'] = GETPOST('mainmenu', 'aZ09') ?GETPOST('mainmenu', 'aZ09') : 'home';
$action = GETPOST('action', 'aZ09');

$hookmanager->initHooks(array('index'));


/*
 * Actions
 */

// Check if company name is defined (first install)
if (!isset($conf->global->MAIN_INFO_SOCIETE_NOM) || empty($conf->global->MAIN_INFO_SOCIETE_NOM))
{
	header("Location: ".DOL_URL_ROOT."/admin/index.php?mainmenu=home&leftmenu=setup&mesg=setupnotcomplete");
	exit;
}

if (count($conf->modules) <= (empty($conf->global->MAIN_MIN_NB_ENABLED_MODULE_FOR_WARNING) ? 1 : $conf->global->MAIN_MIN_NB_ENABLED_MODULE_FOR_WARNING))	// If only user module enabled
{
	header("Location: ".DOL_URL_ROOT."/admin/index.php?mainmenu=home&leftmenu=setup&mesg=setupnotcomplete");
	exit;
}

if (GETPOST('addbox'))	// Add box (when submit is done from a form when ajax disabled)
{
	require_once DOL_DOCUMENT_ROOT.'/core/class/infobox.class.php';
	$zone = GETPOST('areacode', 'aZ09');
	$userid = GETPOST('userid', 'int');
	$boxorder = GETPOST('boxorder', 'aZ09');
	$boxorder .= GETPOST('boxcombo', 'aZ09');

	$result = InfoBox::saveboxorder($db, $zone, $boxorder, $userid);
	if ($result > 0) setEventMessages($langs->trans("BoxAdded"), null);
}


/*
 * View
 */

if (!isset($form) || !is_object($form)) $form = new Form($db);

// Title
$title = $langs->trans("HomeArea").' - JMVD '.DOL_VERSION;
if (!empty($conf->global->MAIN_APPLICATION_TITLE)) 
{
	$title = $langs->trans("HomeArea").' - '.$conf->global->MAIN_APPLICATION_TITLE;
}

llxHeaderLayout('', $title, $title);


$resultboxes = FormOther::getBoxesArea($user, "0"); // Load $resultboxes (selectboxlist + boxactivated + boxlista + boxlistb)
//print_r($resultboxes);

print load_fiche_titre_layout('&nbsp;', $resultboxes['selectboxlist'], '', 0, '', 'titleforhome');


if (!empty($conf->global->MAIN_MOTD))
{
	$conf->global->MAIN_MOTD = preg_replace('/<br(\s[\sa-zA-Z_="]*)?\/?>/i', '<br>', $conf->global->MAIN_MOTD);
	if (!empty($conf->global->MAIN_MOTD))
	{
		$substitutionarray = getCommonSubstitutionArray($langs);
		complete_substitutions_array($substitutionarray, $langs);
		$texttoshow = make_substitutions($conf->global->MAIN_MOTD, $substitutionarray, $langs);

		print "\n<!-- Start of welcome text -->\n";
		print '<table width="100%" class="notopnoleftnoright"><tr><td>';
		print dol_htmlentitiesbr($texttoshow);
		print '</td></tr></table><br>';
		print "\n<!-- End of welcome text -->\n";
	}
}



/*
 * Dashboard Dolibarr states (statistics)
 * Hidden for external users
 */

$boxstatItems = array();
$boxstatFromHook = '';

// Load translation files required by page
$langs->loadLangs(array('commercial', 'bills', 'orders', 'contracts'));

// Load global statistics of objects
if (empty($user->socid) && empty($conf->global->MAIN_DISABLE_GLOBAL_BOXSTATS))
{
	$object = new stdClass();
	$parameters = array();
	$action = '';
	$reshook = $hookmanager->executeHooks('addStatisticLine', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
	$boxstatFromHook = $hookmanager->resPrint;

	if (empty($reshook))
	{
		// Cle array returned by the method load_state_board for each line
		$keys = array(
			'projects',
			'projects1',
			'projects2',
			'users',
			'members',
			'expensereports',
			'holidays',
			'customers',
			//'prospects',
			'suppliers',
			'contacts',
			'products',
			'services',
			
			'proposals',
			'orders',
			'invoices',
			'donations',
			'supplier_proposals',
			'supplier_orders',
			'supplier_invoices',
			'contracts',
			'interventions',
			//'ticket'
		);

		// Condition to be checked for each display line dashboard
		$conditions = array(
			'users' => $user->rights->user->user->lire,
			'members' => !empty($conf->adherent->enabled) && $user->rights->adherent->lire,
			'customers' => !empty($conf->societe->enabled) && $user->rights->societe->lire && empty($conf->global->SOCIETE_DISABLE_CUSTOMERS) && empty($conf->global->SOCIETE_DISABLE_CUSTOMERS_STATS),
			'prospects' => !empty($conf->societe->enabled) && $user->rights->societe->lire && empty($conf->global->SOCIETE_DISABLE_PROSPECTS) && empty($conf->global->SOCIETE_DISABLE_PROSPECTS_STATS),
			'suppliers' => !empty($conf->fournisseur->enabled) && $user->rights->fournisseur->lire && empty($conf->global->SOCIETE_DISABLE_SUPPLIERS_STATS),
			'contacts' => !empty($conf->societe->enabled) && $user->rights->societe->contact->lire,
			'products' => !empty($conf->product->enabled) && $user->rights->produit->lire,
			'services' => !empty($conf->service->enabled) && $user->rights->service->lire,
			'proposals' => !empty($conf->propal->enabled) && $user->rights->propale->lire,
			'orders' => !empty($conf->commande->enabled) && $user->rights->commande->lire,
			'invoices' => !empty($conf->facture->enabled) && $user->rights->facture->lire,
			'donations' => !empty($conf->don->enabled) && $user->rights->don->lire,
			'contracts' => !empty($conf->contrat->enabled) && $user->rights->contrat->lire,
			'interventions' => !empty($conf->ficheinter->enabled) && $user->rights->ficheinter->lire,
			'supplier_orders' => !empty($conf->supplier_order->enabled) && $user->rights->fournisseur->commande->lire && empty($conf->global->SOCIETE_DISABLE_SUPPLIERS_ORDERS_STATS),
			'supplier_invoices' => !empty($conf->supplier_invoice->enabled) && $user->rights->fournisseur->facture->lire && empty($conf->global->SOCIETE_DISABLE_SUPPLIERS_INVOICES_STATS),
			'supplier_proposals' => !empty($conf->supplier_proposal->enabled) && $user->rights->supplier_proposal->lire && empty($conf->global->SOCIETE_DISABLE_SUPPLIERS_PROPOSAL_STATS),
			'projects' => !empty($conf->projet->enabled) && $user->rights->projet->lire,
			'expensereports' => !empty($conf->expensereport->enabled) && $user->rights->expensereport->lire,
			'holidays' => !empty($conf->holiday->enabled) && $user->rights->holiday->read,
			'ticket' => !empty($conf->ticket->enabled) && $user->rights->ticket->read
		);
		// Class file containing the method load_state_board for each line
		$includes = array(
			'users' => DOL_DOCUMENT_ROOT."/user/class/user.class.php",
			'members' => DOL_DOCUMENT_ROOT."/adherents/class/adherent.class.php",
			'customers' => DOL_DOCUMENT_ROOT."/societe/class/client.class.php",
			'prospects' => DOL_DOCUMENT_ROOT."/societe/class/client.class.php",
			'suppliers' => DOL_DOCUMENT_ROOT."/fourn/class/fournisseur.class.php",
			'contacts' => DOL_DOCUMENT_ROOT."/contact/class/contact.class.php",
			'products' => DOL_DOCUMENT_ROOT."/product/class/product.class.php",
			'services' => DOL_DOCUMENT_ROOT."/product/class/product.class.php",
			'proposals' => DOL_DOCUMENT_ROOT."/comm/propal/class/propal.class.php",
			'orders' => DOL_DOCUMENT_ROOT."/commande/class/commande.class.php",
			'invoices' => DOL_DOCUMENT_ROOT."/compta/facture/class/facture.class.php",
			'donations' => DOL_DOCUMENT_ROOT."/don/class/don.class.php",
			'contracts' => DOL_DOCUMENT_ROOT."/contrat/class/contrat.class.php",
			'interventions' => DOL_DOCUMENT_ROOT."/fichinter/class/fichinter.class.php",
			'supplier_orders' => DOL_DOCUMENT_ROOT."/fourn/class/fournisseur.commande.class.php",
			'supplier_invoices' => DOL_DOCUMENT_ROOT."/fourn/class/fournisseur.facture.class.php",
			'supplier_proposals' => DOL_DOCUMENT_ROOT."/supplier_proposal/class/supplier_proposal.class.php",
			'projects' => DOL_DOCUMENT_ROOT."/projet/class/project.class.php",
			'expensereports' => DOL_DOCUMENT_ROOT."/expensereport/class/expensereport.class.php",
			'holidays' => DOL_DOCUMENT_ROOT."/holiday/class/holiday.class.php",
			'ticket' => DOL_DOCUMENT_ROOT."/ticket/class/ticket.class.php"
		);
		// Name class containing the method load_state_board for each line
		$classes = array(
			'users' => 'User',
			'members' => 'Adherent',
			'customers' => 'Client',
			'prospects' => 'Client',
			'suppliers' => 'Fournisseur',
			'contacts' => 'Contact',
			'products' => 'Product',
			'services' => 'ProductService',
			'proposals' => 'Propal',
			'orders' => 'Commande',
			'invoices' => 'Facture',
			'donations' => 'Don',
			'contracts' => 'Contrat',
			'interventions' => 'Fichinter',
			'supplier_orders' => 'CommandeFournisseur',
			'supplier_invoices' => 'FactureFournisseur',
			'supplier_proposals' => 'SupplierProposal',
			'projects' => 'Project',
			'expensereports' => 'ExpenseReport',
			'holidays' => 'Holiday',
			'ticket' => 'Ticket',
		);
		// Translation keyword
		$titres = array(
			'users' => "Users",
			'members' => "Members",
			'customers' => "ThirdPartyCustomersStats",
			'prospects' => "ThirdPartyProspectsStats",
			'suppliers' => "Suppliers",
			'contacts' => "Contacts",
			'products' => "Products",
			'services' => "Services",
			'proposals' => "CommercialProposalsShort",
			'orders' => "CustomersOrders",
			'invoices' => "BillsCustomers",
			'donations' => "Donations",
			'contracts' => "Contracts",
			'interventions' => "Interventions",
			'supplier_orders' => "SuppliersOrders",
			'supplier_invoices' => "SuppliersInvoices",
			'supplier_proposals' => "SupplierProposalShort",
			'projects' => "Leads",
			'expensereports' => "ExpenseReports",
			'holidays' => "Holidays",
			'ticket' => "Ticket",
		);
		// Dashboard Link lines
		$links = array(
			'users' => DOL_URL_ROOT.'/user/list.php',
			'members' => DOL_URL_ROOT.'/adherents/list.php?statut=1&mainmenu=members',
			'customers' => DOL_URL_ROOT.'/societe/list.php?type=c&mainmenu=companies',
			'prospects' => DOL_URL_ROOT.'/societe/list.php?type=p&mainmenu=companies',
			'suppliers' => DOL_URL_ROOT.'/societe/list.php?type=f&mainmenu=companies',
			'contacts' => DOL_URL_ROOT.'/contact/list.php?mainmenu=companies',
			'products' => DOL_URL_ROOT.'/product/list.php?type=0&mainmenu=products',
			'services' => DOL_URL_ROOT.'/product/list.php?type=1&mainmenu=products',
			'proposals' => DOL_URL_ROOT.'/comm/propal/list.php?mainmenu=commercial&leftmenu=propals',
			'orders' => DOL_URL_ROOT.'/commande/list.php?mainmenu=commercial&leftmenu=orders',
			'invoices' => DOL_URL_ROOT.'/compta/facture/list.php?mainmenu=billing&leftmenu=customers_bills',
			'donations' => DOL_URL_ROOT.'/don/list.php?leftmenu=donations',
			'contracts' => DOL_URL_ROOT.'/contrat/list.php?mainmenu=commercial&leftmenu=contracts',
			'interventions' => DOL_URL_ROOT.'/fichinter/list.php?mainmenu=commercial&leftmenu=ficheinter',
			'supplier_orders' => DOL_URL_ROOT.'/fourn/commande/list.php?mainmenu=commercial&leftmenu=orders_suppliers',
			'supplier_invoices' => DOL_URL_ROOT.'/fourn/facture/list.php?mainmenu=billing&leftmenu=suppliers_bills',
			'supplier_proposals' => DOL_URL_ROOT.'/supplier_proposal/list.php?mainmenu=commercial&leftmenu=',
			'projects' => DOL_URL_ROOT.'/projet/list.php?mainmenu=project',
			'expensereports' => DOL_URL_ROOT.'/expensereport/list.php?mainmenu=hrm&leftmenu=expensereport',
			'holidays' => DOL_URL_ROOT.'/holiday/list.php?mainmenu=hrm&leftmenu=holiday',
			'ticket' => DOL_URL_ROOT.'/ticket/list.php?leftmenu=ticket'
		);
		// Translation lang files
		$langfile = array(
			'customers' => "companies",
			'contacts' => "companies",
			'services' => "products",
			'proposals' => "propal",
			'invoices' => "bills",
			'supplier_orders' => "orders",
			'supplier_invoices' => "bills",
			'supplier_proposals' => 'supplier_proposal',
			'expensereports' => "trips",
			'holidays' => "holiday",
		);


		// Loop and displays each line of table
		$boardloaded = array();
		//echo '<pre>';print_r($keys); exit;
		foreach ($keys as $val)
		{
			if ($conditions[$val])
			{
				$boxstatItem = '';
				$class = $classes[$val];
				// Search in cache if load_state_board is already realized
				$classkeyforcache = $class;
				if ($classkeyforcache == 'ProductService') $classkeyforcache = 'Product'; // ProductService use same load_state_board than Product

				if (!isset($boardloaded[$classkeyforcache]) || !is_object($boardloaded[$classkeyforcache]))
				{
					include_once $includes[$val]; // Loading a class cost around 1Mb

					$board = new $class($db);
					$board->load_state_board();
					$boardloaded[$class] = $board;
				} else {
					$board = $boardloaded[$classkeyforcache];
				}

				$langs->load(empty($langfile[$val]) ? $val : $langfile[$val]);

				$text = $langs->trans($titres[$val]);
				$value = $board->nb[$val] ? $board->nb[$val] : "0";

				if($text == "Leads")
				{
					$text = "Open PO";
				}
				else if($text == "Users")
				{
					$text = "Invoice";
					$board->picto = 'project';
				}
				else if($text == "Customers")
				{
					$text = "Reject Invoice";
				}
				else if($text == "Contacts/Addresses")
				{
					$text = "Payable Invoice";
				}
				else if($text == "Products")
				{
					$text = "Pending Invoice";
				}


				$boxstatItem .= '<a href="'.$links[$val].'" class="boxstatsindicator thumbstat nobold nounderline">';
				$boxstatItem .= '<div class="boxstats boxstats-heading">';
				$boxstatItem .= '<span class="boxstatstext" title="'.dol_escape_htmltag($text).'">'.$text.'</span><br>';
				$boxstatItem .= '<span class="boxstatsindicator">'.img_object("", $board->picto, 'class="inline-block"').' '.$value.'</span>';
				$boxstatItem .= '</div>';
				$boxstatItem .= '</a>';

				$boxstatItems[$val] = $boxstatItem;
			}
		}
	}
}




// Dolibarr Working Board with weather

if (empty($conf->global->MAIN_DISABLE_GLOBAL_WORKBOARD)) {
	$showweather = (empty($conf->global->MAIN_DISABLE_METEO) || $conf->global->MAIN_DISABLE_METEO == 2) ? 1 : 0;

	//Array that contains all WorkboardResponse classes to process them
	$dashboardlines = array();

	// Do not include sections without management permission
	require_once DOL_DOCUMENT_ROOT.'/core/class/workboardresponse.class.php';

	// Number of actions to do (late)
	if (!empty($conf->agenda->enabled) && $user->rights->agenda->myactions->read) {
		include_once DOL_DOCUMENT_ROOT.'/comm/action/class/actioncomm.class.php';
		$board = new ActionComm($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of project opened
	if (!empty($conf->projet->enabled) && $user->rights->projet->lire) {
		include_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
		$board = new Project($db);
		$dashboardlines[$board->element] = $board->load_board($user);

		$board = new Project($db);
		$dashboardlines['project1'] = $board->load_pending_board($user);
	}

	// Number of tasks to do (late)
	if (!empty($conf->projet->enabled) && empty($conf->global->PROJECT_HIDE_TASKS) && $user->rights->projet->lire) {
		include_once DOL_DOCUMENT_ROOT.'/projet/class/task.class.php';
		$board = new Task($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of commercial proposals open (expired)
	if (!empty($conf->propal->enabled) && $user->rights->propale->lire) {
		include_once DOL_DOCUMENT_ROOT.'/comm/propal/class/propal.class.php';
		$board = new Propal($db);
		$dashboardlines[$board->element.'_opened'] = $board->load_board($user, "opened");
		// Number of commercial proposals CLOSED signed (billed)
		$dashboardlines[$board->element.'_signed'] = $board->load_board($user, "signed");
	}

	// Number of commercial proposals open (expired)
	if (!empty($conf->supplier_proposal->enabled) && $user->rights->supplier_proposal->lire) {
		include_once DOL_DOCUMENT_ROOT.'/supplier_proposal/class/supplier_proposal.class.php';
		$board = new SupplierProposal($db);
		$dashboardlines[$board->element.'_opened'] = $board->load_board($user, "opened");
		// Number of commercial proposals CLOSED signed (billed)
		$dashboardlines[$board->element.'_signed'] = $board->load_board($user, "signed");
	}

	// Number of customer orders a deal
	if (!empty($conf->commande->enabled) && $user->rights->commande->lire) {
		include_once DOL_DOCUMENT_ROOT.'/commande/class/commande.class.php';
		$board = new Commande($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of suppliers orders a deal
	if (!empty($conf->supplier_order->enabled) && $user->rights->fournisseur->commande->lire) {
		include_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.commande.class.php';
		$board = new CommandeFournisseur($db);
		$dashboardlines[$board->element.'_opened'] = $board->load_board($user, "opened");
		$dashboardlines[$board->element.'_awaiting'] = $board->load_board($user, 'awaiting');
	}

	// Number of contract / services enabled (delayed)
	if (!empty($conf->contrat->enabled) && $user->rights->contrat->lire) {
		include_once DOL_DOCUMENT_ROOT.'/contrat/class/contrat.class.php';
		$board = new Contrat($db);
		$dashboardlines[$board->element.'_inactive'] = $board->load_board($user, "inactive");
		// Number of active services (expired)
		$dashboardlines[$board->element.'_active'] = $board->load_board($user, "active");
	}

	// Number of tickets open
	if (!empty($conf->ticket->enabled) && $user->rights->ticket->read) {
		include_once DOL_DOCUMENT_ROOT.'/ticket/class/ticket.class.php';
		$board = new Ticket($db);
		$dashboardlines[$board->element.'_opened'] = $board->load_board($user, "opened");
		// Number of active services (expired)
		//$dashboardlines[$board->element.'_active'] = $board->load_board($user, "active");
	}

	// Number of invoices customers (paid)
	if (!empty($conf->facture->enabled) && $user->rights->facture->lire) {
		include_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
		$board = new Facture($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of supplier invoices (paid)
	if (!empty($conf->supplier_invoice->enabled) && !empty($user->rights->fournisseur->facture->lire)) {
		include_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.facture.class.php';
		$board = new FactureFournisseur($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of transactions to conciliate
	if (!empty($conf->banque->enabled) && $user->rights->banque->lire && !$user->socid) {
		include_once DOL_DOCUMENT_ROOT.'/compta/bank/class/account.class.php';
		$board = new Account($db);
		$nb = $board->countAccountToReconcile(); // Get nb of account to reconciliate
		if ($nb > 0) {
			$dashboardlines[$board->element] = $board->load_board($user);
		}
	}

	// Number of cheque to send
	if (!empty($conf->banque->enabled) && $user->rights->banque->lire && !$user->socid && empty($conf->global->BANK_DISABLE_CHECK_DEPOSIT)) {
		include_once DOL_DOCUMENT_ROOT.'/compta/paiement/cheque/class/remisecheque.class.php';
		$board = new RemiseCheque($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of foundation members
	if (!empty($conf->adherent->enabled) && $user->rights->adherent->lire && !$user->socid) {
		include_once DOL_DOCUMENT_ROOT.'/adherents/class/adherent.class.php';
		$board = new Adherent($db);
		$dashboardlines[$board->element.'_shift'] = $board->load_board($user, 'shift');
		$dashboardlines[$board->element.'_expired'] = $board->load_board($user, 'expired');
	}

	// Number of expense reports to approve
	if (!empty($conf->expensereport->enabled) && $user->rights->expensereport->approve) {
		include_once DOL_DOCUMENT_ROOT.'/expensereport/class/expensereport.class.php';
		$board = new ExpenseReport($db);
		$dashboardlines[$board->element.'_toapprove'] = $board->load_board($user, 'toapprove');
	}

	// Number of expense reports to pay
	if (!empty($conf->expensereport->enabled) && $user->rights->expensereport->to_paid) {
		include_once DOL_DOCUMENT_ROOT.'/expensereport/class/expensereport.class.php';
		$board = new ExpenseReport($db);
		$dashboardlines[$board->element.'_topay'] = $board->load_board($user, 'topay');
	}

	// Number of holidays to approve
	if (!empty($conf->holiday->enabled) && $user->rights->holiday->approve) {
		include_once DOL_DOCUMENT_ROOT.'/holiday/class/holiday.class.php';
		$board = new Holiday($db);
		$dashboardlines[$board->element] = $board->load_board($user);
	}

	// Number of Customer
	if (!empty($user->rights->societe->creer) && $user->rights->societe->lire) {
		include_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
		$board = new Societe($db);
		$dashboardlines['societe'] = $board->load_board($user);

		
	}

	// Number of Pending Customer
	if (!empty($user->rights->societe->creer) && $user->rights->societe->lire) {
		include_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
		$board = new Societe($db);
		$dashboardlines['societe1'] = $board->load_pending_board($user);

		
	}

	$object = new stdClass();
	$parameters = array();
	$action = '';
	$reshook = $hookmanager->executeHooks('addOpenElementsDashboardLine', $parameters, $object,
		$action); // Note that $action and $object may have been modified by some hooks
	if ($reshook == 0) {
		$dashboardlines = array_merge($dashboardlines, $hookmanager->resArray);
	}

	/* Open object dashboard */
	$dashboardgroup = array(
		'action' =>
			array(
				'groupName' => 'Agenda',
				'typeName' => 'Agenda',
				'stats' => array('action'),
			),
		'project' =>
			array(
				'groupName' => 'Leads',
				'typeName' => 'Open Ticket',
				'globalStatsKey' => 'projects',
				'stats' => array('project', 'project_task'),
			),
		'project1' =>
			array(
				'groupName' => 'Leads1',
				'typeName' => 'Pending Ticket',
				'globalStatsKey' => 'projects',
				'stats' => array('project1', 'project_task'),
			),
		'project2' =>
			array(
				'groupName' => 'Leads2',
				'typeName' => 'Overdue Ticket',
				'globalStatsKey' => 'projects',
				'stats' => array('project', 'project_task'),
			),
		'propal' =>
			array(
				'groupName' => 'Proposals',
				'typeName' => 'Proposals',
				'globalStatsKey' => 'proposals',
				'stats' =>
					array('propal_opened', 'propal_signed'),
			),
		'commande' =>
			array(
				'groupName' => 'Orders',
				'typeName' => 'Orders',
				'globalStatsKey' => 'orders',
				'stats' =>
					array('commande'),
			),
		'facture' =>
			array(
				'groupName' => 'Invoices',
				'typeName' => 'Invoices',
				'globalStatsKey' => 'invoices',
				'stats' =>
					array('facture'),
			),
		'supplier_proposal' =>
			array(
				'groupName' => 'SupplierProposals',
				'typeName' => 'SupplierProposals',
				'globalStatsKey' => 'askprice',
				'stats' =>
					array('supplier_proposal_opened', 'supplier_proposal_signed'),
			),
		'order_supplier' =>
			array(
				'groupName' => 'SuppliersOrders',
				'typeName' => 'SuppliersOrders',
				'globalStatsKey' => 'supplier_orders',
				'stats' =>
					array('order_supplier_opened', 'order_supplier_awaiting'),
			),
		'invoice_supplier' =>
			array(
				'groupName' => 'BillsSuppliers',
				'typeName' => 'BillsSuppliers',
				'globalStatsKey' => 'supplier_invoices',
				'stats' =>
					array('invoice_supplier'),
			),
		'contrat' =>
			array(
				'groupName' => 'Contracts',
				'typeName' => 'Contracts',
				'globalStatsKey' => 'Contracts',
				'stats' =>
				array('contrat_inactive', 'contrat_active'),
			),
		'project3' =>
			array(
				'groupName' => 'Leads2',
				'typeName' => 'Total Ticket',
				'globalStatsKey' => 'projects',
				'stats' => array('project', 'project_task'),
			),
		'ticket' =>
			array(
				'groupName' => 'Tickets',
				'typeName' => 'AMC',
				'globalStatsKey' => 'ticket',
				'stats' =>
					array('ticket_opened'),
			),
		'ticket2' =>
			array(
				'groupName' => 'Tickets',
				'typeName' => '--',
				'globalStatsKey' => 'ticket',
				'stats' =>
					array('ticket_opened'),
			),
		'bank_account' =>
			array(
				'groupName' => 'BankAccount',
				'typeName' => 'BankAccount',
				'stats' =>
					array('bank_account', 'chequereceipt'),
			),
		'member' =>
			array(
				'groupName' => 'Members',
				'typeName' => 'Members',
				'globalStatsKey' => 'members',
				'stats' =>
					array('member_shift', 'member_expired'),
			),
		'expensereport' =>
			array(
				'groupName' => 'ExpenseReport',
				'typeName' => 'ExpenseReport',
				'globalStatsKey' => 'expensereports',
				'stats' =>
					array('expensereport_toapprove', 'expensereport_topay'),
			),
		'holiday' =>
			array(
				'groupName' => 'Holidays',
				'typeName' => 'Holidays',
				'globalStatsKey' => 'holidays',
				'stats' =>
					array('holiday'),
			),
		'societe' =>
			array(
				'groupName' => 'totalcustomer',
				'typeName' => 'Total Customers',
				'globalStatsKey' => 'societe',
				'stats' => array('societe'),
			),
		'societe1' =>
			array(
				'groupName' => 'pendingcustomers',
				'typeName' => 'Pending Customer',
				'globalStatsKey' => 'pendingcustomers',
				'stats' =>
					 array('societe1'),
			),	
	);

	//exit;
	$object = new stdClass();
	$parameters = array(
		'dashboardgroup' => $dashboardgroup
	);
	$reshook = $hookmanager->executeHooks('addOpenElementsDashboardGroup', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
	if ($reshook == 0) {
		$dashboardgroup = array_merge($dashboardgroup, $hookmanager->resArray);
	}
	/*echo '<pre>';
	print_r($dashboardlines);*/
	// Calculate total nb of late
	$totallate = $totaltodo = 0;

	//Remove any invalid response
	//load_board can return an integer if failed or WorkboardResponse if OK
	$valid_dashboardlines = array();
	foreach ($dashboardlines as $workboardid => $tmp) {
		if ($tmp instanceof WorkboardResponse) {
			$tmp->id = $workboardid; // Complete the object to add its id into its name
			$valid_dashboardlines[$workboardid] = $tmp;
		}
	}

	// We calculate $totallate. Must be defined before start of next loop because it is show in first fetch on next loop
	foreach ($valid_dashboardlines as $board) {
		if ($board->nbtodolate > 0) {
			$totaltodo += $board->nbtodo;
			$totallate += $board->nbtodolate;
		}
	}

	$openedDashBoardSize = 'info-box-sm'; // use sm by default
	foreach ($dashboardgroup as $dashbordelement) {
		if (is_array($dashbordelement['stats']) && count($dashbordelement['stats']) > 2) {
			$openedDashBoardSize = ''; // use default info box size : big
			break;
		}
	}

	$totalLateNumber = $totallate;
	$totallatePercentage = ((!empty($totaltodo)) ? round($totallate / $totaltodo * 100, 2) : 0);
	if (!empty($conf->global->MAIN_USE_METEO_WITH_PERCENTAGE)) {
		$totallate = $totallatePercentage;
	}

	$boxwork = '';
	$boxwork .= '<div class="box">';
	$boxwork .= '<table summary="'.dol_escape_htmltag($langs->trans("WorkingBoard")).'" class="noborder boxtable boxtablenobottom boxworkingboard" width="100%">'."\n";
	$boxwork .= '<tr class="liste_titre">';
	$boxwork .= '<th class="liste_titre"><div class="inline-block valignmiddle">'.$langs->trans("DolibarrWorkBoard").'</div>';
	if ($showweather) {
		if ($totallate > 0) {
			$text = $langs->transnoentitiesnoconv("WarningYouHaveAtLeastOneTaskLate").' ('.$langs->transnoentitiesnoconv("NActionsLate",
					$totallate.(!empty($conf->global->MAIN_USE_METEO_WITH_PERCENTAGE) ? '%' : '')).')';
		} else {
			$text = $langs->transnoentitiesnoconv("NoItemLate");
		}
		$text .= '. '.$langs->transnoentitiesnoconv("LateDesc");
		//$text.=$form->textwithpicto('',$langs->trans("LateDesc"));
		$options = 'height="24px" style="float: right"';
		$boxwork .= showWeather($totallate, $text, $options, 'inline-block valignmiddle');
	}
	$boxwork .= '</th>';
	$boxwork .= '</tr>'."\n";



	// Show dashboard
	$nbworkboardempty = 0;
	$isIntopOpenedDashBoard = $globalStatInTopOpenedDashBoard = array();
	if (!empty($valid_dashboardlines)) {
		$openedDashBoard = '';

		$boxwork .= '<tr class="nobottom nohover"><td class="tdboxstats nohover flexcontainer centpercent"><div style="display: flex: flex-wrap: wrap">';

		foreach ($dashboardgroup as $groupKey => $groupElement) {
			$boards = array();
			if (empty($conf->global->MAIN_DISABLE_NEW_OPENED_DASH_BOARD)) {
				foreach ($groupElement['stats'] as $infoKey) {
					if (!empty($valid_dashboardlines[$infoKey])) {
						$boards[] = $valid_dashboardlines[$infoKey];
						$isIntopOpenedDashBoard[] = $infoKey;
					}
				}
			}


			if (!empty($boards)) {
				$groupName = $langs->trans($groupElement['groupName']);
				$typeName = $langs->trans($groupElement['typeName']);
				$groupKeyLowerCase = strtolower($groupKey);
				$nbTotalForGroup = 0;

				// global stats
				$globalStatsKey = false;
				if (!empty($groupElement['globalStatsKey']) && empty($groupElement['globalStats'])) { // can be filled by hook
					$globalStatsKey = $groupElement['globalStatsKey'];
					$groupElement['globalStats'] = array();

					if (is_array($keys) && in_array($globalStatsKey, $keys))
					{
						// get key index of stats used in $includes, $classes, $keys, $icons, $titres, $links
						$keyIndex = array_search($globalStatsKey, $keys);

						$classe = $classes[$keyIndex];
						if (isset($boardloaded[$classe]) && is_object($boardloaded[$classe]))
						{
							$groupElement['globalStats']['total'] = $boardloaded[$classe]->nb[$globalStatsKey] ? $boardloaded[$classe]->nb[$globalStatsKey] : 0;
							$nbTotal = doubleval($groupElement['globalStats']['total']);
							if ($nbTotal >= 10000) { $nbTotal = round($nbTotal / 1000, 2).'k'; }
							$groupElement['globalStats']['text'] = $langs->trans('Total').' : '.$langs->trans($titres[$keyIndex]).' ('.$groupElement['globalStats']['total'].')';
							$groupElement['globalStats']['total'] = $nbTotal;
							$groupElement['globalStats']['link'] = $links[$keyIndex];
						}
					}
				}

				$openedDashBoard .= '<div class="box-flex-item"><div class="box-flex-item-with-margin bg-'.$groupKeyLowerCase.'">'."\n";
				$openedDashBoard .= '	<div class="info-box '.$openedDashBoardSize.'">'."\n";
				
				$openedDashBoard .= '<div class="info-box-content">'."\n";

				$openedDashBoard .= '<div class="info-box-title" title="'.strip_tags($typeName).'">'.$typeName.'</div>'."\n";
				$openedDashBoard .= '<div class="info-box-lines">'."\n";

				foreach ($boards as $board) {
					if($board->label == "Open tasks")
					{

					}
					else
					{
						if($typeName == "Total Customers")
						{
							$infoName = 'Total';
							$openedDashBoard .= '<a href="'.$board->url.'" class="info-box-text info-box-text-a">'.$infoName.' : ';

							$textPending = '';
							$textPendingTitle = 'Total Customer';
							$textPending .= '<span title="'.dol_escape_htmltag($textPendingTitle).'" class="classfortooltip badge badge-primary">';
							$textPending .= '<i class="fa fa-exclamation-triangle"></i> '.$board->nbtodo;
							$textPending .= '</span>';
							
							$openedDashBoard .= $textPending;
							$openedDashBoard .= '</a>'."\n";
						}

						if($typeName == "Pending Customer")
						{
							$infoName = 'Pending';
							$openedDashBoard .= '			<a href="'.$board->url.'" class="info-box-text info-box-text-a">'.$infoName.' : ';

							$textPending = '';
							$textPendingTitle = 'Total Customer';
							$textPending .= '<span title="'.dol_escape_htmltag($textPendingTitle).'" class="classfortooltip badge badge-primary">';
							$textPending .= '<i class="fa fa-exclamation-triangle"></i> '.$board->nbtodo;
							$textPending .= '</span>';
							
							$openedDashBoard .= $textPending;
							$openedDashBoard .= '</a>'."\n";
						}
						if($typeName == "Pending Ticket")
						{
							$infoName = 'Pending';
							$openedDashBoard .= '			<a href="'.$board->url.'" class="info-box-text info-box-text-a">'.$infoName.' : ';

							$textPending = '';
							$textPendingTitle = 'Draft Tickets';
							$textPending .= '<span title="'.dol_escape_htmltag($textPendingTitle).'" class="classfortooltip badge badge-primary">';
							$textPending .= '<i class="fa fa-exclamation-triangle"></i> '.$board->pending;
							$textPending .= '</span>';
							
							$openedDashBoard .= $textPending;
							$openedDashBoard .= '</a>'."\n";
						}
						else
						{
							$openedDashBoard .= '<div class="info-box-line">';

							if (!empty($board->labelShort)) {
								$infoName = '<span title="'.$board->label.'">'.$board->labelShort.'</span>';
							} else {
								$infoName = $board->label;
							}

							$textLateTitle = $langs->trans("NActionsLate", $board->nbtodolate);
							$textLateTitle .= ' ('.$langs->trans("Late").' = '.$langs->trans("DateReference").' > '.$langs->trans("DateToday").' '.(ceil($board->warning_delay) >= 0 ? '+' : '').ceil($board->warning_delay).' '.$langs->trans("days").')';

							if ($board->id == 'bank_account') {
								$textLateTitle .= '<br><span class="opacitymedium">'.$langs->trans("IfYouDontReconcileDisableProperty", $langs->transnoentitiesnoconv("Conciliable")).'</span>';
							}

							$textLate = '';
							if ($board->nbtodolate > 0) {
								$textLate .= '<span title="'.dol_escape_htmltag($textLateTitle).'" class="classfortooltip badge badge-warning">';
								$textLate .= '<i class="fa fa-exclamation-triangle"></i> '.$board->nbtodolate;
								$textLate .= '</span>';
							}

							$nbtodClass = '';
							if ($board->nbtodo > 0) {
								$nbtodClass = 'badge badge-info';
							}

							if($typeName == "Open Ticket")
							{
								$openedDashBoard .= '			<a href="'.$board->url.'" class="info-box-text info-box-text-a">'.$infoName.' : ';

							
								$openedDashBoard .= '			<span class="'.$nbtodClass.' classfortooltip" title="'.$board->label.'" >'.$board->nbtodo.'</span>';
								$openedDashBoard .= '</a>'."\n";
							}
							if ($typeName == "Overdue Ticket") {
								$infoName = 'Overdue';
								$openedDashBoard .= '			<a href="#">'.$infoName.' : ';

								if ($board->url_late) {
									$openedDashBoard .= ' <a href="'.$board->url_late.'" class="info-box-text info-box-text-a paddingleft">';
								} else {
									$openedDashBoard .= ' 0 ';
								}
								$openedDashBoard .= $textLate;
								$openedDashBoard .= '</a>'."\n";
							}
							

							if($typeName == "Total Ticket")
							{
								$textTotal = '';
								$infoName = 'Total';
								$openedDashBoard .= '<a href="'.$board->url.'" class="info-box-text info-box-text-a">'.$infoName.' : ';

								$textTotal .= '<span title="'.dol_escape_htmltag($texTotalTitle).'" class="classfortooltip badge badge-success">';
								$textTotal .= '<i class="fa fa-exclamation-triangle"></i> '.($board->nbtodo + $board->nbtodolate + $board->pending);
								$textTotal .= '</span>';
								$openedDashBoard .= $textTotal;
								$openedDashBoard .= '</a>'."\n";
							}

							if ($board->total > 0 && !empty($conf->global->MAIN_WORKBOARD_SHOW_TOTAL_WO_TAX)) {
								$openedDashBoard .= '<a href="'.$board->url.'" class="info-box-text">'.$langs->trans('Total').' : '.price($board->total).'</a>';
							}
							$openedDashBoard .= '</div>'."\n";
						}
					}
				}

				// TODO Add hook here to add more "info-box-line"

				$openedDashBoard .= '		</div><!-- /.info-box-lines --></div><!-- /.info-box-content -->'."\n";

				$openedDashBoard .= '		<span class="info-box-icon bg-infobox-'.$groupKeyLowerCase.'">'."\n";
				$openedDashBoard .= '		<i class="fa fa-dol-'.$groupKeyLowerCase.'"></i>'."\n";

				// Show the span for the total of record
				if (!empty($groupElement['globalStats'])) {
					$globalStatInTopOpenedDashBoard[] = $globalStatsKey;
					$openedDashBoard .= '<span class="info-box-icon-text" title="'.$groupElement['globalStats']['text'].'">'.$nbTotal.'</span>';
				}

				$openedDashBoard .= '</span> <!-- info-box-icon -->'."\n";

				$openedDashBoard .= '	</div><!-- /.info-box -->'."\n";
				$openedDashBoard .= '</div><!-- /.box-flex-item-with-margin -->'."\n";
				$openedDashBoard .= '</div><!-- /.box-flex-item -->'."\n";
				$openedDashBoard .= "\n";
			}
		}

		if ($showweather && !empty($isIntopOpenedDashBoard)) {
			$appendClass = $conf->global->MAIN_DISABLE_METEO == 2 ? ' hideonsmartphone' : '';
			$weather = getWeatherStatus($totallate);

			$text = '';
			if ($totallate > 0) {
				$text = $langs->transnoentitiesnoconv("WarningYouHaveAtLeastOneTaskLate").' ('.$langs->transnoentitiesnoconv("NActionsLate",
						$totallate.(!empty($conf->global->MAIN_USE_METEO_WITH_PERCENTAGE) ? '%' : '')).')';
			} else {
				$text = $langs->transnoentitiesnoconv("NoItemLate");
			}
			$text .= '. '.$langs->transnoentitiesnoconv("LateDesc");

			/*$weatherDashBoard = '<div class="box-flex-item '.$appendClass.'"><div class="box-flex-item-with-margin">'."\n";
			$weatherDashBoard .= '	<div class="info-box '.$openedDashBoardSize.' info-box-weather info-box-weather-level'.$weather->level.'">'."\n";
			$weatherDashBoard .= '		<span class="info-box-icon">';
			$weatherDashBoard .= img_weather('', $weather->level, '', 0, 'valignmiddle width50');
			$weatherDashBoard .= '       </span>'."\n";
			$weatherDashBoard .= '		<div class="info-box-content">'."\n";
			$weatherDashBoard .= '			<div class="info-box-title">'.$langs->trans('GlobalOpenedElemView').'</div>'."\n";

			if ($totallatePercentage > 0 && !empty($conf->global->MAIN_USE_METEO_WITH_PERCENTAGE)) {
				$weatherDashBoard .= '			<span class="info-box-number">'.$langs->transnoentitiesnoconv("NActionsLate",
						price($totallatePercentage).'%').'</span>'."\n";
				$weatherDashBoard .= '			<span class="progress-description">'.$langs->trans('NActionsLate',
						$totalLateNumber).'</span>'."\n";
			} else {
				$weatherDashBoard .= '			<span class="info-box-number">'.$langs->transnoentitiesnoconv("NActionsLate",
						$totalLateNumber).'</span>'."\n";
				if ($totallatePercentage > 0) {
					$weatherDashBoard .= '			<span class="progress-description">'.$langs->trans('NActionsLate',
							price($totallatePercentage).'%').'</span>'."\n";
				}
			}

			$weatherDashBoard .= '		</div><!-- /.info-box-content -->'."\n";
			$weatherDashBoard .= '	</div><!-- /.info-box -->'."\n";
			$weatherDashBoard .= '</div><!-- /.box-flex-item-with-margin -->'."\n";
			$weatherDashBoard .= '</div><!-- /.box-flex-item -->'."\n";*/
			$weatherDashBoard .= "\n";

			$openedDashBoard = $weatherDashBoard.$openedDashBoard;
		}

		if (!empty($isIntopOpenedDashBoard)) {
			for ($i = 1; $i <= 10; $i++) {
				//$openedDashBoard .= '<div class="box-flex-item filler"></div>';
			}
		}

		$nbworkboardcount = 0;
		foreach ($valid_dashboardlines as $infoKey => $board) {
			if (in_array($infoKey, $isIntopOpenedDashBoard)) {
				// skip if info is present on top
				continue;
			}

			if (empty($board->nbtodo)) {
				$nbworkboardempty++;
			}
			$nbworkboardcount++;


			$textlate = $langs->trans("NActionsLate", $board->nbtodolate);
			$textlate .= ' ('.$langs->trans("Late").' = '.$langs->trans("DateReference").' > '.$langs->trans("DateToday").' '.(ceil($board->warning_delay) >= 0 ? '+' : '').ceil($board->warning_delay).' '.$langs->trans("days").')';


			$boxwork .= '<div class="boxstatsindicator thumbstat150 nobold nounderline"><div class="boxstats130 boxstatsborder">';
			$boxwork .= '<div class="boxstatscontent">';
			$boxwork .= '<span class="boxstatstext" title="'.dol_escape_htmltag($board->label).'">'.$board->img.' <span>'.$board->label.'</span></span><br>';
			$boxwork .= '<a class="valignmiddle dashboardlineindicator" href="'.$board->url.'"><span class="dashboardlineindicator'.(($board->nbtodo == 0) ? ' dashboardlineok' : '').'">'.$board->nbtodo.'</span></a>';
			if ($board->total > 0 && !empty($conf->global->MAIN_WORKBOARD_SHOW_TOTAL_WO_TAX)) {
				$boxwork .= '&nbsp;/&nbsp;<a class="valignmiddle dashboardlineindicator" href="'.$board->url.'"><span class="dashboardlineindicator'.(($board->nbtodo == 0) ? ' dashboardlineok' : '').'">'.price($board->total).'</span></a>';
			}
			$boxwork .= '</div>';
			if ($board->nbtodolate > 0) {
				$boxwork .= '<div class="dashboardlinelatecoin nowrap">';
				$boxwork .= '<a title="'.dol_escape_htmltag($textlate).'" class="valignmiddle dashboardlineindicatorlate'.($board->nbtodolate > 0 ? ' dashboardlineko' : ' dashboardlineok').'" href="'.((!$board->url_late) ? $board->url : $board->url_late).'">';
				//$boxwork .= img_picto($textlate, "warning_white", 'class="valigntextbottom"').'';
				$boxwork .= img_picto($textlate, "warning_white",
						'class="inline-block hideonsmartphone valigntextbottom"').'';
				$boxwork .= '<span class="dashboardlineindicatorlate'.($board->nbtodolate > 0 ? ' dashboardlineko' : ' dashboardlineok').'">';
				$boxwork .= $board->nbtodolate;
				$boxwork .= '</span>';
				$boxwork .= '</a>';
				$boxwork .= '</div>';
			}
			$boxwork .= '</div></div>';
			$boxwork .= "\n";
		}

		$boxwork .= '<div class="boxstatsindicator thumbstat150 nobold nounderline"><div class="boxstats150empty"></div></div>';
		$boxwork .= '<div class="boxstatsindicator thumbstat150 nobold nounderline"><div class="boxstats150empty"></div></div>';
		$boxwork .= '<div class="boxstatsindicator thumbstat150 nobold nounderline"><div class="boxstats150empty"></div></div>';
		$boxwork .= '<div class="boxstatsindicator thumbstat150 nobold nounderline"><div class="boxstats150empty"></div></div>';

		$boxwork .= '</div>';
		$boxwork .= '</td></tr>';
	} else {
		$boxwork .= '<tr class="nohover">';
		$boxwork .= '<td class="nohover valignmiddle opacitymedium">';
		$boxwork .= $langs->trans("NoOpenedElementToProcess");
		$boxwork .= '</td>';
		$boxwork .= '</tr>';
	}

	$boxwork .= '</td></tr>';

	$boxwork .= '</table>'; // End table array of working board
	$boxwork .= '</div>';

	if(1 == 2)//$user->admin)
	{
		print '
		<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class="container">
				<!--Begin::Row-->
				<div class="row">
					<div class="col-xl-3">
						<!--begin::Stats Widget 13-->
						<a href="#" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
							<!--begin::Body-->
							<div class="card-body">
								<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
									<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Shopping/Cart3.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
											<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg>
									<!--end::Svg Icon-->
									
									<!--end::Svg Icon-->
								</span>
								<div class="font-weight-bold text-inverse-danger font-size-h1">2</div>
								<div class="text-inverse-danger font-weight-bolder font-size-h6 mb-2 mt-5">Open Leads</div>
							</div>
							<!--end::Body-->
						</a>
						<!--end::Stats Widget 13-->
					</div>
					<div class="col-xl-3">
						<!--begin::Stats Widget 14-->
						<a href="#" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
							<!--begin::Body-->
							<div class="card-body">
								<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
									<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
											<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
								<div class="font-weight-bold text-inverse-danger font-size-h1">3</div>
								<div class="text-inverse-primary font-weight-bolder font-size-h6 mb-2 mt-5">Close Leads</div>
							</div>
							<!--end::Body-->
						</a>
						<!--end::Stats Widget 14-->
					</div>
					<div class="col-xl-3">
						<!--begin::Stats Widget 15-->
						<a href="#" class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
							<!--begin::Body-->
							<div class="card-body">
								<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
									<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
											<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
											<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
											<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
								<div class="font-weight-bold text-inverse-danger font-size-h1">3</div>
								<div class="text-inverse-primary font-weight-bolder font-size-h6 mb-2 mt-5">Overdue Leads</div>
							</div>
							<!--end::Body-->
						</a>
						<!--end::Stats Widget 15-->
					</div>
					<div class="col-xl-3">
						<!--begin::Stats Widget 15-->
						<a href="#" class="card card-custom bg-info bg-hover-state-info card-stretch card-stretch gutter-b">
							<!--begin::Body-->
							<div class="card-body">
								<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
									<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
											<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
											<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
											<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
								<div class="font-weight-bold text-inverse-danger font-size-h1">2</div>
								<div class="text-inverse-primary font-weight-bolder font-size-h6 mb-2 mt-5">Technician</div>
							</div>
							<!--end::Body-->
						</a>
						<!--end::Stats Widget 15-->
					</div>
				</div>
				<!--End::Row-->
			</div>
		</div>';
	}

	if (!empty($isIntopOpenedDashBoard)) {
		print '<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class="container">';
				print '<div class="fichecenter">';
				print '<div class="opened-dash-board-wrap"><div class="box-flex-container">'.$openedDashBoard.'</div></div>';
				print '</div>';
			print '</div>';
		print '</div>';
	}
}


print '<div class="clearboth"></div>';

print '<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class="container">';

print '<div class="fichecenter fichecenterbis">';


/*
 * Show widgets (boxes)
 */

$boxlist .= '<div class="twocolumns">';

$boxlist .= '<div class="firstcolumn" id="boxhalfleft">';
if (!empty($nbworkboardcount))
{
	$boxlist .= $boxwork;
}

$boxlist .= $resultboxes['boxlista'];

$boxlist .= '</div>';

// For graph view
if (empty($user->socid) && empty($conf->global->MAIN_DISABLE_GLOBAL_BOXSTATS))
{
	// Remove allready present info in new dash board
	if (!empty($conf->global->MAIN_INCLUDE_GLOBAL_STATS_IN_OPENED_DASHBOARD) && is_array($boxstatItems) && count($boxstatItems) > 0) {
		foreach ($boxstatItems as $boxstatItemKey => $boxstatItemHtml) {
			if (in_array($boxstatItemKey, $globalStatInTopOpenedDashBoard)) {
				unset($boxstatItems[$boxstatItemKey]);
			}
		}
	}

	if (!empty($boxstatFromHook) || !empty($boxstatItems)) {
		$boxstat .= '<!-- Database statistics -->'."\n";
		$boxstat .= '<div class="box boxdraggable card card-custom card-stretch gutter-b">';
		$boxstat .= '<div class="card-header border-0 pt-5"><h3 class="card-title font-weight-bolder">'.$langs->trans("DolibarrStateBoard").'</h3>';
		$boxstat .= '</div><div class="card-body d-flex flex-column">';
		$boxstat .= '<table summary="'.dol_escape_htmltag($langs->trans("DolibarrStateBoard")).'" class="table table-bordered table-checkable">';
		$boxstat .= '<tr class=""><td class="">';

		$boxstat .= $boxstatFromHook;

		if (is_array($boxstatItems) && count($boxstatItems) > 0)
		{
			$boxstat .= implode('', $boxstatItems);
		}

		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';
		$boxstat .= '<a class="boxstatsindicator thumbstat nobold nounderline"><div class="boxstatsempty"></div></a>';

		$boxstat .= '</td></tr>';
		$boxstat .= '</table>';
		$boxstat .= '</div></div>';


		// Graph here
		$boxstat .= '<div class="box boxdraggable card card-custom card-stretch gutter-b">';
		$boxstat .= '
						<div class="card-header">
							<div class="card-title">
								<h3 class="card-label">Analytics</h3>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<h5>RT Graph</h5>
									<div id="kt_amcharts_11" style="height: 500px;"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<h4>RS Graph</h4>
									<div id="kt_amcharts_12" style="height: 500px;"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<h4>TAT Graph</h4>
									<div id="kt_amcharts_10" style="height: 500px;"></div>
								</div>
							</div>
						</div>
					</div>';
	}
}

$boxlist .= '<div class=" boxhalfright" id="boxhalfright">';

$boxlist .= $boxstat;
$boxlist .= $resultboxes['boxlistb'];

$boxlist .= '</div>';
$boxlist .= "\n";

$boxlist .= '</div>';


print $boxlist;

print '</div>';

print '</div>';
print '</div>';



/*
 * Show security warnings
 */

// Security warning repertoire install existe (si utilisateur admin)
if ($user->admin && empty($conf->global->MAIN_REMOVE_INSTALL_WARNING))
{
	$message = '';

	// Check if install lock file is present
	$lockfile = DOL_DATA_ROOT.'/install.lock';
	if (!empty($lockfile) && !file_exists($lockfile) && is_dir(DOL_DOCUMENT_ROOT."/install"))
	{
		$langs->load("errors");
		//if (! empty($message)) $message.='<br>';
		$message .= info_admin($langs->trans("WarningLockFileDoesNotExists", DOL_DATA_ROOT).' '.$langs->trans("WarningUntilDirRemoved", DOL_DOCUMENT_ROOT."/install"), 0, 0, '1', 'clearboth');
	}

	// Conf files must be in read only mode
	if (is_writable($conffile))
	{
		$langs->load("errors");
		//$langs->load("other");
		//if (! empty($message)) $message.='<br>';
		$message .= info_admin($langs->transnoentities("WarningConfFileMustBeReadOnly").' '.$langs->trans("WarningUntilDirRemoved", DOL_DOCUMENT_ROOT."/install"), 0, 0, '1', 'clearboth');
	}

	if ($message)
	{
		print $message;
		//$message.='<br>';
		//print info_admin($langs->trans("WarningUntilDirRemoved",DOL_DOCUMENT_ROOT."/install"));
	}
}

//print 'mem='.memory_get_usage().' - '.memory_get_peak_usage();

// End of page
llxFooterLayout();

print '
<!--begin::Page Vendors Styles(used by this page)-->
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/boxes-search.js?v=7.2.0"></script>

<!--begin::Page Vendors(used by this page)-->
<script src="//www.amcharts.com/lib/3/amcharts.js"></script>
<script src="//www.amcharts.com/lib/3/serial.js"></script>
<script src="//www.amcharts.com/lib/3/radar.js"></script>
<script src="//www.amcharts.com/lib/3/pie.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js"></script>

<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/amcharts-charts.js?v=7.2.0"></script>
<!--end::Page Vendors-->';

$db->close();


/**
 *  Show weather logo. Logo to show depends on $totallate and values for
 *  $conf->global->MAIN_METEO_LEVELx
 *
 *  @param      int     $totallate      Nb of element late
 *  @param      string  $text           Text to show on logo
 *  @param      string  $options        More parameters on img tag
 *  @param      string  $morecss        More CSS
 *  @return     string                  Return img tag of weather
 */
function showWeather($totallate, $text, $options, $morecss = '')
{
	global $conf;

	$weather = getWeatherStatus($totallate);
	return img_weather($text, $weather->picto, $options, 0, $morecss);
}


/**
 *  get weather level
 *  $conf->global->MAIN_METEO_LEVELx
 *
 *  @param      int     $totallate      Nb of element late
 *  @return     string                  Return img tag of weather
 */
function getWeatherStatus($totallate)
{
	global $conf;

	$weather = new stdClass();
	$weather->picto = '';

	$offset = 0;
	$factor = 10; // By default

	$used_conf = !empty($conf->global->MAIN_USE_METEO_WITH_PERCENTAGE) ? 'MAIN_METEO_PERCENTAGE_LEVEL' : 'MAIN_METEO_LEVEL';

	$level0 = $offset;
	$weather->level = 0;
	if (!empty($conf->global->{$used_conf.'0'})) {
		$level0 = $conf->global->{$used_conf.'0'};
	}
	$level1 = $offset + 1 * $factor;
	if (!empty($conf->global->{$used_conf.'1'})) {
		$level1 = $conf->global->{$used_conf.'1'};
	}
	$level2 = $offset + 2 * $factor;
	if (!empty($conf->global->{$used_conf.'2'})) {
		$level2 = $conf->global->{$used_conf.'2'};
	}
	$level3 = $offset + 3 * $factor;
	if (!empty($conf->global->{$used_conf.'3'})) {
		$level3 = $conf->global->{$used_conf.'3'};
	}

	if ($totallate <= $level0) {
		$weather->picto = 'weather-clear.png';
		$weather->level = 0;
	}
	elseif ($totallate <= $level1) {
		$weather->picto = 'weather-few-clouds.png';
		$weather->level = 1;
	}
	elseif ($totallate <= $level2) {
		$weather->picto = 'weather-clouds.png';
		$weather->level = 2;
	}
	elseif ($totallate <= $level3) {
		$weather->picto = 'weather-many-clouds.png';
		$weather->level = 3;
	}
	else {
		$weather->picto = 'weather-storm.png';
		$weather->level = 4;
	}

	return $weather;
}
