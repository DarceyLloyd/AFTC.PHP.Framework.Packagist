<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 03/2016
 */

namespace AFTC\Framework\Core;

// Autoload namespace method
//composer dumpautoload -o
require_once(__DIR__ . "../../../vendor/autoload.php");

// init custom variables
use AFTC\Framework\App\Variables;

Variables::init();

// Some global functions and utilties for use
$path = __DIR__ . "../../Functions.php";
require_once($path);
use \AFTC\Framework\Utilities as Utils;


// User config to overide what is set in Framework Config if not been used already
use AFTC\Framework\Config;

$path = __DIR__ . "../../../../../../Application/Config.php";
require_once($path);
//use \AFTC\Framework\Config;

// User routes which will use router
$path = __DIR__ . "../../../../../../Application/Routes.php";
require_once($path);


//$path = __DIR__ . "../../Ext/Singleton.php";
// Utilities class for the AFTC PHP Framework
use AFTC\Framework\Singleton;
use AFTC\Framework\Utilities;
use Defuse\Crypto\Crypto;


class AFTC
{
	// Traits  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	use Singleton;

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private $url = "";
	//private $url_parts = [];
	//private $url_no_of_dirs = 0;
	public $route = []; //url,controller,function
	private $controller_file = "";
	private $controller;
	private $page_class;
	private $page_cache_file;
	private $page_cache_file_exists;

	private $key_file1;
	private $key1;
	private $key_file2;
	private $key2;

	public $helpers = [];
	public $models = [];
	public $components = [];
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		// Make sure user config has overriden the framework default config!
		Config::init();

		// Setup encryption keys
		$this->createEncryptionKeyFiles();

		// Sessions
		$this->iniSessions();

		// init
		$this->init();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function createEncryptionKeyFiles()
	{
		$this->key_file1 = Config::$server_root_path . Config::$root_absolute_path . "Application/key1";
		$this->key_file2 = Config::$server_root_path . Config::$root_absolute_path . "Application/key2";
		

		clearstatcache();

		$encryption_files_missing = false;

		// Generate encryption key for Defuse
		if (!file_exists($this->key_file1)) {
			$this->key1 = Crypto::CreateNewRandomKey();
			file_put_contents($this->key_file1, $this->key1);

			$encryption_files_missing = true;
		}

		// Generate encryption key for AFTC ECB Encryption
		if (!file_exists($this->key_file2)) {
			$this->key2 = Utils::generateRandomString(32);
			$this->key2 = hash('sha256', $this->key2, true);
			file_put_contents($this->key_file2, $this->key2);

			$encryption_files_missing = true;
		}

		// Redirect after a pause so that we know encryption keys are available
		if ($encryption_files_missing) {
			sleep(2);
			if (isHTTPS()) {
				$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			} else {
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			}
			redirect($url);
			die;
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
			//session_name(Config::$session_name);

			ob_start();

			if (ini_set('session.use_only_cookies', 1) === FALSE) {
				echo("Could not initiate a safe session (ini_set)");
				exit();
			}
			
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function init()
	{
		// Get URL path
		if (isset($_GET["aftc"]) && !empty($_GET["aftc"])) {
			$this->url = $_GET["aftc"];
			$this->url = Utilities::removeTrailingSlash($this->url);
		}
		
		// Get the route
		$this->route = Router::getRouteByURL($this->url);

		if (!is_array($this->route)) {
			//header("HTTP/1.0 404 Not Found - " . $this->url);
			redirect(Config::$root_absolute_path . Config::$page_not_found . "?e=1&page=" . $this->url);
			die;
		}

		// Controller file
		$this->controller_file = Config::$server_root_path . Config::$root_absolute_path . "Application/Controllers/" . $this->route["controller"] . ".php";


		if (!file_exists($this->controller_file)) {
			redirect(Config::$root_absolute_path . Config::$page_not_found . "?e=2&page=" . $this->url . "&c=" . $this->controller_file);
			die;
		}

		// Cache file
		$function = $this->route["function"];
		$size = strlen($this->route["function"]);
		if ($size === 0) {
			$function = "init";
		}
		$this->page_cache_file = "page-" . $this->route["controller"] . $function;
		$remove = ["-", "\\"];
		$this->page_cache_file = str_replace($remove, "", $this->page_cache_file);
		$this->page_cache_file = Config::$server_root_path . "/Application/cache/" . $this->page_cache_file . ".htm";
		$function = null;
		$remove = null;

		$this->page_cache_file_exists = Utils::doesFileExist($this->page_cache_file);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function processRoute()
	{
		// Load up and output the controller or do we output the cache file?
		if ($this->route["cache"]) {
			// Does the cache file exist?
			if ($this->page_cache_file_exists) {
				$this->loadCachedPage();
			} else {
				$this->processController();
			}
		} else {
			$this->processController();

			// OUTPUT CONTROLLER GENERATED HTML

			//trace(Controller::getId());
			//echo($this->controller->html);
		}


	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function loadCachedPage()
	{
		echo(file_get_contents($this->page_cache_file));
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function processController()
	{

		$controller_path = $this->route["controller"];
		$controller_path = str_replace("/", "\\", $controller_path);
		$controller_class_name = $this->route["class"];
		$controller_class_function = $this->route["function"];
		$this->page_class = '\\AFTC\\Framework\\App\\Controllers\\' . $controller_path;

		$this->controller = new $this->page_class();

		if (!$controller_class_function) {

		} else {
			if (method_exists($this->controller, $controller_class_function)) {
				// Prevent duplicate execution where class & function are entered as the same name
				if ($controller_class_name != $controller_class_function) {
					$this->controller->$controller_class_function();
				}
			} else {
				trace("AFTC Framework message: The controller [" . $controller_class_name . "] doesn't have the function [" . $controller_class_function . "]
				that is defined in the route for execution!");
			}
		}


		// OUTPUT HTML
		if (property_exists($this->controller, "html")) {
			//header('Content-Type: text/html; charset=utf-8');
			echo($this->controller->html);
		}


		// Clean up database connection
		$db = Database::getInstance();
		if ($db->isConnected()) {
			$db->disconnect();
			unset($db);
			$db = null;
		}


	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}