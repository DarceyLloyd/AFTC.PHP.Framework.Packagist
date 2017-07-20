<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 16/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config;
use Doctrine\DBAL\DriverManager;


class Model
{
	// http://www.doctrine-project.org/projects/dbal.html
	// http://doctrine-orm.readthedocs.io/projects/doctrine-dbal/en/latest/index.html
	// https://www.thedevfiles.com/2014/08/simplifying-database-interactions-with-doctrine-dbal/

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	//public $con;
	private $database;
	protected $db;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		$this->database = Database::getInstance();
		$this->db = $this->database->con; // To allow developer models to use $this->db->dbalCommand
		//trace("Database(): Instance created/obtained id:[" . $this->database->getID() . "]");
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getConnection()
	{
		trace("Model.getConnection()");
		return $this->database->con;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}