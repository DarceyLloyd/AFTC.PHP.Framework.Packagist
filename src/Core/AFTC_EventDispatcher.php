<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 01/03/2019
 * Time: 15:57
 */

namespace AFTC\Framework\Core;


use AFTC\Framework\Vo\AFTC_VO_Event;
use AFTC\Framework\Vo\AFTC_VO_EventNames;
use AFTC\Framework\Vo\AFTC_VO_EventTypes;
use AFTC\Framework\Vo\AFTCVo;

class AFTC_EventDispatcher
{
    public static $stack = ["CUSTOM" => [], // custom->eventName->[stack]
        "COMMON" => [], // common->frameworkEventName->[stack]
        "API" => [], // common->frameworkEventName->[stack]
        "WEB" => [], // common->frameworkEventName->[stack]
    ]; // Stack

    public static $initComplete = false;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function init()
    {
        if (!self::$initComplete) {
            self::$initComplete = true;

            // Setup the stack
            foreach (AFTC_VO_EventNames::$validFrameworkEventNames as $eventName) {
                self::$stack["COMMON"][$eventName] = [];
                self::$stack["API"][$eventName] = [];
                self::$stack["WEB"][$eventName] = [];
            }
            // vd(self::$stack);

            // Add AFTC/APP event listeners
            // $appEvents = new \AFTC\App\Config\Events();
            require_once(ROOT_DIR . "/App/Config/Events.php");

            // Process CUSTOM events
            //            vd($appEvents->customEvents);
            //            foreach ($appEvents->customEvents as $key => $event){
            //                $eventName = $key;
            //                self::addEvent(AFTC_VO_EventTypes::$CUSTOM,$eventName,$event[0],$event[1]);
            //            }
            //            // Process COMMON events
            //            foreach ($appEvents->commonEvents as $key => $event){
            //                $eventName = $key;
            //                self::addEvent(AFTC_VO_EventTypes::$COMMON,$eventName,$event[0],$event[1]);
            //            }
            //
            //            // Process API events
            //            foreach ($appEvents->apiEvents as $key => $event){
            //                $eventName = $key;
            //                self::addEvent(AFTC_VO_EventTypes::$API,$eventName,$event[0],$event[1]);
            //            }
            //
            //            // Process WEB events
            //            foreach ($appEvents->webEvents as $key => $event){
            //                $eventName = $key;
            //                self::addEvent(AFTC_VO_EventTypes::$WEB,$eventName,$event[0],$event[1]);
            //            }

        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function addEvent($type, $name, $listener, $listenerMethod)
    {
        // trace("AFTC_EventDispatcher->addEvent(\$type:[$type], \$name:[$name], \$listener:[$listener], \$listenerMethod:[$listenerMethod])");

        /** @var AFTC_VO_Event $event */
        $event = new AFTC_VO_Event($type, $name, $listener, $listenerMethod);

        // Validate
        $isValidType = self::isValidType($event, "addEvent");
        // trace("\$isValidType($event->type) = " . $isValidType);

        $isValidName = self::isValidName($event, "addEvent");
        // trace("\$isValidName($event->name) = " . $isValidName);

        $isValidListener = self::isValidListener($event, "addEvent");
        // trace("\$isValidListener($event->listener) = " . $isValidListener);

        $isValidListenerMethod = self::isValidListenerMethod($event, "addEvent");
        // trace("\$isValidListenerMethod($event->listenerMethod) = " . $isValidListenerMethod);

        if ($isValidType === true && $isValidName === true && $isValidListener === true && $isValidListenerMethod === true) {
            // CUSTOM vs Framework Event types
            if (!in_array($event->type, AFTC_VO_EventTypes::$validFrameworkEventTypes)) {
                // Process CUSTOM event type
                // Check if index of event name exists on custom array if it does array push, if not create index
                if (!array_key_exists($event->name, self::$stack[$event->type])) {
                    self::$stack[$event->type][$event->name] = [];
                }
                array_push(self::$stack[$event->type][$event->name], $event);
            } else {
                // Process Framework event type
                array_push(self::$stack[$event->type][$event->name], $event);
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function dispatchEvent($type, $name, $params = null)
    {
        // trace("AFTC_EventDispatcher->addEvent(\$type:[$type], \$name:[$name], \$params:[$params])");

        $event = null;

        if (key_exists($type, self::$stack)) {
            if (key_exists($name, self::$stack[$type])) {
                // Loop through stack on [type][name][]
                foreach (self::$stack[$type][$name] as $event) {
                    // Validate
                    $isValidType = self::isValidType($event, "addEvent");
                    // trace("\$isValidType($event->type) = " . $isValidType);

                    $isValidName = self::isValidName($event, "addEvent");
                    // trace("\$isValidName($event->name) = " . $isValidName);

                    $isValidListener = self::isValidListener($event, "addEvent");
                    // trace("\$isValidListener($event->listener) = " . $isValidListener);

                    $isValidListenerMethod = self::isValidListenerMethod($event, "addEvent");
                    // trace("\$isValidListenerMethod($event->listenerMethod) = " . $isValidListenerMethod);

                    if ($isValidType === true && $isValidName === true && $isValidListener === true && $isValidListenerMethod === true) {
                        $c = "\AFTC\App\Listeners\\" . $event->listener;
                        if ($isValidListener && $event->listenerMethod == "") {
                            $listener = new $c();
                        } else {
                            $listener = new $c();
                            $m = $event->listenerMethod;
                            if (method_exists($listener, $m)) {
                                $listener->$m();
                            } else {
                                $title = "AFTC_EventDispatcher-dispatchEvent(): Usage error!";
                                $msg = "Event type [" . $event->type . "], name [" . $event->name . "].<br>";
                                $msg .= "Method [" . $event->listenerMethod . "] doesn't exist in class [" . $c . "]";
                                $cls = "AFTC_EventDispatcher->dispatchEvent()";
                                AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
                            }
                        }
                    }
                }

            } else {
                $title = "AFTC_EventDispatcher-dispatchEvent(): Usage error!";
                $msg = "The event name of [" . $name . "] doesn't exist on event type [" . $type . "].";
                $msg .= "Please check spelling, refer to docs or use AFTC_VO_EventNames::\$CHOOSE for intellisense selection.";
                $cls = "AFTC_EventDispatcher->dispatchEvent()";
                AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
            }
        } else {
            $title = "AFTC_EventDispatcher-dispatchEvent(): Usage error!";
            $msg = "Invalid event type of [" . $type . "] supplied.";
            $msg .= "Please check spelling, refer to docs or use AFTC_VO_EventTypes::\$CHOOSE for intellisense selection.";
            $cls = "AFTC_EventDispatcher->dispatchEvent()";
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
        }

    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    public static function dispatchFrameworkEvent($name, $params = null)
    {
        if (gettype($name) == "array") {
            foreach ($name as $frameworkEventName) {
                self::dispatchEventWrapper($frameworkEventName, $params);
            }
        } else {
            self::dispatchEventWrapper($name, $params);
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private static function dispatchEventWrapper($name, $params = null)
    {
        // Fire COMMON event type -> event name
        self::dispatchEvent(AFTC_VO_EventTypes::$COMMON, $name, $params);

        // Fire Router route type (API/WEB) -> event name
        if (AFTCVo::$routeVo) {
            if (AFTCVo::$routeVo->type != "" && AFTCVo::$routeVo->type != null) {
                self::dispatchEvent(AFTCVo::$routeVo->type, $name, $params);
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private static function isValidType(AFTC_VO_Event $event, $callingFunctionName)
    {
        $title = "AFTC_EventDispatcher: Usage error, invalid event type";
        $msg = "Invalid event type of [" . $event->type . "] supplied, check spelling or set it via:<br>";
        $msg .= "AFTC_VO_EventType::\$CHOOSE";
        $cls = "AFTC_EventDispatcher->" . $callingFunctionName . "->validateType()";


        if ($event->type == "") {
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
        }

        if ($event->type == "CUSTOM") {
            return true;
        } else {
            if (!in_array($event->type, AFTC_VO_EventTypes::$validTypes)) {
                AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
                return false;
            } else {
                return true;
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private static function isValidName(AFTC_VO_Event $event, $callingFunctionName)
    {
        $title = "AFTC_EventDispatcher: Usage error, invalid event name";
        $msg = "Invalid event name of [" . $event->name . "] supplied for type [" . $event->type . "], if the event is a CUSTOM type you can give it any name you wish,";
        $msg .= "if it's a framework event type of COMMON, WEB or API then set it via AFTC_VO_EventNames::\$CHOOSE for intellisense selection";
        $cls = "AFTC_EventDispatcher->" . $callingFunctionName . "->isValidName()";

        if ($event->name == "") {
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
        }

        if ($event->type == "CUSTOM") {
            return true;
        } else {
            if (!in_array($event->name, AFTC_VO_EventNames::$validFrameworkEventNames)) {
                AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
                return false;
            } else {
                return true;
            }
        }
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private static function isValidListener(AFTC_VO_Event $event, $callingFunctionName)
    {
        $title = "AFTC_EventDispatcher: Usage error, invalid event listener";
        $msg = "Invalid event callback handler of [" . $event->listener . "] supplied, if the event is a CUSTOM type you can give it any name you wish,";
        $msg .= "Event callbacks must be namespace strings or function objects.";
        $cls = "AFTC_EventDispatcher->" . $callingFunctionName . "->isValidListener()";


        if ($event->listener == "") {
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
            return false;
        }


        // eventController should be a string (not going to allow function objects)
        if (gettype($event->listener) != "string") {
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
            return false;
        }

        return true;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private static function isValidListenerMethod(AFTC_VO_Event $event, $callingFunctionName)
    {
        $t = gettype($event->listenerMethod);

        $title = "AFTC_EventDispatcher: Usage error, invalid event controller method";
        $msg = "Invalid event controller method type of [" . $t . "] supplied, methods must be strings leave blank to use __construct.";
        $cls = "AFTC_EventDispatcher->" . $callingFunctionName . "->isValidListenerMethod()";

        // eventController should be a string (not going to allow function objects)
        if ($t != "string") {
            AFTCVo::$utils->debug->errorMessage($title, $msg, $cls);
            return false;
        }

        return true;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function dumpCustomStack()
    {
        vd(AFTC_EventDispatcher::$stack["CUSTOM"]);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function dumpCommonStack()
    {
        vd(AFTC_EventDispatcher::$stack["COMMON"]);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function dumpApiStack()
    {
        vd(AFTC_EventDispatcher::$stack["API"]);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function dumpWebStack()
    {
        vd(AFTC_EventDispatcher::$stack["WEB"]);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}