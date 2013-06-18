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

//параметры соединения с MySQL
$db = array(
	'driver' => 'mysql',
	'host' => 'localhost',
	'dbname' => 'micro_mvc',
	'username' => 'root',
	'password' => '120391',
	'charset' => 'utf-8',
	);

//параметры соединения с MongoDb
/*$db = array(
	'driver' => 'mongodb',
	'host' => 'localhost',
	'dbname' => 'test',
	'username' => null,
	'password' => null,
	);*/