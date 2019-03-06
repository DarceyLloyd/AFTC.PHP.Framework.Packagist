<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

Class IsLib extends AFTC_Library
{


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function isStringInArray($string, $array)
    {
        $string = strtolower($string);
        foreach ($array as $value) {
            $value = strtolower($value);
            if (strpos($string, $value) !== false) {
                return true;
            }
        }
        return false;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    public function isArrayAssociative($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            if (!isset($array[$i])) {
                return true;
            }
        }
        return false;
    }


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function bool()
    {
        $no_of_args = func_num_args();
        if ($no_of_args === 1) {
            $arg = func_get_arg(0);
            // http://php.net/manual/en/function.gettype.php
            if (gettype($arg) === "boolean") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function isHTTPS()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || intval($_SERVER['SERVER_PORT']) == 443;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}