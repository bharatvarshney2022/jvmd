<?php
/* Copyright (C) 2009-2010 Regis Houssin <regis.houssin@inodbox.com>
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


if (!defined('NOBROWSERNOTIF')) define('NOBROWSERNOTIF', 1);

// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf))
{
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

$php_self = $_SERVER['PHP_SELF'];
$php_self .= dol_escape_htmltag($_SERVER["QUERY_STRING"]) ? '?'.dol_escape_htmltag($_SERVER["QUERY_STRING"]) : '';
$php_self = str_replace('action=validatenewpassword', '', $php_self);

$titleofpage = $langs->trans('SendNewPassword');

print top_htmlhead_login('', $titleofpage);


$colorbackhmenu1 = '60,70,100'; // topmenu
if (!isset($conf->global->THEME_ELDY_TOPMENU_BACK1)) $conf->global->THEME_ELDY_TOPMENU_BACK1 = $colorbackhmenu1;
$colorbackhmenu1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $conf->global->THEME_ELDY_TOPMENU_BACK1) : (empty($user->conf->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $user->conf->THEME_ELDY_TOPMENU_BACK1);
$colorbackhmenu1 = join(',', colorStringToArray($colorbackhmenu1)); // Normalize value to 'x,y,z'

?>
<!-- BEGIN PHP TEMPLATE PASSWORDFORGOTTEN-JMVD.TPL.PHP -->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"<?php print empty($conf->global->MAIN_LOGIN_BACKGROUND) ? '' : ' style="background-size: cover; background-position: center center; background-attachment: fixed; background-repeat: no-repeat; background-image: url(\''.DOL_URL_ROOT.'/viewimage.php?cache=1&noalt=1&modulepart=mycompany&file='.urlencode('logos/'.$conf->global->MAIN_LOGIN_BACKGROUND).'\')"';

 ?>>

 <?php
 	print "\n<!--begin::Main-->";
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
			<div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden" style="background-image: url('<?php echo DOL_URL_ROOT.'/theme/oblyon/'; ?>media/bg-1.jpg');">
				<!--begin: Aside Container-->
				<div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-1 px-lg-35">
					<!--begin::Logo-->
					<a href="<?php echo $dolibarr_main_url_root; ?>" class="text-center">
						<img src="<?php echo $urllogo; ?>" class="max-h-150px" alt="" />
					</a>
					<!--end::Logo-->
					<!--begin::Aside body-->
					<div class="d-flex flex-column-fluid flex-column flex-center">
						<!--begin::Signin-->
						<div class="login-form login-forgot">
							<?php if ($message) { ?>
								<div class="alert alert-danger  login_main_message">
								<?php echo dol_htmloutput_mesg($message, '', '', 1); ?>
								</div>
							<?php } ?>

							<form id="kt_login_forgot_form" class="form" name="login" method="POST" action="<?php echo $php_self; ?>">
								<input type="hidden" name="token" value="<?php echo $_SESSION['newtoken']; ?>">
								<input type="hidden" name="action" value="buildnewpassword">

								<!--begin::Title-->
								<div class="text-center pb-8">
									<h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
									<p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
								</div>

								<!--end::Title-->
								<!--begin::Form group-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark"><?php echo $langs->trans("Login"); ?></label>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" value="<?php echo dol_escape_htmltag($username); ?>" placeholder="<?php echo $langs->trans("Login"); ?>" <?php echo $disabled; ?> id="username" name="username" autocomplete="off" />
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
								<!--begin::Form group-->
								<div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
									<button type="submit" name="button_password" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4"><?php echo $langs->trans('SendNewPassword'); ?></button>

									<?php
										$moreparam = '';
										if (!empty($conf->dol_hide_topmenu))   $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_hide_topmenu='.$conf->dol_hide_topmenu;
										if (!empty($conf->dol_hide_leftmenu))  $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_hide_leftmenu='.$conf->dol_hide_leftmenu;
										if (!empty($conf->dol_no_mouse_hover)) $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_no_mouse_hover='.$conf->dol_no_mouse_hover;
										if (!empty($conf->dol_use_jmobile))    $moreparam .= (strpos($moreparam, '?') === false ? '?' : '&').'dol_use_jmobile='.$conf->dol_use_jmobile;

										print '<a class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4" href="'.$dol_url_root.'/index.php'.$moreparam.'">'.$langs->trans('BackToLoginPage').'</a>';
									?>
								</div>
								<!--end::Form group-->

								<?php if ($mode == 'dolibarr' || !$disabled) { ?>
									<span class="passwordmessagedesc">
									<?php //echo $langs->trans('SendNewPasswordDesc'); ?>
									</span>
								<?php } else { ?>
									<div class="warning center">
									<?php echo $langs->trans('AuthenticationDoesNotAllowSendNewPassword', $mode); ?>
									</div>
								<?php } ?>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Forgot-->
					</div>
					<!--end::Aside body-->
					<!--begin: Aside footer for desktop-->
					<div class="text-center">
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
									<script	src="//pagead2.googlesyndication.com/pagead/show_ads.js"></script>
								</div>
									<?php
								}
							}

							if (isset($conf->file->main_authentication) && preg_match('/openid/', $conf->file->main_authentication))
							{
								$langs->load("users");

								//if (! empty($conf->global->MAIN_OPENIDURL_PERUSER)) $url=
								echo '<br>';
								echo '<div class="center" style="margin-top: 4px;">';

								$url = $conf->global->MAIN_AUTHENTICATION_OPENID_URL;
								if (!empty($url)) print '<a class="alogin" href="'.$url.'">'.$langs->trans("LoginUsingOpenID").'</a>';
								else {
									$langs->load("errors");
									print '<font class="warning">'.$langs->trans("ErrorOpenIDSetupNotComplete", 'MAIN_AUTHENTICATION_OPENID_URL').'</font>';
								}

								echo '</div>';
							}
						?>
					</div>
					<!--end: Aside footer for desktop-->
				</div>
				<!--end: Aside Container-->
			</div>
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
					<div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-top bgi-position-x-center" style="background-image: url('<?php echo DOL_URL_ROOT.'/theme/oblyon/'; ?>media/new-login-visual-2.jpg');")></div>
				<!--end::Image-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Login-->
	</div>

	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
	</script>
	<!--end::Global Config-->

	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/js/plugins.bundle.js?v=7.2.0"></script>
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/js/prismjs.bundle.js?v=7.2.0"></script>
	<script src="<?php echo DOL_URL_ROOT.'/theme/oblyon'; ?>/js/scripts.bundle.js?v=7.2.0"></script>
	<!--end::Global Theme Bundle-->

	<script>
		"use strict";
		var KTLogin = function() {
		    var t, i = function(i) {
		        var o = "login-" + i + "-on";
		        i = "kt_login_" + i + "_form";
		        t = $("#kt_login");
		        t.removeClass("login-forgot-on"),
		        t.removeClass("login-signin-on"),
		        t.removeClass("login-signup-on"),
		        
		        t.addClass(o);
		        KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
		    };

		    return {
        		init: function() {
        			i('forgot');
        		}
        	};
			
		}();

		jQuery(document).ready((function(){
			KTLogin.init();

		}));
	</script>

	</body>
	<!--end::Body-->
</html>
<!-- END PHP TEMPLATE -->
