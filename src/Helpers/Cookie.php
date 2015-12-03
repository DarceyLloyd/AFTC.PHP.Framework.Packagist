<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 03/12/2015
 */

namespace AFTC\Framework\Helpers;

use AFTC\Framework\Helpers\Encryption as Encryption;

class Cookie
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function set($key,$value)
	{
		$EncryptedKey = base64_encode(Encryption::ecbEncrypt($key));
		$EncryptedValue = Encryption::encrypt($value);
		trace($EncryptedKey);
		trace($EncryptedValue);
		//setcookie( $key, $value, strtotime( '+30 days' ) );
		//setcookie( $EncryptedKey, $EncryptedValue, strtotime( '+30 days' ) );
		setcookie( $key, $EncryptedValue, strtotime( '+30 days' ) );
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function get($key)
	{
		$DecryptedValue = "";

		if (isset($_COOKIE[$key])){
			$EncryptedValue = $_COOKIE[$key];
			$DecryptedValue = Encryption::decrypt($EncryptedValue);
		}

		return $DecryptedValue;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function delete($key)
	{
		setcookie($key, 'content', 1);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}