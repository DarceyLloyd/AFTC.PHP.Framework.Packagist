<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 14/02/2019
 * Time: 15:44
 */

namespace AFTC\Framework\Core;



use AFTC\Framework\Libraries\ArrayLib;
use AFTC\Framework\Libraries\CastLib;
use AFTC\Framework\Libraries\DateTimeLib;
use AFTC\Framework\Libraries\DebugLib;
use AFTC\Framework\Libraries\HttpLib;
use AFTC\Framework\Libraries\IsLib;
use AFTC\Framework\Libraries\LoggerLib;

class AFTC_Utilities
{
    /** @var IsLib */
    public $is;

    /** @var CastLib */
    public $cast;

    /** @var LoggerLib */
    public $logger;

    /** @var DateTimeLib */
    public $dateTime;

    /** @var DebugLib */
    public $debug;

    /** @var HttpLib */
    public $http;

    /** @var ArrayLib */
    public $array;

    public function __construct()
    {

        $this->is = new IsLib();
        $this->cast = new CastLib();
        $this->logger = new LoggerLib(); // TODO: Needs work
        $this->dateTime = new DateTimeLib();
        $this->debug = new DebugLib();
        $this->http = new HttpLib();
        $this->array = new ArrayLib();


    }
}