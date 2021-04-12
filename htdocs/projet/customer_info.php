<?php
/* TVI
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

/**
 *  \file htdocs/loan/calcmens.php
 *  \ingroup    loan
 *  \brief File to calculate loan monthly payments
 */

if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1'); // Disables token renewal
if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');
if (!defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');

require '../main.inc.php';
//require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

$socid = GETPOST('socid');

$objsoc = new Societe($db);
$objsoc->fetch($socid);

$zipCode = 0;
$userZip = $objsoc->zip;
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

$json = array('address' => $objsoc->address, 'zip' => $zipCode, 'town' => $objsoc->town, 'state_id' => $objsoc->state_id, 'country_id' => $objsoc->country_id);

$headers = 'Content-type: application/json';
header($headers);
echo json_encode($json);