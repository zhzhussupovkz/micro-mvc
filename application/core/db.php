<?php

//Класс DB - класс подключения к БД
abstract class DB {

	//параметры соединения
	private $conn = array();

	//open - открытие соединения
	abstract function open();

	//close - закрытие соединения
	abstract function close();
}

//Абстрактная фабрика
abstract class DbFactory {

	//метод для создания объекта соединения с БД
	abstract public static function createConnection($conn);
}

//класс создатель MongoConnection
class MongoDbFactory extends DbFactory {

	public static function createConnection($conn) {
		return new MongoConnection($conn);
	}
}

//класс создатель MysqlConnection
class MysqlDbFactory extends DbFactory {

	public static function createConnection($conn) {
		return new MysqlConnection($conn);
	}
}