<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 *
 * Wrapper for Symfony HttpFoundation
 * https://symfony.com/doc/current/components/http_foundation.html
 */

namespace AFTC\Framework\Libraries\Wrappers;

use AFTC\Framework\Core\AFTC_Library;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Class HttpFoundationRequestWrapper extends AFTC_Library
{
    public $symfony;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        parent::__construct();

        // Symfony HttpFoundation - Request
        // https://symfony.com/doc/current/introduction/http_fundamentals.html
        // https://symfony.com/doc/current/create_framework/http_foundation.html
        // https://api.symfony.com/4.2/Symfony/Component/HttpFoundation/Request.html
        $this->symfony = Request::createFromGlobals();
        // NOTE: GET and POST are detected under GET
        $get = $this->symfony->get("a");
        $post = $this->symfony->get("name");



    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




    // Symfony 4.x request wrappings
    // https://symfony.com/doc/current/components/http_foundation.html
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // request: equivalent of $_POST;
    public function request($index,$default=null){
        return $this->symfony->request->get($index,$default);
    }
    // query: equivalent of $_GET ($request->query->get('name'));
    public function query($index){
        return $this->symfony->query->get($index);
    }
    // cookies: equivalent of $_COOKIE;
    public function cookies($index){
        return $this->symfony->cookies($index);
    }
    // attributes used by your app to store other data
    public function attributes($attr){
        return $this->symfony->attributes($attr);
    }
    // files: equivalent of $_FILES;
    public function files($index){
        return $this->symfony->files($index);
    }
    // server: equivalent of $_SERVER;
    public function server($index){
        return $this->symfony->server($index);
    }
    // headers: mostly equivalent to a subset of $_SERVER ($request->headers->get('User-Agent')).
    public function headers($index){
        return $this->symfony->headers($index);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}