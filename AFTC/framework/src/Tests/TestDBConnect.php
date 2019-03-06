<?php

namespace AFTC\Framework\Tests;

use AFTC\Framework\Config;

class TestDBConnect {


    public function __construct()
    {
        trace("DBConnect(): " . Config::$database->db);

        $servername = Config::$database->host;
        $username = Config::$database->username;
        $password = Config::$database->password;

        // Create connection
        $conn = new \mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";

    }

}