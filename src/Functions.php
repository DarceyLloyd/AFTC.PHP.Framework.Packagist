<?php
/**
 * User: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 */


function vds($var)
{
	ob_start();
	var_dump($var);
	return htmlspecialchars_decode(strip_tags(ob_get_clean()));
}


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('logError')) {
	function logError($arg){

		$msg = "";
		switch (strtolower(gettype($arg))) {
			case "array":
				$msg .= "Array():\n";
				foreach ($arg as $key => $value) {
					$msg .= "\t" . $key . " = " . $value . "\n";
				}
				error_log($msg);
				break;

			case "object":
				$msg .= "Object():\n";
				foreach ($arg as $key => $value) {
					$msg .= "\t" . $key . " = " . $value . "\n";
				}
				error_log($msg);
				break;

			default:
				error_log($arg);
				break;
		}


	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('logClear')) {
	function logClear(){
		file_put_contents("w:/xampp/php/logs/php_error_log", "");
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('trace')) {
	function trace($input = "")
	{
		$html = "";
		$html .= "<span style='font-size:16px; background: #FFFFFF; border:1px solid #000000;padding:3px; display:table; z-index:99999'>";
		switch (strtolower(gettype($input))) {
			case "array":
				$html .= "Array():<br>";
				foreach ($input as $key => $value) {
					$html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = " . $value . "<br>\n";
				}
				break;

			case "object":
				$html .= "Object():<br>";
				foreach ($input as $key => $value) {
					$html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = " . $value . "<br>\n";
				}
				break;

			case "boolean":
				if ($input) {
					$html .= "ture";
				} else {
					$html .= "false";
				}
				break;

			case "null":
				$html .= "null";
				break;

			default:
				$html .= $input;
				break;
		}
		$html .= "</span><br/>\n";

		echo($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('vd')) {
	function vd($var)
	{
		echo("<pre style='background: #DDDDDD; border:1px solid #000000; padding:5px; display: inline-block;'>");
		var_dump($var);
		echo("</pre><br>\n");
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('isArrayAssociative')) {
	function isArrayAssociative($array)
	{
		for ($i = 0; $i < count($array); $i++) {
			if (!isset($array[$i])) {
				return true;
			}
		}
		return false;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('arrayToXML')) {
	function arrayToXML($array)
	{
		$xml = "";
		foreach ($array as $key => $value) {
			if (is_array($value)){
				$xml .= "\t<" . $key . ">\n";
				arrayToXML($value);
				$xml .= "\t</" . $key . ">\n";
			} else {
				if (instr($key,"_")){
					$k = str_replace("_","-",$key);
					$xml .= "\t" . "<" . $k . ">" . $value . "</" . $k . ">\n";
				} else {
					$xml .= "\t" . "<" . $key . ">" . $value . "</" . $key . ">\n";
				}

			}
		}
		return $xml;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('isHTTPS')) {
	function isHTTPS()
	{
		return
			(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			|| $_SERVER['SERVER_PORT'] == 443;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('isStringInArray')) {
	function isStringInArray($string, $array)
	{
		$string = strtolower($string);
		foreach ($array as $value) {
			$value = strtolower($value);
			if (strpos($string, $value) !== false) {
				return true;
			}
		}
		return false;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('showMemoryUsage')) {
	function showMemoryUsage()
	{
		echo("<span style='display: table; padding: 3px; border:1px solid; font-size:12px; background: #FFFFFF;'>" . "memory_get_usage = " . floor(memory_get_usage() / 1024) . " KB" . "</span><br/>\n");
	}
}
if (!function_exists('showMemory')) {
	function showMemory()
	{
		showMemoryUsage();
	}
}
if (!function_exists('showMem')) {
	function showMem()
	{
		showMemoryUsage();
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('redirect')) {
	function redirect($url)
	{
		if (!headers_sent()) {
			header("Location: " . $url);
			die;
		} else {
			trace("REDIRECT TO [" . $url . "] FAILED - HEADERS HAVE ALREADY BEEN SENT TO THE BROWSER!");
		}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpArray')) {
	function dumpArray($arr)
	{
		foreach ($arr as $key => $value) {
			trace($key . " = " . $arr[$key]);
		}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function dumpAvailableClasses()
{
	$html = "";
	$html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
	$html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
	$html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>AVAILABLE CLASSES</caption>";

	$cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
	$cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
	foreach (get_declared_classes() as $key => $value) {
		$html .= "<tr>";
		$html .= "<td $cssKey>" . $key . "</th>";
		$html .= "<td $cssValue>" . $value . "</th>";
		$html .= "<tr>";
	}
	$html .= "</table>";
	$html .= "</div></br>";

	echo($html);
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpServer')) {
	function dumpServer()
	{
		$html = "";

		if (sizeof($_SERVER) == 0) {
			$html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpPost(): </span><span style=''>NO SERVER DATA TO LIST</span>
			</div></br>";
		} else {
			$html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
			$html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
			$html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>SERVER DATA</caption>";

			$cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			$cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			foreach ($_SERVER as $key => $value) {
				$html .= "<tr>";
				$html .= "<td $cssKey>" . $key . "</th>";
				$html .= "<td $cssValue>" . $value . "</th>";
				$html .= "<tr>";
			}
			$html .= "</table>";
			$html .= "</div></br>";
		}

		return ($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpPost')) {
	function dumpPost()
	{
		$html = "<div style='display:table;border:1px solid #000000;background: #444444; color:#FFFFFF;font-size:12px;margin:0; padding:5px;'>";
		$html .= "<h3 style='margin:0;padding:0;'>\$_POST DUMP</h3>";

		if (sizeof($_POST) == 0) {
			$html .= "<p style='margin:0;padding:0;'>NO POST DATA AVAILABLE</p>";
		} else {
			foreach ($_POST as $key => $value) {
				$html .= $key . ": " . $value . "<br>\n";
			}
		}

		$html .= "</div>";

		echo($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpGet')) {
	function dumpGet()
	{
		$html = "<div style='display:table;border:1px solid #000000;background: #444444; color:#FFFFFF;font-size:12px;margin:0; padding:5px;'>";
		$html .= "<h3 style='margin:0;padding:0;'>\$_GET DUMP</h3>";

		if (sizeof($_GET) == 0) {
			$html .= "<p style='margin:0;padding:0;'>NO GET DATA AVAILABLE</p>";
		} else {
			foreach ($_GET as $key => $value) {
				$html .= $key . ": " . $value . "<br>\n";
			}
		}

		$html .= "</div>";

		echo($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpSession')) {
	function dumpSession()
	{

		$html = "";
		if (sizeof($_SESSION) == 0) {
			$html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpSession(): </span><span style=''>NO SESSION DATA TO LIST</span>
			</div>";
			$html .= "<div style='clear:both;'></div>";
		} else {
			$html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
			$html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
			$html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>SESSION DATA</caption>";

			$cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			$cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			foreach ($_SESSION as $key => $value) {
				$html .= "<tr>";
				$html .= "<td $cssKey>" . $key . "</th>";
				$html .= "<td $cssValue>" . $value . "</th>";
				$html .= "<tr>";
			}
			$html .= "</table>";
			$html .= "</div>";
			$html .= "<div style='clear:both;'></div>";
		}

		return ($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpCookies')) {
	function dumpCookies()
	{

		$html = "";
		if (sizeof($_COOKIE) == 0) {
			$html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpCookies(): </span><span style=''>NO COOKIE DATA TO LIST</span>
			</div>";
			$html .= "<div style='clear:both;'></div>";
		} else {
			$html .= "<div style='display: block; border: 1px dashed #CC0000; margin:0; padding: 5px;'>";
			$html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
			$html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>COOKIE DATA</caption>";

			$cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			$cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
			foreach ($_COOKIE as $key => $value) {
				$html .= "<tr>";
				$html .= "<td $cssKey>" . $key . "</th>";
				$html .= "<td $cssValue>" . $value . "</th>";
				$html .= "<tr>";
			}
			$html .= "</table>";
			$html .= "</div>";
			$html .= "<div style='clear:both;'></div>";
		}

		return ($html);
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getPost')) {
	function getPost($param)
	{
		if (isSet($_POST[$param])) {
			$value = $_POST[$param];
			return $value;
		} else {
			return "";
		}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getGet')) {
	function getGet($param)
	{
		if (isSet($_GET[$param])) {
			$value = $_GET[$param];
			//$value = mysql_real_escape_string($value);
			/**/
			$value = str_replace("'", '', $value);
			$value = str_replace("`", '', $value);
			$value = str_replace("\"", '', $value);
			$value = str_replace("=", '', $value);

			//$value = sanitize($value);
			return $value;
		} else {
			return "";
		}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getSession')) {
	function getSession($param)
	{
		if (isSet($_SESSION[$param])) {
			$value = $_SESSION[$param];
			return $value;
		} else {
			return "";
		}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('instr')) {
	function instr($haystack, $needle)
	{
		$pos = strpos($haystack, $needle, 0);
		if ($pos != 0) return true;
		return false;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
/**
 * Function: sanitize
 * Returns a sanitized string, typically for URLs.
 *
 * Parameters:
 *     $string - The string to sanitize.
 *     $force_lowercase - Force the string to lowercase?
 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
 */
if (!function_exists('sanitize')) {
	function sanitize($string, $force_lowercase = false, $anal = false)
	{
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
			"}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
			"â€�?", "â€“", ",", "<", ".", ">", "/", "?");
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "-", $clean);
		$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
		return ($force_lowercase) ?
			(function_exists('mb_strtolower')) ?
				mb_strtolower($clean, 'UTF-8') :
				strtolower($clean) :
			$clean;
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function summarise($str, $limit)
{
	$array = explode(" ", $str);
	/*
	trace($str);
	foreach ($array as $value){
		trace("value = " . $value);
	}
	*/
	$return_string = "";
	for ($i = 0; $i <= $limit; $i++) {
		$return_string .= $array[$i] . " ";
	}

	$return_string = ltrim($return_string);
	$return_string = rtrim($return_string);

	return $return_string;
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -


// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function getSuffixFromFileName($str)
{
	$arr = explode(".", $str);
	$lastindex = sizeof($arr) - 1;
	$str = $arr[$lastindex];

	return $str;
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -


// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function dumpFileUploads()
{
	foreach ($_FILES as $key => $file) {

		trace("Uploaded: key: " . $key);
		trace("Uploaded: " . $file['name']);
		trace("Uploaded: " . $file['type']);
		trace("Uploaded: " . $file['size']);
		trace("Uploaded: " . $file['error']);
		trace("Uploaded: " . $file['tmp_name']);
		trace("");
		//trace("Uploaded: " . $_FILES[$file]["name"]);
	}
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

