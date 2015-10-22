<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

use AFTC\Framework\Config as Config;

Config::$show_page_generation_time = true;
Config::$site_path = "http://127.0.0.1/TheresNoPlaceLikeHome";
Config::$page_not_found = "404.htm";
Config::$encryption_key = "+++___+++1234+++___!!!:@~@:@~}{}{&&*8asd3tsdgsdg88888csaoi98uIICZZZZZXC<>?.";
Config::$enable_sessions = true;
Config::$session_https = false;
Config::$session_http_only = true; // This stops javascript being able to access the session id
Config::$session_name = "AFTC";

Config::$cookie_expiration_time = 48; // Time in hours

Config::$live_server_domain = "Frank";

// Live database configuration
Config::$database_live_host = "Frank";
Config::$database_live_name = "Frank";
Config::$database_live_username = "Frank";
Config::$database_live_password = "Frank";

// Dev database configuration
Config::$database_dev_host = "Frank";
Config::$database_dev_name = "Frank";
Config::$database_dev_username = "Frank";
Config::$database_dev_password = "Frank";