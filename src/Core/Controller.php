<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 12/11/2015
 */

namespace AFTC\Framework\Core;
use AFTC\Framework\Config as Config;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class Controller
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $data = [];

	public $css_files = []; // Array of CSS files so you don't need multiple views just for new js includes
	public $js_files = []; // Array of JS files so you don't need multiple views just for new js includes
	public $html = "";

	public $page_access_group = "public"; // public || admin || db_group_names etc
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	final public function loadView($path)
	{
		$view = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/Views/" . $path;

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





}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -