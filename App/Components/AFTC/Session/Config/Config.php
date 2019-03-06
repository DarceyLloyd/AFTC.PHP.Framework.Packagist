<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 06/03/2019
 * Time: 11:28
 */

namespace AFTC\App\Components\AFTC\Session\Config;


class Config
{
    public static $enableSessions = true;
    public static $sessionHttps = false;
    public static $sessionHttpOnly = true; // This stops javascript being able to access the session id
    public static $sessionName = "AFTC"; // Change for your projects
}