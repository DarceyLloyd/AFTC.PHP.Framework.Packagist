<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 27/03/2017
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Config;
use AFTC\Framework\Utilities;

class ResponseLibrary
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $route;
	private $path;
	private $twig_loader;
	private $twig;

	private $view;

	public $data; // Page data for exposure to views
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct($route)
	{
		$this->route = $route;
		//vd($this->route);

		// Add some config params to page data (can be useful in views)
		$this->data["root_url"] = Config::$root_url;
		$this->data["root_path"] = Config::$root_path;

		// Init common view params
		/*
		$this->data["css_files"] = [];
		$this->data["js_files"] = [];

		$this->data["css"] = "";
		$this->data["js"] = "";
		*/

		// Var ini
		$this->path = Config::$view_path . "/";
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function twig($view)
	{
		// NOTE: Twig takes the path and file name at different locations
		// Twiggle it just a little bit!
		// http://twig.sensiolabs.org/doc/api.html
		// http://twig.sensiolabs.org/doc/templates.html

		// Twig 2.x for PHP 7.x
		$loader = new \Twig_Loader_Filesystem(Config::$view_path);

		// Initial twig configuration
		$twig_config = array(
			'cache' => Config::$template_engine_cache_dir,
			'strict_variables' => Config::$twig_strict_variables
		);


		// Configure twig (var defs 1st, then extensions after twig environment has been instantiated (bad design in v2.x)
		if (Config::$twig_debug){
			$twig_config["debug"] = true;
		}


		// Run Twig
		$twig = new \Twig_Environment($loader, $twig_config);


		// Configure twig (var defs 1st, then extensions after twig environment has been instantiated (bad design in v2.x)
		if (Config::$twig_debug){
			$twig->addExtension(new \Twig_Extension_Debug());
		}


		// Twig 2.x render
		echo $twig->render($view, $this->data);

		/*
		// Twig 1.x (for PHP 5.x)
		if (!$this->twig) {
			$twig_template_folder = Config::$view_path;
			$twig_cache_folder = Config::$template_engine_cache_dir;

			if (!$this->twig_loader) {
				$this->twig_loader = new \Twig_Loader_Filesystem($twig_template_folder);
			}

			if (!$this->twig) {
				$params = array(
					'cache' => $twig_cache_folder,
					'debug' => Config::$twig_debug,
					'strict_variables' => Config::$twig_strict_variables
				);
				$this->twig = new \Twig_Environment($this->twig_loader, $params);

				if (Config::$twig_debug){
					$this->twig->addExtension(new \Twig_Extension_Debug());
				}
			}
		}

		echo( $this->twig->render($view, $this->data) );

		*/

		if (Config::$show_page_generation_time){
			$this->outputHTMLRenderTimeNotice();
		}



		// Output render time logging
		if (Config::$page_generation_time_logging) {
			$this->logRenderTime();
		}


	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function php($view)
	{
		// NOTE: Sequence is important here

		// Var ini
		$cache_file_exists = false;
		$cache_file = "";
		$html = "";

		// Caching
		//vd($this->route);
		if ($this->route["cache"]){
			// Cache is on
			// Check if cache file exists
			$cache_file = Config::$php_view_cache_dir . "/" . pathinfo($view, PATHINFO_FILENAME)  . "." . $this->route["method"] . ".htm";
			//trace($cache_file);
			$cache_file_exists = file_exists($cache_file); // So we don't have to do it again below
			if ($cache_file_exists){
				// Process cache file exists
				// Check for cache update command
				if (!isset($_GET["updatecache"])){
					echo (file_get_contents($cache_file));
				} else {
					$html = $this->getRenderedView($view);
					$this->updateCacheFile($cache_file,$html);
				}
			} else {
				// Cache file doesn't exist, create it
				$html = $this->getRenderedView($view);
				$this->updateCacheFile($cache_file,$html);
			}
		} else {
			// Cache is off
			$html = $this->getRenderedView($view);
		}

		// Output controller output
		echo( $html );


		// Profiling
		if (Config::$show_page_generation_time){
			$this->outputHTMLRenderTimeNotice();
		}

		// Output render time logging
		if (Config::$page_generation_time_logging) {
			$this->logRenderTime();
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function getRenderedView($view)
	{
		$this->view = $this->path . $view;

		if (!file_exists($this->view)){
			echo("AFTC Framework: Controller Error: View file not found [" . $this->view . "]. (NOTE: Windows is non case sensitive, linux/Unix are, check your directory and file names.)");
			die();
		}

		// Render php controller into a string
		require($this->view);
		$html = ob_get_contents();
		ob_clean();

		return $html;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function updateCacheFile($cache_file,$html)
	{
		if (!isset($_GET["cache_update"])){
			// Cache file update is required, do nothing (new/updated file will be created after controller code below)
			$fhandle = fopen($cache_file, "w+");
			fwrite($fhandle, $html);
			fclose($fhandle);
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	
	



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function rest($responseType="json",$output=null)
	{
		/* REST { Representational State Transfer } is a simple stateless architecture that generally runs over HTTP.
		REST web service system produce status code response in JSON or XML format.
		*/

		if ($responseType==="json"){
			header('content-type: text/json');

			if (is_array($output) && $output !== null){

				echo json_encode($output);

				// Adds render time to json output (breaks structure for js processing etc (thus removed)
				/*
				if (Config::$show_page_generation_time){
					Config::$page_render_time = round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4);
					$output["generation_time"] = Config::$page_render_time;
					echo json_encode($output);
				} else {
					echo json_encode($output);
				}*/

			} else {
				// Adds render time to json output (breaks structure for js processing etc (thus removed)
				/*
				if (Config::$show_page_generation_time){
					Config::$page_render_time = round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4);
					$this->data["generation_time"] = Config::$page_render_time;
				}

				echo json_encode($this->data);
				*/
			}
		} else {
			//TODO: Recursive associative array parsing

			header('content-type: text/xml');

			$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$xml .= "<xml>\n";

			if (is_array($output) && $output !== null){
				$xml .= arrayToXML($output);
			} else {
				$xml .= arrayToXML($this->data);
			}

			// Adds render time to json output (breaks structure for js processing etc (thus removed)
			/*
			if (Config::$show_page_generation_time){
				Config::$page_render_time = round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4);
				$xml .= "\t" . "<generationTime>" . Config::$page_render_time . "</generationTime>\n";
			}
			*/

			$xml .= "</xml>\n";

			header('Access-Control-Allow-Origin: *');
			echo($xml);
		}


		// Output render time logging
		if (Config::$page_generation_time_logging) {
			$this->logRenderTime();
		}

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function soap($output=null)
	{
		/*
		SOAP is Simple Object Access Protocol based on XML so it easy to read. It is simple XML based
		protocol to exchange data between two different language.
		*/

		//TODO

		// Output render time logging
		if (Config::$page_generation_time_logging) {
			$this->logRenderTime();
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function write($file)
	{
		echo( file_get_contents($file) );


		// Output render time logging
		if (Config::$page_generation_time_logging) {
			$this->logRenderTime();
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function outputHTMLRenderTimeNotice()
	{
		Config::$page_render_time = round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4);
		$html = "<html><body><div id='AFTCFrameworkPageRenderTime' style='";
		$html .= "display:table; margin: 15px 5px 15px 0px; padding:2px; border:2px solid #BBBBBB; ";
		$html .= "background:#CCCCCC; color:#666666; font-family:arial; font-size:11px; margin: 10px 0 0 0";
		$html .= "'>";
		$html .= "AFTC Framework " . Config::$version . ": Page was generated in " . Config::$page_render_time . " seconds. " . Config::$page_generation_time_append_string;
		$html .= "</div></body></html>";
		echo($html);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function logRenderTime()
	{
		$file = Config::$dir . "/render_times.txt";
		$log_file = fopen($file, "a+") or die("Unable to open file!");
		$page = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$msg = '"'. Utilities::getDateTimeUK() . '",' . Config::$page_render_time . ',"' . $page . '"';
		fwrite($log_file, "\n" . $msg);
		fclose($log_file);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function header($type)
	{
		switch (strtolower($type)){
			case "401":

				break;
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



}