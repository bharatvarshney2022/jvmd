<?php
/* Copyright (C) 2000-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2003      Jean-Louis Bergamo   <jlb@j1b.org>
 * Copyright (C) 2004-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2009 Regis Houssin        <regis.houssin@inodbox.com>
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
 * or see https://www.gnu.org/
 *
 * Lots of code inspired from Dan Potter's CSMSFile class
 */

/**
 *      \file       htdocs/core/class/CSMSFile.class.php
 *      \brief      File of class to send sms
 *      \author	    Laurent Destailleur.
 */

/**
 *		Class to send SMS
 *      Usage: $smsfile = new CSMSFile($subject,$sendto,$replyto,$message,$filepath,$mimetype,$filename,$cc,$ccc,$deliveryreceipt,$msgishtml,$errors_to);
 *             $smsfile->sendfile();
 */
class CSMSSend
{
	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	public $addr_url;


	/**
	 *	CSMSFile
	 *
	 *	@param	string	$to                 Recipients SMS
	 *	@param 	string	$from               Sender SMS
	 *	@param 	string	$msg                Message
	 *	@param 	int		$deliveryreceipt	Not used
	 *	@param 	int		$deferred			Deferred or not
	 *	@param 	int		$priority			Priority
	 *	@param 	int		$class				Class
	 */
	public function __construct($url)
	{
		global $conf;

		// On definit fin de ligne
		$this->eol = "\n";
		if (preg_match('/^win/i', PHP_OS)) $this->eol = "\r\n";
		if (preg_match('/^mac/i', PHP_OS)) $this->eol = "\r";

		// If ending method not defined
		if (empty($conf->global->MAIN_SMS_SENDMODE))
		{
			$this->error = 'No SMS Engine defined';
			return -1;
		}

		// Action according to choosed sending method
		$this->addr_url = $url;
	}


	/**
	 * Send sms that was prepared by constructor
	 *
	 * @return    boolean     True if sms sent, false otherwise
	 */
	public function sendSMS()
	{
		global $conf;

		$errorlevel = error_reporting();
		error_reporting($errorlevel ^ E_WARNING); // Desactive warnings

		$res = false;

		
		$this->addr_url = stripslashes($this->addr_url);

		
		if (!empty($conf->global->MAIN_SMS_SENDMODE))    // $conf->global->MAIN_SMS_SENDMODE looks like a value 'class@module'
		{
			$tmp = explode('@', $conf->global->MAIN_SMS_SENDMODE);
			$classfile = $tmp[0]; $module = 'sms';
			dol_include_once('/'.$module.'/class/'.$classfile.'.class.php');
			try {
				$classname = ucfirst($classfile);
				$sms = new $classname($this->db);
				$sms->url = $this->addr_url;

				$res = $sms->SmsSend();
				if (!$res)
				{
					dol_syslog("CSMSFile::sendfile: sms send error=".$this->error, LOG_ERR);
				} else {
					//var_dump($res);        // 1973128
					if (!empty($conf->global->MAIN_SMS_DEBUG)) $this->dump_sms_result($res);
				}
			} catch (Exception $e)
			{
				dol_print_error('', 'Error to get list of senders: '.$e->getMessage());
			}
		} else {
			// Send sms method not correctly defined
			// --------------------------------------

			return 'Bad value for MAIN_SMS_SENDMODE constant';
		}

		return $res;
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Write content of a SendSms request into a dump file (mode = all)
	 *  Used for debugging.
	 *
	 *  @return	void
	 */
	public function dump_sms()
	{
		// phpcs:enable
		global $conf, $dolibarr_main_data_root;

		if (@is_writeable($dolibarr_main_data_root))	// Avoid fatal error on fopen with open_basedir
		{
			$outputfile = $dolibarr_main_data_root."/dolibarr_sms.log";
			$fp = fopen($outputfile, "w");

			fputs($fp, "From: ".$this->addr_from."\n");
			fputs($fp, "To: ".$this->addr_to."\n");
			fputs($fp, "Priority: ".$this->priority."\n");
			fputs($fp, "Class: ".$this->class."\n");
			fputs($fp, "Deferred: ".$this->deferred."\n");
			fputs($fp, "DisableStop: ".$this->nostop."\n");
			fputs($fp, "Message:\n".$this->message);

			fclose($fp);
			if (!empty($conf->global->MAIN_UMASK))
			@chmod($outputfile, octdec($conf->global->MAIN_UMASK));
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Write content of a SendSms result into a dump file (mode = all)
	 *  Used for debugging.
	 *
	 *  @param	int		$result		Result of sms sending
	 *  @return	void
	 */
	public function dump_sms_result($result)
	{
		// phpcs:enable
		global $conf, $dolibarr_main_data_root;

		if (@is_writeable($dolibarr_main_data_root))    // Avoid fatal error on fopen with open_basedir
		{
			$outputfile = $dolibarr_main_data_root."/dolibarr_sms.log";
			$fp = fopen($outputfile, "a+");

			fputs($fp, "\nResult id=".$result);

			fclose($fp);
			if (!empty($conf->global->MAIN_UMASK))
			@chmod($outputfile, octdec($conf->global->MAIN_UMASK));
		}
	}
}
