<?php

//все модели работающие с MongoDb наследуют MongoModel
class MongoModel extends Model {

	//constructor
	public function __construct() {
		parent::__construct();

		//новый объект MongoDB
		$this->db = MongoDBFactory::createConnection($this->config);
	}
}