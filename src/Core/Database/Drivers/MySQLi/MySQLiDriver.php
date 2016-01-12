<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 11/12/2015
 */

namespace AFTC\Framework\Core\Database\Drivers;

use mysqli;

class MySQLiDriver
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $con;
	public $connected = false;
	public $query;
	public $result;
	public $query_time = 0;

	private $domain_live;
	private $domain_dev;

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
				$this->con = new mysqli(
					$this->params["host"],
					$this->params["username"],
					$this->params["password"],
					$this->params["db"]
				);
				$this->connected = true;
			} catch (PDOException $e) {
				trace('PDO CONNECTION ERROR: ' . $e->getMessage());
				trace("mysqli_connect_errno = " . mysqli_connect_errno());
				trace("mysqli_connect_error = " . mysqli_connect_error());
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
		if ($this->result){
			//$this->result->close();
			$this->result->free();
		}

		mysqli_close($this->con);

		$this->con = null;
		$this->query = null;

		unset($this->con);
		unset($this->query);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function query($sql)
	{
		/*
		if you want prepared statement usage with mysqli you can write more advanced queries in your models (too much wrapper for now)
		*/

		if ($this->con == null) {
			$this->connect();
		}

		$query_time = microtime(true);
		/*
		if ($params){
			// Process a prepared value binded query
			$this->query = $this->con->prepare($sql);
			$this->query->bind_param($params); // TO DO Wrapper for dynamic array to bind param
			$this->result = $this->query->execute();
		} else {
			// Direct query
			$this->result = mysqli_query($this->con,$sql);
		}
		*/

		$this->result = mysqli_query($this->con,$sql);
		$this->query_time = microtime(true) - $query_time;
		return $this->result;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
		return $this->result->num_rows;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertID()
	{
		return $this->con->inser_id;
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
		if ($this->result == null) {
			$html = "
			<hr/>
			<h2>Query is null!</h2>
			<hr/>
			";
			return $html;
		}

		if ($this->result->num_rows == 0) {
			$html = "<h3 style='margin:0;'>quer2HTML(): Query returned 0 rows!</h3>";
			return $html;
		}


		$html = "\n\n";
		$html .= "" . "\n";
		$html .= "<style>" . "\n";
		$html .= "#dbdump {font-size:12px; color:#000000;}" . "\n";
		$html .= "#dbdump th { background:#CCCCCC; border:1px solid #000000; padding: 2px; text-align: left;}" . "\n";
		$html .= "#dbdump td { background:#999999; border:1px solid #000000; padding: 2px; text-align: left;}" . "\n";
		$html .= "" . "\n";
		$html .= "</style>" . "\n";
		$html .= "" . "\n";
		$html .= "" . "\n";


		$html .= "Query returned [" . $this->result->num_rows . "] results</br>\n";

		$html .= "<table id='dbdump' border='0' cellpadding='1' cellspacing='1'>\n";
		$html .= "\t" . "<thead>\n";
		$html .= "\t\t" . "<tr>\n";

		// Column headers & row 1
		$first_row_html = "";
		$single_result = $this->result->fetch_assoc();

		// Manual count column
		$html .= "\t\t\t". "<th></th>\n";
		$first_row_html .= "\t\t\t<td>1</th>\n";

		foreach ($single_result as $key => $value)
		{
			$html .= "\t\t\t". "<th>".urldecode($key)."</th>\n";
			$first_row_html .= "\t\t\t<td>" . $value . "</th>\n";
		}
		$html .= "\t\t". "</tr>\n";
		$html .= "\t". "</thead>\n";

		$html .= "\t". "<tbody>\n";
		$html .= "\t\t". "<tr>\n";
		$html .= $first_row_html;
		$html .= "\t\t". "</tr>\n";

		// Dump out the rest
		$html .= "\t" . "<tbody>\n";
		$cnt = 1;
		while ($row = $this->result->fetch_assoc()) {
			$cnt++;
			$html .= "\t\t" . "<tr>\n";
			$html .= "\t\t\t" . "<td>" . $cnt . "</td>\n";
			foreach ($row as $key => $value) {
				$html .= "\t\t\t" . "<td>" . $value . "</td>\n";
			}
			$html .= "\t\t" . "</tr>\n";
		}

		$html .= "\t" . "<tbody>\n";


		$html .= "</table>\n";
		return $html;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}