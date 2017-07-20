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
	public static $version = "0.9.5.8";

	// Configuration
	public static $enable_encryption = false;

	// General
	public static $page_not_found = "404.htm"; // This is your 404 page not found! (HOST can handle the rest)

	// Dev
	public static $show_page_generation_time = false;
	public static $page_generation_time_logging = false;
	public static $page_generation_time_append_string = "";
	public static $page_render_time = 0;

	// Twig (Template Engine)
	// NOTE: Twig will only initialise if you use the controller functions using it
	public static $twig_debug = true;
	public static $twig_strict_variables = true;

	// Router
	public static $router_cache_enabled = true;

	// Sessions
	public static $enable_sessions = true;
	public static $session_https = false;
	public static $session_http_only = true; // This stops javascript being able to access the session id
	public static $session_name = "AFTC";

	// Cookies
	public static $cookie_expiration_time = 2419200; // Time in sec (1h:3600, 24h:86400, 28d:2419200, 1y:31536000)

	// PHP Password
	public static $password_hashing_cost = 12; // MUST BE 4 AND ABOVE WARNING: VALUES OVER 12 CAN SLOW DOWN PAGE GENERATION TIME CONSIDERABLY!!

	// Domain: Will define Config::$domain
	public static $domain_dev = "http://127.0.0.1";
	public static $domain_live = "http://www.yourdomain.com";

	// Paths: NOTE: Use / for root. Will define Config::root_path for url paths
	public static $root_path_dev = "/"; // Root path after dev domain ( use / if at root of domain )
	public static $root_path_live = "/"; // Root path after live domain ( use / if at root of domain )

	// Database
	// http://www.doctrine-project.org/projects/dbal.html
	// Driver: pdo_mysql, pdo_sqlite, pdo_pgsql, pdo_oci, oci8, ibm_db2, pdo_sqlsrv, mysqli, drizzle_pdo_mysql, sqlanywhere, sqlsrv

	// Live database configuration
	public static $database_live_driver = "pdo_mysql";
	public static $database_live_charset = "utf8";
	public static $database_live_host = "255.255.255.255";
	public static $database_live_port = "3306";
	public static $database_live_db = "AllForTheCodeDB1";
	public static $database_live_username = "CrypticName";
	public static $database_live_password = "CrypticPassword";

	// Dev database configuration
	public static $database_dev_driver = "pdo_mysql";
	public static $database_dev_charset = "utf8";
	public static $database_dev_host = "127.0.0.1";
	public static $database_dev_port = "3306";
	public static $database_dev_db = "DatabaseName";
	public static $database_dev_username = "CrypticName";
	public static $database_dev_password = "CrypticPassword";


	// DO NOT MODIFY AFTER THIS POINT
	public static $domain = "";
	public static $root_url = ""; // full url path to root of aftc installation
	public static $root_path = ""; // url path to root of aftc installation excluding the domain

	public static $dir = ""; // Use ROOT
	public static $application_dir = "";

	public static $view_path = "/Application/Views"; // Will be appended to $dir || ROOT (Case sensitive)

	public static $php_view_cache_dir = "/var/cache/php"; // Will be appended to $dir
	public static $template_engine_cache_dir = "/var/cache/twig"; // Will be appended to $dir
	public static $router_cache_file = "/var/cache/router/route.cache";  // Will be appended to $dir

	// Database live & dev resolved variables
	public static $database_driver = "";
	public static $database_charset = "";
	public static $database_host = "";
	public static $database_port = "";
	public static $database_db = "";
	public static $database_username = "";
	public static $database_password = "";
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function init()
	{
		self::$application_dir = self::$dir . "\Application";
		self::$view_path = self::$dir . self::$view_path;
		self::$php_view_cache_dir = self::$dir . self::$php_view_cache_dir;
		self::$template_engine_cache_dir = self::$dir . self::$template_engine_cache_dir;
		self::$router_cache_file = self::$dir . self::$router_cache_file;

		// Set some variables depending on whether we are on the development or live servers
		$domain = str_replace("http://","",self::$domain_dev);
		$domain = str_replace("https://","",$domain);

		if ($_SERVER["HTTP_HOST"] == $domain) {
			self::$domain = self::$domain_dev;
			self::$root_url = self::$domain_dev . self::$root_path_dev;
			self::$root_path = self::$root_path_dev;

			self::$database_driver = self::$database_dev_driver;
			self::$database_charset = self::$database_dev_charset;
			self::$database_host = self::$database_dev_host;
			self::$database_port = self::$database_dev_port;
			self::$database_db = self::$database_dev_db;
			self::$database_username = self::$database_dev_username;
			self::$database_password = self::$database_dev_password;
		} else {
			self::$domain = self::$domain_live;
			self::$root_url = self::$domain_live . self::$root_path_live;
			self::$root_path = self::$root_path_live;

			self::$database_driver = self::$database_live_driver;
			self::$database_charset = self::$database_live_charset;
			self::$database_host = self::$database_live_host;
			self::$database_port = self::$database_live_port;
			self::$database_db = self::$database_live_db;
			self::$database_username = self::$database_live_username;
			self::$database_password = self::$database_live_password;
		}

		/*
		trace("self::\$dir: " . self::$dir);
		trace("self::\$domain: " . self::$domain);
		trace("self::\$root_url: " . self::$root_url);
		trace("self::\$root_path: " . self::$root_path);
		trace("self::\$view_path: " . self::$view_path);
		trace("self::\$framework_cache_dir: " . self::$framework_cache_dir);
		trace("self::\$template_engine_cache_dir: " . self::$template_engine_cache_dir);
		trace("self::\$router_cache_file: " . self::$router_cache_file);
		*/
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}