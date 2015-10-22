<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

use AFTC\Framework\Core\Router as Router;

/**
 * USAGE:
 * $param1 = page url
 * $param2 = controller file name
 * $param3 = controller function name (blank will default call init)
 */

Router::addRoute("home","index","");