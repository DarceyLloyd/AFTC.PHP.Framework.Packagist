<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

// Profiling start
$before = microtime(true);

// Include some generic functions for global use
require_once("src\Framework\Core\Functions.php");

// Error configuration
error_reporting(0); // Turn off all error reporting
error_reporting(-1); // Report all PHP errors

// Autoload namespace method
//composer dumpautoload -o
require_once(__DIR__ . "/vendor/autoload.php");

// Start up the AFTC Framework
use AFTC\Framework\Core\AFTC;
$aftc = new AFTC();

// Profiling end
$sec = number_format((microtime(true) - $before), 4);
$html = "<div style='";
$html .= "display:table; margin: 15px 5px 15px 0px; padding:2px; border:2px solid #FF9900; ";
$html .= "background:#000000; color:#FFFFFF; font-family:arial; font-size:11px;";
$html .= "'>";
$html .= "AFTC PHP Framework generate the page in " . $sec . " seconds";
$html .= "</div>";
echo($html);



/**
 * TODO:
 * - Rename AFTC folder in project to SRC
 * - Create installer php file at SRC root called install.php (for dos calling php install.php
 * - Create src/web_root folder and put framework files in there (includes/images/downloads/data etc)
 * - Create PHP installer which will move the contents of the web_root folder from vendor/aftc/freamework/src/  etc
 *
 * - structural
 *
 *
 * SETUP PROJECT DEVELOPMENT FOLDER TO WORK WITH GIT
 * - clone from github
 * - copy files in from old work dir
 * - sync with github
 * - 1.0 release when template can be fully run
 */