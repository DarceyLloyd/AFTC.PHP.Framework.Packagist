<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 14/02/2019
 * Time: 15:00
 */

namespace AFTC\Framework\Vo;


use AFTC\Framework\AFTC;
use AFTC\Framework\Core\AFTC_Utilities;
use AFTC\Framework\Core\AFTCRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AFTCVo
{
    /** @var AFTC */
    public static $aftc;

    /** @var AFTC_VO_Route */
    public static $routeVo;

    /** @var AFTC_Utilities $utils */
    public static $utils;

    public function __construct(){
        
    }
}