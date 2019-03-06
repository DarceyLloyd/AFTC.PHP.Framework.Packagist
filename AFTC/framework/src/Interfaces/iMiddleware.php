<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 18/01/2019
 * Time: 14:31
 */

namespace AFTC\Framework\Interfaces;

interface iMiddleware {
    public function preDatabase();
    public function preController();
    public function postController();
}