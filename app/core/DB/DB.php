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