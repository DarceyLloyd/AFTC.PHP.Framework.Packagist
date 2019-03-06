<?php

require_once("includes/vars.php");
require_once("includes/functions.php");

cls();
trace("AFTC Framework CLI Tool","green");

Class AFTC {

    private $argv;
    private $command;
    private $sub_command;
    private $help_message = "
Commands:
    update - will update composer.json require with aftc_require and then aftc_modules composer.json (ensure
    integrate
    refresh
    ";

    public function __construct($argv){
        $this->argv = $argv;
        // var_dump($argv);
        trace("arg1 = " . $this->getArg(0));
        trace("arg2 = " . $this->getArg(1));
        trace("arg3 = " . $this->getArg(2));

        $this->help_message = trace("HELP:","yellow",true);

        $this->command = $this->getArg(0);
        $this->sub_command = $this->getArg(1);

        

        switch ($this->command){
            case "install":
                 if ($this->sub_command != "error"){
                     $cc = "composer require " . $this->sub_command;
                     trace("Running command \"" . $cc . "\"");
                     shell_exec("cd ..");
                     shell_exec("cd ..");
                     exec("cd ..");
                     trace(__DIR__);
                     //$a = shell_exec($cc);
                     //shell_exec("cd App\bin");
                     //trace($a);
                     trace("DONE");
                 } else {
                     trace("ERROR: Install needs a vendor/package name to install","red");
                 }
                
            break;
            case "integrate":
            break;
            case "refresh":
            break;
            default:
            trace("ERROR: Unknown command [" . $this->command . "]\n".$this->help_message);
            break;
        }
        
    }

    public function getArg($index){
        $index++;
        if (is_array($this->argv)){
            if (isset($this->argv[$index])){
                return strtolower($this->argv[$index]);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
        
    }    

}

new AFTC($argv);

die();

var_dump($argv);
$command1 = getArg(1);
$command2 = getArg(2);
trace("command1 = " . $command1);
trace("command2 = " . $command2);


