<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework\Core;


class Router
{
    protected static $routes = [];

    public function __construct()
    {

    }

    public static function addRoute($PageName,$Controller,$Function)
    {
        //trace("addRoute(" . $PageName . "," . $Controller . "," . $Function . ")");
        array_push(self::$routes,[$PageName,$Controller,$Function]);
    }

    public static function listRoutes()
    {
        //var_dump(self::$routes);

        echo("<ul>");
        foreach (self::$routes as $key => $value) {
            $PageName = $value[0];
            $Controller = $value[1];
            $Function = $value[2];
            echo("<li>ROUTE: Page: [" . $PageName . "] Controller: [" . $Controller . "] Function: [" . $Function ."]</li>");
        }
        echo("</ul>");
    }

}