<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 22:59
 */

namespace AFTC\Framework\Interfaces;


interface iEventHandler
{
    public function __construct($type,$name,$params);
}