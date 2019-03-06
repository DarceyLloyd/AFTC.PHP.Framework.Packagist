<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

Class HttpLib extends AFTC_Library
{
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function redirect($url)
    {
        if (!headers_sent()) {
            header("Location: " . $url);
            die;
        } else {
            throw new Exception("REDIRECT TO [" . $url . "] FAILED - HEADERS HAVE ALREADY BEEN SENT TO THE BROWSER!");
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getURL(){
        $sub = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
        $sub = rtrim($sub,"//");
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER["HTTP_HOST"] . $sub;
        return $url;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getSeoStringFrom($input)
    {
        $output = strip_tags($input);
        $output = str_replace(array('[\', \']'), '', $output);
        $output = preg_replace('/\[.*\]/U', '', $output);
        $output = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $output);
        $output = htmlentities($output, ENT_COMPAT, 'utf-8');
        $output = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $output);
        $output = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $output);
        return strtolower(trim($output, '-'));
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function getIp()
    {
        // NOTE THERE IS NO 100% SECURE METHOD OF GETTING THE USERS IP!
        $ip = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
                getenv('HTTP_X_FORWARDED') ?:
                    getenv('HTTP_FORWARDED_FOR') ?:
                        getenv('HTTP_FORWARDED') ?:
                            getenv('REMOTE_ADDR');

        return $ip;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function urlEncodeArray($input)
    {
        $output = array();
        foreach ($input as $value) {
            array_push($output,urlencode($value));
        }
        return $output;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}