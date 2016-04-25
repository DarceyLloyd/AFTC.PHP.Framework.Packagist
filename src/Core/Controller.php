<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 12/11/2015
 */

namespace AFTC\Framework\Core;
use AFTC\Framework\Config as Config;
use AFTC\Framework\App\Variables;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class Controller
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $data = [];

	public $css_files = []; // Array of CSS files so you don't need multiple views just for new js includes
	public $js_files = []; // Array of JS files so you don't need multiple views just for new js includes
	public $html = "";

	public $page_access_group = ""; // public || user || admin || db_group_names etc
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	final public function loadView($path)
	{
		$view = Config::$server_root_path . Config::$root_absolute_path . "Application/Views/" . $path;

		// For PHP to be processed and to return the page as a string we have to use ob_get_contents
		if (inStr(".php", $path)) {

			$view_html = "";
			require($view);
			if (ob_get_length() > 0) {
				$view_html = ob_get_contents();
				ob_clean();
			}

			return $view_html;
		} else {
			// File is not php based so we will just use file get contents
			return (file_get_contents($view));
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function cssIncludes($array)
	{
		$html = "\n";
		foreach ($array as $value)
		{
			$html .= "\t<link type='text/css' href='" . Config::$root_absolute_path . "includes/css/" . $value . "' rel='stylesheet'/>\n";
		}
		return $html;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function jsIncludes($array)
	{
		$html = "\n";
		foreach ($array as $value)
		{
			$html .= "\t<script type=\"text/javascript\" src=\"" . Config::$root_absolute_path . "includes/js/" . $value . "\"></script>\n";
		}
		return $html;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getData($index)
	{
		if (array_key_exists($index,$this->data)) {
			return ($this->data[$index]);
		} else {
			return "";
		}
	}
	public function echoData($index)
	{
		if (array_key_exists($index,$this->data)) {
			echo($this->data[$index]);
		} else {
			echo("");
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getVar($index)
	{
		// I want error notificaion if not found
		return(Variables::$injectables[$index]);

		/*
		// If you want error protection
		if (isSet(Variables::$injectables[$index])) {
			echo(Variables::$injectables[$index]);
		} else {
			echo("UNDEFINED");
		}
		*/
	}
	public function outputVar($index)
	{
		// I want error notificaion if not found
		echo(Variables::$injectables[$index]);

		/*
		// If you want error protection
		if (isSet(Variables::$injectables[$index])) {
			echo(Variables::$injectables[$index]);
		} else {
			echo("UNDEFINED");
		}
		*/
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -