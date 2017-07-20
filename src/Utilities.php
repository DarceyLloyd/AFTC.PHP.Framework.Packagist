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
	public static function getDateTimeUK()
	{
		$now  = date('d-m-Y H:i:s');
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getDateTimeUS()
	{
		$now  = date('m-d-Y H:i:s');
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getDateUK()
	{
		$now  = date('d-m-Y');
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getDateUS()
	{
		$now  = date('m-d-Y');
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getTime()
	{
		$now  = date('H:i:s');
		return $now;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getDateFrom($input)
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
	public static function getYesNoFrom($input)
	{
		$input_datatype = gettype($input);
		//echo("FROM: " . $input_datatype . " TO: " . $datatype . "<br>\n");
		switch ($input_datatype) {
			case "boolean":
				if ($input) {
					return "yes";
				} else {
					return "no";
				}
				break;
			case "string":
				if ($input == "1" || $input == "true" || $input ==  "y" || $input == 1)
				{
					return "yes";
				} else {
					return "false";
				}
				break;
			case "double":
				if ($input >= 1){
					return true;
				} else {
					return false;
				}
				break;
			case "int":
				if ($input >= 1){
					return true;
				} else {
					return false;
				}
				break;
		}

		return null;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getIntFromBoolean($input)
	{
		if (is_string($input)){
			if ($input == "true"){
				return 1;
			} else {
				return 0;
			}
		} else {
			if ($input){
				return 1;
			} else {
				return 0;
			}
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getIntFromString($input)
	{
		if (is_string($input)){
			$input = strtolower($input);
			if ($input == "true" || $input == "yes" || $input == "y" || $input == "1") {
				return 1;
			} else {
				return 0;
			}
		}

		if (is_bool($input)){
			if ($input == true){ return 1; }
			if ($input == false){ return 0; }
		}

		return "ERROR: getBitFromString(): UNABLE TO GET BIT FROM [". $input . "]";
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
	public static function convertDataType($input,$output_datatype)
	{

		$input_datatype = gettype($input);
		//echo("FROM: " . $input_datatype . " TO: " . $output_datatype . "<br>\n");
		switch ($output_datatype)
		{
			case "string":
				if ($input_datatype == "boolean"){
					if ($input){
						return "true";
					} else {
						return "false";
					}
				}
				return (string)$input;
				break;

			case "int":
				$input = preg_replace("/[^0-9\.]/", "",$input);
				return (int)$input;
				break;

			case "integer":
				$input = preg_replace("/[^0-9]/","",$input);
				return (int)$input;
				break;

			case "float":
				trace("input = " . $input);
				$input = preg_replace("/[^0-9\.]/", "",$input);
				return (float)$input;
				break;

			case "double":
				$input = preg_replace("/[^0-9\.]/", "",$input);
				return (double)$input;
				break;

			case "boolean":
				return self::getBoolean($input);
				break;

			case "bool":
				return self::getBoolean($input);
				break;

			default:
				return $input;
				break;
		}
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
				if ($input < 1){
					return false;
				} else {
					return true;
				}
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

	

}