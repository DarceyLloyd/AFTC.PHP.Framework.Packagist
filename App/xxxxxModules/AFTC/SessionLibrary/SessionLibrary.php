<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 */

namespace AFTC\App\Libraries\AFTC\SessionLibrary;


use AFTC\Framework\Core\AFTCLibrary;

class SessionLibrary extends AFTCLibrary
{
    // var ini
    public $started = false;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {



        // Var ini


        // No sessions under CLI
        if (isCli()) {
            //            logToFile("WARNING Sessions can't be started in the Command Line Interface (CLI)!");
            return false;
        } elseif ((bool)ini_get('session.auto_start')) {
            //            logToFile("WARNING Sessions are auto stated via session.auto_start in php.ini");
            $this->started = true;
            return true;
        }


        // Configure sessions
        // http://php.net/manual/en/session.configuration.php
        // http://php.net/manual/en/session.security.ini.php
        if (Config::$enableSessions) {
            // Although, enabling session.use_strict_mode is mandatory. It is not enabled by default
            ini_set('use_strict_mode ', 1); // Available since PHP 5.5.2

            // Although HTTP cookie has some problems, cookie is preferred way to manage session ID.
            // Use only cookies for session ID management when it is possible. Most applications should use cookie for session ID.
            ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
            if (ini_get('session.use_only_cookies') === FALSE) {
                echo("Could not initiate a safe session (ini_set)");
                exit();
            }

            // Allows access to session ID cookie only when protocol is HTTPS. If your web site is HTTPS only web site, you must enable this setting.
            ini_set('session.cookie_secure', Config::$sessionHttps);

            // Disallow access to session cookie by JavaScript. This setting prevents cookies stolen by JavaScript injection.
            ini_set('session.cookie_httponly', Config::$sessionHttpOnly);
            ini_set('session.hash_function', 'whirlpool');

            //ini_set('session.entropy_file', '/dev/urandom');
            ini_set('session.entropy_length', '512');

            $cookieParams = session_get_cookie_params(); // Gets current cookies params.
            //vd($cookieParams);
            session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], Config::$sessionHttps, Config::$sessionHttpOnly);

            if (session_status() == PHP_SESSION_NONE) {
                sessionName(Config::$sessionName);
                session_start(); // Start the php session
                ob_start();
                Config::$sessionStarted = true;
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}