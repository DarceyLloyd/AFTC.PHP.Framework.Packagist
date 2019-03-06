<?php
/**
 * Created by Darcey@aftc.io
 * Date: 04/09/2017
 * Time: 11:51
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception;

class SecurityKeyManager
{
    //WARNING - DEPRECIATION: $this->key1 = \Defuse\Crypto\Crypto::createNewRandomKey();
    //WARNING - ALTERNATIVE PHP 7.x: $this->key1 = bin2hex(random_bytes(32)); // php 7.x

    public function init()
    {
        // Var ini
        $key_file_missing = false;

        $key_file = ROOT_DIR. "\\" . "var\\keys.json";
        if (!file_exists($key_file)) {
            $key_file_missing = true;

            $keys = [];

            // For openSSL
            $keys["key1"] = bin2hex(random_bytes(16)); // 128bit (iv) - NOTE 16 is max size for an iv
            $keys["key2"] = bin2hex(random_bytes(32)); // 256bit (key)

            // For Defuse
            $key = Key::createNewRandomKey();
            $keys["key3"] = $key->saveToAsciiSafeString();

            // Cookie authentication key
            $keys["cookie"] = bin2hex(random_bytes(64));

            // Session authentication key
            $keys["session"] = bin2hex(random_bytes(64));

            $key_file_contents = json_encode($keys);
            file_put_contents($key_file, $key_file_contents);

            //vd($keys);
            //vd($key_file_contents);
        }


        // Redirect after a pause, in an attempt to ensure key files have been generated and are not locked
        if ($key_file_missing) {
            sleep(1.5);
            if (isHTTPS()) {
                $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            } else {
                $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }
            redirect($url);
            die();
        }
    }


}