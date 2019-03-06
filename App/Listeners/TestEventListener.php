<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 01/03/2019
 * Time: 11:06
 */

namespace AFTC\App\Listeners;


use AFTC\Framework\Core\AFTC_Listener;

class TestEventListener extends AFTC_Listener
{
    // CUSTOM
    public function customEvent1Task1($params=null){
        trace("TestEventListener->customEvent1Task1()");
    }

    public function customEvent1Task2($params=null){
        trace("TestEventListener->customEvent1Task2()");
    }

    public function customEvent1Task3($params=null){
        trace("TestEventListener->customEvent1Task3()");
    }

    public function customEvent2($params=null){
        trace("TestEventListener->customEvent2()");
    }

    public function customEvent3($params=null){
        trace("TestEventListener->customEvent3()");
    }

    public function customPreDatabaseConnect($params=null){
        trace("TestEventListener->customPreDatabaseConnect()");
    }

    public function customPostDatabaseConnect($params=null){
        trace("TestEventListener->customPostDatabaseConnect()");
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    // COMMON
    public function commonInit1($params=null){
        trace("TestEventListener->commonInit1()");
    }

    public function commonInit2($params=null){
        trace("TestEventListener->commonInit2()");
    }

    public function commonPreDatabaseConnect($params=null){
        trace("TestEventListener->commonPreDatabaseConnect()");
    }

    public function commonPostDatabaseConnect($params=null){
        trace("TestEventListener->commonPostDatabaseConnect()");
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    // API
    public function apiInit1($params=null){
        trace("TestEventListener->apiInit1()");
    }

    public function apiInit2($params=null){
        trace("TestEventListener->apiInit2()");
    }

    public function apiPreDatabaseConnect($params=null){
        trace("TestEventListener->apiPreDatabaseConnect()");
    }

    public function apiPostDatabaseConnect($params=null){
        trace("TestEventListener->apiPostDatabaseConnect()");
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    // WEB
    public function webInit1($params=null){
        trace("TestEventListener->webInit1()");
    }

    public function webInit2($params=null){
        trace("TestEventListener->webInit2()");
    }

    public function webPreDatabaseConnect($params=null){
        trace("TestEventListener->webPreDatabaseConnect()");
    }

    public function webPostDatabaseConnect($params=null){
        trace("TestEventListener->webPostDatabaseConnect()");
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}