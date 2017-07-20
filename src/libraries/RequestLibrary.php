<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 27/03/2017
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Helpers\StringHelper;

class RequestLibrary
{
	/*
	 * As soon as this enters we are going to process GET and POST so that the following can be used:
	 * xxxx->request->post("xxxx")
	 * xxxx->request->get("xxxx")
	 */


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $rest;
	private $post = [];
	private $get = [];
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		// TODO: Continue working on this
		// For processing rest json data
		$this->rest = new RestLibrary();

		/*
		if (sizeof($_GET) > 0){
			foreach ($_GET as $key => $value) {
				$this->get[$key] = htmlentities(stripcslashes(strip_tags($value)));

				trace($key . " = " . htmlentities($value) );
				trace($key . " = " . stripcslashes($value) );
				trace($key . " = " . strip_tags($value) );
			}
		}
		*/

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function ioCheck($method,$index)
	{
		// Ensure everything is lowercase
		$method = strtolower($method);
		$index = strtolower($index);
		$result = (object)[
			"pass" => false,
			"value" => ""
		];

		// Validate methods (get && post)
		if ($method !== "get" && $method !== "post"){
			$result->pass = false;
			$result->value = "RequestHelper:: Unhandled request method [" . $method . "]";
		}

		// Validate index exists and get value
		if ($method == "get"){
			if (isSet($_GET[$index])) {
				$result->pass = true;
				$result->value = $_GET[$index];
			}
		} else if ($method === "post") {
			if (isSet($_POST[$index])) {
				$result->pass = true;
				$result->value = $_POST[$index];
			}
		} else {
			$result->pass = false;
			$result->value = "RequestHelper:: Unable to find index [" . $index . "] on " . $method;
		}

		return $result;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function int($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::parseInt($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function float($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::parseFloat($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function number($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::number($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function boolean($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::parseBoolean($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function string($method,$index,$raw=false)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = $ioCheck->value;

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function html($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::html($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function htmlentities($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::htmlentities($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function htmlspecialchars($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::htmlspecialchars($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function seoString($method,$index)
	{
		$ioCheck = $this->ioCheck($method,$index);
		if (!$ioCheck->pass){
			return $ioCheck->value;
		}

		$value = StringHelper::seoString($ioCheck->value);

		unset($ioCheck);
		return $value;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function json()
	{
		// We can auto detect but
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			return json_decode(file_get_contents('php://input',true));
		} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			//$object = json_decode(json_encode((object) $_GET));
			return (object) $_GET;
		} else {
			return (object) ["AFTC_Request_Helper:"=>"Only POST and GET are supported (check routes.php and your js ajax method."];
		}

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * @param $method
	 * @param $index
	 * @param string $options
	 * @options array[strings]
	 *      email , alpha , numeric , alpha_numeric ,
	 *      sanitize_int , sanitize_float , sanitize_string , sanitize_url ,
	 *      urlencode , urldecode , html_encode , html_decode ,
	 *      special , sanitize , url , lite ,
	 *      strip_tags , mangle_js
	 * @param string $return_data_type
	 * @return bool|float|mixed|string
	 */


	/*
	public static function request(
		$method,
		$index,
		$options = "array[
				email , alpha , numeric , alpha_numeric ,
				sanitize_int , sanitize_float , sanitize_string , sanitize_url ,
				urlencode , urldecode , html_encode , html_decode , 
				special , sanitize , url , lite , 
				strip_tags , mangle_js
		]",
		$return_data_type = "string"
	)
	{
		$method = strtolower($method);
		if ($method !== "get" && $method !== "post") {
			return "RequestHelper:: \$method must be either 'post' or 'get'";
		}

		if ($index == "" || $index == null) {
			return "RequestHelper:: \$index must not be '' or null";
		}

		// Process method
		if ($method === "get") {
			if (isSet($_GET[$index])) {
				$value = urldecode($_GET[$index]);
			} else {
				return "RequestHelper:: Unable to find index [" . $index . "] on \$_GET";
			}
		} else if ($method === "post") {
			if (isSet($_POST[$index])) {
				$value = $_POST[$index];
			} else {
				return "RequestHelper:: Unable to find index [" . $index . "] on \$_POST";
			}
		} else {
			return "RequestHelper:: Unhandled request method [" . $method . "]";
		}

		// process options
		if (strtolower(gettype($options)) == "array") {
			foreach ($options as $option) {
				if ($option == "" || $option == null) {
					continue;
				}
				if ($option == "alpha" || $option == "letters" || $option == "letters_only") {
					$value = preg_replace("/[^a-zA-Z]+/", "", $value);
				} else
					if ($option == "numeric") {
						$value = preg_replace("/[^0-9]/", "", $value);
					} else
						if ($option == "alpha_numeric") {
							$value = preg_replace("/[^a-zA-Z0-9]+/", "", $value);
						} else
							if ($option == "sanitize_int" || $option == "sanitizeint") {
								$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
							} else
								if ($option == "sanitize_float" || $option == "sanitizefloat") {
									$value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
								} else
									if ($option == "sanitize_url" || $option == "sanitizeurl") {
										$value = filter_var($value, FILTER_SANITIZE_URL);
									} else
										if ($option == "email" || $option == "sanitize_email" || $option == "sanitizeemail") {
											$value = filter_var($value, FILTER_SANITIZE_EMAIL);
										} else
											if ($option == "sanitize" || $option == "sanitise" || $option == "sanitize_string") {
												$value = filter_var($value, FILTER_SANITIZE_STRING);
											} else
												if ($option == "urlencode" || $option == "url_encode") {
													$value = urlencode($value);
												} else
													if ($option == "urldecode" || $option == "url_decode") {
														$value = urldecode($value);
													} else
														if ($option == "html_encode" || $option == "htmlencode") {
															$value = htmlspecialchars($value);
														} else
															if ($option == "html_decode" || $option == "htmldecode") {
																$value = htmlspecialchars_decode($value);
															} else
																if ($option == "special") {
																	$value = self::removeSpecial($value);
																} else
																	if ($option == "url") {
																		$value = self::getSEOFriendlyUrlString($value);
																	} else
																		if ($option == "lite") {
																			$value = self::removeCustom1($value);
																		} else
																			if ($option == "strip" || $option == "strip_tags" || $option == "striptags" || $option == "remove_tags") {
																				$value = strip_tags($value);
																			} else
																				if ($option == "break_js" || $option == "mangle_js" || $option == "breakjs" || $option == "manglejs") {
																					$value = self::mangleJS($value);
																				} else {
																					$value = "RequestHelper:: Unhandled option given [" . $option . "]";
																				}
			}
		}

		// Process return
		if ($return_data_type == "" || $return_data_type == null) {
			return trim($value);
		} else {
			return Utilities::convertDataType($value, strtolower($return_data_type));
		}

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private static function removeSpecial($input)
	{
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
			"}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
			"â€�?", "â€“", ",", "<", ".", ">", "/", "?");
		$output = trim(str_replace($strip, "", strip_tags($input)));
		$output = preg_replace('/\s+/', "-", $input);
		$output = preg_replace("/[^a-zA-Z0-9]/", "", $input);
		return $output;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private static function removeCustom1($input)
	{
		$strip = array("~", "^", "\\", "|", "\"", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
			"â€�?", "â€“", "<", ">", "/");
		$output = trim(str_replace($strip, "", strip_tags($input)));
		//$output = preg_replace('/\s+/', "-", $input);
		//$output = preg_replace("/[^a-zA-Z0-9]/", "", $input);
		return $output;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private static function mangleJS($input)
	{
		$remove = array(
			"<script>", "</script>",
			"<SCRIPT>", "</SCRIPT>",
			"text/javascript", "Text/javascript",
			"alert(", "window.",
			"script", "< script",
			"&lt;/script", "&lt;/ script",
			"script&gt;", "script &gt;",
			"%3Cscript", "%3C script",
			"script%3E", "script %3E",
			"&lt;/SCRIPT", "&lt;/ SCRIPT",
			"SCRIPT&gt;", "SCRIPT &gt;",
			"%3CSCRIPT", "%3C SCRIPT",
			"SCRIPT%3E", "SCRIPT %3E",
			"document.", ".getElementBy",
			"%3C%3E", "%3C %3E", "%3C/%3E",
			"&lt;&gt;", "&lt;&gt;", "&lt;/&gt;",
			"<>", "</>",
		);
		$output = str_replace($remove, "", $input);
		return $output;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	*/

}