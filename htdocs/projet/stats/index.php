<?php
/* Copyright (C) 2014-2015 Florian HENRY       <florian.henry@open-concept.pro>
 * Copyright (C) 2015      Laurent Destailleur <ldestailleur@users.sourceforge.net>
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
 *       \file       htdocs/projet/stats/index.php
 *       \ingroup    project
 *       \brief      Page for project statistics
 */

require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/dolgraph.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/project.lib.php';
require_once DOL_DOCUMENT_ROOT.'/projet/class/projectstats.class.php';

// Security check
if (!$user->rights->projet->lire)
	accessforbidden();


$WIDTH = DolGraph::getDefaultGraphSizeForStats('width');
$HEIGHT = DolGraph::getDefaultGraphSizeForStats('height');

$userid = GETPOST('userid', 'int');
$socid = GETPOST('socid', 'int');
// Security check
if ($user->socid > 0)
{
	$action = '';
	$socid = $user->socid;
}
$nowyear = strftime("%Y", dol_now());
$year = GETPOST('year') > 0 ?GETPOST('year') : $nowyear;
//$startyear=$year-2;
$startyear = $year - 1;
$endyear = $year;

// Load translation files required by the page
$langs->loadLangs(array('companies', 'projects'));


/*
 * View
 */

$form = new Form($db);

$includeuserlist = array();


llxHeaderLayout('', $langs->trans('Projects'), $langs->trans('Projects'));

$title = $langs->trans("ProjectsStatistics");
$dir = $conf->projet->dir_output.'/temp';

