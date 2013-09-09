<?php

//подключаем параметры
require_once(APP_PATH.'/config/main.php');

//Config - класс конфигурации приложения
class Config {

	//параметры приложения
	private static $params = array();

	//установка параметров приложения
	public static function setParams($key, $value) {
		self::$params[$key] = $value;
	}

	//получение параметров приложения
	public static function getParams($key) {
		return self::$params[$key];
	}
}

//установка параметров
Config::setParams('main', $main);
Config::setParams('db', $db);
Config::setParams('memcache', $memcache);
Config::setParams('cachepath', APP_PATH.'/cache');