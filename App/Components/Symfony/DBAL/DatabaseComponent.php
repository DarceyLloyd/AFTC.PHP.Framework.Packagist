<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 01/03/2019
 */

namespace AFTC\App\Components\Symfony\DBAL;

use AFTC\App\Components\Symfony\DBAL\Config\Config;
use AFTC\Framework\Core\AFTC_Component;
use AFTC\Framework\Core\AFTC_EventDispatcher;
use AFTC\Framework\Interfaces\iDatabaseComponent;
use AFTC\Framework\Patterns\Singleton;
use AFTC\Framework\Vo\AFTC_VO_EventNames;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

/**
 * https://symfony.com/doc/current/doctrine.html
 * http://www.doctrine-project.org/projects/dbal.html
 * https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/index.html
 * https://www.thedevfiles.com/2014/08/simplifying-database-interactions-with-doctrine-dbal/
 * http://www.doctrine-project.org/api/dbal/2.5/class-Doctrine.DBAL.Connection.html
 * https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/data-retrieval-and-manipulation.html#data-retrieval-and-manipulation
 */

class DatabaseComponent extends AFTC_Component implements iDatabaseComponent
{
    // Patterns
    use Singleton;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    /** @var Configuration */
    private $cfg;

    /** @var Connection */
    public $con;

    public $connected = false;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        require_once 'vendor/autoload.php';

        parent::__construct();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function connect()
    {
        // Event: preDatabaseConnect
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$preDatabaseConnect);

        // Connect
        if (!$this->connected) {
            $this->connected = true;

            $this->cfg = new Configuration();

            $connectionParams = array('driver' => Config::$databaseDriver, 'charset' => Config::$databaseCharset, 'host' => Config::$databaseHost, 'port' => Config::$databasePort, 'dbname' => Config::$databaseName, 'user' => Config::$databaseUsername, 'password' => Config::$databasePassword,);

            $this->con = DriverManager::getConnection($connectionParams, $this->cfg);
            // vd($this->con);
        }

        // Event: postDatabaseConnect
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$postDatabaseConnect);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function disconnect()
    {
        // Event: preDatabaseDisconnect
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$preDatabaseDisconnect);

        // TODO: Implement disconnect() method.

        // Event: postDatabaseDisconnect
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$postDatabaseDisconnect);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function isConnected()
    {
        if ($this->con) {
            return $this->con->isConnected();
        } else {
            return false;
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function query()
    {
        // Event: preDatabaseQuery
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$preDatabaseQuery);

        // TODO: Implement query() method.

        // Event: postDatabaseQuery
        AFTC_EventDispatcher::dispatchFrameworkEvent(AFTC_VO_EventNames::$postDatabaseQuery);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getConnection()
    {
        $this->connect();

        return $this->con;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getNumRows()
    {
        $this->connect();

        return $this->con->getNumRows();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getLastInsertId()
    {
        if ($this->con) {
            return $this->con->getInsertID();
        } else {
            return null;
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}