print '<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom">
			<div class="card-header py-3">
				<div class="card-title">
					<span class="card-icon">
						<i class="flaticon2-shopping-cart text-primary"></i>
					</span>
					<h3 class="card-label">'.$title .'</h3>
				</div>
			</div>

			<div class="card-body">'."\n";

			dol_mkdir($dir);


			$stats_project = new ProjectStats($db);
			if (!empty($userid) && $userid != -1) $stats_project->userid = $userid;
			if (!empty($socid) && $socid != -1) $stats_project->socid = $socid;
			if (!empty($year)) $stats_project->year = $year;

			/*
			if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
			{
				// Current stats of project amount per status
				$data1 = $stats_project->getAllProjectByStatus();

				if (!is_array($data1) && $data1 < 0) {
					setEventMessages($stats_project->error, null, 'errors');
				}
				if (empty($data1))
				{
					$showpointvalue = 0;
					$nocolor = 1;
					$data1 = array(array(0=>$langs->trans("None"), 1=>1));
				}

				$filenamenb = $conf->project->dir_output."/stats/projectbystatus.png";
				$fileurlnb = DOL_URL_ROOT.'/viewimage.php?modulepart=projectstats&amp;file=projectbystatus.png';
				$px = new DolGraph();
				$mesg = $px->isGraphKo();
				if (empty($mesg)) {
					$i = 0; $tot = count($data1); $legend = array();
					while ($i <= $tot)
					{
						$legend[] = $data1[$i][0];
						$i++;
					}

					$px->SetData($data1);
					unset($data1);

					if ($nocolor)
						$px->SetDataColor(array(
								array(
										220,
										220,
										220
								)
						));

					$px->SetLegend($legend);
					$px->setShowLegend(0);
					$px->setShowPointValue($showpointvalue);
					$px->setShowPercent(1);
					$px->SetMaxValue($px->GetCeilMaxValue());
					$px->SetWidth($WIDTH);
					$px->SetHeight($HEIGHT);
					$px->SetShading(3);
					$px->SetHorizTickIncrement(1);
					$px->SetCssPrefix("cssboxes");
					$px->SetType(array('pie'));
					$px->SetTitle($langs->trans('OpportunitiesStatusForProjects'));
					$result = $px->draw($filenamenb, $fileurlnb);
					if ($result < 0) {
						setEventMessages($px->error, null, 'errors');
					}
				} else {
					setEventMessages(null, $mesg, 'errors');
				}
			}*/


			// Build graphic number of object
			// $data = array(array('Lib',val1,val2,val3),...)
			$data = $stats_project->getNbByMonthWithPrevYear($endyear, $startyear);
			//var_dump($data);

			$filenamenb = $conf->project->dir_output."/stats/projectnbprevyear-".$year.".png";
			$fileurlnb = DOL_URL_ROOT.'/viewimage.php?modulepart=projectstats&amp;file=projectnbprevyear-'.$year.'.png';

			$px1 = new DolGraph();
			$mesg = $px1->isGraphKo();
			if (!$mesg)
			{
				$px1->SetData($data);
				$i = $startyear; $legend = array();
				while ($i <= $endyear)
				{
					$legend[] = $i;
					$i++;
				}
				$px1->SetLegend($legend);
				$px1->SetMaxValue($px1->GetCeilMaxValue());
				$px1->SetWidth($WIDTH);
				$px1->SetHeight($HEIGHT);
				$px1->SetYLabel($langs->trans("ProjectNbProject"));
				$px1->SetShading(3);
				$px1->SetHorizTickIncrement(1);
				$px1->mode = 'depth';
				$px1->SetTitle($langs->trans("ProjectNbProjectByMonth"));

				$px1->draw($filenamenb, $fileurlnb);
			}


			if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
			{
				// Build graphic amount of object
				$data = $stats_project->getAmountByMonthWithPrevYear($endyear, $startyear);
				//var_dump($data);
				// $data = array(array('Lib',val1,val2,val3),...)

				$filenamenb = $conf->project->dir_output."/stats/projectamountprevyear-".$year.".png";
				$fileurlnb = DOL_URL_ROOT.'/viewimage.php?modulepart=projectstats&amp;file=projectamountprevyear-'.$year.'.png';

				$px2 = new DolGraph();
				$mesg = $px2->isGraphKo();
				if (!$mesg)
				{
					$i = $startyear; $legend = array();
					while ($i <= $endyear)
					{
						$legend[] = $i;
						$i++;
					}

					$px2->SetData($data);
					$px2->SetLegend($legend);
					$px2->SetMaxValue($px2->GetCeilMaxValue());
					$px2->SetMinValue(min(0, $px2->GetFloorMinValue()));
					$px2->SetWidth($WIDTH);
					$px2->SetHeight($HEIGHT);
					$px2->SetYLabel($langs->trans("ProjectOppAmountOfProjectsByMonth"));
					$px2->SetShading(3);
					$px2->SetHorizTickIncrement(1);
					$px2->SetType(array('bars', 'bars'));
					$px2->mode = 'depth';
					$px2->SetTitle($langs->trans("ProjectOppAmountOfProjectsByMonth"));

					$px2->draw($filenamenb, $fileurlnb);
				}
			}

			if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
			{
				// Build graphic with transformation rate
				$data = $stats_project->getWeightedAmountByMonthWithPrevYear($endyear, $startyear, 0, 0);
				//var_dump($data);
				// $data = array(array('Lib',val1,val2,val3),...)

				$filenamenb = $conf->project->dir_output."/stats/projecttransrateprevyear-".$year.".png";
				$fileurlnb = DOL_URL_ROOT.'/viewimage.php?modulepart=projectstats&amp;file=projecttransrateprevyear-'.$year.'.png';

				$px3 = new DolGraph();
				$mesg = $px3->isGraphKo();
				if (!$mesg)
				{
					$px3->SetData($data);
					$i = $startyear; $legend = array();
					while ($i <= $endyear)
					{
						$legend[] = $i;
						$i++;
					}
					$px3->SetLegend($legend);
					$px3->SetMaxValue($px3->GetCeilMaxValue());
					$px3->SetMinValue(min(0, $px3->GetFloorMinValue()));
					$px3->SetWidth($WIDTH);
					$px3->SetHeight($HEIGHT);
					$px3->SetYLabel($langs->trans("ProjectWeightedOppAmountOfProjectsByMonth"));
					$px3->SetShading(3);
					$px3->SetHorizTickIncrement(1);
					$px3->mode = 'depth';
					$px3->SetTitle($langs->trans("ProjectWeightedOppAmountOfProjectsByMonth"));

					$px3->draw($filenamenb, $fileurlnb);
				}
			}


			// Show array
			$stats_project->year = 0;
			$data_all_year = $stats_project->getAllByYear();

			if (!empty($year)) $stats_project->year = $year;
			$arrayyears = array();
			foreach ($data_all_year as $val) {
				$arrayyears[$val['year']] = $val['year'];
			}
			if (!count($arrayyears)) $arrayyears[$nowyear] = $nowyear;


			$h = 0;
			$head = array();
			$head[$h][0] = DOL_URL_ROOT.'/projet/stats/index.php';
			$head[$h][1] = $langs->trans("ByMonthYear");
			$head[$h][2] = 'byyear';
			$h++;

			complete_head_from_modules($conf, $langs, null, $head, $h, $type);

			print dol_get_fiche_head_layout($head, 'byyear', $langs->trans("Statistics"), -1, '');

			print '<div class="row my-4"><div class="col-sm-6">';

			print '<form name="stats" method="POST" action="'.$_SERVER["PHP_SELF"].'">';
			print '<input type="hidden" name="token" value="'.newToken().'">';

			print '<table class="table table-bordered">';
			print '<tr class=""><td class="" colspan="2">'.$langs->trans("Filter").'</td></tr>';
			// Company
			print '<tr><td>'.$langs->trans("ThirdParty").'</td><td>';
			print $form->select_company($socid, 'socid', '', 1, 0, 0, array(), 0, '', 'style="width: 95%"');
			print '</td></tr>';
			// User
			/*print '<tr><td>'.$langs->trans("ProjectCommercial").'</td><td>';
			print $form->select_dolusers($userid, 'userid', 1, array(),0,$includeuserlist);
			print '</td></tr>';*/
			// Year
			print '<tr><td>'.$langs->trans("Year").'</td><td>';
			if (!in_array($year, $arrayyears)) $arrayyears[$year] = $year;
			if (!in_array($nowyear, $arrayyears)) $arrayyears[$nowyear] = $nowyear;
			arsort($arrayyears);
			print $form->selectarray('year', $arrayyears, $year, 0);
			print '</td></tr>';
			print '<tr><td class="center" colspan="2"><input type="submit" name="submit" class="btn btn-info" value="'.$langs->trans("Refresh").'"></td></tr>';
			print '</table>';
			print '</form>';
			print '<br><br>';

			print '<table class="table table-bordered"><thead>';
			print '<tr class="" height="24">';
			print '<th class="">'.$langs->trans("Year").'</th>';
			print '<th class="">'.$langs->trans("NbOfProjects").'</th>';
			if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
			{
				print '<td class="">'.$langs->trans("OpportunityAmountShort").'</td>';
				print '<td class="">'.$langs->trans("OpportunityAmountAverageShort").'</td>';
				print '<td class="">'.$langs->trans("OpportunityAmountWeigthedShort").'</td>';
			}
			print '</tr></thead><tbody>';

			$oldyear = 0;
			foreach ($data_all_year as $val)
			{
				$year = $val['year'];
				while ($year && $oldyear > $year + 1)
				{	// If we have empty year
					$oldyear--;

					print '<tr class="" height="24">';
					print '<td class="center"><a href="'.$_SERVER["PHP_SELF"].'?year='.$oldyear.($socid > 0 ? '&socid='.$socid : '').($userid > 0 ? '&userid='.$userid : '').'">'.$oldyear.'</a></td>';
					if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
					{
						print '<td class="">0</td>';
						print '<td class="">0</td>';
						print '<td class="">0</td>';
					}
					print '<td class="">0</td>';
					print '</tr>';
				}

				print '<tr class="" height="24">';
				print '<td class=""><a href="'.$_SERVER["PHP_SELF"].'?year='.$year.($socid > 0 ? '&socid='.$socid : '').($userid > 0 ? '&userid='.$userid : '').'">'.$year.'</a></td>';
				print '<td class="">'.$val['nb'].'</td>';
				if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
				{
					print '<td class="">'.($val['total'] ?price(price2num($val['total'], 'MT'), 1) : '0').'</td>';
					print '<td class="">'.($val['avg'] ?price(price2num($val['avg'], 'MT'), 1) : '0').'</td>';
					print '<td class="">'.($val['weighted'] ?price(price2num($val['weighted'], 'MT'), 1) : '0').'</td>';
				}
				print '</tr>';
				$oldyear = $year;
			}

			print '</tbody></table>';

			print '</div><div class="col-sm-6">';

			$stringtoshow .= '<table class="table table-bordered"><tr class=""><td class="">';
			if ($mesg) { print $mesg; } else {
				$stringtoshow .= $px1->show();
				$stringtoshow .= "<br>\n";
				if (!empty($conf->global->PROJECT_USE_OPPORTUNITIES))
				{
					//$stringtoshow .= $px->show();
					//$stringtoshow .= "<br>\n";
					$stringtoshow .= $px2->show();
					$stringtoshow .= "<br>\n";
					$stringtoshow .= $px3->show();
				}
			}
			$stringtoshow .= '</td></tr></table>';

			print $stringtoshow;


			print '</div></div></div>';

// End of page
// End of page
llxFooterLayout();

print '<!--begin::Page Vendors(used by this page)-->
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.bundle.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/datatables.buttons.js?v=7.2.0"></script>
<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/cards-tools.js?v=7.2.0"></script>
<!--<script src="'.DOL_URL_ROOT.'/theme/oblyon/js/advanced-search.js?v=7.2.0"></script>-->
<!--end::Page Vendors-->';

print "	</body>\n";
print "</html>\n";

$db->close();
