<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 15/01/2019
 * Time: 17:49
 */

namespace AFTC\Framework;

use AFTC\Framework\Core\AFTC_EventDispatcher;
use AFTC\Framework\Core\AFTC_EventParser;
use AFTC\Framework\Core\AFTC_Base;
use AFTC\Framework\Core\AFTC_Database;
use AFTC\Framework\Core\AFTC_Event;
use AFTC\Framework\Core\AFTC_EventManager;
use AFTC\Framework\Core\AFTC_Utilities;
use AFTC\Framework\Interfaces\iRouterComponent;
use AFTC\Framework\Interfaces\iSessionComponent;
use AFTC\Framework\Libraries\ResponseLib;
use AFTC\Framework\Patterns\Singleton;
use AFTC\Framework\Config\Config;
use AFTC\Framework\Core\AFTC_Router;
use AFTC\Framework\Libraries\RequestLib;
use AFTC\Framework\Vo\AFTC_VO_RouteTypes;
use AFTC\Framework\Vo\AFTCVo;
use AFTC\Framework\Vo\AFTC_VO_EventNames;
use AFTC\Framework\Vo\AFTC_VO_EventTypes;
use AFTC\Framework\Vo\AFTC_VO_Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Class AFTC extends AFTC_Base
{
    // Patterns
    use Singleton;


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // Vars defs
    /** @var AFTC_Utilities $utils */
    protected $utils;



    /** @var iRouterComponent */
    protected $routerClass;

    /** @var AFTC_Database */
    protected $dbClass;

    /** @var iSessionComponent */
    protected $sessionClass;

    /** @var RequestLib */
    protected $request;

    /** @var ResponseLib */
    protected $response;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        /**
         * Init
         * - autoloader
         * - utils
         * - config init and app config init
         * - validations (https only etc)
         * - Router & App routes
         * - Session
         * - Middleware
         * - Request and Response lib init
         * - Middleware (pre db) - (Common, Service, Web) (session would be typically setup here)
         * - DBConnect
         * - Middleware (post db, pre controller) - (Common, Service, Web)
         * - Controller
         * - Middleware (post db, post controller) - (Common, Service, Web)
         * - ResponseHandler
         */

        // Autoload
        require_once(__DIR__ . "/../vendor/autoload.php");
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // parent::__construct();
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // AFTC VO
        AFTCVo::$aftc = $this;

        // AFTC Utilities
        $this->utils = new AFTC_Utilities();
        AFTCVo::$utils = $this->utils;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Config
        $this->initConfig();
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Validate https only (if set in config)
        $this->validateHttpsOnly();
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Init AFTC_EventDispatcher
        AFTC_EventDispatcher::init();
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Event
        // NOTE: Only COMMON->preRouter will fire as API->preRouter && WEB->preRouter are defined by the router itself
        AFTC_EventDispatcher::dispatchFrameworkEvent([AFTC_VO_EventNames::$init,AFTC_VO_EventNames::$preRouter]);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Router
        if (Config::$routerComponent != "") {
            $this->routerClass = new Config::$routerComponent();
            $this->routerClass->lookupRoute(); // Will redirect or die on error
            AFTCVo::$routeVo = $this->routerClass->getRoute();
        }
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Event
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$postRouter);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Database
        if (Config::$databaseComponent != "") {
            $this->dbClass = new Config::$databaseComponent;
            $this->dbClass->connect();
        }
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Event
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$preSession);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Sessions
        if (Config::$sessionComponent != "") {
            $this->sessionClass = new Config::$sessionComponent();
            $this->sessionClass->start();
        }
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Event
        AFTC_EventDispatcher::dispatchFrameworkEvent([AFTC_VO_EventNames::$postSession,AFTC_VO_EventNames::$preController]);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function initConfig()
    {


        // Config stage 1 of 2: Static class which the App\Config\Config.php will update it's variables
        require_once(ROOT_DIR . "/App/Config/Config.php"); // Remember to use / not \

        // Error configuration
        ini_set("error_log", ROOT_DIR . "/logs/error.log");
        if (Config::$logErrors) {
            ini_set('log_errors', 1);
            //error_log( "Logger to error test..." );
        } else {
            ini_set('log_errors', 0);
        }

        if (Config::$showErrors) {
            error_reporting(E_ALL);
            // error_reporting(E_ALL ^ E_NOTICE);
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }


        // Config stage 2 of 2: Call init to process any vars that need calculating
        Config::init();


        // Time zone
        date_default_timezone_set(Config::$timeZone);
        ini_set('date.timezone', Config::$timeZone);
        // trace(ini_get('date.timezone'));
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function validateHttpsOnly()
    {
        // HTTPS Only check
        if (Config::$httpsOnly) {
            if (!$this->is->isHTTPS()) {
                $redirectTo = ROOT_URL . "/" . $_SERVER["REQUEST_URI"];
                $redirectTo = "https://" . str_replace("http://", "https://", $redirectTo);
                //out("FORCE HTTPS ONLY: REDIRECT TO [" . $redirectTo . "]");
                redirect($redirectTo);
                die();
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}