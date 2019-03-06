<?php
/**
 * Author: Darcey Lloyd
 * Date: 11/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config\Config;
use AFTC\Framework\Patterns\Singleton;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class AFTC_Database
{
    // https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#configuration
	// http://www.doctrine-project.org/projects/dbal.html
	// http://doctrine-orm.readthedocs.io/projects/doctrine-dbal/en/latest/index.html
	// https://www.thedevfiles.com/2014/08/simplifying-database-interactions-with-doctrine-dbal/
	// http://www.doctrine-project.org/api/dbal/2.5/class-Doctrine.DBAL.Connection.html

	// Patterns
	use Singleton;

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private $cfg;
	public $con;
	public $connected = false;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function __construct()
	{
        
    }
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function connect()
    {
        if (!$this->connected){
            $this->connected = true;

            // NOTE: This doesn't automatically connect, DBAL will only connect if a query is executed
            $this->cfg = new Configuration();

            $connectionParams = array(
                'driver' => Config::$databaseDriver,
                'charset' => Config::$databaseCharset,
                'host' => Config::$databaseHost,
                'port' => Config::$databasePort,
                'dbname' => Config::$databaseName,
                'user' => Config::$databaseUsername,
                'password' => Config::$databasePassword,
            );

            $this->con = DriverManager::getConnection($connectionParams, $this->cfg);
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function initConnection()
    {
        if (!$this->connected){
            $this->connect();
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
        $this->initConnection();

		return $this->con->getNumRows();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertId()
	{
        $this->initConnection();

		return $this->con->getInsertID();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function queryToHTML()
	{
        $this->initConnection();

		//return $this->con->queryToHTML();
        return null;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function isConnected()
	{
        if ($this->con){
            return $this->con->isConnected();
        } else {
            return false;
        }
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function disconnect()
	{
        if ($this->con){
            $this->con->close();
        }
	}
	public function close(){
	    $this->disconnect();
    }
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}