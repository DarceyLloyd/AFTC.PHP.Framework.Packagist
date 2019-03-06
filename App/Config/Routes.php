<?php

Namespace AFTC\App\Config;

use AFTC\Framework\Interfaces\iRouterComponent;

class Routes {

    /** @var iRouterComponent */
    private $router;

    public function __construct(iRouterComponent $router)
    {
        /*
         * $router-addRoute(requestMethod, $url, $controller, $controllerMethod, $type, $cachePage)
         * @param string $requestMethod - GET, POST, PUT, PATCH, DELETE & HEAD
         * @param string $url - https://github.com/nikic/FastRoute
         * @param string $controller - partial namespace of controller to use from controller folder and up
         * @param string $controllerMethod - method to run in specified controller (if left blank will rely on __construct)
         * @param string $type - route type, COMMON, API & WEB (used for middleware)
         * @param * $custom  - OPTIONAL var for anything you wish the router to pass back for a specific route when a matching url has been found
         */

        // Encase we need a reference to it later?
        $this->router = $router;

        $router->addRoute(["POST","GET"],"/","HomeController","","WEB");
        $router->addRoute("GET","/Page1","HomeController","page1","WEB");
        $router->addRoute("POST","/Page2","HomeController","page2","WEB");
        $router->addRoute(["POST","GET"],"/Page3","HomeController","page3","WEB");
        $router->addRoute(["POST","GET"],"/Page4","HomeController","page4","WEB");


        $router->addRoute(["POST","GET"],"/aftc19/public_html/","HomeController","","WEB");

        
    }
}