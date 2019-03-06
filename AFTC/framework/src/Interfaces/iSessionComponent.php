<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 00:20
 */

namespace AFTC\Framework\Interfaces;


interface iSessionComponent
{
    public function __construct();
    public function start();
    public function regenerate();
    public function destroy();
    public function getId();
    public function setId($id);
    public function getName();
    public function setName($name);
    public function isStarted();
    public function getSessionClass(); // Returns the session class that you may be using eg Symfony's or other package
    public function set($name,$value);
    public function get($name);
}