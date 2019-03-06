<?php

use AFTC\Framework\Core\AFTC_EventDispatcher;
use AFTC\Framework\Vo\AFTC_VO_EventTypes;
use AFTC\Framework\Vo\AFTC_VO_EventNames;

/**
 * AFTC_EventDispatcher
 * @method: addEvent
 * @param1: string - Event Type - CUSTOM || COMMON || API || WEB - Want intellisense? use AFTC_VO_EventTypes::$CHOOSE
 * @param2: string - Event Name - For CUSTOM types this can be anything you want for framework events See AFTC_VO_EventNames - Want intellisense? use AFTC_VO_EventNames::$CHOOSE
 * @param3: string - Listener Namespace
 * @param4: string - Listener Namespace Method - can be left blank if you are fine with just executing __construct
 */

AFTC_EventDispatcher::addEvent("CUSTOM","CustomEvent1","TestEventListener","customEvent1Task1");
AFTC_EventDispatcher::addEvent("CUSTOM","CustomEvent1","TestEventListener","customEvent1Task2");
AFTC_EventDispatcher::addEvent("CUSTOM","CustomEvent1","TestEventListener","customEvent1Task3");
AFTC_EventDispatcher::addEvent("CUSTOM","customEvent2","TestEventListener","customEvent2");
AFTC_EventDispatcher::addEvent("CUSTOM","customEvent3","TestEventListener","customEvent3");
AFTC_EventDispatcher::addEvent("CUSTOM","preDatabaseConnect","TestEventListener","customPreDatabaseConnect");
AFTC_EventDispatcher::addEvent("CUSTOM","postDatabaseConnect","TestEventListener","customPostDatabaseConnect");
// AFTC_EventDispatcher::dumpCustomStack(); // Want to see what's on the CUSTOM event stack?

AFTC_EventDispatcher::addEvent("COMMON","init","TestEventListener","commonInit1");
AFTC_EventDispatcher::addEvent("COMMON","init","TestEventListener","commonInit2");
AFTC_EventDispatcher::addEvent("COMMON","preDatabaseConnect","TestEventListener","commonPreDatabaseConnect");
AFTC_EventDispatcher::addEvent("COMMON","postDatabaseConnect","TestEventListener","commonPostDatabaseConnect");
// AFTC_EventDispatcher::dumpCommonStack(); // Want to see what's on the COMMON event stack?

AFTC_EventDispatcher::addEvent("API","init","TestEventListener","apiInit1");
AFTC_EventDispatcher::addEvent("API","init","TestEventListener","apiInit2");
AFTC_EventDispatcher::addEvent("API","preDatabaseConnect","TestEventListener","apiPreDatabaseConnect");
AFTC_EventDispatcher::addEvent("API","postDatabaseConnect","TestEventListener","apiPostDatabaseConnect");
// AFTC_EventDispatcher::dumpApiStack(); // Want to see what's on the API event stack?

AFTC_EventDispatcher::addEvent("WEB","init","TestEventListener","webInit1");
AFTC_EventDispatcher::addEvent("WEB","init","TestEventListener","webInit2");
AFTC_EventDispatcher::addEvent(AFTC_VO_EventTypes::$WEB,AFTC_VO_EventNames::$preDatabaseConnect,"TestEventListener","webPreDatabaseConnect"); // VO Usage example for intellisense users
AFTC_EventDispatcher::addEvent(AFTC_VO_EventTypes::$WEB,AFTC_VO_EventNames::$postDatabaseConnect,"TestEventListener","webPostDatabaseConnect"); // VO Usage example for intellisense users
//// AFTC_EventDispatcher::dumpWebStack(); // Want to see what's on the WEB event stack?