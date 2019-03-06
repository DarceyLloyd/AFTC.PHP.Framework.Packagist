<?php


function getArg($index){
    if (isset($argv[$index])){
        return strtolower($argv[index]);
    } else {
        return null;
    }
}


function trace($msg,$color=null,$return=false){
    $color = strtolower($color);
    $start = "\033[37m"; // white
    $end = "\033[0m ";
    switch ($color){
        case "red":
            $start = "\033[31m";
            break;
        case "green":
            $start = "\033[32m";
            break;
        case "blue":
            $start = "\033[34m";
            break;
        case "purple":
            $start = "\033[35m";
            break;
        case "magenta":
            $start = "\033[35m";
            break;
        case "cyan":
            $start = "\033[36m";
            break;
        case "yellow":
            $start = "\033[33m";
            break;
        case "yellow":
            $start = "\033[33m";
            break;
        case "white":
            $start = "\033[37m";
            break;
        case "black":
            $start = "\033[30m";
            break;
    }

    $m = $start . $msg . "\033[0m" . "\n";
    if (!$return){
        //echo($start . "" . $msg . $end . "\n");
        fwrite(STDOUT,$m);
    } else {
        return $m;
    }
    
}

function cls(){
    // system('cls');
    // system('clear');
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
}