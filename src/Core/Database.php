<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 11/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config as Config;
use AFTC\Framework\Patterns\Singleton;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
	// http://www.doctrine-project.org/projects/dbal.html
	// http://doctrine-orm.readthedocs.io/projects/doctrine-dbal/en/latest/index.html
	// https://www.thedevfiles.com/2014/08/simplifying-database-interactions-with-doctrine-dbal/
	// http://www.doctrine-project.org/api/dbal/2.5/class-Doctrine.DBAL.Connection.html

	// Patterns
	use Singleton;

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $config;
	public $con;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function __construct()
	{
		$this->config = new \Doctrine\DBAL\Configuration();

		$connectionParams = array(
			'driver' => Config::$database_driver,
			'charset' => Config::$database_charset,
			'host' => Config::$database_host,
			'port' => Config::$database_port,
			'dbname' => Config::$database_db,
			'user' => Config::$database_username,
			'password' => Config::$database_password,
		);

		$this->con = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $this->config);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
		return $this->con->getNumRows();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertId()
	{
		return $this->con->getInsertID();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function queryToHTML()
	{
		return $this->con->queryToHTML();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function isConnected()
	{
		return $this->con->isConnected();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function disconnect()
	{
		$this->con->close();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}