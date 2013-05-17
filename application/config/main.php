<?php

//параметры приложения
$main = array(
	//название сайта
	'name' => 'My Company',

	//Email администратора сайта
	'adminEmail' => 'mycompany@mycompany.com',

	//базовый URL приложения
	'baseUrl'=>  'http://localhost/mvc',

	//контроллер по умолчанию
	'defaultController' => 'My',
	);

//параметры соединения с БД
$db = array(
	'connection' => 'mysql:host=localhost;dbname=micro_mvc',
	'username' => 'root',
	'password' => '120391',
	'charset' => 'utf-8',
	);