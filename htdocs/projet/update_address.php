<?php
/* This program is free software; you can redistribute it and/or modify
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
 *	\file       htdocs/projet/list.php
 *	\ingroup    projet
 *	\brief      Page to list projects
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/projet/class/project.class.php';

// Load translation files required by the page
$langs->loadLangs(array('projects', 'companies', 'commercial'));

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$object = new Project($db);

$sqlProjet = "SELECT rowid, fk_soc FROM ".MAIN_DB_PREFIX."projet WHERE fk_soc IS NOT NULL";
$resqlProjet = $db->query($sqlProjet);
$numProjet = $db->num_rows($resqlProjet);
if($numProjet > 0){
	while($projObj = $db->fetch_array($resqlProjet))
	{
		//print_r($projObj); exit;
		$proj_id = $projObj[0];
		$soc_id = $projObj[1];

		$sqlProjet1 = "SELECT * FROM ".MAIN_DB_PREFIX."societe WHERE rowid = '".$soc_id."'";
		$resqlProjet1 = $db->query($sqlProjet1);
		$projObj1 = $db->fetch_array($resqlProjet1);

		$address = $projObj1['address'];
		$town = $projObj1['town'];
		$fk_departement = $projObj1['fk_departement'];
		$fk_pays = $projObj1['fk_pays'];

		$zipCode = 0;
		$userZip = $projObj1['zip'];
		if($userZip > 0)
		{
			$sqlZip = "SELECT rowid, zip FROM ".MAIN_DB_PREFIX."c_pincodes WHERE active = '1' AND zip LIKE '".$userZip."'";
			$resqlZip = $db->query($sqlZip);
			if ($resqlZip)
			{
				$row = $db->fetch_object($resqlZip);
				$zipCode = $row->rowid;
			}
		}


		$sqlProjet2 = "UPDATE ".MAIN_DB_PREFIX."projet SET address = '".$db->escape($address)."', zip = '".$db->escape($zipCode)."', town = '".$db->escape($town)."', fk_departement = '".$db->escape($fk_departement)."', fk_pays = '".$db->escape($fk_pays)."' WHERE rowid = '".$proj_id."'";
		$db->query($sqlProjet2);
	}
}