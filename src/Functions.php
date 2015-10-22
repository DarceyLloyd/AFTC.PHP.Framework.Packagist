<?php
/**
 * User: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 */



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('xssProtect')) {
    function xssProtect($arg)
    {
        //$str = preg_replace("/[^0-9]+/", "", $arg);
        $str = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $arg);
        return $str;
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('forceFilePutContents')) {
    function forceFilePutContents($filepath, $contents)
    {
        try {
            $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $filepath, $filepathMatches);
            if ($isInFolder) {
                $folderName = $filepathMatches[1];
                $fileName = $filepathMatches[2];
                if (!is_dir($folderName)) {
                    mkdir($folderName, 0777, true);
                }
            }
            file_put_contents($filepath, $contents);
        } catch (Exception $e) {
            echo "ERR: error writing to '$filepath', " . $e->getMessage();
        }
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('trace')) {
    function trace($str)
    {
        echo("<span style='font-size:16px; background: #FFFFFF;'>" . $str . "</span><br/>\n");
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('showMemoryUsage')) {
    function showMemoryUsage()
    {
        echo("<span style='display: table; padding: 3px; border:1px solid; font-size:12px; background: #FFFFFF;'>" . "memory_get_usage = " . floor(memory_get_usage() / 1024) . " KB" . "</span><br/>\n");
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
if (!function_exists('vd')) {
    function vd($var)
    {
        var_dump($var);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('redirect')) {
    function redirect($url)
    {
        header("Location: " . $url);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpArray')) {
    function dumpArray($arr)
    {
        foreach ($arr as $key => $value) {
            trace($key . " = " . $arr[$key]);
        }
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpServer')) {
    function dumpServer()
    {
        $html = "";

        if (sizeOf($_SERVER) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpPost(): </span><span style=''>NO SERVER DATA TO LIST</span>
			</div></br>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0;margin-top:10px; min-width: 100px;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; margin-bottom:10px; font-weight: bold;'>POST DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;'";
            foreach ($_SERVER as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                $html .= "<td $cssValue>" . $value . "</th>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div></br>";
        }

        echo($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpPost')) {
    function dumpPost()
    {
        $html = "";

        if (sizeOf($_POST) == 0) {
            $html = "
			<span style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpPost(): </span><span style=''>NO POST DATA TO LIST</span>
			</span>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<span style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0;margin-top:10px; min-width: 100px;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; margin-bottom:10px; font-weight: bold;'>POST DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px; color: #000000'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; padding-left: 5px; padding-right: 5px;'";
            foreach ($_POST as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</td>";
                $html .= "<td $cssValue>" . $value . "</td>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</span>";
            $html .= "<div style='clear:both;'></div>";
        }

        echo($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpGet')) {
    function dumpGet()
    {
        $html = "";

        if (sizeOf($_GET) == 0) {
            $html = "
			<span style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpGet(): </span><span style=''>NO GET DATA TO LIST</span>
			</span>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<span style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0;margin-top:10px; min-width: 100px;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; margin-bottom:10px; font-weight: bold;'>GET DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px; color: #000000'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; padding-left: 5px; padding-right: 5px;'";
            foreach ($_GET as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</td>";
                $html .= "<td $cssValue>" . $value . "</td>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</span>";
            $html .= "<div style='clear:both;'></div>";
        }

        echo($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpSession')) {
    function dumpSession()
    {

        if (!session_id()) {
            session_start();
        }

        $html = "";
        if (sizeOf($_SESSION) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpSession(): </span><span style=''>NO SESSION DATA TO LIST</span>
			</div>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0;margin-top:10px; min-width: 100px;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; margin-bottom:10px; font-weight: bold;'>SESSION DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;'";
            foreach ($_SESSION as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                $html .= "<td $cssValue>" . $value . "</th>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";
        }

        return ($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('dumpCookies')) {
    function dumpCookies()
    {

        $html = "";
        if (sizeOf($_COOKIE) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpCookies(): </span><span style=''>NO COOKIE DATA TO LIST</span>
			</div>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0;margin-top:10px; min-width: 100px;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; margin-bottom:10px; font-weight: bold;'>COOKIE DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;'";
            foreach ($_COOKIE as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                $html .= "<td $cssValue>" . $value . "</th>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";
        }

        echo($html);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('instr')) {
    function instr($needle, $haystack)
    {

        $pos = strpos($haystack, $needle, 0);
        if ($pos != 0) return true;
        return false;
        /*
        if (strpos($haystack,$needle) !== false){
            return true;
        } else {
            return false;
        }
        */
    }
}
if (!function_exists('instr')) {
    function inString($haystack, $needle)
    {
        instr($haystack, $needle);
    }
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if (!function_exists('getPost')) {
    function getPost($param)
    {
        if (isSet($_POST[$param])) {
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
        if (isSet($_GET[$param])) {
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
if (!function_exists('instr')) {
    function instr($haystack, $needle)
    {
        $pos = strpos($haystack, $needle, 0);
        if ($pos != 0) return true;
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
function delete_directory($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    } else {
        trace("delete_directory - Cannot find dir [" . $dirname . "]");
    }

    if (!$dir_handle) {
        return false;
    } else {
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    delete_directory($dirname . '/' . $file);
            }
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -






	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	function debugFileUploads()
    {
        foreach ($_FILES as $key => $file) {

            trace("Uploaded: key: " . $key);
            trace("Uploaded: " . $file['name']);
            trace("Uploaded: " . $file['type']);
            trace("Uploaded: " . $file['size']);
            trace("Uploaded: " . $file['tmp_name']);
            trace("");
            //trace("Uploaded: " . $_FILES[$file]["name"]);
        }
    }
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -


	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	function debugFileUpload($formFileUploadTagName)
    {

        // Debug file upload
        if ($_FILES[$formFileUploadTagName]["error"] > 0) {
            echo "Error: " . $_FILES[$formFileUploadTagName]["error"] . "<br />";
        } else {
            echo "Upload: " . $_FILES[$formFileUploadTagName]["name"] . "<br />";
            echo "Type: " . $_FILES[$formFileUploadTagName]["type"] . "<br />";
            echo "Size: " . ($_FILES[$formFileUploadTagName]["size"] / 1024) . " Kb<br />";
            echo "Stored in: " . $_FILES[$formFileUploadTagName]["tmp_name"] . "<hr />";
        }


    }
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	function fDeleteFile($file)
    {
        $success = false;
        if (file_exists($file)) {
            if (unlink($file)) {
                $success = true;
            }
            return $success;
        } else {
            $success = true;
            return $success;
        }
    }
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -


	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	function recursiveDelete($str)
    {
        if (is_file($str)) {
            return @unlink($str);
        } elseif (is_dir($str)) {
            $scan = glob(rtrim($str, '/') . '/*');
            foreach ($scan as $index => $path) {
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -




	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	function fSetCookie($cName, $value)
    {
        // All cookies will be set to 1 day - calcuated in seconds
        // 3600 seconds = 1 hour
        $expireTime = 3600 * 24 * 365; // Should be 1 year
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        //setcookie('test1', 'test1 data '.$domain, time()+60*60*24*365, '/', $domain, false);


        if (!setcookie($cName, $value, time() + $expireTime, '/', $domain, false)) {
            $sPageTitle = "ERROR - Site functionality";
            $sMessage = "This website uses cookies, please ensure your borwser supports cookies and they are enabled.";

        }

    }



	function fGetCookie($cName)
    {
        if (isset($_COOKIE[$cName])) {
            //trace($_COOKIE[$cName]);
            return $_COOKIE[$cName];
        } else {
            return null;
        }
    }




	function fDeleteAllCookies()
    {

        //check to see how to set the cookie
        $Browsertype = $_SERVER['HTTP_USER_AGENT'];
        $Parts = explode(" ", $Browsertype);
        $MSIE = array_search("MSIE", $Parts);
        $cnt = 0;

        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cnt++;
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', (time() - 1000));
                setcookie($name, '', time() - 1000, '/');

            }
        }


    }


	function fDumpCookiesToHTML()
    {
        // after the page reloads, print them out
        trace("COOKIE DUMP:");
        foreach ($_COOKIE as $name => $value) {
            echo "$name : $value <br />\n";
        }

    }

// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

