<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 16/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Core\Database;


class Model
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	protected $db;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		$this->db = Database::getInstance();
		//trace("Model.Construct(): DB Instance created [" . $this->db->getID() . "]");
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	

	protected function getRow($sql, $params = null)
	{
		return $this->db->driver->getRow($sql, $params);
	}

	protected function getRows($sql, $params = null)
	{
		return $this->db->driver->getRows($sql, $params);
	}

	protected function query($sql, $params = null)
	{
		return $this->db->driver->query($sql, $params);
	}

	protected function insert($sql, $params = null)
	{
		return $this->db->driver->insert($sql, $params);
	}

	protected function update($sql, $params = null)
	{
		return $this->db->driver->update($sql, $params);
	}

	protected function delete($sql, $params = null)
	{
		return $this->db->driver->delete($sql, $params);
	}

	protected function like($sql, $input)
	{
		return $this->db->driver->like($sql, $input);
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getResult($index=null)
	{
		if ($index==null){
			return $this->db->driver->result;
		} else {
			return $this->db->driver->result[$index];
		}

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getNumRows()
	{
		return $this->db->driver->getNumRows();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getInsertId()
	{
		return $this->db->driver->getInsertId();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getQueryTime()
	{
		return $this->db->driver->query_time;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function query2HTML()
	{
		return $this->db->driver->query2HTML();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}