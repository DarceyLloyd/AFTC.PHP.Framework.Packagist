<?php

namespace AFTC\Framework\Config;

class Config
{
    // Configuration

    // Framework constants
    public static $version = "0.0.1";

    // Application mode (live/dev)
    public static $devMode = true;

    public static $email = "darcey.lloyd@gmail.com";
    public static $timeZone = "Europe/London"; // http://php.net/manual/en/timezones.php

    // Errors and Logging
    public static $showErrors = true;
    public static $logErrors = true;
    public static $errorLogFile = "/logs/error.log";

    public static $devLogFile = "/logs/dev.log";
    public static $devLogFileSizeLimit = (5*1024); //kb * 1024 = mb

    // https & Domain
    public static $httpsOnly = false;


    // Components (Class's which make up the core functionality of the AFTC Framework)
    public static $routerComponent = "";
    public static $databaseComponent = "";
    public static $sessionComponent = "";











    // Twig (Template Engine)
    // NOTE: Twig will only initialise if you use the controller functions using it
    public static $twigDebug = false;
    public static $twigStrictVariables = true;

    // Router
    public static $routerCacheDisabled = false;

    // Cookies
    public static $cookieExpirationTime = 2419200; // Time in sec (1h:3600, 24h:86400, 28d:2419200, 1y:31536000)

    // Security
    public static $passwordHasingCost = 12; // MUST BE 4 AND ABOVE WARNING: VALUES OVER 12 CAN SLOW DOWN PAGE GENERATION TIME CONSIDERABLY!!
    public static $encryptionMethod = "AES-256-CTR"; // Recommended options are AES-256-CTR || AES-256-CBC || AES-256-ECB

    // Database
    // http://www.doctrine-project.org/projects/dbal.html
    // Driver: pdo_mysql, pdo_sqlite, pdo_pgsql, pdo_oci, oci8, ibm_db2, pdo_sqlsrv, mysqli, drizzle_pdo_mysql, sqlanywhere, sqlsrv
    public static $useDatabase = true; // Enables or disables the Database Abstraction Layer
    public static $useDevDatabase = false;

    // Live database configuration
    // public static $databaseLiveDriver = "pdo_mysql";
    // public static $databaseLiveCharset = "utf8";
    // public static $databaseLiveHost = "";
    // public static $databaseLivePort = "3306";
    // public static $databaseLiveName = "";
    // public static $databaseLiveUsername = "";
    // public static $databaseLivePassword = "";

    // Dev database configuration
    // public static $databaseDevDriver = "pdo_mysql";
    // public static $databaseDevCharset = "utf8";
    // public static $databaseDevHost = "";
    // public static $databaseDevPort = "3306";
    // public static $databaseDevName = "";
    // public static $databaseDevUsername = "";
    // public static $databaseDevPassword = "";

    // Caches
    public static $cache = "var/cache";
    public static $viewCache = "var/cache/html";
    public static $templateEngineCache = "var/cache/twig";
    public static $routerCacheDir = "var/cache/router/route.cache";
    
    // Library folders
    public static $appFolder = "";
    public static $libraryFolder = "";
    public static $componentFolder = "";


    // DO NOT MODIFY ANYTHING BELOW THIS - VARIABLES FROM THIS POINT ARE CALCULATED
    public static $viewPath = "";
    public static $cacheView = "";
    public static $cacheTemplateEngine = "";
    public static $cacheRouter = "";

//    public static $databaseDriver = "mysqli";
//    public static $databaseCharset = "utf8";
//    public static $databaseHost = "127.0.0.1";
//    public static $databasePort = "";
//    public static $databaseName = "aftc19";
//    public static $databaseUsername = "root";
//    public static $databasePassword = "";


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function init()
    {
//        self::$viewPath = ROOT_DIR . "/App/Views/";
//
//        self::$cacheView = ROOT_DIR . self::$viewCache;
//        self::$cacheTemplateEngine = ROOT_DIR . self::$templateEngineCache;
//        self::$cacheRouter = ROOT_DIR . self::$routerCache;
//
//        self::$domain = $_SERVER["HTTP_HOST"];
//
//
//        // Get root url
//        // This will find ROOT URL on localhost / 127
//        /*
//        self::$rootUrl = str_replace("/index.php", "", $_SERVER["REQUEST_URI"]);
//        if (isHTTPS()) {
//            self::$rootUrl = "https://";
//        } else {
//            self::$rootUrl = "http://";
//        }
//        self::$rootUrl = self::$rootUrl . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//        self::$rootUrl = substr(self::$rootUrl,0,-2); // trim last 2 char(s) from url
//
//        self::$rootUrlPath = $_SERVER["REQUEST_URI"];
//        */
//
//
//        // Get root url
//        self::$rootUrl = "http://";
//        if (isHTTPS()) {
//            self::$rootUrl = "https://";
//        }
//        self::$rootUrl = self::$rootUrl . $_SERVER["HTTP_HOST"] . self::$rootUrlPath;
//
//        define("ROOT_URL", self::$rootUrl);
//        // pre(ROOT_URL);
//        // die();
//
//
//
//        // Framework paths
//        self::$appFolder = ROOT_DIR . "/App";
//        self::$libraryFolder = ROOT_DIR . "/App/Libraries";
//        self::$componentFolder = ROOT_DIR . "/App/Components";
//
//
//        if (self::$httpsOnly) {
//            self::$protocol = "https://";
//        } else {
//            if (isHTTPS()) {
//                self::$protocol = "https://";
//            } else {
//                self::$protocol = "http://";
//            }
//        }
//
//        // // Are we setting up for Dev or Live?
//        // $remove_list = ["http://", "https://"];
//        // $live_domain_check_string = strtolower(str_replace($remove_list, "", self::$domain_live));
//        // if ($_SERVER["HTTP_HOST"] != $live_domain_check_string) {
//
//        if (self::$useDevDatabase) {
//            self::$databaseDriver = self::$databaseDevDriver;
//            self::$databaseCharset = self::$databaseDevCharset;
//            self::$databaseHost = self::$databaseDevHost;
//            self::$databasePort = self::$databaseDevPort;
//            self::$databaseName = self::$databaseDevName;
//            self::$databaseUsername = self::$databaseDevUsername;
//            self::$databasePassword = self::$databaseDevPassword;
//        } else {
//            self::$databaseDriver = self::$databaseLiveDriver;
//            self::$databaseCharset = self::$databaseLiveCharset;
//            self::$databaseHost = self::$databaseLiveHost;
//            self::$databasePort = self::$databaseLivePort;
//            self::$databaseName = self::$databaseLiveName;
//            self::$databaseUsername = self::$databaseLiveUsername;
//            self::$databasePassword = self::$databaseLivePassword;
//        }
    }


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}
