<?php

//Session - класс для работы с сессиями
class Session {

	//экземпляр session
	public static $instance;

	//construct
	protected function __construct() {
		//...
	}

	//старт сессии
	public static function init() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	//получение значения
	public function get($key) {
		return $_SESSION[$key];
	}

	//установка значения
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	//очистка массива сессии
	public function clear() {
		$_SESSION = array();
	}

	//уничтожение сессии
	public function destroy() {
		session_destroy();
	}
}