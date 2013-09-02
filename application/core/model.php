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

//все модели работающие с MongoDb наследуют MongoModel
class MongoModel extends Model {

	//constructor
	public function __construct() {
		parent::__construct();

		//новый объект MongoConnection
		$this->db = MongoDbFactory::createConnection($this->config);
	}
}

//все модели работающие с Mysql наследуют MysqlModel
class MysqlModel extends Model {

	//constructor
	public function __construct() {
		parent::__construct();

		//новый объект MysqlConnection
		$this->db = MysqlDbFactory::createConnection($this->config);
	}
}