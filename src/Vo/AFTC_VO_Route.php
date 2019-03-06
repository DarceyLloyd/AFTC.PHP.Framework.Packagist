<?php

namespace AFTC\Framework\Vo;

final class AFTC_VO_Route
{
    public $requestMethod = ""; // GET, POST, PUT, PATCH, DELETE, HEAD etc
    public $url = "";
    public $type = "";
    public $controller = "";
    public $controllerMethod = "";
    public $custom; // Var pass through
    public $index = -1;
}