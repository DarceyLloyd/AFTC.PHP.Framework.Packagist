<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 03/2016
 */

namespace AFTC\Framework\Core;

require_once($GLOBALS["AFTCRoot"] . "/vendor/aftc/framework/vendor/autoload.php");

use AFTC\Framework\App\Helpers\RequestHelper;
use AFTC\Framework\Patterns\Singleton;
use AFTC\Framework\App\Variables;
use AFTC\Framework\Config;
use AFTC\Framework\App\Helpers\StringHelper;
use AFTC\Framework\Utilities;
use Defuse\Crypto\Crypto;



class AFTC
{
	// Patterns  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	use Singleton;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	/* Router response ($route)
	 * array (size=5)
	 * 'httpMethod' => string 'GET/POST'
	 * 'url' => string
	 * 'controller' => string
	 * 'method' => string controller class method
	 * 'cache' => boolean
	 * 'url_params' => array (based on fast route url definition)
	*/
	private $route;

	private $key_file1;
	private $key1;
	private $key_file2;
	private $key2;

	private $controller_namespace;
	private $controller_method;
	private $controller;

	private $page_cache_file;
	private $page_cache_file_exists = false;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// used by index, no constructor as I want getInstance to work if anyone needs it
	public function init()
	{
		//trace("AFTC.init()");

		/*
		* Process any commands
		* Config init
		* Process EncryptionKeyFileHandler
		* Router
		* Session
		* Controller
		* Output
		* Check DB for close and clean
		*/

		// Commands
		if (isset($_GET["cmd"])){
			$cmd = strtolower($_GET["cmd"]);
			switch($cmd){
				case "render-times":
					echo( file_get_contents($GLOBALS["AFTCRoot"]."/render_times.txt") );
					die();
					break;
				case "clear-render-times":
					file_put_contents( $GLOBALS["AFTCRoot"]."/render_times.txt" , "" );
					break;
			}
		}


		// Set some config values
		//Config::$dir = str_replace("\\vendor\\aftc\\framework\\src\\core","",__dir__);
		Config::$dir = $GLOBALS["AFTCRoot"]; // Duplication but is nice for inteli'

		// Override default framework config with users application config
		require_once(Config::$dir . "/Application/Config/Config.php");
		Config::init();

		// Setup encryption keys
		if (Config::$enable_encryption){
			$this->processEncryptionKeyFiles();
		}

		// Router
		$this->processRoute();

		// Sessions
		$this->iniSessions();

		// Controller
		$this->processController();

		// DB Cleanup
		$db = Database::getInstance();
		//trace("Database(): Instance created/obtained id:[" . $db->getID() . "]");
		//trace("DB Connected = " . Utilities::getYesNoFrom($db->con->isConnected()));
		if ($db->con->isConnected()){
			$db->con->close();
		}
		//trace("DB Connected = " . Utilities::getYesNoFrom($db->con->isConnected()));
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -







	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function processEncryptionKeyFiles()
	{
		$key_file1 = Config::$dir . "\\" . "var\\keys\\key1";
		$key_file2 = Config::$dir . "\\" . "var\\keys\\key2";

		// If there are issues with cache
		//clearstatcache();

		$encryption_files_missing = false;

		// Generate encryption key for Defuse
		if (!file_exists($key_file1)) {
			$this->key1 = Crypto::createNewRandomKey();
			file_put_contents($key_file1, $this->key1);

			$encryption_files_missing = true;
		}

		// Generate encryption key for AFTC ECB Encryption
		if (!file_exists($key_file2)) {
			$this->key2 = StringHelper::generateRandomString(32);
			$this->key2 = hash('sha256', $this->key2, true);
			file_put_contents($key_file2, $this->key2);

			$encryption_files_missing = true;
		}

		// Redirect after a pause so in an attempt to ensure key files have been generated and are not creation locked
		if ($encryption_files_missing) {
			sleep(1);
			if (isHTTPS()) {
				$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			} else {
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			}
			redirect($url);
			die();
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function processRoute()
	{
		// User routes which will use router
		$path = Config::$dir . "/Application/Config/Routes.php";
		require_once($path);

		$this->route = Router::getRoute();

		if ($this->route === "404"){
			//trace("404 redirect = 404.htm");
			//$redirect = Config::$root_url . "/404.htm";
			redirect(Config::$root_url . "/404.htm");
			die();
		} else if ($this->route === "405"){
			//trace("405 redirect = 405.htm");
			redirect(Config::$root_url . "/405.htm");
			die();
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
			//ini_set('session.entropy_file', '/dev/urandom');
			ini_set('session.entropy_length', '512');

			$cookieParams = session_get_cookie_params(); // Gets current cookies params.
			//vd($cookieParams);
			session_set_cookie_params(
				$cookieParams["lifetime"],
				$cookieParams["path"],
				$cookieParams["domain"],
				Config::$session_https,
				Config::$session_http_only
			);

			if (session_status() == PHP_SESSION_NONE) {
				session_start(); // Start the php session
				//session_name(Config::$session_name);
				ob_start();
			}



			if (ini_set('session.use_only_cookies', 1) === FALSE) {
				echo("Could not initiate a safe session (ini_set)");
				exit();
			}
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -







	/*
	* 'httpMethod' => string 'GET/POST'
	* 'url' => string
	* 'controller' => string
	* 'method' => string controller class method
	* 'cache' => boolean
	* 'url_params' => array (based on fast route url definition)
	*/
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function processController()
	{
		/*
		$controller_path = $this->route["controller"];
		$controller_path = str_replace("/", "\\", $controller_path);
		$controller_class_name = $this->route["class"];
		$controller_class_function = $this->route["function"];
		$this->page_class = '\\AFTC\\Framework\\App\\Controllers\\' . $controller_path;
		$this->controller = new $this->page_class();
		*/

		//$this->controller_file = Config::$root_absolute_path . "/" . $this->route["controller"];
		$this->controller_namespace = '\\AFTC\\Framework\\App\\Controllers\\' . $this->route["controller"];
		$this->controller_method = $this->route["method"];


		// TODO: AFTC Framework full controller caching (NOTE: ONLY FOR PHP Views)


		// Execute controller (will run __construct());
		//vd($this->route);
		$this->controller = new $this->controller_namespace($this->route);


		if ($this->controller_method != null && $this->controller_method != "") {
			if (method_exists($this->controller, $this->controller_method)) {
				$controller_method = $this->controller_method;
				$this->controller->$controller_method();
			} else {
				trace("AFTC Framework: The controller/namespace [" . $this->controller_namespace . "] doesn't have the method [" . $this->controller_method . "]");
			}
		}

		//trace("controller_namespace = " . $this->controller_namespace);
		//trace("controller_method = " . $this->controller_method);
		//vd($this->controller);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	/*private function outputController()
	{
		// OUTPUT HTML
		if (property_exists($this->controller, "html")) {
			//header('Content-Type: text/html; charset=utf-8');
			echo($this->controller->html);
		}
	}*/
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





}