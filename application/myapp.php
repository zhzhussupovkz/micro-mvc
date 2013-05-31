<?php

//приложение
class MyApplication {

	//параметры приложения
	public $params = array();

	//текущий пользователь приложения
	public $user = null;

	/*
	статичный метод для хранения 
	экземпляра класса NewApplication
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

	//установка текущего пользователя
	public function setUser(User $user) {
		$this->user = $user;
	}

	//удаление текущего пользователя
	public function removeUser() {
		$this->user = null;
	}

	//получение параметров приложения
	public function params($key) {
		return $this->params[$key];
	}

	/*
	создаем объект NewApplication и 
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
		require_once(dirname(__FILE__).'/config/config.php');
		require_once(dirname(__FILE__).'/core/load.php');
		require_once(dirname(__FILE__).'/core/controller.php');
		require_once(dirname(__FILE__).'/core/model.php');
		require_once(dirname(__FILE__).'/core/view.php');
		require_once(dirname(__FILE__).'/core/mysql.php');
		require_once(dirname(__FILE__).'/core/session.php');
		require_once(dirname(__FILE__).'/core/bauth.php');
		require_once(dirname(__FILE__).'/components/user.php');
		require_once(dirname(__FILE__).'/components/auth.php');
		require_once(dirname(__FILE__).'/core/route.php');
		Route::start();
	}
}