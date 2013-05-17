<?php

//параметры приложения
$main = array(
	//название сайта
	'name' => 'My Company',

	//Email администратора сайта
	'adminEmail' => 'mycompany@mycompany.com',

	//базовый URL приложения
	'baseUrl'=>  'http://localhost/micro-mvc',

	//контроллер по умолчанию
	'defaultController' => 'My',
	);

//параметры соединения с БД
$db = array(
	'connection' => 'mysql:host=localhost;dbname=micro_mvc',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf-8',
	);
