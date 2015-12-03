<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 02/12/2015
 */

namespace AFTC\Framework\Helpers;

use AFTC\Framework\Helpers\Encryption as Encryption;


class Session
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function set($key,$value)
	{
		$EncryptedKey = Encryption::ecbEncrypt($key);
		$EncryptedValue = Encryption::encrypt($value);
		$_SESSION[$EncryptedKey] = $EncryptedValue;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function get($key)
	{
		$EencryptedKey = Encryption::ecbEncrypt($key);
		$DecryptedValue = "";

		if (isset($_SESSION[$EencryptedKey])){
			$EncryptedValue = $_SESSION[$EencryptedKey];
			$DecryptedValue = Encryption::decrypt($EncryptedValue);
		}

		return $DecryptedValue;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
}