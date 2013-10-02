<?php

//все модели работающие с Mysql наследуют MysqlModel
class MysqlModel extends Model {

	//constructor
	public function __construct() {
		parent::__construct();

		//новый объект MysqlDB
		$this->db = MysqlDBFactory::createConnection($this->config);
	}
}