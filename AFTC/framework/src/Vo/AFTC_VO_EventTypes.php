<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 25/02/2019
 * Time: 11:34
 */

namespace AFTC\Framework\Vo;


class AFTC_VO_EventTypes
{
    public static $COMMON = "COMMON";
    public static $API = "API";
    public static $WEB = "WEB";
    public static $CUSTOM = "CUSTOM";


    public static $validTypes = [
        "CUSTOM",
        "COMMON",
        "API",
        "WEB"
    ];

    public static $validFrameworkEventTypes = [
        "COMMON",
        "API",
        "WEB"
    ];
}