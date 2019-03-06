<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 18:27
 */

namespace AFTC\Framework\Core;


use AFTC\Framework\AFTC;
use AFTC\Framework\Vo\AFTCVo;

class AFTC_Component
{
    /** @var AFTC */
    public $aftc;

    /** @var AFTC_VO_Route */
    public $routeVo;

    /** @var AFTC_Utilities */
    public $utils;

    public function __construct()
    {
        $this->aftc = AFTCVo::$aftc;
        $this->routeVo = AFTCVo::$routeVo;
        $this->utils = AFTCVo::$utils;
    }


    
}