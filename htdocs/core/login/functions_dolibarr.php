<?php
/* Copyright (C) 2007-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2007-2015 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2010-2011 Juanjo Menent		<jmenent@2byte.es>
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
 *      \file       htdocs/core/login/functions_dolibarr.php
 *      \ingroup    core
 *      \brief      Authentication functions for Dolibarr mode (check user on login or email and check pass)
 */


/**
 * Check validity of user/password/entity
 * If test is ko, reason must be filled into $_SESSION["dol_loginmesg"]
 *
 * @param	string	$usertotest		Login
 * @param	string	$passwordtotest	Password
 * @param   int		$entitytotest   Number of instance (always 1 if module multicompany not enabled)
 * @return	string					Login if OK, '' if KO
 */
function check_user_password_dolibarr($usertotest, $passwordtotest, $entitytotest = 1)
{
	global $db, $conf, $langs;

	// Force master entity in transversal mode
	$entity = $entitytotest;
	if (!empty($conf->multicompany->enabled) && !empty($conf->global->MULTICOMPANY_TRANSVERSE_MODE)) $entity = 1;

	$login = '';

	if (!empty($usertotest))
	{
		require_once DOL_DOCUMENT_ROOT.'/core/lib/date.lib.php';
		dol_syslog("functions_dolibarr::check_user_password_dolibarr usertotest=".$usertotest." passwordtotest=".preg_replace('/./', '*', $passwordtotest)." entitytotest=".$entitytotest);

		// If test username/password asked, we define $test=false if ko and $login var to login if ok, set also $_SESSION["dol_loginmesg"] if ko
		$table = MAIN_DB_PREFIX."user";
		$usernamecol1 = 'login';
		$usernamecol2 = 'email';
		$entitycol = 'entity';

		$sql = 'SELECT rowid, login, entity, pass, pass_crypted, datestartvalidity, dateendvalidity';
		$sql .= ' FROM '.$table;
		$sql .= ' WHERE ('.$usernamecol1." = '".$db->escape($usertotest)."'";
		if (preg_match('/@/', $usertotest)) $sql .= ' OR '.$usernamecol2." = '".$db->escape($usertotest)."'";
		$sql .= ') AND '.$entitycol." IN (0,".($entity ? $entity : 1).")";
		$sql .= ' AND statut = 1';
		// Note: Test on validity is done later
		// Required to firstly found the user into entity, then the superadmin.
		// For the case (TODO we must avoid that) a user has renamed its login with same value than a user in entity 0.
		$sql .= ' ORDER BY entity DESC';

		$resql = $db->query($sql);
		if ($resql)
		{
			$obj = $db->fetch_object($resql);
			if ($obj)
			{
				$now = dol_now();
				if ($obj->datestartvalidity && $db->jdate($obj->datestartvalidity) > $now) {
					// Load translation files required by the page
					$langs->loadLangs(array('main', 'errors'));
					$_SESSION["dol_loginmesg"] = $langs->trans("ErrorLoginDateValidity");
					return '--bad-login-validity--';
				}
				if ($obj->dateendvalidity && $db->jdate($obj->dateendvalidity) < dol_get_first_hour($now)) {
					// Load translation files required by the page
					$langs->loadLangs(array('main', 'errors'));
					$_SESSION["dol_loginmesg"] = $langs->trans("ErrorLoginDateValidity");
					return '--bad-login-validity--';
				}

				$passclear = $obj->pass;
				$passcrypted = $obj->pass_crypted;
				$passtyped = $passwordtotest;

				$passok = false;

				// Check crypted password
				$cryptType = '';
				if (!empty($conf->global->DATABASE_PWD_ENCRYPTED)) $cryptType = $conf->global->DATABASE_PWD_ENCRYPTED;

				// By default, we use default setup for encryption rule
				if (!in_array($cryptType, array('auto'))) $cryptType = 'auto';
				// Check crypted password according to crypt algorithm
				if ($cryptType == 'auto')
				{
					if (dol_verifyHash($passtyped, $passcrypted, '0'))
					{
						$passok = true;
						dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentification ok - ".$cryptType." of pass is ok");
					}
				}

				// For compatibility with very old versions
				if (!$passok)
				{
					if ((!$passcrypted || $passtyped)
						&& ($passclear && ($passtyped == $passclear)))
					{
						$passok = true;
						dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentification ok - found pass in database");
					}
				}

				// Password ok ?
				if ($passok)
				{
					$login = $obj->login;
				} else {
					sleep(2); // Anti brut force protection
					dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentication KO bad password for '".$usertotest."', cryptType=".$cryptType, LOG_NOTICE);

					// Load translation files required by the page
					$langs->loadLangs(array('main', 'errors'));

					$_SESSION["dol_loginmesg"] = $langs->trans("ErrorBadLoginPassword");
				}

				// We must check entity
				if ($passok && !empty($conf->multicompany->enabled))	// We must check entity
				{
					global $mc;

					if (!isset($mc)) $conf->multicompany->enabled = false; // Global not available, disable $conf->multicompany->enabled for safety
					else {
						$ret = $mc->checkRight($obj->rowid, $entitytotest);
						if ($ret < 0)
						{
							dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentication KO entity '".$entitytotest."' not allowed for user '".$obj->rowid."'", LOG_NOTICE);
							$login = ''; // force authentication failure
						}
					}
				}
			} else {
				dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentication KO user not found for '".$usertotest."'", LOG_NOTICE);
				sleep(1);

				// Load translation files required by the page
				$langs->loadLangs(array('main', 'errors'));

				$_SESSION["dol_loginmesg"] = $langs->trans("ErrorBadLoginPassword");
			}
		} else {
			dol_syslog("functions_dolibarr::check_user_password_dolibarr Authentication KO db error for '".$usertotest."' error=".$db->lasterror(), LOG_ERR);
			sleep(1);
			$_SESSION["dol_loginmesg"] = $db->lasterror();
		}
	}

	return $login;
}

