<?php
/**
 * User: Darcey Lloyd
 * Email: Darcey@AFTC.io
 */

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function vds($var)
{
    ob_start();
    var_dump($var);
    return htmlspecialchars_decode(strip_tags(ob_get_clean()));
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function listDir($dir)
{
    $sd = scandir($dir);
    $html = "$dir<hr>";
    $c = 0;
    foreach ($sd as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . "/" . $value)) {
                $html .= "$value [DIR]<br>";
            } else {
                $html .= "$value<br>";
            }

        }
    }
    trace($html);
}
function dumpDir($dir){listDir($dir);}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function redirect($url, $permanent = false, $cache = true)
{
    if (!$cache) {
        header("Cache-Control: no-cache");
    }

    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);

    exit();
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('trace')) {
    function trace($input = "")
    {
        $html = "";
        $html .= "<span style='font-size:15px; background: #FFFFFF; border:1px solid RGBA(0,0,0,0.5); padding:2px 5px; margin: 3px 0;display:table; z-index:99999'>";
        switch (strtolower(gettype($input))) {
            case "array":
                $html .= "Array():<br>";
                foreach ($input as $key => $value) {
                    if (gettype($value) != "array") {
                        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = " . $value . "<br>\n";
                    } else {
                        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = (array)<br>\n";
                    }
                }
                break;

            case "object":
                $html .= "Object():<br>";
                foreach ($input as $key => $value) {
                    if (gettype($value) != "array") {
                        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = " . $value . "<br>\n";
                    } else {
                        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $key . " = (array)<br>\n";
                    }
                }
                break;

            case "boolean":
                if ($input) {
                    $html .= "true";
                } else {
                    $html .= "false";
                }
                break;

            case "null":
                $html .= "null";
                break;

            default:
                $html .= $input;
                break;
        }
        $html .= "</span>\n";

        echo ($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('vd')) {
    function vd($var)
    {
        echo ("<pre style='background: #DDDDDD; border:1px solid #000000; padding:5px; display: inline-block;'>");
        var_dump($var);
        echo ("</pre><br>\n");
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('arrayToXML')) {
    function arrayToXML($array)
    {
        $xml = "";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $xml .= "\t<" . $key . ">\n";
                arrayToXML($value);
                $xml .= "\t</" . $key . ">\n";
            } else {
                if (instr($key, "_")) {
                    $k = str_replace("_", "-", $key);
                    $xml .= "\t" . "<" . $k . ">" . $value . "</" . $k . ">\n";
                } else {
                    $xml .= "\t" . "<" . $key . ">" . $value . "</" . $key . ">\n";
                }

            }
        }
        return $xml;
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('showMemoryUsage')) {
    function showMemoryUsage()
    {
        echo ("<span style='display: table; padding: 3px; border:1px solid; font-size:12px; background: #FFFFFF;'>" . "memory_get_usage = " . floor(memory_get_usage() / 1024) . " KB" . "</span><br/>\n");
    }
}
if (!function_exists('showMemory')) {
    function showMemory()
    {
        showMemoryUsage();
    }
}
if (!function_exists('showMem')) {
    function showMem()
    {
        showMemoryUsage();
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getPost')) {
    function getPost($param)
    {
        if (isset($_POST[$param])) {
            $value = $_POST[$param];
            return $value;
        } else {
            return "";
        }
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getGet')) {
    function getGet($param)
    {
        if (isset($_GET[$param])) {
            $value = $_GET[$param];
            //$value = mysql_real_escape_string($value);
            /**/
            $value = str_replace("'", '', $value);
            $value = str_replace("`", '', $value);
            $value = str_replace("\"", '', $value);
            $value = str_replace("=", '', $value);

            //$value = sanitize($value);
            return $value;
        } else {
            return "";
        }
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getSession')) {
    function getSession($param)
    {
        if (isset($_SESSION[$param])) {
            $value = $_SESSION[$param];
            return $value;
        } else {
            return "";
        }
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('instr')) {
    function instr($haystack, $needle)
    {
        $pos = strpos($haystack, $needle, 0);
        if ($pos != 0) {
            return true;
        }

        return false;
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
/**
 * Function: sanitize
 * Returns a sanitized string, typically for URLs.
 *
 * Parameters:
 *     $string - The string to sanitize.
 *     $force_lowercase - Force the string to lowercase?
 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
 */
if (!function_exists('sanitize')) {
    function sanitize($string, $force_lowercase = false, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€�?", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function summarise($str, $limit)
{
    $array = explode(" ", $str);
    /*
    trace($str);
    foreach ($array as $value){
    trace("value = " . $value);
    }
     */
    $return_string = "";
    for ($i = 0; $i <= $limit; $i++) {
        $return_string .= $array[$i] . " ";
    }

    $return_string = ltrim($return_string);
    $return_string = rtrim($return_string);

    return $return_string;
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function getSuffixFromFileName($str)
{
    $arr = explode(".", $str);
    $lastindex = sizeof($arr) - 1;
    $str = $arr[$lastindex];

    return $str;
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function dumpFileUploads()
{
    foreach ($_FILES as $key => $file) {

        trace("Uploaded: key: " . $key);
        trace("Uploaded: " . $file['name']);
        trace("Uploaded: " . $file['type']);
        trace("Uploaded: " . $file['size']);
        trace("Uploaded: " . $file['error']);
        trace("Uploaded: " . $file['tmp_name']);
        trace("");
        //trace("Uploaded: " . $_FILES[$file]["name"]);
    }
}

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

// AFTC Framework Exception handler functions (See AFTC.PHP)
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function AFTCExceptionHandler($ex)
{
//    var_dump($ex);
    //    var_dump(get_class_methods($ex));
    //    die();
    $trace = $ex->getTrace();
    if ($trace[0]) {
        $ExceptionFile = $trace[0]["file"];
        $ExceptionFileLine = $trace[0]["line"];
        $ExceptionFunction = $trace[0]["function"];
        if (array_key_exists("class", $trace[0])) {
            $ExceptionClass = $trace[0]["class"];
        } else {
            $ExceptionClass = "0";
        }

        $out = "<div style='border:1px solid #000000; background: #CCCCCC; color: #000000;padding: 5px; font-size:14px; font-family: \"Tahoma\"'>\n";

        $out .= "<div style='font-size: 16px; color: #CC0000;'>";
        // $out .= "<b>ERROR " . $ex->getCode() . ": [" . basename($ex->getFile()) . "] - LINE: " . $ex->getLine() . "</b>";
        $out .= "<b>ERROR " . $ex->getCode() . ": " . basename($ExceptionFile) . " (" . $ExceptionFileLine . ")</b>";
        //$out .= "<b>ERROR " . $ex->getCode() . ": [" . basename($GLOBALS["AFTC_TraceFile"]) . "]</b>";
        $out .= "</div>\n";

        $out .= "<div style='font-size: 14px; color: #550000; margin: 5px;'>";
        // $out .= "<b>Files:</b><br>\n";
        // $out .= "<b>ERROR " . $ex->getCode() . ": [" . basename($ex->getFile()) . "] - LINE: " . $ex->getLine() . "</b>";
        $out .= "<b>" . $ExceptionFile . " - " . $ExceptionFunction . "() (" . $ExceptionFileLine . ")</b><br>\n";
        //$out .= "<b>" . $ExceptionClass . "</b><br>\n";
        $out .= "<b>" . $ex->getFile() . " (" . $ex->getLine() . ")</b><br>\n";
        $out .= "</div>\n";

        $out .= "<div style='font-size: 14px; color: #000055; border: 1px solid #000000; padding: 5px; background: #BBBBBB; margin: 5px;'>";
        $out .= "<b>Message:</b><br>\n";
        $out .= $ex->getMessage();
        $out .= "</div>\n";

        $out .= "<div style='font-size: 14px; color: #000055; border: 1px solid #000000; padding: 5px; background: #BBBBBB; margin: 5px;'>";
        $out .= "<b>Trace:</b><br>\n";
        $tr = $ex->getTrace();
        //    foreach ($tr as $key => $value){
        //        $out .= $value . "<br>\n";
        //    }
        $out .= "<span style='font-size: 12px;'>" . recurseExceptionTraceOut($tr) . "</span>";
        $out .= "</div>\n";

        $out .= "<div style='font-size: 14px; color: #000055; border: 1px solid #000000; padding: 5px; background: #BBBBBB; margin: 5px;'>";
        $out .= "<b>Previous:</b><br>\n";
        $out .= $ex->getPrevious();
        $out .= "</div>\n";

        // $out .= "<b>TraceAsString:</b><br>\n" . $ex->getTraceAsString() . "<br>\n";
        $out .= "</div>";
        echo ($out);

        $log = "";
        $log .= "[" . $ExceptionFile . " (" . $ExceptionFileLine . ")" . "] ";
        $log .= "[" . $ex->getFile() . " (" . $ex->getLine() . ")" . "] ";
        $log .= "[" . $ex->getMessage() . "]";
        error_log($log);

    } else {
        var_dump($ex);
    }

}
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
function recurseExceptionTraceOut($input)
{
    //    trace(gettype($input));
    $out = "";
    if (gettype($input) == "array") {

        foreach ($input as $key => $value) {
            $out .= recurseExceptionTraceOut($value);
        }

        $out .= "<br>";
    } else {
        switch (gettype($input)) {
            case "string":
                // $out = getAFTCExceptionIndent() . " [" . gettype($input) . "] = " . $input . "<br>\n";
                $out = "&nbsp;&nbsp;&nbsp;&nbsp;" . $input . "<br>\n";
                break;
            case "integer":
                $out = "&nbsp;&nbsp;&nbsp;&nbsp;" . $input . "<br>\n";
                break;
            case "object":
                $out = "&nbsp;&nbsp;&nbsp;&nbsp;" . " OBJECT: [" . get_class($input) . "]<br>\n";
                break;
            default:
                $out = "&nbsp;&nbsp;&nbsp;&nbsp;" . " Unhandled Type: [" . gettype($input) . "] = <br>\n";
                break;
        }

    }

    $out = str_replace("<br><br>", "<br>", $out);
    return $out;
}
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
