<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 28/02/2019
 * Time: 00:20
 */

namespace AFTC\Framework\Interfaces;


interface iDatabaseComponent
{
    public function connect();
    public function disconnect();
    public function isConnected();
    public function getConnection();
    public function query();
    public function getLastInsertId();
    public function getNumRows();
}