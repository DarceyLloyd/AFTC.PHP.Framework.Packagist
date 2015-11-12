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
    public static $show_page_generation_time = true;

	public static $domain = ""; // All other domains will be considered
	public static $root_url = "";
	public static $root_relative_path = "";
	public static $server_root_path = "";
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    public static $page_not_found = "404.htm"; // This is your 404 page not found! (HOST can handle the rest)

    public static $encryption_key = "+++___+++1234+++___!!!:@~@:@~}{}{&&*8asd3tsdgsdg88888csaoi98uIICZZZZZXC<>?.";

    public static $enable_sessions = true;
    public static $session_https = false;
    public static $session_http_only = true; // This stops javascript being able to access the session id
    public static $session_name = "aftc";

    public static $cookie_expiration_time = 48; // time in hours

    //public static $database_driver = "PDO"; // TODO: PDO & MySQLi
    public static $live_server_domain = "www.allforthecode.co.uk/aftc_php_framework"; // EG: "www.allforthecode.co.uk" = LIVE  Anything other is DEV

    // Live database configuration
    public static $database_live_host = "255.255.255.255";
    public static $database_live_name = "AllForTheCodeDB1";
    public static $database_live_username = "Cryptic";
    public static $database_live_password = "Cryptic";

    // Dev database configuration
    public static $database_dev_host = "127.0.0.1";
    public static $database_dev_name = "AllForTheCodeDB1Dev";
    public static $database_dev_username = "Cryptic";
    public static $database_dev_password = "Cryptic";
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function init()
	{
		self::$server_root_path = self::getServerRootPath();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getServerRootPath()
	{
		return str_replace("\\vendor\\aftc\\framework\\src","",__DIR__);
		//return str_replace("vendor\\aftc\\framework\\src","",strtolower(__DIR__));
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}