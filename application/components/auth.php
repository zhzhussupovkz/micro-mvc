<?php

//Auth - класс аутентификации
class Auth extends BaseAuth {

	/*
	перегрузка метода BaseAuth::check 
	проверка данных пользователя
	(можно сравнивать данные с записями
	в бд, с данными различных API соц. сетей...)
	*/
	public static function check(User $user) {
		return parent::check($user);
	}
}