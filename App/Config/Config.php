<?php

use AFTC\Framework\Config\Config;

Config::$devMode = true;


/**
 * Components
 * Class's which make up the core functionality of the AFTC Framework.
 * Components are wrappers for packages or straight up package namespaces.
 */

// Router component
Config::$routerComponent = "\AFTC\App\Components\AFTC\Router\RouterComponent"; // AFTC Router component (TODO: migrate to package aftc\framework-router-component)

// Database component
Config::$databaseComponent = "\AFTC\App\Components\Symfony\DBAL\DatabaseComponent"; // AFTC Database component

// Session component
// Want to use symfony sessions? Use "\AFTC\App\Components\Symfony\SessionComponent"
Config::$sessionComponent = "\AFTC\App\Components\AFTC\Session\SessionComponent"; // AFTC Session component (TODO: migrate to package aftc\framework-session-component)

new AFTC\App\Components\AFTC\Router\