<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 */

namespace AFTC\Framework\App\Libraries\AuthenticationLibrary;

use AFTC\Framework\App\Libraries\AuthenticationLibrary\Models\AuthenticationLibraryModel;
use AFTC\Framework\App\Libraries\AuthenticationLibrary\VOs\AuthVo;
use AFTC\Framework\Config;
use AFTC\Framework\Libraries\CookieLibrary;
use AFTC\Framework\Libraries\SessionLibrary;
use AFTC\Framework\VOs\RouteVo;

class AuthenticationLibrary
{
    private $routeVo;
    private $authVo;
    
    private $definitionsFile = "";
    
    private $sessionLibrary;
    private $cookieLibrary;
    
    private $model;
    
    private $page_user_type = "";
    private $page_user_type_rank = -1;
    
    private $page_userRole = "";
    private $page_userRole_rank = -1;
    
    // Indexes which will be used for session lookup
    // NOTE: Each key and value is encrypted by default with the AFTC Framework SessionLibrary
    public $sessionIdKey = "SessionID";
    public $sessionUserTypeKey = "UserType";
    public $sessionUserRoleKey = "UserRole";
    public $sessionUserAgentKey = "UserAgent";
    public $sessionUserIPKey = "UserIP";
    
    public $autoLoginTokenKey = "AutoLoginToken";
    
