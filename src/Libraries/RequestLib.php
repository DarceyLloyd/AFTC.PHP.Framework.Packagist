<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 14/02/2019
 * Time: 16:02
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Libraries\Wrappers\HttpFoundationRequestWrapper;
use Symfony\Component\HttpFoundation\Session\Session;

class RequestLib extends HttpFoundationRequestWrapper
{

    private $valid_methods = [
        "POST",
        "GET"
    ];

    /** @var Session */
    private $session;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct($session=null)
    {
        $this->session = $session;

        parent::__construct();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




    /**
     * @param string $method
     * @param string $index
     * @param array $options
     * @return string
     */
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function get(
        $method,
        $index,
        $options = null
    )
    {
        // Var formatting
        $method = trim(strtoupper($method));

        if (!in_array($method,$this->valid_methods)){
            return "AFTC RequestLibrary->get(): Invalid METHOD of [" . $method . "] supplied, METHOD must be [" . implode(", ",$this->valid_methods);
        }

        // Process method
        $targetMethod = "";
        switch ($method){
            case "GET":
                $targetMethod = $_GET;
                break;
            case "POST":
                $targetMethod = $_POST;
                break;
            default:
                return "AFTC RequestLibrary->get(): invalid METHOD of [" . $method . "] supplied! METHOD must be one of the following [" . implode(", ",$this->valid_methods) . "]";
                break;
        }

        // Value retrieval
        $value = "";


        if (isset($targetMethod[$index])){
            $value = $targetMethod[$index];
        } else {
            // STRICT is not needed on GET or POST, just return empty string instead of error string
            //return "AFTC RequestLibrary->get(): index of [" . $index . "] doesn't exist on " . $method . ".";
        }


        // process options
        $valid_options = [
            "alpha", "letters", "letters_only",
            "numeric", "numbers", "numbers_only",
            "alpha_numeric", "sanitize_int", "sanitize_float",
            "sanitize_url", "sanitize_float", "sanitize",
            "sanitize_url", "sanitize_email", "strip_tags",
            "urlencode", "urldecode", "html_encode",
            "html_decode", "xss_safe"
        ];

        $value = trim($value);

        if (strtolower(gettype($options)) == "array") {
            foreach ($options as $option) {
                if ($option == "" || $option == null) {
                    continue;
                }
                if ($option == "alpha" || $option == "letters" || $option == "letters_only") {
                    $value = preg_replace("/[^a-zA-Z]+/", "", $value);
                } else if ($option == "numeric" || $option == "numbers" || $option == "numbers_only") {
                    $value = preg_replace("/[^0-9]/", "", $value);
                } else if ($option == "alpha_numeric") {
                    $value = preg_replace("/[^a-zA-Z0-9]+/", "", $value);
                } else if ($option == "sanitize_int") {
                    $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                } else if ($option == "sanitize_float") {
                    $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
                } else if ($option == "sanitize_url") {
                    $value = filter_var($value, FILTER_SANITIZE_URL);
                } else if ($option == "sanitize_email") {
                    $value = filter_var($value, FILTER_SANITIZE_EMAIL);
                } else if ($option == "sanitize" || $option == "sanitise") {
                    $value = filter_var($value, FILTER_SANITIZE_STRING);
                } else if ($option == "urlencode" || $option == "url_encode") {
                    $value = urlencode($value);
                } else if ($option == "urldecode" || $option == "url_decode") {
                    $value = urldecode($value);
                } else if ($option == "html_encode" || $option == "htmlencode") {
                    $value = htmlspecialchars($value);
                } else if ($option == "html_decode" || $option == "htmldecode") {
                    $value = htmlspecialchars_decode($value);
                } else if ($option == "strip_tags") {
                    $value = strip_tags($value);
                } else if ($option == "xss_safe" || $option == "xss") {
                    // Effective way to stop all XSS attacks on a UTF-8 encoded web page, but doesn't allow any HTML
                    // https://paragonie.com/blog/2017/12/2018-guide-building-secure-php-software
                    $value =  htmlentities($value, ENT_QUOTES | ENT_HTML5, 'UTF-8') ;
                } else {
                    $this->utils->debug->errorMessage(
                        "AFTC RequestLibrary - Unhandled option given [" . $option . "]",
                        "options are: " . implode(", ",$valid_options)
                    );
                }
            }
        }

        // Process return
        return $value;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}