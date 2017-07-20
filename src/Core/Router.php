<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config;
use FastRoute;

class Router
{
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// https://github.com/nikic/FastRoute
	// https://packagist.org/packages/nikic/fast-route
	protected static $dispatcher;
	protected static $routes = [];
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function addRoute($httpMethod,$url,$controller,$controllerMethod,$cache)
	{
		/* Router response ($route)
		 * array (size=5)
		 * 'httpMethod' => string 'GET/POST'
		 * 'controller' => string
		 * 'controllerMethod' => string
		 * 'cache' => boolean
		 * 'url_params' => array (based on fast route url definition)
		*/
		//GET','/article/{id:\d+}/{title1}/{title2}','Home/Home', '__construct', false
		$params = array (
			"httpMethod" => $httpMethod,
			"url" => $url,
			"controller" => $controller,
			"controllerMethod" => $controllerMethod,
			"cache" => $cache,
		);
		array_push(self::$routes,$params);
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public static function getRoute()
	{
		$config = [
			'cacheFile' => Config::$router_cache_file,
			'cacheDisabled' => Config::$router_cache_enabled,
		];

		/* Router response ($route)
		 * 'httpMethod' => string 'GET/POST'
		 * 'url' => string
		 * 'controller' => string
		 * 'method' => string controller class method
		 * 'cache' => boolean
		 * 'url_params' => array (based on fast route url definition)
		 * Router::addRoute('GET','/article/{id:\d+}[/{title}]','Home/Home', '__construct', false);
		 * $r->addRoute('GET', '/article/{id:\d+}/{title}', ["Home/Home", "default", false]);
		 * $r->addRoute('GET', '/article/{id:\d+}/{title}/{title2}', ["Articles/Viewer", "default", false]);
		*/
		
		self::$dispatcher = FastRoute\cachedDispatcher(function (FastRoute\RouteCollector $r) {
			foreach (self::$routes as $route) {
				$r->addRoute($route["httpMethod"], $route["url"], [$route["controller"], $route["controllerMethod"], $route["cache"]]);
			}
		}, $config);


		// Fetch method and URI from somewhere
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		//$uri = $_SERVER['REQUEST_URI']; // Use for root websites but doesn't work sub folder use (next 2 lines do)
		$base = dirname($_SERVER['PHP_SELF']);
		
		$uri = $_SERVER['REQUEST_URI'];
		// Strip query string (?foo=bar) and decode URI
		if (false !== $pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);
		

		// Strip query string (?foo=bar) and decode URI
		if (false !== $pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);
		//trace("uri = " . $uri);

		$routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);
		
		//vd($routeInfo[0]);

		switch ($routeInfo[0]) {
			case FastRoute\Dispatcher::NOT_FOUND:
				// ... 404 Not Found
				/*
				trace("404 Not Found");
				vd(self::$routes);
				vd($routeInfo);
				die();
				*/
				return "404";
				break;
			case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
				//$allowedMethods = $routeInfo[1];
				// ... 405 Method Not Allowed
				//trace("405 Not Found");
				return "405";
				break;
			case FastRoute\Dispatcher::FOUND:
				$params = array(
					"controller" => $routeInfo[1][0],
					"method" => $routeInfo[1][1],
					"cache" => $routeInfo[1][2],
					"params" => $routeInfo[2],
				);
				//vd($params);
				return $params;
				break;
		}

		// We shouldn't get this far, but if we do
		return "404";

	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}