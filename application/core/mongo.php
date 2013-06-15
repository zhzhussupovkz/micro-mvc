<?php

//класс для работы с MongoDb
class MongoConnection {

	//текущее соединение
	public $conn;

	//БД
	public $db = 'test';

	//коллекция
	public $collection;

	//подключение к БД (например: mongodb://localhost:27017)
	public function __constructor($connection) {
		$this->conn = new MongoClient($connection);
	}

	//выбрать базу
	public function selectDb($db) {
		$this->db = $this->conn->$db;
	}

	//выбрать коллекцию
	public function selectCollection($collection) {
		$this->collection = $this->db->$collection;
	}

	//ввод данных
	/*
	$data = array('name' => 'MongoDB', 'type' => 'database');
	$this->db->insert($data);
	*/
	public function insert($data) {
		try {
			$this->collection->insert($data);
		} catch (MongoCursorException $e) {
			echo 'Error inserting data to collection!';
		}
	}

	//выборка по id
	public function findById($id) {
		$id = new MongoId($id);
		$data = $this->collection->findOne(array('_id' => $id));
		return $data;
	}

	//выборка одного документа
	/*
	$query = array('name' => 'David', 'surname' => 'Flanagan');
	$fields = array('age' => 1);
	$this->db->findOne($query, $fields);
	*/
	public function findOne($query = array(), $fields = array()) {
		$data = $this->collection->findOne($query, $fields);
		return $data;
	}

	//выборка данных (запрос find)
	/*
	$query = array('age' => array('$gt' => 21));
	$fields = array('age' => 1);
	$this->db->find($query, $fields);
	*/
	public function find($query = array(), $fields = array()) {
		$cursor = $this->collection->find($query, $fields);
		$data = iterator_to_array($cursor);
		return $data;
	}

	//обновление данных
	/*
	$where = array('age' => 12);
	$fields = array('$set' => array('position' => 'second'));
	$this->db->update($where, $fields);
	*/
	public function update($where = array(), $fields = array()) {
		try {
			$this->collection->update($where, $fields);
		} catch (MongoCursorException $e) {
			echo 'Error updating data!';
		}
	}

	//удаление данных
	/*
	$where = array('age' => '22');
	$this->db->remove($where);
	*/
	public function remove($where) {
		try {
			$this->collection->remove($where);
		} catch (MongoCursorException $e) {
			echo 'Error removing data!';
		}
	}
}
