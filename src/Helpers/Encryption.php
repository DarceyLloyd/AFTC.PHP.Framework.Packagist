<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 02/12/2015
 */

namespace AFTC\Framework\Helpers;

use AFTC\Framework\Config as Config;
use AFTC\Framework\Utilities as Utils;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception;


class Encryption
{
	// NOTE: Defuse encryption rotates so it cant be used for session / cookie keys etc, use ecbEncrypt and ecbDecrypt

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private static $init = false;

	private static $key_file1 = ""; // Key file path for Defuse Crypto Key storage
	private static $key1 = ""; // Key for use with Defuse Crypto, NOT with the AFTC Encrptor

	private static $key_file2 = ""; // Key file path for Defuse Crypto Key storage
	private static $key2 = ""; // Key for use with Defuse Crypto, NOT with the AFTC Encrptor
	private static $iv_size;
	private static $iv;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private static function init($regenerateKeys = false)
	{
		// KEYS & Var ini
		self::$init = true;
		self::$key_file1 = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/key1";
		self::$key_file2 = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/key2";

		if ($regenerateKeys){
			// Regenerate encryption key for Defuse
			self::$key1 = Crypto::CreateNewRandomKey();
			file_put_contents(self::$key_file1, self::$key1);

			// Regenerate encryption key for AFTC ECB Encryption
			self::$key2 = Utils::generateRandomString(32);
			self::$key2 = hash('sha256',self::$key2,true);
			file_put_contents(self::$key_file2, self::$key2);
		} else {
			// Generate encryption key for Defuse
			clearstatcache();
			if (file_exists(self::$key_file1)) {
				self::$key1 = file_get_contents(self::$key_file1);
			} else {
				self::$key1 = Crypto::CreateNewRandomKey();
				file_put_contents(self::$key_file1, self::$key1);
			}

			// Generate encryption key for AFTC ECB Encryption
			if (file_exists(self::$key_file2)) {
				self::$key2 = file_get_contents(self::$key_file2);
			} else {
				self::$key2 = Utils::generateRandomString(32);
				self::$key2 = hash('sha256',self::$key2,true);
				file_put_contents(self::$key_file2, self::$key2);
			}
		}

		// ECB setup
		self::$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		self::$iv = mcrypt_create_iv(self::$iv_size, MCRYPT_RAND);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getKey1()
	{
		return self::$key1;
	}
	public static function getKey2()
	{
		return self::$key2;
	}
	public static function regenerateKeys()
	{
		self::init(true);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function encrypt($str)
	{
		if (!self::$init){
			self::init();
		}

		return Crypto::encrypt($str,self::$key1);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function decrypt($str)
	{
		if (!self::$init){
			self::init();
		}

		return Crypto::decrypt($str,self::$key1);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function ecbEncrypt($input)
	{
		if (!self::$init){
			self::init();
		}

		$str = base64_encode( mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$key2, $input, MCRYPT_MODE_ECB, self::$iv_size) );
		return $str;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function ecbDecrypt($input)
	{
		if (!self::$init){
			self::init();
		}

		$str = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$key2, base64_decode($input), MCRYPT_MODE_ECB, self::$iv_size);
		return $str;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




}