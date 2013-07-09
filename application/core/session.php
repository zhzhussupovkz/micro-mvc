<?php

//Session - класс для работы с сессиями
class Session {

	//экземпляр session
	public static $instance;

	//construct
	protected function __construct() {
		//...
		session_start();
	}

	//старт сессии
	public static function init() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	//массив сессии
	public function current() {
		if (!is_null($_SESSION)) {
			return $_SESSION;
		} else {
			return null;
		}
	}

	//получение значения
	public function get($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return null;
		}
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