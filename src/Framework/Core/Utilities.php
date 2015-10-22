<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */


namespace AFTC\Framework\Core;


class Utilities
{
    public function __construct(){
        trace("utils.__construct()");
    }

    public function publicTest(){
        trace("utils.publicTest()");
    }

    public static function staticTest(){
        trace("utils.staticTest()");
    }

}