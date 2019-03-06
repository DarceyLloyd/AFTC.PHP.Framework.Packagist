<?php

/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 15/01/2019
 * Time: 17:49
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$ScriptStartTime = microtime(true);
$ScriptEndTime = 0;

// Define public dir here as this script is in that folder and thus can be moved and the AFTC Framework will handle it
define("PUBLIC_DIR",__DIR__);

// Get URL here as we should be at root of the AFTC Framework Application installation
$sub = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
$sub = rtrim($sub,"//");
$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER["HTTP_HOST"] . $sub;
define("ROOT_URL",$url);


//echo(__DIR__); // /home/aftcio/framework.aftc.io/public_html
// Want to place your app files somewhere else change dirname(__DIR__) to the path you want
$AppRootDir = dirname(__DIR__);
require($AppRootDir."/AFTC.php");

// new AFTC($ScriptStartTime);