<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework;

class Config
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static $show_page_generation_time = false;
	public static $case_sensitive_urls = true;

	public static $path_method = "relative"; // relative || absolute

	public static $domain_live = "";
	public static $root_url_live = "";
	public static $root_relative_path_live = "";
	public static $root_absolute_path_live = "";

	public static $domain_dev = "";
	public static $root_url_dev = "";
	public static $root_relative_path_dev = "";
	public static $root_absolute_path_dev = "";

	// DO NOT SET (WILL BE SET BY THE ABOVE DEPENDING ON LIVE OR DEV MODE)
	public static $domain = "";
	public static $root_url = "";
	public static $root_relative_path = "";
	public static $root_absolute_path = "";

	public static $server_root_path = ""; // Set this in AFTC Framework>Config->init() if you have any issues set it manually

	public static $page_not_found = "404.htm"; // This is your 404 page not found! (HOST can handle the rest)

	public static $enable_sessions = true;
	public static $session_https = false;
	public static $session_http_only = true; // This stops javascript being able to access the session id
	public static $session_name = "aftc";

	public static $cookie_expiration_time = 0; // time in hours

	// MUST BE 4 AND ABOVE
	// WARNING: NUMBERS OVER 10 CAN SLOW DOWN PAGE GENERATION TIME CONSIDERABLY!!
	public static $password_hashing_cost = 12;

	public static $database_driver = ""; // TODO: PDO & MySQLi

	// Live database configuration
	public static $database_live_host = "255.255.255.255";
	public static $database_live_port = "3306";
	public static $database_live_name = "AllForTheCodeDB1";
	public static $database_live_username = "CrypticName";
	public static $database_live_password = "CrypticPassword";

	// Dev database configuration
	public static $database_dev_host = "127.0.0.1";
	public static $database_dev_port = "3306";
	public static $database_dev_name = "AllForTheCodeDB1Dev";
	public static $database_dev_username = "CrypticName";
	public static $database_dev_password = "CrypticPassword";

	// Database live & dev resolved variables
	public static $database_host = "";
	public static $database_port = "";
	public static $database_name = "";
	public static $database_username = "";
	public static $database_password = "";
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function init()
	{
		// Var ini
		// Set server root path if it's not already been set
		if (self::$server_root_path == "") {
			self::$server_root_path = $_SERVER["DOCUMENT_ROOT"];
		}

		// Set variables depending on whether we are on the development or live servers
		$domain = "";
		if (isset($_SERVER["HTTP_HOST"])) {
			$domain = $_SERVER["HTTP_HOST"];
		} else {
			$domain = $_SERVER["SERVER_NAME"];
		}

		if ($_SERVER["HTTP_HOST"] == self::$domain_dev) {
			self::$domain = self::$domain_dev;
			self::$root_url = self::$root_url_dev;
			self::$root_relative_path = self::$root_relative_path_dev;
			self::$root_absolute_path = self::$root_absolute_path_dev;

			self::$database_host = self::$database_dev_host;
			self::$database_port = self::$database_dev_port;
			self::$database_name = self::$database_dev_name;
			self::$database_username = self::$database_dev_username;
			self::$database_password = self::$database_dev_password;
		} else {
			self::$domain = self::$domain_live;
			self::$root_url = self::$root_url_live;
			self::$root_relative_path = self::$root_relative_path_live;
			self::$root_absolute_path = self::$root_absolute_path_live;

			self::$database_host = self::$database_live_host;
			self::$database_port = self::$database_live_port;
			self::$database_name = self::$database_live_name;
			self::$database_username = self::$database_live_username;
			self::$database_password = self::$database_live_password;
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}