function check_user_password($usertotest, $passwordtotest, $entitytotest = 1)
{
	global $db,$conf,$langs;

	// Force master entity in transversal mode
	$entity=$entitytotest;
	if (! empty($conf->multicompany->enabled) && ! empty($conf->global->MULTICOMPANY_TRANSVERSE_MODE)) $entity=1;

	$login=array();

	if (! empty($usertotest))
	{
		subpe_syslog("functions_subpe::check_user_password_subpe usertotest=".$usertotest." passwordtotest=".preg_replace('/./', '*', $passwordtotest)." entitytotest=".$entitytotest);

		// If test username/password asked, we define $test=false if ko and $login var to login if ok, set also $_SESSION["dol_loginmesg"] if ko
		$table = MAIN_DB_PREFIX."user";
		$usernamecol1 = 'login';
		$usernamecol2 = 'email';
		$entitycol = 'entity';

		$sql ='SELECT rowid, login, firstname, lastname, email, photo, pass_crypted';
		$sql.=' FROM '.$table;
		$sql.=' WHERE ('.$usernamecol1." = '".$db->escape($usertotest)."'";
		if (preg_match('/@/', $usertotest)) $sql.=' OR '.$usernamecol2." = '".$db->escape($usertotest)."'";
		$sql.=') AND '.$entitycol." IN (0," . ($entity ? $entity : 1) . ")";
		$sql.=' AND statut = 1';
		// Required to first found the user into entity, then the superadmin.
		// For the case (TODO and that we must avoid) a user has renamed its login with same value than a user in entity 0.
		$sql.=' ORDER BY entity DESC';

		$resql=$db->query($sql);
		if ($resql)
		{
			$obj=$db->fetch_object($resql);
			if ($obj)
			{
				$passclear=$obj->pass;
				$passcrypted=$obj->pass_crypted;
				$passtyped=$passwordtotest;

				$passok=false;

				// Check crypted password
				$cryptType='';
				if (! empty($conf->global->DATABASE_PWD_ENCRYPTED)) $cryptType=$conf->global->DATABASE_PWD_ENCRYPTED;
				

				// By default, we used MD5
				if (! in_array($cryptType, array('md5'))) $cryptType='md5';
				
				//echo $passtyped.",".$passcrypted; exit;
				// Check crypted password according to crypt algorithm
				if ($cryptType == 'md5')
				{
					if (dol_verifyHash($passtyped, $passcrypted))
					{
						$passok=true;
						subpe_syslog("functions_subpe::check_user_password_subpe Authentification ok - ".$cryptType." of pass is ok");
					}
				}

				// For compatibility with old versions
				if (! $passok)
				{
					if ((! $passcrypted || $passtyped)
						&& ($passclear && ($passtyped == $passclear)))
					{
						$passok=true;
						subpe_syslog("functions_subpe::check_user_password_subpe Authentification ok - found pass in database");
					}
				}

				// Password ok ?
				if ($passok)
				{
					unset($obj->pass_crypted);
					$login=$obj;
				}
				else
				{
				    sleep(2);      // Anti brut force protection
				    subpe_syslog("functions_subpe::check_user_password_subpe Authentification ko bad password for '".$usertotest."', cryptType=".$cryptType);

					// Load translation files required by the page
                    $langs->loadLangs(array('main', 'errors'));
				}

				// We must check entity
				if ($passok && ! empty($conf->multicompany->enabled))	// We must check entity
				{
					global $mc;

					if (! isset($mc)) $conf->multicompany->enabled = false; 	// Global not available, disable $conf->multicompany->enabled for safety
					else
					{
						$ret = $mc->checkRight($obj->rowid, $entitytotest);
						if ($ret < 0)
						{
							subpe_syslog("functions_subpe::check_user_password_subpe Authentification ko entity '" . $entitytotest . "' not allowed for user '" . $obj->rowid . "'");
							$login = array(); // force authentication failure
						}
					}
				}
			}
			else
			{
				subpe_syslog("functions_subpe::check_user_password_subpe Authentification ko user not found for '".$usertotest."'");
				
				// Load translation files required by the page
                $langs->loadLangs(array('main', 'errors'));
			}
		}
		else
		{
			subpe_syslog("functions_subpe::check_user_password_subpe Authentification ko db error for '".$usertotest."' error=".$db->lasterror());
		}
	}

	return $login;
}


