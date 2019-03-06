<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 *
 * 3rd party possibilities
 * https://packagist.org/packages/jasny/typecast
 * https://github.com/jasny/typecast
 * https://packagist.org/packages/jrfnl/php-cast-to-type
 * https://github.com/jrfnl/PHP-cast-to-type
 *
 * Decided to make my own without any dependencies based on the above and old AFTC Utils
 *
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

Class CastLib extends AFTC_Library
{
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        // Tests
        // var_dump($this->toBool(1));
        // var_dump($this->toBool(-1));
        // var_dump($this->toBool(0.1));
        // var_dump($this->toBool(-0.5));
        // var_dump($this->toBool("0"));
        // var_dump($this->toBool("y"));
        // var_dump($this->toBool(""));
        // var_dump($this->toBool());
    }


    public function toBool($value="")
    {
        return $this->cast($value, "boolean");
    }

    public function toInt($value="")
    {
        return $this->cast($value, "int");
    }

    public function toFloat($value="")
    {
        return $this->cast($value, "float");
    }

    public function toString($value="")
    {
        return $this->cast($value, "string");
    }

    public function toYesNo($value="")
    {
        $bool = $this->toBool($value);
        if ($bool) {
            return "yes";
        } else {
            return "no";
        }
    }



    private function cast($value, $type, $array2null = true, $allow_empty = true)
    {

        // Have the expected variables been passed ?
        if (isset($value) === false || isset($type) === false) {
            return null;
        }

        var_dump(strlen($value));

        if (gettype($value) === "string"){
            if (strlen($value)<=0){
                return null;
            }
        }


        $type = strtolower(trim($type));
        $valid_types = array('bool' => 1, 'boolean' => 1, 'int' => 1, 'integer' => 1, 'float' => 1, 'num' => 1, 'string' => 1, 'array' => 1, 'object' => 1,);

        // Check if the typing passed is valid, if not return NULL.
        if (!isset($valid_types[$type])) {
            return null;
        }

        switch ($type) {
            case 'bool':
            case 'boolean':
                return $this->_bool($value, $array2null, $allow_empty);

            case 'integer':
            case 'int':
                return $this->_int($value, $array2null, $allow_empty);

            case 'float':
                return $this->_float($value, $array2null, $allow_empty);

            case 'num':
                if (is_numeric($value)) {
                    $value = (((float)$value != (int)$value) ? (float)$value : (int)$value);
                } else {
                    $value = null;
                }
                return $value;

            case 'string':
                return $this->_string($value, $array2null, $allow_empty);

            case 'array':
                return $this->_array($value, $allow_empty);

            case 'object':
                return $this->_object($value, $allow_empty);

            case 'null':
            default:
                return null;
        }
    }


    /**
     * Cast a value to bool.
     *
     * @static
     *
     * @param mixed $value Value to cast.
     * @param bool $array2null Optional. Whether to return null for an array or to cast the
     *                           individual values within the array to the chosen type.
     * @param bool $allow_empty Optional. Whether to allow empty arrays. Only has effect
     *                           when $array2null = false.
     *
     * @return bool|array|null
     */
    private function _bool($value, $array2null = true, $allow_empty = true)
    {
        echo("\n");
        var_dump($value);

        if (is_bool($value)) {
            return $value;
        } elseif (is_int($value)) {
            if ($value <= 0) {
                return false;
            } else {
                return true;
            }
        } elseif (is_float($value)) {
            if ($value <= 0) {
                return false;
            } else {
                return true;
            }
        } elseif (is_string($value)) {
            $value = strtolower($value);
            $value = trim($value);
            $true = array('1', 'true', 'y', 'yes', 'on');
            $false = array('0', 'false', 'n', 'no', 'off');
            if (in_array($value, $true, true)) {
                return true;
            } elseif (in_array($value, $false, true)) {
                return false;
            } else {
                return false;
            }
        }

        return false;
    }


    /**
     * Cast a value to integer.
     *
     * @static
     *
     * @param mixed $value Value to cast.
     * @param bool $array2null Optional. Whether to return null for an array or to cast the
     *                           individual values within the array to the chosen type.
     * @param bool $allow_empty Optional. Whether to allow empty arrays. Only has effect
     *                           when $array2null = false.
     *
     * @return int|array|null
     */
    private function _int($value, $array2null = true, $allow_empty = true)
    {
        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            if ((int)$value == $value && !is_nan($value)) {
                return (int)$value;
            } else {
                return null;
            }
        } elseif (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return null;
            } elseif (ctype_digit($value)) {
                return (int)$value;
            } elseif (strpos($value, '-') === 0 && ctype_digit(substr($value, 1))) {
                return (int)$value;
            } else {
                return null;
            }
        } elseif ($array2null === false && is_array($value)) {
            return $this->recurse($value, '_int', $allow_empty);
        } elseif (is_object($value) && get_class($value) === 'SplInt') {
            if ((int)$value == $value) {
                return (int)$value;
            } else {
                return null;
            }
        } elseif (is_object($value) && (get_class($value) === 'SplBool' || get_class($value) === 'SplFloat' || get_class($value) === 'SplString')) {
            return $this->spl_helper($value, '_int', $array2null, $allow_empty);
        }

        return null;
    }


    /**
     * Cast a value to float.
     *
     * @static
     *
     * @param mixed $value Value to cast.
     * @param bool $array2null Optional. Whether to return null for an array or to cast the
     *                           individual values within the array to the chosen type.
     * @param bool $allow_empty Optional. Whether to allow empty arrays. Only has effect
     *                           when $array2null = false.
     *
     * @return float|array|null
     */
    private function _float($value, $array2null = true, $allow_empty = true)
    {
        if (is_float($value)) {
            return $value;
        } elseif ($array2null === false && is_array($value)) {
            return $this->recurse($value, '_float', $allow_empty);
        } elseif (is_scalar($value) && (is_numeric(trim($value)) && (floatval($value) == trim($value)))) {
            return floatval($value);
        } elseif (is_object($value) && get_class($value) === 'SplFloat') {
            if ((float)$value == $value) {
                return (float)$value;
            } else {
                return null;
            }
        } elseif (is_object($value) && (get_class($value) === 'SplBool' || get_class($value) === 'SplInt' || get_class($value) === 'SplString')) {
            return $this->spl_helper($value, '_float', $array2null, $allow_empty);
        }

        return null;
    }


    /**
     * Cast a value to string.
     *
     * @static
     *
     * @param mixed $value Value to cast.
     * @param bool $array2null Optional. Whether to return null for an array or to cast the
     *                           individual values within the array to the chosen type.
     * @param bool $allow_empty Optional. Whether to allow empty strings/arrays/objects.
     *
     * @return string|array|null
     */
    private function _string($value, $array2null = true, $allow_empty = true)
    {
        if (is_string($value) && ($value !== '' || $allow_empty === true)) {
            return $value;
        } elseif (is_int($value) || is_float($value)) {
            return strval($value);
        } elseif ($array2null === false && is_array($value)) {
            return $this->recurse($value, '_string', $allow_empty);
        } elseif (is_object($value) && get_parent_class($value) === 'SplType') {
            if ((string)$value == $value) {
                return (string)$value;
            } else {
                return null;
            }
        } elseif (is_object($value) && method_exists($value, '__toString')) {
            return (string)$value;
        }
        return null;
    }


    /**
     * Cast a value to array.
     *
     * @static
     *
     * @param mixed $value Value to cast.
     * @param bool $allow_empty Optional. Whether to allow empty strings/arrays/objects.
     *
     * @return array|null
     */
    private function _array($value, $allow_empty = true)
    {
        try {
            if (is_array($value) !== true) {
                settype($value, 'array');
            }

            if (count($value) > 0 || $allow_empty === true) {
                return $value;
            }
            return null;
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
    }


    /**
     * Recurse through an array.
     *
     * @static
     * @internal
     *
     * @param array $value Array holding values to cast.
     * @param string $method Calling method, i.e. cast to which type of variable.
     *                            Can only be _bool, _int, _float or _string.
     * @param bool $allow_empty Optional. Whether to allow empty arrays in the return.
     *
     * @return array|null
     */
    private function recurse($value, $method, $allow_empty = true)
    {
        if (is_array($value)) {
            if (count($value) === 0) {
                if ($allow_empty === true) {
                    return $value;
                } else {
                    return null;
                }
            } else {
                foreach ($value as $k => $v) {
                    $value[$k] = $method($v, false, $allow_empty);
                }
                return $value;
            }
        }
        return null;
    }


    /**
     * Cast an SPL object to scalar.
     *
     * @static
     *
     * @since 2.0
     *
     * @param \SplType $value Value to cast.
     * @param string $method Calling method, i.e. cast to which type of variable.
     *                              Can only be _bool, _int, _float or _string.
     * @param bool $array2null Optional. Whether to return null for an array or to cast the
     *                              individual values within the array to the chosen type.
     * @param bool $allow_empty Optional. Whether to allow empty strings/arrays/objects.
     *
     * @return bool|int|float|string|null
     */
    private function spl_helper($value, $method, $array2null = true, $allow_empty = true)
    {
        switch (get_class($value)) {
            case 'SplBool':
                return $method((bool)$value, $array2null, $allow_empty);

            case 'SplInt':
                return $method((int)$value, $array2null, $allow_empty);

            case 'SplFloat':
                return $method((float)$value, $array2null, $allow_empty);

            case 'SplString':
                return $method((string)$value, $array2null, $allow_empty);

            default:
                return null;
        }
    }


    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function int($input)
    //    {
    //        if (gettype($input) === "boolean") {
    //            if ($input) {
    //                return 1;
    //            } else {
    //                return 0;
    //            }
    //        } else {
    //            return (int)$input;
    //        }
    //    }
    //    private function number($input){
    //        return $this->int($input);
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function float($input)
    //    {
    //        if (gettype($input) === "boolean") {
    //            if ($input) {
    //                return 1.0;
    //            } else {
    //                return 0.0;
    //            }
    //        } else {
    //            return (float)$input;
    //        }
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function double($input)
    //    {
    //        if (gettype($input) === "boolean") {
    //            if ($input) {
    //                return (double) 1;
    //            } else {
    //                return (double) 0;
    //            }
    //        } else {
    //            return (double)$input;
    //        }
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function string($input)
    //    {
    //        $output = $input;
    //        try {
    //            $output = (string)$input;
    //        } catch (Exception $e) {
    //            $output = "Cast Error - Unable to cast [" + gettype($input) + "] to String!";
    //        }
    //        return $output;
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function bool($input)
    //    {
    //        $msg = "AFTC CastLib: Unable to get a boolean value from [" . $input . "] datatype: [" . gettype($input) . "]";
    //        //http://php.net/manual/en/function.gettype.php
    //        switch (gettype($input)) {
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case "boolean":
    //                // really!?
    //                return $input;
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case "string":
    //
    //                if ($input || $input > 0 || $input === "1" || $input === "yes" || $input === "y" || $input === "true") {
    //                    return true;
    //                }
    //
    //                if ($input == "" || !$input || $input === 0 || $input === "0" || $input === "no" || $input === "n" || $input === "false" || $input === null || $input === "null") {
    //                    return false;
    //                }
    //
    //                return $msg;
    //
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case "integer":
    //                if ($input == 0) {
    //                    return false;
    //                } else {
    //                    return true;
    //                }
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case "double":
    //                if ($input <= 0) {
    //                    return false;
    //                } else {
    //                    return true;
    //                }
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case "NULL":
    //                return false;
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            case NULL:
    //                return false;
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //            default:
    //                return $msg;
    //                break;
    //            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //        }
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function float($input)
    //    {
    //        if (gettype($input) === "boolean") {
    //            if ($input) {
    //                return 1.0;
    //            } else {
    //                return 0.0;
    //            }
    //        } else {
    //            return (float)$input;
    //        }
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //    private function yesNo($input)
    //    {
    //        $input_datatype = gettype($input);
    //        //echo("FROM: " . $input_datatype . " TO: " . $datatype . "<br>\n");
    //        switch ($input_datatype) {
    //            case "boolean":
    //                if ($input) {
    //                    return "yes";
    //                } else {
    //                    return "no";
    //                }
    //                break;
    //            case "string":
    //                if ($input == "1" || $input == "true" || $input == "y") {
    //                    return "yes";
    //                } else {
    //                    return "no";
    //                }
    //                break;
    //            case "double":
    //                if ($input > 0) {
    //                    return "yes";
    //                } else {
    //                    return "no";
    //                }
    //                break;
    //            case "int":
    //                if ($input > 0) {
    //                    return "yes";
    //                } else {
    //                    return "no";
    //                }
    //                break;
    //        }
    //
    //        return null;
    //    }
    //    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}