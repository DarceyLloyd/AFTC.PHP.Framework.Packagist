<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

Class DebugLib extends AFTC_Library
{

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function errorMessage($title,$message,$class="",$no=-1,$die=false)
    {
        $classMsg = "";
        if ($class != ""){
            $classMsg = "Class: " . $class;
        }

        $noMsg = "";
        if ($no > 0){
            $noMsg = "(" . $no . ")";
        }


        $msg = "";
        $msg .= "";

        $msg .= "<div style='display: table;background: #EEEEEE;border:1px solid #000000;margin:5px;padding: 5px; font-family: Tahoma;font-size:14px;line-height: 24px;'>";
        $msg .= "<div style='color:#CC0000;font-size:17px;'><b>" . $title . $noMsg . "</b></div>";
        if ($classMsg != ""){
            $msg .= "<div style='color:#990000;font-size:14px;'><b>" . $classMsg . "</b></div>";
        }
        $msg .= "<div style='color:#330000;font-size:12px;'>";
        $msg .= $message;
        $msg .= "</div>";
        $msg .= "</div>";

        $msg .= "";

        echo($msg);

        if ($die){
            die();
        }

    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    private $dumpArrayIndent = 0;
    public function dumpArray($arr)
    {
        $html = "<div style='display: table;border:1px solid #000000;padding:5px;margin:5px;background:#EEEEEE;font-size:14px;'>";
        $html .= "Array Dump:<hr>";
        foreach ($arr as $key => $value) {
            if (gettype($value) == "array"){
                $html .= $this->getDumpArrayIndent() . " [$key] = [ARRAY]<br>";
                $this->dumpArrayIndent++;
                $html .= $this->dumpArrayRecurse($value);
            } else {
                $html .= $this->getDumpArrayIndent() . " [$key] = $value <br>";
            }
        }
        $html .= "</div>";
        echo($html);
    }
    private function dumpArrayRecurse($arr){
        if ($this->dumpArrayIndent >= 10){
            return "RECURSE LIMIT REACHED!";
        }
        $html = "";
        foreach ($arr as $key => $value) {
            if (gettype($value) == "array"){
                $html .= $this->getDumpArrayIndent() . " [$key] = [ARRAY]<br>";
                $this->dumpArrayIndent++;
                $html .= $this->dumpArrayRecurse($value);
            } else {
                $html .= $this->getDumpArrayIndent() . " [$key] = $value <br>";
            }
        }
        $this->dumpArrayIndent--;
        return $html;
    }
    private function getDumpArrayIndent(){
        $html = "";
        for ($i = 0; $i < $this->dumpArrayIndent; $i++)
        {
            $html .= "&nbsp;&nbsp;&nbsp;";
        }
        return $html;
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpServer()
    {
        $html = "";

        if (sizeof($_SERVER) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpPost(): </span><span style=''>NO SERVER DATA TO LIST</span>
			</div></br>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>SERVER DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            foreach ($_SERVER as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                $html .= "<td $cssValue>" . $value . "</th>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div></br>";
        }

        trace($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpPost()
    {
        $html = "<div style='display:table;border:1px solid #000000;background: #444444; color:#FFFFFF;font-size:12px;margin:0; padding:5px;'>";
        $html .= "<h3 style='margin:0;padding:0;'>\$_POST DUMP</h3>";

        if (sizeof($_POST) == 0) {
            $html .= "<p style='margin:0;padding:0;'>NO POST DATA AVAILABLE</p>";
        } else {
            foreach ($_POST as $key => $value) {
                $html .= $key . ": " . $value . "<br>\n";
            }
        }

        $html .= "</div>";

        trace($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpGet()
    {
        $html = "<div style='display:table;border:1px solid #000000;background: #444444; color:#FFFFFF;font-size:12px;margin:0; padding:5px;'>";
        $html .= "<h3 style='margin:0;padding:0;'>\$_GET DUMP</h3>";

        if (sizeof($_GET) == 0) {
            $html .= "<p style='margin:0;padding:0;'>NO GET DATA AVAILABLE</p>";
        } else {
            foreach ($_GET as $key => $value) {
                $html .= $key . ": " . $value . "<br>\n";
            }
        }

        $html .= "</div>";

        trace($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpSession()
    {

        $html = "";
        if (sizeof($_SESSION) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpSession(): </span><span style=''>NO SESSION DATA TO LIST</span>
			</div>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>SESSION DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            foreach ($_SESSION as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                if (gettype($value) != "array"){
                    $html .= "<td $cssValue>" . $value . "</th>";
                } else {
                    $html .= "<td $cssValue>array</th>";
                }

                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";
        }

        trace($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpCookies()
    {
        $html = "";
        if (sizeof($_COOKIE) == 0) {
            $html = "
			<div style='display: inline-block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 10px; padding: 5px;'>
				<span style='font-weight: bold;'>dumpCookies(): </span><span style=''>NO COOKIE DATA TO LIST</span>
			</div>";
            $html .= "<div style='clear:both;'></div>";
        } else {
            $html .= "<div style='display: block; border: 1px dashed #CC0000; margin:0; padding: 5px;'>";
            $html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
            $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>COOKIE DATA</caption>";

            $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
            foreach ($_COOKIE as $key => $value) {
                $html .= "<tr>";
                $html .= "<td $cssKey>" . $key . "</th>";
                $html .= "<td $cssValue>" . $value . "</th>";
                $html .= "<tr>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";
        }

        echo($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function dumpAvailableClasses()
    {
        $html = "";
        $html .= "<div style='display: block; border: 1px dashed #CC0000; margin-top: 10px; margin-bottom: 5px; padding: 5px;'>";
        $html .= "<table style='display: inline-block; padding:0; margin:0; width:100%;overflow:auto;'>";
        $html .= "<caption style='margin: 0; text-align: left; font-size: 12px; font-weight: bold;'>AVAILABLE CLASSES</caption>";

        $cssKey = "style='font-size: 11px; font-weight: bold; background: #CCCCCC; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
        $cssValue = "style='font-size: 11px; font-weight: bold; background: #DDDDDD; color: #000000; padding-left: 5px; padding-right: 5px;vertical-align:top;'";
        foreach (get_declared_classes() as $key => $value) {
            $html .= "<tr>";
            $html .= "<td $cssKey>" . $key . "</th>";
            $html .= "<td $cssValue>" . $value . "</th>";
            $html .= "<tr>";
        }
        $html .= "</table>";
        $html .= "</div></br>";

        echo($html);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}