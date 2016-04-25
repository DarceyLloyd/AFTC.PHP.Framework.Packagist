<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework;

use Defuse\Crypto\Crypto as Crypto;
use Defuse\Crypto\Exception as Ex;


class Utilities
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getNiceDateTime()
	{
		$now  = date('d-m-y h:i:s'); // outout format 2008-04-04 07:30:00
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getDateUK($input)
	{
		$dt = new \DateTime($input);
		return $dt->format("d/m/Y");
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function urlEncodeArray($array)
	{
		$output = array();
		foreach ($array as $value) {
			array_push($output,$value);
		}
		return $output;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function xssClean($input)
	{
		$output = rawurldecode($input);
		$output = filter_var($output, FILTER_SANITIZE_STRING);
		return $output;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getGet($param)
	{
		if (isSet($_GET[$param])) {
			return $_GET[$param];
		} else {
			return null;
		}
	}
	public static function getCleanGet($param)
	{
		if (isSet($_GET[$param])) {
			return self::xssClean($_GET[$param]);
		} else {
			return null;
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getPost($param)
	{
		if (isSet($_POST[$param])) {
			return $_POST[$param];
		} else {
			return null;
		}
	}
	public static function getCleanPost($param)
	{
		if (isSet($_POST[$param])) {
			return self::xssClean($_POST[$param]);
		} else {
			return null;
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function convertZeroAndEmptyToNull($input){
		if ($input === 0){
			//trace("FOUND: input === 0 on [" . $input . "]");
			return null;
		}
		if ($input === ""){
			//trace("FOUND: input === '' on [" . $input . "]");
			return null;
		}
		if (strlen($input)==0){
			//trace("FOUND: strlen(input) == 0 on [" . $input . "]");
			return null;
		}
		if ($input == "null"){
			//trace("FOUND: input == 'null' on [" . $input . "]");
			return null;
		}

		//trace("NOT FOUND: on input [" . $input . "]");
		return $input;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function removeTrailingSlash($string)
	{
		return rtrim($string, '/');
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function generateRandomString($length = 10) {
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-+=[]{}@:;#~`?.,<>|';
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function deleteAllCookies()
	{
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function doesFileExist($file_path)
	{
		if (file_exists($file_path)) {
			return true;
		}
		return false;
	}

	public static function doesDirExist($path)
	{
		return doesFileExist($path);
	}

	public static function doesDirctoryExist($path)
	{
		return doesFileExist($path);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getUserIP()
	{
		// NOTE THERE IS NO 100% SECURE METHOD OF GETTING THE USERS IP!
		$ip = getenv('HTTP_CLIENT_IP') ?:
			getenv('HTTP_X_FORWARDED_FOR') ?:
				getenv('HTTP_X_FORWARDED') ?:
					getenv('HTTP_FORWARDED_FOR') ?:
						getenv('HTTP_FORWARDED') ?:
							getenv('REMOTE_ADDR');

		return $ip;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getStringBetween($startDelimiter, $endDelimiter, $str)
	{
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
			$contentStart += $startDelimiterLength;
			$contentEnd = strpos($str, $endDelimiter, $contentStart);
			if (false === $contentEnd) {
				break;
			}
			$contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
			yield substr($str, $contentStart, $contentEnd - $contentStart);
			$startFrom = $contentEnd + $endDelimiterLength;
		}
		$startDelimiterLength = null;
		$endDelimiterLength = null;
		$startFrom = null;
		yield $contents;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getBoolean($input)
	{
		$msg = "AFTC UTILITY: getBoolean is unable to get a boolean value from input: [" . $input . "] datatype: [". gettype($input) . "]";
		//http://php.net/manual/en/function.gettype.php
		switch (gettype($input))
		{
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "boolean":
				// really!?
				return $input;
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "string":

				if ($input == ""){
					return false;
				}

				if ($input == "true"){
					return true;
				}

				if ($input == "false"){
					return false;
				}

				if ($input == "1"){
					return true;
				}

				if ($input == "0"){
					return false;
				}

				if (strtolower($input) == "yes"){
					return true;
				}

				if (strtolower($input) == "no"){
					return false;
				}

				if (strtolower($input) == "y"){
					return true;
				}

				if (strtolower($input) == "n"){
					return false;
				}

				if (strtolower($input) == "null"){
					return false;
				}

				return $msg;

				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "integer":
				if ($input == 0){
					return false;
				} else {
					return true;
				}
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "double":
				if ($input == 0){
					return false;
				}

				if ($input == 1){
					return true;
				}

				return $msg;
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "NULL":
				return false;
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			default:
				return $msg;
			break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function toString($input)
	{
		//http://php.net/manual/en/function.gettype.php
		switch (gettype($input))
		{
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "boolean":
				if ($input){
					return "true";
				} else {
					return "false";
				}
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			case "NULL":
				return "NULL";
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			default:
				return $input;
				break;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}