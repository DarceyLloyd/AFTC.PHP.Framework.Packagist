<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:32
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

class LoggerLib extends AFTC_Library
{

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public static function logToFile($message)
    {
        array_push($line, $message);


        $logFile = ROOT_DIR . "/" . Config::$devLogFile;
        trace("TODO... logFile = " . $logFile);
        return;

        if (file_exists($logFile)) {
            $logFileSize = filesize($logFile) / 1024; //kb
            // trace("logFileSize = " . $logFileSize);

            // Check file size (make sure it doesn't go over 2mb
            if ($logFileSize > Config::$logFileSizeLimit) {
                // trace("Create new log");
                // Append current date to log file file name and create a new blank one
                $newFileName = str_replace(".txt", "", $logFile);
                $fi = new FilesystemIterator(ROOT_DIR . "/var/logs/", FilesystemIterator::SKIP_DOTS);
                // var_dump($fi);
                $newFileName = $newFileName . "_" . iterator_count($fi) . ".txt";
                rename($logFile, $newFileName);
                logClear(); // will create a new one with nothing in it
            }
        } else {
            logClear(); // will create a new one with nothing in it
        }


        $handle = fopen($logFile, "a+");
        $put = fputcsv($handle, $line);
        fclose($handle);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function logClear()
    {
        trace("TODO...");
        //file_put_contents("w:/xampp/php/logs/php_error_log", "");
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function logError($arg)
    {

        $msg = "";
        switch (strtolower(gettype($arg))) {
            case "array":
                $msg .= "Array():\n";
                foreach ($arg as $key => $value) {
                    $msg .= "\t" . $key . " = " . $value . "\n";
                }
                error_log($msg);
                break;

            case "object":
                $msg .= "Object():\n";
                foreach ($arg as $key => $value) {
                    $msg .= "\t" . $key . " = " . $value . "\n";
                }
                error_log($msg);
                break;

            default:
                error_log($arg);
                break;
        }


    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


}