<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@AllForTheCode.co.uk
 * Date: 10/2015
 */

namespace AFTC\Framework;

trait Singleton
{
	public static $instance;
	public static $id = 0;

	public static function getInstance() {
		if (!(self::$instance instanceof self)) {
			self::$id = rand(0, 99999999); // Instance ID
			//trace("NOTICE: Creating singleton instance of [" . get_called_class() . " ] ID:[" . self::$id . "]");
			self::$instance = new static;
		}
		return self::$instance;
	}

	public static function getId(){
		return self::$id;
	}

	public static function getInstanceVar(){
		return self::$instance;
	}
}