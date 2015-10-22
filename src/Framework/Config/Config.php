<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Config;

class Config
{
    //public static $turn_output_buffering_on = true; // Enables ob_start();
    public static $show_page_generation_time = true;
    public static $site_path = "http://127.0.0.1/Clients/DataAndDreams/AFTC_PHP_Framework/www/";
    public static $page_not_found = "404.htm"; // This is your 404 page not found! (HOST can handle the rest)
    public static $encryption_key = "+++___+++1234+++___!!!:@~@:@~}{}{&&*8asd3tsdgsdg88888csaoi98uIICZZZZZXC<>?.";

    public static $enable_sessions = true;
    public static $session_https = false;
    public static $session_http_only = true; // This stops javascript being able to access the session id
    public static $session_name = "aftc_application_1";

    public static $cookie_expiration_time = 48; // time in hours

    /* Database configurations
        FEATURE:
            99% of the time I work on a development version of my projects on a different server and database
            having to manually switch the config values back and fore can be annoying so I will attempt to do this for you!
    */
    //public static $use_database = true;
    //public static $database_driver = "PDO"; // PDO || MYSQLI (TODO: MySQLi works but needs work for live use)
    public static $live_server_domain = "clients.aftc.co.uk/DND/IEMS/"; // EG: "www.allforthecode.co.uk" = LIVE  Anything other is DEV

    // Live database configuration
    public static $database_live_host = "10";
    public static $database_live_name = "all";
    public static $database_live_username = "all";
    public static $database_live_password = "xxxxxxxxxxxxxx";

    // Dev database configuration
    public static $database_dev_host = "127.0.0.1";
    public static $database_dev_name = "xxxxx";
    public static $database_dev_username = "xxx";
    public static $database_dev_password = "xxx";

}