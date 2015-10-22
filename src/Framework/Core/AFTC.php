<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;

// Include some generic functions for global use
require_once("Functions.php");

use AFTC\Framework\Config\Config as AFTC_Config;
use AFTC\Framework\Core\Utilities as AFTC_Utils;

use AFTC\Framework\Core\Router as AFTC_Router;
require_once(__DIR__ ."../../Config/Routes.php");

class AFTC
{
    public function __construct()
    {
        trace("AFTC.__construct()");
        //AFTC_Utils::staticTest();

        // Configure sessions
        if (AFTC_Config::$enable_sessions) {
            $session_name = AFTC_Config::$session_name; // Set a custom session name
            ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
            ini_set('session.entropy_file', '/dev/urandom'); // better session id's
            ini_set('session.entropy_length', '512'); // and going overkill with entropy length for maximum security
            ini_set('use_strict_mode ', 1); //Available since PHP 5.5.2

            $cookieParams = session_get_cookie_params(); // Gets current cookies params.
            session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], AFTC_Config::$session_https, AFTC_Config::$session_http_only);
            session_name($session_name); // Sets the session name to the one set above.
            session_start(); // Start the php session
            session_regenerate_id(true); // regenerated the session, delete the old one.

            if (ini_set('session.use_only_cookies', 1) === FALSE) {
                echo("Could not initiate a safe session (ini_set)");
                exit();
            }
        }

        AFTC_Router::listRoutes();
    }

    public function publicTest()
    {
        trace("AFTC.publicTest()");
    }

    private function privateTest()
    {
        trace("AFTC.privateTest()");
    }

    public static function publicStaticTest()
    {
        trace("AFTC.publicStaticTest()");
    }

    private static function privateStaticTest()
    {
        trace("AFTC.privateStaticTest()");
    }
}