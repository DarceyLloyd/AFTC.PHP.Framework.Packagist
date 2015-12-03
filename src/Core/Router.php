<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;


class Router
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	protected static $routes = [];
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function addRoute($URL, $Controller, $Function, $Cache)
	{
		//trace("addRoute(" . $URL . "," . $Controller . "," . $Function . "," . $cache . ")");
		array_push(self::$routes, [$URL, $Controller, $Function, $Cache]);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function listRoutes()
	{
		//var_dump(self::$routes);

		echo("<ul>");
		foreach (self::$routes as $key => $value) {
			$URL = $value[0];
			$Controller = $value[1];
			$Function = $value[2];
			$Cache = $value[3];
			echo("<li>ROUTE: Page: [" . $value[0] . "] Controller: [" . $value[1] . "] Function: [" . $value[2] . "] Cache: [" . $value[3] . "]</li>");
		}
		echo("</ul>");
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getRouteByURL($url)
	{
		foreach (self::$routes as $key => $value) {
			if ($value[0] === $url) {
				$parts = explode("/",$value[1]);
				$class = $parts[ sizeof($parts)-1 ];
				return [
					"url" => $value[0],
					"controller" => $value[1],
					"class" => $class,
					"function" => $value[2],
					"cache" => $value[3]
				];
				break;
			}
		}
		return null;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}