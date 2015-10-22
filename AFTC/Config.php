<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

use AFTC\Framework\Config as Config;

Config::$show_page_generation_time = true;

Config::$website_root_url = "http://127.0.0.1/TheresNoPlaceLikeHome";

//Config::$website_root_file_path = ""; \\ You should not need to modify this, however if you do, here it is
//Config::$website_root_file_path = __DIR__ . "\\"; // NOTE Added \ at end so I can easily remove AFTC dir from end as we need root
//Config::$website_root_file_path = str_replace("\\AFTC\\","",Config::$website_root_file_path);

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