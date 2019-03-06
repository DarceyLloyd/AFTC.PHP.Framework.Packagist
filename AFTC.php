<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 15/01/2019
 * Time: 17:49
 *
 * Index calling this file allows this script to get the root_path correctly
 * Want to change the location of this folder simply change the path in the index.php in your publicly visible dir
 *
 */

// AFTC Generic functions
require_once "AFTC/framework/src/Helpers/functions.php";
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Set custom exception handler for nicer error outputs (should not be seen on live sites!)
// set_exception_handler("AFTCExceptionHandler");
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Calculate root and public folder paths and name
define("ROOT_DIR", __DIR__);
$public_dir_name = str_replace(ROOT_DIR, "", PUBLIC_DIR);
$public_dir_name = ltrim($public_dir_name, "\\"); // linux / unix
$public_dir_name = ltrim($public_dir_name, "/"); // windows
define("PUBLIC_DIR_NAME", $public_dir_name);
// trace("AFTC(ScriptStartTime:" . $ScriptStartTime . ")");
// trace("ROOT_DIR = " . ROOT_DIR);
// trace('PUBLIC_DIR = ' . PUBLIC_DIR);
// trace('PUBLIC_DIR_NAME = ' . PUBLIC_DIR_NAME);
// trace("ROOT_URL = " . ROOT_URL);
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Autoload
require_once ROOT_DIR . "/vendor/autoload.php";
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// AFTC
$aftc = \AFTC\Framework\AFTC::getInstance();
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Script time end
$ScriptEndTime = microtime(true);
$time = round(($ScriptEndTime - $ScriptStartTime), 4);
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

trace("Completed in $time seconds\n");
