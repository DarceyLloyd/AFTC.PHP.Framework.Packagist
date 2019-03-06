<?php

/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\App\Config\Vars;
use AFTC\Framework\App\Middleware\Middleware;

use AFTC\Framework\Config;
use AFTC\Framework\Libraries\RequestLibrary;
use AFTC\Framework\Libraries\ResponseLibrary;
use AFTC\Framework\Libraries\SessionLibrary;
use AFTC\Framework\Libraries\TokenLibrary;
use AFTC\Framework\Vo\AFTCVo;
use AFTC\Framework\VOs\RouteVo;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
class AFTC_Controller
{
    /** @var AFTCMiddleware $middleware */
    public $middleware;
    
    /** @var RouteVo $routeVo */
    public $routeVo;
    
    // Libs
    public $response;
    public $request;
    public $session;

    // Libs
    public $utils;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    //public function __construct(Middleware $middleware, AFTCVORoute $routeVo)
    public function __construct()
    {
        // Var ini
        $this->utils = new AFTC_Utilities();

        $this->middleware = AFTCVo::$middleware;
        $this->routeVo = AFTCVo::$routeVo;
        
        // Libraries
        $this->session = new SessionLibrary();
        $this->response = new ResponseLibrary($this->routeVo);
        $this->request = new RequestLibrary();
        
        // Ensure response page data gets some of the useful variables
        $this->response->data["aftc_framework_version"] = Config::$version;
        $this->response->data["url_path"] = $this->routeVo->url;
        $this->response->data["ip"] = getIP();
    
        // Parse user vars to page data
        if (isset(Vars::$page_data)){
            foreach (Vars::$page_data as $key => $value) {
                $this->response->data[$key] = $value;
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private function xgenerateNewCSRFToken()
    {
        $this->CSRF_Token = bin2hex(random_bytes(32)); // 256bit
        $this->session->set("CSRF_Token", $this->CSRF_Token);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function xgetCSRFToken()
    {
        if ($this->session->isSessionKeySet("CSRF_Token")) {
            return $this->session->get("CSRF_Token");
        } else {
            return $this->CSRF_Token;
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -