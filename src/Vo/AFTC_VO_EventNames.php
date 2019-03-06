<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 25/02/2019
 * Time: 11:35
 */

namespace AFTC\Framework\Vo;


class AFTC_VO_EventNames
{
    public static $init = "init";

    public static $preRouter = "preRouter";
    public static $postRouter = "postRouter";
    public static $onValidRoute = "onValidRoute";
    public static $onInvalidRoute = "onInvalidRoute";

    public static $preSession = "preSession";
    public static $postSession = "postSession";

    public static $preController = "preController";
    public static $postController = "postController";

    public static $preDatabaseConnect = "preDatabaseConnect";
    public static $postDatabaseConnect = "postDatabaseConnect";
    public static $preDatabaseDisconnect= "preDatabaseDisconnect";
    public static $postDatabaseDisconnect= "postDatabaseDisconnect";


    public static $preDatabaseQuery = "preDatabaseQuery";
    public static $postDatabaseQuery = "postDatabaseQuery";
    public static $databaseDisconnect = "databaseDisconnect";

    // Router Events
    public static $RouteNotFound = "RouteNotFound";
    public static $RouteFound = "RouteFound";

    public static $validFrameworkEventNames = [
        "init",

        "preRouter",
        "postRouter",
        "onValidRoute",
        "onInvalidRoute",


        "preSession",
        "postSession",
        "preController",
        "postController",

        "preDatabaseConnect",
        "postDatabaseConnect",
        "preDatabaseDisconnect",
        "postDatabaseDisconnect",


        "preDatabaseQuery",
        "postDatabaseQuery",
        "databaseDisconnect",
    ];
}