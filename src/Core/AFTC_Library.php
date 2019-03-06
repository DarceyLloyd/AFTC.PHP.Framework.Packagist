<?php
/**
 * Author: Darcey Lloyd
 * Date: 16/03/2016
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Vo\AFTCVo;

class AFTC_Library
{
	/** @var AFTC_Utilities */
	protected $utils;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		$this->utils = AFTCVo::$utils;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	

	
}