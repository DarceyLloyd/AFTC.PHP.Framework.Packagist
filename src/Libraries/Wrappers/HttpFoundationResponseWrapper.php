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
use Symfony\Component\HttpFoundation\Response;

Class HttpFoundationResponseWrapper extends AFTC_Library
{
    /** @var Response */
    public $httpResponse;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        // Symfony HttpFoundation - Response
        // // https://symfony.com/doc/current/introduction/http_fundamentals.html
        // https://symfony.com/doc/current/create_framework/http_foundation.html
        // https://api.symfony.com/4.2/Symfony/Component/HttpFoundation/Response.html
        // https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        // Usage method 1
        // $response->setStatusCode("204");
        // $this->response->setContent('ABA');
        // $this->response->send();
        // Usage method 2
        // $response = new Response('Goodbye!');
        // $response->send();
        $this->httpResponse = new Response();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    // Symfony 4.x response wrappings
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // request: equivalent of $_POST;
    public function request($index){
        $this->httpRequest->request($index);
    }
    // query: equivalent of $_GET ($request->query->get('name'));
    public function query($index){
        $this->httpRequest->query($index);
    }
    // cookies: equivalent of $_COOKIE;
    public function cookies($index){
        $this->httpRequest->cookies($index);
    }
    // attributes used by your app to store other data
    public function attributes($attr){
        $this->httpRequest->attributes($attr);
    }
    // files: equivalent of $_FILES;
    public function files($index){
        $this->httpRequest->files($index);
    }
    // server: equivalent of $_SERVER;
    public function server($index){
        $this->httpRequest->server($index);
    }
    // headers: mostly equivalent to a subset of $_SERVER ($request->headers->get('User-Agent')).
    public function headers($index){
        $this->httpRequest->headers($index);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // Symfony 4.x response wrappings
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function xxxxx(){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // AFTC request
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function xxx(){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // AFTC response
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function xxxx(){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}