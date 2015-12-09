<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 12/11/2015
 */

namespace AFTC\Framework\Core;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class Helper
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $dependencies = [];
	public $helpers = [];
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function addDependency($dep)
	{
		array_push($this->dependencies,strtolower($dep));
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function dependencyCheck()
	{
		// Don't check if there are no dependencies to check
		if (sizeof($this->dependencies)==0){
			return;
		}

		// NOTE: Can't use inarray due to datatype issues
		$found = false;
		$value1 = "";
		$value2 = "";
		foreach ($this->dependencies as $key1 => $value1) {

			if (sizeof($this->helpers)==0){
				break;
			}

			foreach ($this->helpers as $key2 => $value2) {
				$value2 = strtolower(get_class($value2));
				//trace("CHECKING value1 [" . $value1 ."] == value2 [". $value2 ."]");
				if ($value1 == $value2) {
					$found = true;
					break;
				}
			}

			if ($found){
				break;
			}
		}

		if (!$found){
			$msg = "";
			$msg .= "AFTC Framwork Helper [" . get_called_class() . "] has a missing dependancy [" . $value1 . "]. ";
			$msg .= "Ensure you load the [" . $value1 . "] helper before the [" . get_called_class() . "] helper.";
			trigger_error($msg,E_USER_ERROR);
		}
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -