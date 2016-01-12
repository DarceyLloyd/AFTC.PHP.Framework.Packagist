<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 11/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config as Config;
use AFTC\Framework\Core\Database\Drivers\PDODriver;
use AFTC\Framework\Core\Database\Drivers\MySQLiDriver;
//use AFTC\Framework\Core\Database\Drivers\PostgreDriver;
use AFTC\Framework\Singleton;

class Database
{
	// Trait
	use Singleton;

	// Vars
	public $driver;
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		if (strtolower(Config::$database_driver) === "pdo"){
			$this->driver = new PDODriver($this->getConnectionParamaters());
		} elseif (strtolower(Config::$database_driver) === "mysqli"){
			$this->driver = new MySQLiDriver($this->getConnectionParamaters());
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function getConnectionParamaters()
	{
		$params = [];

		$this->domain_live = Config::$domain_live;
		$this->domain_live = str_replace("http://", "", $this->domain_live);

		// Will assume dev if not live
		//$this->domain_dev = Config::$domain_dev;
		//$this->domain_dev = str_replace("http://", "", $this->domain_dev);

		// Work out which database values to use LIVE || Dev
		if ($_SERVER["HTTP_HOST"] === $this->domain_live) {
			$params = array(
				"host"=>Config::$database_live_host,
				"port"=>Config::$database_live_port,
				"db"=>Config::$database_live_name,
				"username"=>Config::$database_live_username,
				"password"=>Config::$database_live_password
			);
		} else {
			$params = array(
				"host"=>Config::$database_dev_host,
				"port"=>Config::$database_dev_port,
				"db"=>Config::$database_dev_name,
				"username"=>Config::$database_dev_username,
				"password"=>Config::$database_dev_password
			);
		}

		return $params;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
		return $this->driver->getNumRows();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertId()
	{
		return $this->driver->getInsertID();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function queryToHTML()
	{
		return $this->driver->queryToHTML();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function isConnected()
	{
		return $this->driver->isConnected();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function disconnect()
	{
		$this->driver->disconnect();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
}