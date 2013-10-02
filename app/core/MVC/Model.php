<?php

//класс модели
class Model {

	//объект БД
	protected $db;

	//конфигурация соединния с БД
	protected $config = array();

	//constructor
	public function __construct() {

		//конфигурация соединения с БД
		$this->config = Config::getParams('db');
	}

}