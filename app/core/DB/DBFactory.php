<?php

//Абстрактная фабрика
abstract class DBFactory {

	//метод для создания объекта соединения с БД
	abstract public static function createConnection($conn);
}