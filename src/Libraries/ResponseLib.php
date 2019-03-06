<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 14/02/2019
 * Time: 16:02
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Libraries\Wrappers\HttpFoundationResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class ResponseLib extends HttpFoundationRequestWrapper
{
    /** @var Response */
    public $response;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function __construct()
    {
        parent::__construct();

        // Symfony HttpFoundation - Response
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
        $this->httpResponse = new HttpFoundationResponseWrapper();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function html($data){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function php($data){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // TODO: Fully modular? with public function templateEngineLib?
    /*
     * POSSIBLE: Go fully modular?
     * App side libs for (Most if not ALL AFTC_Core components extending component implementing iComponent:
     *  - templateEngineComponent to render template engine outputs (twig, smarty etc)
     *  - phpResponseComponent to render php views
     *  - xmlResponseComponent to render xml outputs
     *  - jsonResponseComponent to render json outputs
     *
     */


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function twig($data){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function xml($data){

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function json($data,$encode=false){
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');
        if ($encode){
            $this->response->setContent(json_encode($data));
        } else {
            $this->response->setContent($data);
        }
        $this->response->send();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}