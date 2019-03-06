<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 01/03/2019
 * Time: 11:04
 */

namespace AFTC\Framework\Core;


use AFTC\Framework\Vo\AFTCVo;

class AFTC_Listener
{
    /** @var AFTC_Utilities */
    protected $utils;

    public function __construct()
    {
        $this->utils = AFTCVo::$utils;
    }
}