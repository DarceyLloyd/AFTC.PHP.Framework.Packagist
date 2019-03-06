<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 00:34
 */

namespace AFTC\App\Components\AFTC\Session;

use AFTC\App\Components\AFTC\Session\Config\Config;
use AFTC\Framework\Core\AFTC_Component;
use AFTC\Framework\Interfaces\iSessionComponent;

class SessionComponent extends AFTC_Component implements iSessionComponent
{

    private $session;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function __construct()
    {

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function start(){
        // http://php.net/manual/en/session.configuration.php
        // http://php.net/manual/en/session.security.ini.php
        // https://paragonie.com/blog/2017/12/2018-guide-building-secure-php-software

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
        session_set_cookie_params(
            $cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], Config::$sessionHttps, Config::$sessionHttpOnly
        );

        if (session_status() == PHP_SESSION_NONE) {
            session_name(Config::$sessionName);
            session_start([
                'cookie_httponly' => Config::$sessionHttpOnly,
                'cookie_secure' => true
            ]);
            ob_start();
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function regenerate($deleteOldSession = false){
        // http://php.net/manual/en/function.session-regenerate-id.php
        session_regenerate_id($deleteOldSession);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function destroy(){
        session_unset(); //destroys variables
        session_destroy(); //destroys session;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function getId(){
        // http://php.net/manual/en/function.session-id.php
        return session_id();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function setId($id){
        // http://php.net/manual/en/function.session-id.php
        session_id($id);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function getName(){
        // http://php.net/manual/en/function.session-name.php
        return session_name();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function setName($name){
        // http://php.net/manual/en/function.session-name.php
        session_name($name);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function isStarted(){
        if (session_status() == PHP_SESSION_NONE) {
            return false;
        } else {
            return true;
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function getSessionClass(){
        return $this->session;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function get($name){
        return $_SESSION[$name];
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function set($name,$value){
        $_SESSION[$name] = $value;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}