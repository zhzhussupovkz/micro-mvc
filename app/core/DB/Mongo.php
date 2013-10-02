<?php

//MongoConnection - класс для работы с MongoDb
class MongoConnection extends DB {

	//текущий клиент mongo
	public $client;

	//БД
	public $db;

	//коллекция
	public $collection;

	//construct
	public function __construct($conn) {
		$this->conn = $conn;
		$this->open();
	}

	//соединение к БД (например: mongodb://localhost:27017)
	function open() {
		try {
			if (!is_null($this->conn['username']) && !is_null($this->conn['password']))
				$dsn = $this->conn['driver'].'://'.$this->conn['username'].':'.$this->conn['password'].'@'.$this->conn['host'];
			else
				$dsn = 'mongodb://localhost';
			if ($this->isSupported()) {
				$client = new MongoClient($dsn);
				$this->client = $client;
				$db = $this->conn['dbname'];
				$this->selectDb($db);
				return true;
			} else {
				echo 'Не удалось загрузить расширение MongoDB для PHP';
				return false;
			}
		}
		catch (MongoConnectionException $e) {
			echo 'Не удалось установить соединение с БД'.$e->getMessage();
			return false;
		}
	}

	//закрытие соединения
	function close() {
		if($this->open()) {
			$connections = $client->getConnections();
			foreach ($connections as $c) {
				$client->close($c['hash']);
			}
		}
	}

	//выбрать базу
	public function selectDb($db) {
		$this->db = $this->client->$db;
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
	/*
	$id = '51b5c94e848dedf60f000001';
	$this->db->findById($id);
	*/
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

	//проверить доступно ли расширение PHP MongoDB
	private function isSupported() {
		if (extension_loaded('mongo')) {
			return true;
		} else {
			throw new Exception("PHP MongoDB extension is not loaded. Please go to the http://http://www.php.net/manual/ru/mongo.installation.php or http://docs.mongodb.org/ecosystem/drivers/php/");
			return false;
		}
	}
}
