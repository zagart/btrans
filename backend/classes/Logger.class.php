<?php

class Logger extends StrictAccessClass {
	
	private static $log = "";
	
	public static function log(String $log) {
		self::$log .= $log;
	}
	
	public static function print() {
		echo self::$log;
	}
	
}