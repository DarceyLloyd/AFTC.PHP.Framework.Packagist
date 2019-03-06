<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 22/02/2019
 * Time: 01:45
 */

namespace AFTC\App\Controllers\Event;


class TestEventController
{
    public function __construct()
    {
        // trace("TestEventController->__construct()");
    }

    public function init($params){
        trace("TestEventController->init()");
        vd($params);
    }

    public function preDatabase($params){
        trace("TestEventController->preDatabase()");
        vd($params);
    }

    public function postDatabase($params){
        trace("TestEventController->postDatabase()");
        vd($params);
    }

    public function preRouter($params){
        trace("TestEventController->preRouter()");
        vd($params);
    }

    public function postRouter($params){
        trace("TestEventController->postRouter()");
        vd($params);
    }

    public function preSession($params){
        trace("TestEventController->preSession()");
        vd($params);
    }

    public function postSession($params){
        trace("TestEventController->postSession()");
        vd($params);
    }
}