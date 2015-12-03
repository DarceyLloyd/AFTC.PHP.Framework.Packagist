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

			// Parse any AFTC Framework tags
			$new_html = $this->parseCSSJSTags($new_html); // Inserts root tags for parseViewTags to process
			//$new_html = $this->parseViewTags($new_html);

			$output_html = $old_html . $new_html;
			return $output_html;

			/*
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

			// Parse any AFTC Framework tags
			$new_html = $this->parseCSSJSTags($new_html); // Inserts root tags for parseViewTags to process
			$new_html = "bob";
			//$new_html = $this->parseViewTags($new_html);

			$output_html = $old_html . $new_html;
			return $output_html;
			*/
		} else {
			// File is not php based so we will just use file get contents
			return (file_get_contents($view_file_path));
			/*
			if (file_exists($view_file_path)) {
				return(file_get_contents($view_file_path));
			} else {
				echo("\n<br><h3>AFTC FRAMEWORK ERROR: loadView [" . $view_file_path . "] not found! Please go give your Web Developer a cup of tea to wake him up...</h3><br>\n");
			}
			*/
		}


		//return (file_get_contents($view));
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function parseViewTags($html)
	{
		/*
		 * [[domain]] = Config::$domain_live
		 * [[root url]] = Config::$root_url
		 * [[root relative path]] = Config::$root_relative_path
		 * [[root absolute path]] = Config::$root_absolute_path
		 * [[root path]] || [[root]] = [[root absolute path]]  || [[root relative path]]
		 */

		$html = str_replace("[[domain]]", Config::$domain, $html);
		$html = str_replace("[[root url]]", Config::$root_url, $html);
		$html = str_replace("[[root relative path]]", Config::$root_relative_path, $html);
		$html = str_replace("[[root absolute path]]", Config::$root_absolute_path, $html);

		$search = [
			"[[root path]]",
			"[[root]]"
		];
		if (Config::$path_method == "relative") {
			$html = str_replace($search, Config::$root_relative_path, $html);
		} else if (Config::$root_path_method == "absolute") {
			$html = str_replace($search, Config::$root_absolute_path, $html);
		}

		return $html;

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function parseCSSJSTags($html)
	{
		/*
		 * [[css includes]]
		 * [[js includes]]
		 */

		// process view/page specific css includes
		$css_html = "\n";
		if (sizeof($this->css_files) > 0) {
			foreach ($this->css_files as $value) {
				$css_html .= "\t<link type=\"text/css\" rel=\"stylesheet\" href=\"[[root]]/" . $value . "\"/>\n";
			}
		}
		$html = str_replace("[[css includes]]", $css_html, $html);

		// process view/page specific js includes
		$js_html = "\n";
		if (sizeof($this->js_files) > 0) {
			foreach ($this->js_files as $value) {
				$js_html .= "\t<script type=\"application/javascript\" src=\"[[root]]/" . $value . "\"></script>\n";
			}
		}
		$html = str_replace("[[js includes]]", $js_html, $html);

		$css_html = "";
		$js_html = "";

		return $html;
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	protected function addCSSInclude($file)
	{
		array_push($this->css_files,$file);
	}
	protected function addJSInclude($file)
	{
		array_push($this->js_files,$file);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function loadHelper($file_name)
	{
		$helper_file_path = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/Helpers/" . $file_name . ".php";
		require_once($helper_file_path);
		$this->helpers[$file_name] = new $file_name();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -