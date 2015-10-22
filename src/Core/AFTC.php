<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config as Config;
$path = __DIR__ . "../../../AFTC/Config.php";
require_once($path);

// Utilities class for the AFTC PHP Framework
use AFTC\Framework\Utilities as Utils;

use AFTC\Framework\Router as Router;
$path = __DIR__ . "../../../AFTC/Routes.php";
require_once($path);

class AFTC
{
    public function __construct()
    {
        trace("AFTC.__construct()");
        trace("AFTC.__construct(): Config::\$site_path = " . Config::$site_path);
        Utils::staticTest();

        // Configure sessions
        if (Config::$enable_sessions) {
            $session_name = Config::$session_name; // Set a custom session name
            ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
            ini_set('session.entropy_file', '/dev/urandom'); // better session id's
            ini_set('session.entropy_length', '512'); // and going overkill with entropy length for maximum security
            ini_set('use_strict_mode ', 1); //Available since PHP 5.5.2

            $cookieParams = session_get_cookie_params(); // Gets current cookies params.
            session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], Config::$session_https, Config::$session_http_only);
            session_name($session_name); // Sets the session name to the one set above.
            session_start(); // Start the php session
            session_regenerate_id(true); // regenerated the session, delete the old one.

            if (ini_set('session.use_only_cookies', 1) === FALSE) {
                echo("Could not initiate a safe session (ini_set)");
                exit();
            }
        }

        Router::listRoutes();
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