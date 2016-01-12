<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 11/12/2015
 */

namespace AFTC\Framework\Core\Database\Drivers;

use AFTC\Framework\Core\singletons;
use PDO;

class PDODriver
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $con;
	public $connected = false;
	public $query;
	public $result;
	public $query_time = 0;

	private $params;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct($connection_paramaters)
	{
		$this->params = $connection_paramaters;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function connect()
	{
		if ($this->con == null) {
			try {
				$this->con = new PDO(
					"mysql:host=" . $this->params["host"] . ";dbname=" . $this->params["db"] . ";port=" . $this->params["port"],
					$this->params["username"],
					$this->params["password"]
				);
				/*
				 * INFO:
				 * PDO::ERRMODE_SILENT – database-related errors will be ignored.
				 * PDO::ERRMODE_WARNING – database-related errors will cause a warning to be emitted, but execution will continue.
				 * PDO::ERRMODE_EXCEPTION – database-related errors will cause a PDOException to be thrown.
				 */
				//$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				$this->connected = true;
			} catch (PDOException $e) {
				trace('PDO CONNECTION ERROR: ' . $e->getMessage());
				$this->connected = false;
				die;
			}
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function close()
	{
		$this->disconnect();
	}

	public function disconnect()
	{
		$this->con = null;
		$this->query = null;

		unset($this->con);
		unset($this->query);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function query($sql, $params = null)
	{
		$query_time = microtime(true);

		if ($this->con == null) {
			$this->connect();
		}

		try {
			$this->query = $this->con->prepare($sql);
			$this->query->execute($params);
			// Manual use of this is recommended fetch is faster but not by much
			// So we will return the query for the dev to use in the model as they see fit
			// Also as this is the model and we are not processing for output this should be done in the controller
			//$this->result = $this->query->fetchAll();
			$this->query_time = microtime(true) - $query_time;
			return $this->query;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function fetchAll()
	{
		$this->result = $this->query->fetchAll();
	}

	public function fetch()
	{
		$this->result = $this->query->fetch();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function exec()
	{
		$query_time = microtime(true);

		if ($this->con == null) {
			$this->connect();
		}

		try {
			$this->query = $this->con->prepare($sql);
			$this->query->exec($params);
			$this->result = $this->query->fetch();
			$this->query_time = microtime(true) - $query_time;
			return $this->result;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getRow($sql, $params = null)
	{
		$query_time = microtime(true);

		if ($this->con == null) {
			$this->connect();
		}

		try {
			$this->query = $this->con->prepare($sql);
			$this->query->execute($params);
			$this->result = $this->query->fetch();
			$this->query_time = microtime(true) - $query_time;
			return $this->result;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getRows($sql, $params = null)
	{
		$query_time = microtime(true);

		if ($this->con == null) {
			$this->connect();
		}

		try {
			$this->query = $this->con->prepare($sql);
			$this->query->execute($params);
			$this->result = $this->query->fetchAll();
			$this->query_time = microtime(true) - $query_time;
			return $this->result;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function fetchAssoc()
	{
		$this->result = $this->query->fetch(PDO::FETCH_ASSOC);
		return $this->result;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
		return $this->query->rowCount();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertId()
	{
		return $this->query->lastInsertId();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getError()
	{
		var_dump($this->con->errorInfo());
		var_dump($this->con->errorCode());
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function isConnected()
	{
		return $this->connected;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function query2HTML()
	{
		$html = "";
		if ($this->query == null) {
			$html = "
			<hr/>
			<h2>Query is null!</h2>
			<hr/>
			";
			return $html;
		}

		if ($this->query->rowCount() == 0) {
			$html = "<h3 style='margin:0;'>quer2HTML(): Query returned 0 rows!</h3>";
			return $html;
		}


		$html = "\n\n";
		$html .= "" . "\n";
		$html .= "<style>" . "\n";
		$html .= ".dbdump {font-size:12px; color:#000000; background:#CCCCCC; border:1px solid #000000; padding: 2px; overflow: auto;}" . "\n";
		$html .= ".dbdump table { border:none; padding: 2px; text-align: left; width: 100%}" . "\n";
		$html .= ".dbdump th { border:1px solid #000000; padding: 2px; text-align: left;}" . "\n";
		$html .= ".dbdump td { background:#999999; border:1px solid #000000; padding: 2px; text-align: left;}" . "\n";
		$html .= "" . "\n";
		$html .= "</style>" . "\n";
		$html .= "" . "\n";
		$html .= "" . "\n";


		$html .= "<div class='dbdump'><b>Query returned [" . $this->query->rowCount() . "] results. \$result of (fetch/fetchAll) to html = </b>\n";

		$html .= "<table class='dbdump' border='0' cellpadding='1' cellspacing='1'>\n";
		$html .= "\t" . "<thead>\n";
		$html .= "\t\t" . "<tr>\n";



		// Column headers
		//vd(is_array(reset($this->result)));

		$single = false;
		$process;
		if (is_array(reset($this->result))) {
			$html .= "\t\t\t" . "<th></th>\n";
			$process = $this->result[0];
		} else {
			$single = true;
			$process = $this->result;
		}

		foreach ($process as $key => $value) {
			$html .= "\t\t\t" . "<th>" . urldecode($key) . "</th>\n";
		}
		$html .= "\t\t" . "</tr>\n";
		$html .= "\t" . "</thead>\n";


		$html .= "\t" . "<tbody>\n";
		$cnt = 0;

		if ($single) {
			foreach ($process as $key => $value) {
				$html .= "\t\t\t" . "<td>" . $value . "</td>\n";
			}
		} else {
			foreach ($this->result as $key => $value) {
				$cnt++;
				$row = $this->result[$key];
				$html .= "\t\t" . "<tr>\n";
				$html .= "\t\t\t" . "<td>" . $cnt . "</td>\n";
				foreach ($row as $key => $value) {
					$html .= "\t\t\t" . "<td>" . $value . "</td>\n";
				}
				$html .= "\t\t" . "</tr>\n";
			}
		}


		$html .= "\t" . "<tbody>\n";
		$html .= "</table></div>\n";
		return $html;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}