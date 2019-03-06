<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 00:20
 */

namespace AFTC\Framework\Interfaces;


interface iRouterComponent
{
    public function addRoute($requestMethod, $url, $controller, $controllerMethod, $type, $custom = null);

    public function lookupRoute();

    public function getRoute();

    public function getErrorMessage();

    public function getErrorNo();

    public function isFound();
}