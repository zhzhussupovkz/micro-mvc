<?php

//приложение
class MyApplication {

	//параметры приложения
	public $params = array();

	/*
	статичный метод для хранения 
	экземпляра класса MyApplication
	*/
	public static $instance;

	//construct
	protected function __construct() {
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
		$this->params = Config::getMainConfig();
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
		require_once(APP_PATH.'/core/bauth.php');
		require_once(APP_PATH.'/components/user.php');
		require_once(APP_PATH.'/components/auth.php');
		require_once(APP_PATH.'/core/request.php');
		require_once(APP_PATH.'/core/route.php');
	}
}