<?php

//подключаем параметры
require_once(APP_PATH.'/config/main.php');

//Config - класс конфигурации приложения
class Config {

	//параметры приложения
	public static $main = array();

	//параметры БД
	public static $db = array();

	//установка параметров приложения
	public static function setMainConfig($main) {
		self::$main = $main;
	}

	//получение параметров приложения
	public static function getMainConfig() {
		return self::$main;
	}

	//установка параметров БД
	public static function setDbConfig($db) {
		self::$db = $db;
	}

	//получение параметров БД
	public static function getDbConfig() {
		return self::$db;
	}
}

//установка параметров
Config::setMainConfig($main);
Config::setDbConfig($db);