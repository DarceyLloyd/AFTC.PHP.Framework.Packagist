<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;

// Autoload namespace method
//composer dumpautoload -o
require_once(__DIR__ . "../../../vendor/autoload.php");


use \AFTC\Framework\Config as Config;
use \AFTC\Framework\Utilities as Utils;
//use \AFTC\Framework\Core\Router as Router;
//use \AFTC\Framework\Controller as Controller;


// Some global functions for use
$path = __DIR__ . "../../Functions.php";
require_once($path);

// User config to overide what is set in Framework Config
$path = __DIR__ . "../../../../../../AFTC/Config.php";
require_once($path);


// Utilities class for the AFTC PHP Framework


// User routes which will use router
$path = __DIR__ . "../../../../../../AFTC/Routes.php";
require_once($path);


class AFTC
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static $instance;
	public $id = 0;

	protected $url = "";
	protected $url_parts = [];
	protected $url_no_of_dirs = 0;
	public $route = []; //url,controller,function
	public $controller = "";
	protected $page_class;
	protected $page_cache_file;
	protected $page_cache_file_exists;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Singleton
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getInstance()
	{
		//trace("aftc.getInstance()");
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		// Sessions
		$this->iniSessions();

		// Var ini
		$this->iniVars();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function processRoute()
	{
		// Load up and output the controller or do we output the cache file?
		if ($this->route["cache"])
		{
			// Does the cache file exist?
			if ($this->page_cache_file_exists){
				$this->loadCachedPage();
			} else {
				$this->processController();
			}
		} else {
			$this->processController();

			// OUTPUT CONTROLLER GENERATED HTML
			echo($this->page_class->html);
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function iniSessions()
	{
		// Configure sessions
		// http://php.net/manual/en/session.configuration.php
		if (Config::$enable_sessions) {


			ini_set('use_strict_mode ', 1); //Available since PHP 5.5.2
			ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
			ini_set('session.cookie_secure', Config::$session_https);
			ini_set('session.cookie_httponly', Config::$session_http_only);
			ini_set('session.hash_function', 'whirlpool');
			ini_set('session.entropy_file', '/dev/urandom');
			ini_set('session.entropy_length', '512');

			$cookieParams = session_get_cookie_params(); // Gets current cookies params.
			session_set_cookie_params(
				$cookieParams["lifetime"],
				$cookieParams["path"],
				$cookieParams["domain"],
				Config::$session_https,
				Config::$session_http_only
			);

			session_start(); // Start the php session
			session_name(Config::$session_name);

			ob_start();

			if (ini_set('session.use_only_cookies', 1) === FALSE) {
				echo("Could not initiate a safe session (ini_set)");
				exit();
			}


		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function iniVars()
	{
		// Instance ID
		$this->id = rand(0, 99999999);

		// Config init
		Config::init();

		// Get URL path
		if (isset($_GET["aftc_url_path"]) && !empty($_GET["aftc_url_path"])) {
			$this->url = $_GET["aftc_url_path"];
		}

		// Get the route
		$this->route = Router::getRouteByURL($this->url);

		// 404
		if ($this->route == null)
		{

			header("location:".Config::$page_not_found."?page=".$this->route["url"]);
			exit;
		}

		// Controller file
		$this->controller = Config::$server_root_path . Config::$root_absolute_path . "/AFTC/Controllers/" . $this->route["controller"] . ".php";

		// Cache file
		$function = $this->route["function"];
		$size = strlen($this->route["function"]);
		if ($size === 0) {
			$function = "init";
		}
		$this->page_cache_file = "page-" . $this->route["controller"] . $function;
		$remove = ["-","\\"];
		$this->page_cache_file = str_replace($remove,"",$this->page_cache_file);
		$this->page_cache_file = Config::$server_root_path."/AFTC/cache/".$this->page_cache_file.".htm";
		$function = null;
		$remove = null;

		$this->page_cache_file_exists = Utils::doesFileExist($this->page_cache_file);
		//vd($this->page_cache_file);
		//vd($this->page_cache_file_exists);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function loadCachedPage()
	{
		echo( file_get_contents($this->page_cache_file) );
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function processController()
	{
		require_once($this->controller);
		$this->page_class = new $this->route["class"]();

		if (!$this->route["function"]){
			if (method_exists($this->page_class,"init"))
			{
				$this->page_class->init();
			} else {
				// Lets hope the developer is doing something with the controllers class constructor!
			}
		} else {
			// Lets hope the developer is doing something with the controllers class constructor!
		}

		//trace("Config::server_root_path = " . Config::$server_root_path);
		// OUTPUT PAGE HTML
		//echo($this->page_class->html);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -














}