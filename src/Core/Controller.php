<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 12/11/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config as Config;



//use AFTC\Framework\Core\AFTC as AFTC;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class Controller
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $models = [];
	public $helpers = [];

	public $data = [];

	public $css_files = []; // Array of CSS files so you don't need multiple views just for new js includes
	public $js_files = []; // Array of JS files so you don't need multiple views just for new js includes
	public $html = "";

	public $page_access_level = "public"; // public || user || admin || db_group_name etc
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function loadView($path)
	{
		$view = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/Views/" . $path;
		//$view = "../../../../../AFTC/views/" . $path;

		// For PHP to be processed and to return the page as a string we have to use ob_get_contents
		if (inStr(".php", $path)) {

			// We need PHP to process so we are going to be using OB_START / OB_CONTENT etc
			$old_html = "";
			$new_html = "";
			$view_html = "";

			// Store output and clean
			if(ob_get_length()>0){
				$old_html = ob_get_contents();
				ob_clean();
			}

			// Get the view, store it and clean
			require($view);
			if(ob_get_length()>0){
				$new_html = ob_get_contents();
				ob_clean();
			}

			$output_html = $old_html . $new_html;
			return $output_html;
		} else {
			// File is not php based so we will just use file get contents
			return (file_get_contents($view_file_path));
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -






	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function loadHelper($file_name)
	{
		$helper_file_path = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/Helpers/" . $file_name . ".php";
		require_once($helper_file_path);
		$this->helpers[strtolower($file_name)] = new $file_name($this->helpers);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -