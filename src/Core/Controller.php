<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 12/11/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Libraries\RequestLibrary;
use AFTC\Framework\Libraries\ResponseLibrary;


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class Controller
{

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public $route;
	public $response;
	public $request;

	public $page_access_user_category = "public"; // public || user || super user || group admin || admin
	public $page_access_group_id = 0; // 0 == any || group_id
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct($route)
	{
		//trace("Controller->construct()");
		$this->route = $route;
		$this->response = new ResponseLibrary($route);
		$this->request = new RequestLibrary();
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -