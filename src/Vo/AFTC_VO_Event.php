<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 22/02/2019
 * Time: 10:34
 */

namespace AFTC\Framework\Vo;


class AFTC_VO_Event
{
    public $type = ""; // Event type (CUSTOM,COMMON,API,WEB)
    public $name = ""; // Unique name for stacking on that name or preset events from common, api and web
    public $listener; // Listener namespace
    public $listenerMethod; // Listener namespace method

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct($type, $name, $listener, $listenerMethod)
    {
        $this->type = $type;
        $this->name = $name;
        $this->listener = $listener;
        $this->listenerMethod = $listenerMethod;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}