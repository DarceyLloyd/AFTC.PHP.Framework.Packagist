<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 01/03/2019
 * Time: 15:37
 */

namespace AFTC\Framework\Vo;


class AFTC_VO_EventStack
{
    public static $stack = [
        "CUSTOM" => [],
        "COMMON" => [],
        "API" => [],
        "WEB" => [],
    ]; // Stack

    private static $stackInitialized = false;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    public static function initStack(){
        if (!self::$stackInitialized){
            self::$stackInitialized = true;

            foreach (AFTC_VO_EventNames::$validFrameworkEventNames as $eventName){

                self::$stack["COMMON"][$eventName] = [];
                self::$stack["API"][$eventName] = [];
                self::$stack["WEB"][$eventName] = [];
            }

            
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}