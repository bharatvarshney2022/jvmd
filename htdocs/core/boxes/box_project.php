<?php
/* Copyright (C) 2012-2014 Charles-François BENKE <charles.fr@benke.fr>
 * Copyright (C) 2014      Marcos García          <marcosgdf@gmail.com>
 * Copyright (C) 2015      Frederic France        <frederic.france@free.fr>
 * Copyright (C) 2016      Juan José Menent       <jmenent@2byte.es>
 * Copyright (C) 2020      Pierre Ardoin          <mapiolca@me.com>
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
 *  \file       htdocs/core/boxes/box_project.php
 *  \ingroup    projet
 *  \brief      Module to show Projet activity of the current Year
 */
include_once DOL_DOCUMENT_ROOT."/core/boxes/modules_boxes.php";

/**
 * Class to manage the box to show last projet
 */
class box_project extends ModeleBoxes
{
	public $boxcode = "project";
	public $boximg = "object_projectpub";
	public $boxlabel;
	//var $depends = array("projet");

	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	public $param;

	public $info_box_head = array();
	public $info_box_contents = array();

	/**
	 *  Constructor
	 *
	 *  @param  DoliDB  $db         Database handler
	 *  @param  string  $param      More parameters
	 */
	public function __construct($db, $param = '')
	{
		global $user, $langs;

		// Load translation files required by the page
		$langs->loadLangs(array('boxes', 'projects'));

		$this->db = $db;
		$this->boxlabel = "Top 5 Pending Support Ticket";

		$this->hidden = !($user->rights->projet->lire);
	}

