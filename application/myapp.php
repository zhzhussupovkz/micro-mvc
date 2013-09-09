<?php

//приложение
class MyApplication {

	//параметры приложения
	private $params = array();

	/*
	статичное свойство для хранения 
	экземпляра класса MyApplication
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
	создаем объект MyApplication и 
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
		require_once(APP_PATH.'/config/config.php');
		require_once(APP_PATH.'/core/load.php');
		require_once(APP_PATH.'/core/controller.php');
		require_once(APP_PATH.'/core/model.php');
		require_once(APP_PATH.'/core/view.php');
		require_once(APP_PATH.'/core/db.php');
		require_once(APP_PATH.'/core/mysql.php');
		require_once(APP_PATH.'/core/mongo.php');
		require_once(APP_PATH.'/core/session.php');
		require_once(APP_PATH.'/core/security.php');
		require_once(APP_PATH.'/core/bauth.php');
		require_once(APP_PATH.'/core/icache.php');
		require_once(APP_PATH.'/core/mcache.php');
		require_once(APP_PATH.'/core/fcache.php');
		require_once(APP_PATH.'/components/user.php');
		require_once(APP_PATH.'/components/auth.php');
		require_once(APP_PATH.'/core/request.php');
		require_once(APP_PATH.'/core/route.php');
	}
}