function check_user_mobile($usermobile, $device_id, $entitytotest = 1)
{
	global $db,$conf,$langs;

	// Force master entity in transversal mode
	
	$login=array();

	if (! empty($usermobile))
	{
		dol_syslog("functions_subpe::check_user_mobile usermobile=".$usermobile." entitytotest=".$entitytotest);

		// If test username/password asked, we define $test=false if ko and $login var to login if ok, set also $_SESSION["dol_loginmesg"] if ko
		$table = MAIN_DB_PREFIX."socpeople";
		
		$sql ='SELECT rowid, firstname, lastname, email, phone_mobile, photo, otp, device_id, statut';
		$sql.=' FROM '.$table;
		$sql.= " WHERE phone_mobile = '".$db->escape($usermobile)."' AND device_id = '".$db->escape($device_id)."' ";
		// Required to first found the user into entity, then the superadmin.
		// For the case (TODO and that we must avoid) a user has renamed its login with same value than a user in entity 0.
		$sql.=' ORDER BY entity DESC';
		//echo $sql;
		$resql=$db->query($sql);
		if ($resql)
		{
			$obj=$db->fetch_object($resql);
			if ($obj)
			{
				// We must check entity
				 $phone_mobile = $obj->phone_mobile;		
				dol_syslog("functions_subpe::check_user_mobile Authentification ko user not found for '".$usertotest."'");
				
				// Load translation files required by the page
                $langs->loadLangs(array('main', 'errors'));
                $login=$obj;
			}
		}
		else
		{
			dol_syslog("functions_subpe::check_user_mobile Authentification ko db error for '".$usertotest."' error=".$db->lasterror());
		}
	}

	return $login;
}

function check_user_mobile_temp($usermobile, $entitytotest = 1)
{
	global $db,$conf,$langs;

	// Force master entity in transversal mode
	
	$login=array();

	if (! empty($usermobile))
	{
		dol_syslog("functions_subpe::check_user_mobile_temp usermobile=".$usermobile." entitytotest=".$entitytotest);

		// If test username/password asked, we define $test=false if ko and $login var to login if ok, set also $_SESSION["dol_loginmesg"] if ko
		$table = MAIN_DB_PREFIX."socpeople_temp";
		
		$sql ='SELECT rowid, firstname, lastname, email, phone_mobile, photo, otp, statut';
		$sql.=' FROM '.$table;
		$sql.= " WHERE phone_mobile = '".$db->escape($usermobile)."' ";
		// Required to first found the user into entity, then the superadmin.
		// For the case (TODO and that we must avoid) a user has renamed its login with same value than a user in entity 0.
		$sql.=' ORDER BY entity DESC';
		//echo $sql;
		$resql=$db->query($sql);
		if ($resql)
		{
			$obj=$db->fetch_object($resql);
			if ($obj)
			{
				// We must check entity
				 $phone_mobile = $obj->phone_mobile;		
				dol_syslog("functions_subpe::check_user_mobile_temp Authentification ko user not found for '".$usertotest."'");
				
				// Load translation files required by the page
                $langs->loadLangs(array('main', 'errors'));
                $login=$obj;
			}
		}
		else
		{
			dol_syslog("functions_subpe::check_user_mobile_temp Authentification ko db error for '".$usertotest."' error=".$db->lasterror());
		}
	}

	return $login;
}