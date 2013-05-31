<?php

//BaseAuth - базовый класс аутентификации
class BaseAuth {

	//текущий пользователь
	public static $user;

	//создание пользователя и запись его данных в сессию
	public static function login(User $user) {
		self::$user = $user;
		MyApplication::get()->setUser($user);
		Session::init()->set('name', $user->name);
	}

	//удаление данных пользователя
	public static function logout() {
		self::$user = null;
		MyApplication::get()->removeUser();
		Session::clear();
	}

	//проверка авторизованности пользователя
	public static function isAuthorized(User $user) {
		if (!is_null(self::$user)) {
			if (self::$user == $user) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	//проверка данных пользователя
	public static function check(User $user) {
		if ($user->name == $user->password) {
			return true;
		} else {
			return false;
		}
	}
}