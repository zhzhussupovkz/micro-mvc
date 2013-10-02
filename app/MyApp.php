<?php

//приложение
class MyApp {

	//параметры приложения
	private $params = array();

	/*
	статичное свойство для хранения 
	экземпляра класса MyApp
	*/
	private static $instance;

	//construct
	private function __construct() {
		$this->setParams();
	}

	//powered by
	public static function powered() {
		return 'Создано на microMVC. zhzhussupovkz@gmail.com';
	}

	//версия фреймворка
	public static function version() {
		return '1.0';
	}

	//установка параметров приложения
	public function setParams() {
		$this->params = Config::getParams('main');
	}

	//получение параметров приложения
	public function params($key) {
		return $this->params[$key];
	}

	/*
	создаем объект MyApp и 
	сохраняем его в статичном методе $instance
	*/
	public static function get() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}

		//возвращаем $instance
		return self::$instance;
	}

	//запуск нового приложения
	public static function run() {
		require_once(APP_PATH.'/core/Lib/Autoloader.php');
		Autoloader::init();
	}
}