    public $cookieSessionIdKey = "CSID";
    public $cookieTokenIdKey = "Token";
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    public function __construct(RouteVo $routeVo)
    {
        // Var ini
        $this->routeVo = $routeVo;
        
        $this->definitionsFile = Config::$libraryFolder . "/AuthenticationLibrary/Cache/UserDefinitions.php";
        
        // AuthVo
        $this->authVo = new AuthVo();
        
        $this->authVo->sessionIdKey = $this->sessionIdKey;
        $this->authVo->sessionUserTypeKey = $this->sessionUserTypeKey;
        $this->authVo->sessionUserRoleKey = $this->sessionUserRoleKey;
        $this->authVo->sessionUserAgentKey = $this->sessionUserAgentKey;
        $this->authVo->sessionUserIPKey = $this->sessionUserIPKey;
        
        $this->authVo->cookieSessionIdKey = $this->cookieSessionIdKey;
        $this->authVo->cookieTokenIdKey = $this->cookieTokenIdKey;
        
        // Libs
        $this->sessionLibrary = new SessionLibrary();
        $this->cookieLibrary = new CookieLibrary();
        
        // Models
        $this->model = new AuthenticationLibraryModel();
        
        // Check definitions file (PHP Mirror of user_definitions table, so no DB query is required for security check)
        $this->checkDefinitionsFile();
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    
    public function setSessionsAndCookies($type,$role)
    {
        $sid = bin2hex(random_bytes(32)); // 256bit;
        
        $this->sessionLibrary->set($this->authVo->sessionIdKey, $sid);
        $this->sessionLibrary->set($this->authVo->sessionUserTypeKey, $type);
        $this->sessionLibrary->set($this->authVo->sessionUserRoleKey, $role);
        $this->sessionLibrary->set($this->authVo->sessionUserAgentKey, $_SERVER["HTTP_USER_AGENT"]);
        $this->sessionLibrary->set($this->authVo->sessionUserIPKey, getIP());
    
        $this->cookieLibrary->set($this->authVo->sessionIdKey, $sid); // 256bit;
        $this->cookieLibrary->set($this->authVo->sessionUserTypeKey, $type);
        $this->cookieLibrary->set($this->authVo->sessionUserRoleKey, $role);
        $this->cookieLibrary->set($this->authVo->sessionUserAgentKey, $_SERVER["HTTP_USER_AGENT"]);
        $this->cookieLibrary->set($this->authVo->sessionUserIPKey, getIP());
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    
    public function setAutoLoginValues($type,$role)
    {
        $autologin_token = bin2hex(random_bytes(32)) . bin2hex(random_bytes(32)) . bin2hex(random_bytes(32));
        
        $this->cookieLibrary->set($this->autoLoginTokenKey,$autologin_token);
        $this->model->setAutoLoginToken($autologin_token);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    
    
    public function authenticatePage($type, $role)
    {
        $this->page_user_type = $type;
        $this->page_userRole = $role;
        
        // Check to to see if we need to bother checking at all, page might be public
        if ($this->routeVo->user_type == "" || $this->routeVo->user_type == "*") {
            // User type is anything, let them in
            return true;
        } else {
            if ($this->routeVo->userRole == "" || $this->routeVo->userRole == "*") {
                // User type has been set but role hasn't, validate type only
                // Check user type exists in UserDefinitions.php
                // Get user type rank
                // Get page user type rank
                // if page_user_type_rank is => user type rank
            } else {
                // User type and role has been set validate both
            }
        }
        
        
        die();
        
        
        // Check router to see if user type is not "" or *
        if ($this->routeVo->userRole == "" || $this->routeVo->userRole == "*") {
            // No authentication required on current route
            // trace("NO Auth on this route!");
            return true;
        } else {
            // pre($this->routeVo);
            // pre($this->authVo);
            
            // validate all session indexes are set and available
            $set = false;
            if (
                $this->sessionLibrary->isSessionKeySet($this->authVo->sessionUserTypeKey) &&
                $this->sessionLibrary->isSessionKeySet($this->authVo->sessionUserRoleKey) &&
                $this->sessionLibrary->isSessionKeySet($this->authVo->sessionUserAgentKey) &&
                $this->sessionLibrary->isSessionKeySet($this->authVo->sessionUserIPKey)
            ) {
                $set = true;
            }
            
            if (!$set) {
                // trace("Sessions keys are invalid, user needs to login");
                $this->authVo->redirectForUserType($this->routeVo->user_type);
            } else {
                // Validate values
                trace("Session keys are set and available, ready for validation!");
                
            }
            
            // $this->sessionUserType = $this->sessionLibrary->get($this->authVo->sessionUserTypeKey);
            // pre($this->sessionUserType);
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    // Check if user role and type definitions file has been generated
    // Check if user role and type definitions file exists in libs cache folder
    // Generate definitions file for setup user role and type cache file
    private function checkDefinitionsFile()
    {
        if (file_exists($this->definitionsFile)) {
            require_once($this->definitionsFile); // NOTE: This will define $userDefinitions
            // Validate user type and user role exists in userDefinitions
            // vd($this->routeVo);
            if (!isset($userDefinitions[$this->routeVo->user_type])) {
                die("The page / service you are requesting requires access privileges (type) which are not setup in the system, please contact your developer for support.");
            } else {
                $roles = $userDefinitions[$this->routeVo->user_type]["roles"];
                $role_exists = false;
                foreach ($roles as $role) {
                    if ($role["name"] == $this->routeVo->userRole) {
                        $role_exists = true;
                        break;
                    }
                }
                if (!$role_exists) {
                    die("The page / service you are requesting requires access privileges (role) which are not setup in the system, please contact your developer for support.");
                }
            }
        } else {
            $this->buildDefinitionsFile();
        }
    }
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    
    private function buildDefinitionsFile()
    {
        $str = "<?php\n";
        $str .= '$userDefinitions = [];' . "\n\n\n";
        
        $userDefinitions = $this->model->getUserDefinitionsTable();
        // $userTypes = $this->model->getUserTypes();
        // $userRoles = $this->model->getUserRoles();
        
        // I could just dump it to JSON and then do the looping each run, but would be quicker for php array index
        // $j = json_encode($result);
        // $jd = json_decode($j);
        //vd($jd);
        
        
        // User Types
        foreach ($userDefinitions as $row) {
            if ($row["is_type"] == "1") {
                $str .= '$entry = [
    "name" => "' . $row["type"] . '",
    "rank" => ' . $row["type_rank"] . ',
    "roles" => []
];' . "\n";
                //                 $str .= 'array_push($users,$entry);'. "\n\n";
                $str .= '$userDefinitions["' . $row["type"] . '"] = $entry;' . "\n\n";
                
                
            }
        }
        
        $str .= "\n\n\n";
        
        // User Roles
        foreach ($userDefinitions as $row) {
            if ($row["is_role"] == "1") {
                $str .= '$entry = [
    "name" => "' . $row["role"] . '",
    "rank" => ' . $row["role_rank"] . '
];' . "\n";
                
                $str .= 'array_push($userDefinitions["' . $row["parent_type"] . '"]["roles"],$entry);' . "\n\n";
            }
        }
        
        // Write file
        file_put_contents($this->definitionsFile, $str);
        
        
        //trace($str);
        // require_once($this->definitionsFile);
        // vd($userDefinitions);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
}