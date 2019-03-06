<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 */

namespace AFTC\App\Modules\AFTC\CSRF;




//use RandomLib\Factory;
//use SecurityLib\Strength;

class AFTC_CSRF
{
    private $factory;
    private $generator;
    
    public function __construct(){
        echo("AFTC_CSRF()<br>");

//        $this->factory = new Factory();
//        $this->generator = $this->factory->getGenerator(new Strength(Strength::MEDIUM));
//        $randomInt = $this->generator->generateInt(5, 15);
//        echo("randomInt = " . $randomInt . "<br>");

    }
}