<?php
/* Copyright (C) 2009-2015 Regis Houssin <regis.houssin@inodbox.com>
 * Copyright (C) 2011-2013 Laurent Destailleur <eldy@users.sourceforge.net>
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

// Need global variable $title to be defined by caller (like dol_loginfunction)
// Caller can also set 	$morelogincontent = array(['options']=>array('js'=>..., 'table'=>...);


if (!defined('NOBROWSERNOTIF')) define('NOBROWSERNOTIF', 1);

// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf)) {
	print "Error, template page can't be called as URL";
	exit;
}

require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';

header('Cache-Control: Public, must-revalidate');
header("Content-type: text/html; charset=".$conf->file->character_set_client);

if (GETPOST('dol_hide_topmenu')) $conf->dol_hide_topmenu = 1;
if (GETPOST('dol_hide_leftmenu')) $conf->dol_hide_leftmenu = 1;
if (GETPOST('dol_optimize_smallscreen')) $conf->dol_optimize_smallscreen = 1;
if (GETPOST('dol_no_mouse_hover')) $conf->dol_no_mouse_hover = 1;
if (GETPOST('dol_use_jmobile')) $conf->dol_use_jmobile = 1;

// If we force to use jmobile, then we reenable javascript
if (!empty($conf->dol_use_jmobile)) $conf->use_javascript_ajax = 1;

$php_self = dol_escape_htmltag($_SERVER['PHP_SELF']);
$php_self .= dol_escape_htmltag($_SERVER["QUERY_STRING"]) ? '?'.dol_escape_htmltag($_SERVER["QUERY_STRING"]) : '';
if (!preg_match('/mainmenu=/', $php_self)) $php_self .= (preg_match('/\?/', $php_self) ? '&' : '?').'mainmenu=home';

// Javascript code on logon page only to detect user tz, dst_observed, dst_first, dst_second
$arrayofjs = array(
	'/includes/jstz/jstz.min.js'.(empty($conf->dol_use_jmobile) ? '' : '?version='.urlencode(DOL_VERSION)),
	'/core/js/dst.js'.(empty($conf->dol_use_jmobile) ? '' : '?version='.urlencode(DOL_VERSION))
);

// We display application title instead Login term
if (!empty($conf->global->MAIN_APPLICATION_TITLE)) {
	$titleofloginpage = $conf->global->MAIN_APPLICATION_TITLE;
} else {
	$titleofloginpage = constant('DOL_APPLICATION_TITLE'). " | ".$langs->trans('Login');
}
//$titleofloginpage .= ' @ '.$titletruedolibarrversion; // $titletruedolibarrversion is defined by dol_loginfunction in security2.lib.php. We must keep the @, some tools use it to know it is login page and find true dolibarr version.

$disablenofollow = 0;
if (!preg_match('/'.constant('DOL_APPLICATION_TITLE').'/', $title)) $disablenofollow = 0;
if (!empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER)) $disablenofollow = 0;

print top_htmlhead_login('', $titleofloginpage, 0, 0, $arrayofjs, array(), 0, $disablenofollow);


$colorbackhmenu1 = '60,70,100'; // topmenu
if (!isset($conf->global->THEME_ELDY_TOPMENU_BACK1)) $conf->global->THEME_ELDY_TOPMENU_BACK1 = $colorbackhmenu1;
$colorbackhmenu1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $conf->global->THEME_ELDY_TOPMENU_BACK1) : (empty($user->conf->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $user->conf->THEME_ELDY_TOPMENU_BACK1);
$colorbackhmenu1 = join(',', colorStringToArray($colorbackhmenu1)); // Normalize value to 'x,y,z'

print "\n\n 	<!-- BEGIN PHP TEMPLATE LOGIN-JMVD.TPL.PHP -->\n";

if (!empty($conf->global->ADD_UNSPLASH_LOGIN_BACKGROUND)) {
	// For example $conf->global->ADD_UNSPLASH_LOGIN_BACKGROUND = 'https://source.unsplash.com/random'
	?>
	<body class="body bodylogin" style="background-image: url('<?php echo dol_escape_htmltag($conf->global->ADD_UNSPLASH_LOGIN_BACKGROUND); ?>'); background-repeat: no-repeat; background-position: center center; background-attachment: fixed; background-size: cover; background-color: #ffffff;">
	<?php
} else {
	?>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"<?php print empty($conf->global->MAIN_LOGIN_BACKGROUND) ? '' : ' style="background-size: cover; background-position: center center; background-attachment: fixed; background-repeat: no-repeat; background-image: url(\''.DOL_URL_ROOT.'/viewimage.php?cache=1&noalt=1&modulepart=mycompany&file=logos/'.urlencode($conf->global->MAIN_LOGIN_BACKGROUND).'\')"'; ?>>
	<?php
}

print "<!--begin::Main-->";
?>



<?php if (empty($conf->dol_use_jmobile)) { ?>
	<script>
	$(document).ready(function () {
		<?php if ($focus_element) { ?>$('#<?php echo $focus_element; ?>').focus(); <?php } ?>		// Warning to use this only on visible element
	});
	</script>
<?php } ?>

	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
			<!--begin::Aside-->
			<div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
				<!--begin: Aside Container-->
				<div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
					<!--begin::Logo-->
					<a href="#" class="text-center pt-2">
						<img src="<?php echo $urllogo; ?>" class="max-h-75px" alt="" />
					</a>
					<!--end::Logo-->
					<!--begin::Aside body-->
					<div class="d-flex flex-column-fluid flex-column flex-center">
						<!--begin::Signin-->
						<div class="login-form login-signin py-11">
							<!--begin::Form-->
							<?php
								// Show error message if defined
								if (!empty($_SESSION['dol_loginmesg']))
								{
									?>
									<div class="alert alert-danger">
									<?php echo $_SESSION['dol_loginmesg']; ?>
									</div>
									<?php
								}
							?>
							<form class="form" novalidate="novalidate" id="kt_login_signin_form login" name="login" method="post" action="<?php echo $php_self; ?>">
								<input type="hidden" name="token" value="<?php echo newToken(); ?>" />
								<input type="hidden" name="actionlogin" value="login">
								<input type="hidden" name="loginfunction" value="loginfunction" />
								<!-- Add fields to send local user information -->
								<input type="hidden" name="tz" id="tz" value="" />
								<input type="hidden" name="tz_string" id="tz_string" value="" />
								<input type="hidden" name="dst_observed" id="dst_observed" value="" />
								<input type="hidden" name="dst_first" id="dst_first" value="" />
								<input type="hidden" name="dst_second" id="dst_second" value="" />
								<input type="hidden" name="screenwidth" id="screenwidth" value="" />
								<input type="hidden" name="screenheight" id="screenheight" value="" />
								<input type="hidden" name="dol_hide_topmenu" id="dol_hide_topmenu" value="<?php echo $dol_hide_topmenu; ?>" />
								<input type="hidden" name="dol_hide_leftmenu" id="dol_hide_leftmenu" value="<?php echo $dol_hide_leftmenu; ?>" />
								<input type="hidden" name="dol_optimize_smallscreen" id="dol_optimize_smallscreen" value="<?php echo $dol_optimize_smallscreen; ?>" />
								<input type="hidden" name="dol_no_mouse_hover" id="dol_no_mouse_hover" value="<?php echo $dol_no_mouse_hover; ?>" />
								<input type="hidden" name="dol_use_jmobile" id="dol_use_jmobile" value="<?php echo $dol_use_jmobile; ?>" />

								<!--begin::Title-->
								<div class="text-center pb-8">
									<h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2>
									
								</div>
								<!--end::Title-->
								<!--begin::Form group-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark"><?php echo $langs->trans("Login"); ?></label>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" id="username" name="username" autocomplete="off" value="<?php echo dol_escape_htmltag($login); ?>" placeholder="<?php echo $langs->trans("Login"); ?>"  />
								</div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group">
									<div class="d-flex justify-content-between mt-n5">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5"><?php echo $langs->trans("Password"); ?></label>
										<?php
											if ($forgetpasslink || $helpcenterlink)
											{
												$moreparam = '';
												if ($dol_hide_topmenu)   $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_hide_topmenu='.$dol_hide_topmenu;
												if ($dol_hide_leftmenu)  $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_hide_leftmenu='.$dol_hide_leftmenu;
												if ($dol_no_mouse_hover) $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_no_mouse_hover='.$dol_no_mouse_hover;
												if ($dol_use_jmobile)    $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_use_jmobile='.$dol_use_jmobile;

												if ($forgetpasslink) {
													$url = DOL_URL_ROOT.'/user/passwordforgotten.php'.$moreparam;
													if (!empty($conf->global->MAIN_PASSWORD_FORGOTLINK)) $url = $conf->global->MAIN_PASSWORD_FORGOTLINK;
													echo '<a class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" href="'.dol_escape_htmltag($url).'">';
													echo $langs->trans('PasswordForgotten');
													echo '</a>';
												}
											}
										?>
									</div>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" id="password" placeholder="<?php echo $langs->trans("Password"); ?>" value="<?php echo dol_escape_htmltag($password); ?>" name="password" autocomplete="off" />
								</div>
								<!--end::Form group-->

								<?php
								if ($captcha) {
									// Add a variable param to force not using cache (jmobile)
									$php_self = preg_replace('/[&\?]time=(\d+)/', '', $php_self); // Remove param time
									if (preg_match('/\?/', $php_self)) $php_self .= '&time='.dol_print_date(dol_now(), 'dayhourlog');
									else $php_self .= '?time='.dol_print_date(dol_now(), 'dayhourlog');
									// TODO: provide accessible captcha variants
									?>
<!-- Captcha -->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark"><?php echo $langs->trans("SecurityCode"); ?></label>

									<input id="securitycode" placeholder="<?php echo $langs->trans("SecurityCode"); ?>" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" maxlength="5" name="code" />

									<div class="pt-5">
										<img class="" src="<?php echo DOL_URL_ROOT ?>/core/antispamimage.php" border="0" id="img_securitycode" />
										<a class="inline-block valignmiddle" href="<?php echo $php_self; ?>" tabindex="4" data-role="button"><?php echo $captcha_refresh; ?></a>
									</div>
								</div>
									<?php
								}

								if (!empty($morelogincontent)) {
									if (is_array($morelogincontent)) {
										foreach ($morelogincontent as $format => $option)
										{
											if ($format == 'table') {
												echo '<!-- Option by hook -->';
												echo $option;
											}
										}
									} else {
										echo '<!-- Option by hook -->';
										echo $morelogincontent;
									}
								}
							?>

								<!--begin::Action-->
								<div class="text-center pt-2">
									<button id="kt_login_signin_submit" type="submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In</button>
								</div>
								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Aside body-->
					<!--begin: Aside footer for desktop-->
					<div class="text-center">
						
					</div>
					<!--end: Aside footer for desktop-->
				</div>
				<!--end: Aside Container-->
			</div>
			<?php
			
			// Add commit strip
			if (!empty($conf->global->MAIN_EASTER_EGG_COMMITSTRIP)) {
				include_once DOL_DOCUMENT_ROOT.'/core/lib/geturl.lib.php';
				if (substr($langs->defaultlang, 0, 2) == 'fr') {
					$resgetcommitstrip = getURLContent("https://www.commitstrip.com/fr/feed/");
				} else {
					$resgetcommitstrip = getURLContent("https://www.commitstrip.com/en/feed/");
				}
				if ($resgetcommitstrip && $resgetcommitstrip['http_code'] == '200')
				{
					$xml = simplexml_load_string($resgetcommitstrip['content']);
					$little = $xml->channel->item[0]->children('content', true);
					print preg_replace('/width="650" height="658"/', '', $little->encoded);
				}
			}

			?>
			<?php if ($main_home)
			{
				?>
				<div class="center login_main_home paddingtopbottom <?php echo empty($conf->global->MAIN_LOGIN_BACKGROUND) ? '' : ' backgroundsemitransparent'; ?>" style="max-width: 70%">
				<?php echo $main_home; ?>
				</div><br>
				<?php
			}
			?>
			<?php //echo $main_authentication ?>
			<?php //echo $session_name ?>
			<?php //echo isset($_SESSION["urlfrom"]) ? $_SESSION["urlfrom"] : ''; ?>
			<?php
			if (!empty($conf->global->MAIN_HTML_FOOTER)) print $conf->global->MAIN_HTML_FOOTER;

			if (!empty($morelogincontent) && is_array($morelogincontent)) {
				foreach ($morelogincontent as $format => $option)
				{
					if ($format == 'js') {
						echo "\n".'<!-- Javascript by hook -->';
						echo $option."\n";
					}
				}
			} elseif (!empty($moreloginextracontent)) {
				echo '<!-- Javascript by hook -->';
				echo $moreloginextracontent;
			}

			// Google Analytics
			// TODO Add a hook here
			if (!empty($conf->google->enabled) && !empty($conf->global->MAIN_GOOGLE_AN_ID))
			{
				$tmptagarray = explode(',', $conf->global->MAIN_GOOGLE_AN_ID);
				foreach ($tmptagarray as $tmptag) {
					print "\n";
					print "<!-- JS CODE TO ENABLE for google analtics tag -->\n";
					print "
								<!-- Global site tag (gtag.js) - Google Analytics -->
								<script async src=\"https://www.googletagmanager.com/gtag/js?id=".trim($tmptag)."\"></script>
								<script>
								window.dataLayer = window.dataLayer || [];
								function gtag(){dataLayer.push(arguments);}
								gtag('js', new Date());

								gtag('config', '".trim($tmptag)."');
								</script>";
					print "\n";
				}
			}

			// TODO Replace this with a hook
			// Google Adsense (need Google module)
			if (!empty($conf->google->enabled) && !empty($conf->global->MAIN_GOOGLE_AD_CLIENT) && !empty($conf->global->MAIN_GOOGLE_AD_SLOT))
			{
				if (empty($conf->dol_use_jmobile))
				{
					?>
				<div class="center"><br>
					<script><!--
						google_ad_client = "<?php echo $conf->global->MAIN_GOOGLE_AD_CLIENT ?>";
						google_ad_slot = "<?php echo $conf->global->MAIN_GOOGLE_AD_SLOT ?>";
						google_ad_width = <?php echo $conf->global->MAIN_GOOGLE_AD_WIDTH ?>;
						google_ad_height = <?php echo $conf->global->MAIN_GOOGLE_AD_HEIGHT ?>;
						//-->
					</script>
					<script src="//pagead2.googlesyndication.com/pagead/show_ads.js"></script>
				</div>
					<?php
				}
			}
			?>

			<!--begin::Aside-->
			<!--begin::Content-->
			<div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
				<!--begin::Title-->
				<div class="d-flex flex-column justify-content-center text-center pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
					<h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">JMVD Group</h3>
					<p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">A Climate Control Company</p>
				</div>
				<!--end::Title-->
				<!--begin::Image-->
					<div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url('<?php echo DOL_URL_ROOT.'/theme/oblyon/'; ?>media/new-login-visual-2.svg');")></div>
				<!--end::Image-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Login-->
	</div>

	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/js/plugins.bundle.js?v=7.2.0"></script>
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/prismjs.bundle.js?v=7.2.0"></script>
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/scripts.bundle.js?v=7.2.0"></script>
	<!--end::Global Theme Bundle-->

	</body>
	<!--end::Body-->
</html>