	/**
	 *  Load data for box to show them later
	 *
	 *  @param   int		$max        Maximum number of records to load
	 *  @return  void
	 */
	public function loadBox($max = 10)
	{
		global $conf, $user, $langs;

		$this->max = $max;

		$totalMnt = 0;
		$totalnb = 0;
		$totalnbTask = 0;

		$textHead = $langs->trans("Top 10 Pending / Rejected Support Tickets");
		$this->info_box_head = array('text' => $textHead, 'label' => 'project', 'limit'=> dol_strlen($textHead));

		if(!$user->admin)
		{
			require_once DOL_DOCUMENT_ROOT.'/core/lib/usergroups.lib.php';
			$user_group_id = 0;
			$usergroup = new UserGroup($this->db);
			$groupslist = $usergroup->listGroupsForUser($user->id);

			if ($groupslist != '-1')
			{
				foreach ($groupslist as $groupforuser)
				{
					$user_group_id = $groupforuser->id;
				}
			}
		}

		// list the summary of the orders
		if ($user->rights->projet->lire) {
			include_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';
			$projectstatic = new Project($this->db);

			$socid = 0;
			//if ($user->socid > 0) $socid = $user->socid;    // For external user, no check is done on company because readability is managed by public status of project and assignement.

			// Get list of project id allowed to user (in a string list separated by coma)
			$projectsListId = '';
			if (!$user->rights->projet->all->lire) $projectsListId = $projectstatic->getProjectsAuthorizedForUser($user, 0, 1, $socid);

			$sql = "SELECT p.rowid, p.ref, p.title, p.fk_statut as status, p.public, s.nom as s_nom, s.address, s.town, s.zip";
			$sql .= " FROM ".MAIN_DB_PREFIX."projet as p, ".MAIN_DB_PREFIX."societe as s";
			if($user_group_id == 4)
			{
				$sql .= ",  ".MAIN_DB_PREFIX."societe_extrafields as esf ";
			}
			if ($user_group_id == 17) 
			{
				$sql .= ", ".MAIN_DB_PREFIX."element_contact as ecp";
			}
			$sql .= " WHERE  p.entity IN (".getEntity('project').")"; // Only current entity or severals if permission ok
			if($user_group_id == 4)
			{
				$sql .= " AND p.fk_soc = esf.fk_object AND p.fk_soc = s.rowid AND p.fk_statut IN (0,1)"; // Only pending projects
			}else{
				$sql .= " AND p.fk_soc = s.rowid AND p.fk_statut IN (0,3)"; // Only pending projects
			}
			if (!$user->rights->projet->all->lire) $sql .= " AND p.rowid IN (".$projectsListId.")"; // public and assigned to, or restricted to company for external users
			
			if(!$user->admin)
			{
				if($user_group_id == 4)
				{
					$sql .= "  AND FIND_IN_SET(esf.fk_pincode, (select apply_zipcode from ".MAIN_DB_PREFIX."user_extrafields where fk_object = '".$user->id."')) ";

					/*$apply_zipcode = $user->array_options['options_apply_zipcode'];
					if($apply_zipcode != "")
					{
						// Get Zip Data from Master
						$zipCode = array();
						$sqlZip = "SELECT zip FROM ".MAIN_DB_PREFIX."c_pincodes WHERE rowid IN (".$apply_zipcode.")";
						$resqlZip = $this->db->query($sqlZip);
						if ($resqlZip)
						{
							while ($objZip = $this->db->fetch_object($resqlZip))
							{
								$zipCode[] = $objZip->zip;
							}
						}

						if($zipCode)
						{
							$zipData = implode(",", $zipCode);

							$sql .= " AND s.zip IN (".$zipData.")";
						}
					}*/
				}

				if($user_group_id == 17){

					$vendor_list = '';
					$sqlVendor = "SELECT fk_vendor FROM `".MAIN_DB_PREFIX."user_extrafields` WHERE fk_object = '".$user->id."' ";
					$resqlVendor = $this->db->query($sqlVendor);
					if ($resqlVendor)
					{
						$rowVendor = $this->db->fetch_object($resqlVendor);
						$vendorData = $rowVendor->fk_vendor;
						
						//$vendorData[] = $user->id;

						if($vendorData)
						{
							//$vendor_list = implode(",", $vendorData);
							$sql .= " AND ecp.element_id = p.rowid AND ecp.fk_socpeople IN (".$vendorData.")";
						}
					}
				}
			}

			$sql .= " ORDER BY fk_statut DESC, p.datec DESC";
			$sql.= $this->db->plimit($max, 0);
			
			//echo $sql;
			$result = $this->db->query($sql);

			if ($result) {
				$num = $this->db->num_rows($result);
				$i = 0;
				while ($i < min($num, $max)) {
					$objp = $this->db->fetch_object($result);

					$projectstatic->id = $objp->rowid;
					$projectstatic->ref = $objp->ref;
					$projectstatic->title = $objp->title;
					$projectstatic->public = $objp->public;
					$projectstatic->statut = $objp->status;

					$this->info_box_contents[$i][] = array(
						'td' => 'class=""',
						'text' => $projectstatic->getNomUrl(1),
						'asis' => 1
					);

					$this->info_box_contents[$i][] = array(
						'td' => 'class=""',
						'text' => $objp->title,
					);

					// Customer Info
					//s_nom, s., s.town, s.zip
					$this->info_box_contents[$i][] = array(
						'td' => 'class=""',
						'text' => $objp->s_nom,
					);

					$this->info_box_contents[$i][] = array(
						'td' => 'class="" data-toggle="tooltip" title="'.$objp->address.'"',
						'text' => dol_substr($objp->address, 0, 30),
					);

					$this->info_box_contents[$i][] = array(
						'td' => 'class=""',
						'text' => $objp->town,
					);

					$this->info_box_contents[$i][] = array(
						'td' => 'class=""',
						'text' => $objp->zip,
					);

					$sql = "SELECT count(*) as nb, sum(progress) as totprogress";
					$sql .= " FROM ".MAIN_DB_PREFIX."projet as p LEFT JOIN ".MAIN_DB_PREFIX."projet_task as pt on pt.fk_projet = p.rowid";
					   $sql .= " WHERE p.entity IN (".getEntity('project').')';
					$sql .= " AND p.rowid = ".$objp->rowid;
					$resultTask = $this->db->query($sql);
					/*if ($resultTask) {
						$objTask = $this->db->fetch_object($resultTask);
						$this->info_box_contents[$i][] = array(
							'td' => '',
							'text' => $objTask->nb."&nbsp;".$langs->trans("Tasks"),
						);
						if ($objTask->nb > 0)
							$this->info_box_contents[$i][] = array(
								'td' => '',
								'text' => round($objTask->totprogress / $objTask->nb, 0)."%",
							);
						else $this->info_box_contents[$i][] = array('td' => '', 'text' => "N/A&nbsp;");
						$totalnbTask += $objTask->nb;
					} else {
						$this->info_box_contents[$i][] = array('td' => '', 'text' => round(0));
						$this->info_box_contents[$i][] = array('td' => '', 'text' => "N/A&nbsp;");
					}*/

					// Box
					$this->info_box_contents[$i][] = array('td' => '', 'text' => $projectstatic->getLibStatutLayout(3));

					$i++;
				}
				if ($max < $num)
				{
					$this->info_box_contents[$i][] = array('td' => 'colspan="5"', 'text' => '...');
					$i++;
				}
			}
		}


		// Add the sum à the bottom of the boxes
		/*$this->info_box_contents[$i][] = array(
			'td' => 'class="liste_total"',
			'text' => $langs->trans("Total")."&nbsp;".$textHead,
			 'text' => "&nbsp;",
		);
		$this->info_box_contents[$i][] = array(
			'td' => 'class="right liste_total" ',
			'text' => round($num, 0)."&nbsp;".$langs->trans("Projects"),
		);
		$this->info_box_contents[$i][] = array(
			'td' => 'class="right liste_total" ',
			'text' => (($max < $num) ? '' : (round($totalnbTask, 0)."&nbsp;".$langs->trans("Tasks"))),
		);
		$this->info_box_contents[$i][] = array(
			'td' => 'class="liste_total"',
			'text' => "&nbsp;",
		);
		$this->info_box_contents[$i][] = array(
			'td' => 'class="liste_total"',
			'text' => "&nbsp;",
		);*/
	}

	/**
	 *	Method to show box
	 *
	 *	@param	array	$head       Array with properties of box title
	 *	@param  array	$contents   Array with properties of box lines
	 *  @param	int		$nooutput	No print, only return string
	 *	@return	string
	 */
	public function showBox($head = null, $contents = null, $nooutput = 0)
	{
		return parent::showBox($this->info_box_head, $this->info_box_contents, $nooutput);
	}
}
