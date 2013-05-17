<?php

//класс модели
class Model {

	//объект БД
	protected $db;

	//constructor
	public function __construct() {

		//конфигурация соединения с БД
		$config = Config::getDbConfig();

		//новый объект MysqlConnection
		$this->db = new MysqlConnection($config);
	}
}