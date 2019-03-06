<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 */

namespace AFTC\Framework\Interfaces;

interface iLibrary {
    public function __construct();
    public function install();
    public function uninstall();
}