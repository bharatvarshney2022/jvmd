<?php
/* 
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
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

$fk_defect = GETPOST('fk_defect');

print '<option value="">Select</option>';

$sqlDetect = "SELECT rowid, label FROM ".MAIN_DB_PREFIX."c_defect_action WHERE active = '1' AND fk_defect = '".$fk_defect."'";
$resqlDetect = $db->query($sqlDetect);
$numtech = $db->num_rows($resqlDetect);
if($numtech > 0){
	while ($objtech = $db->fetch_object($resqlDetect))
	{
		print '<option value="'.$objtech->rowid.'">'.$objtech->label.'</option>';
	}
}