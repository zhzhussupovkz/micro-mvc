<?php

//BaseAuth - базовый класс аутентификации
class BaseAuth {

	//создание пользователя и запись его данных в сессию
	public static function login(User $user) {
		Session::init()->set('name', $user->name);
	}

	//удаление данных пользователя
	public static function logout() {
		Session::init()->clear();
	}

	//проверка авторизованности пользователя
	public static function isAuthorized(User $user) {
		if (!is_null(Session::init()->current())) {
			if (Session::init()->get('name') == $user->name) {
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