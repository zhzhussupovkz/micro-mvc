<?php

//MysqlConnection - класс для работы с СУБД MySQL
class MysqlConnection extends DB {

	//prepared statements
	public $params;

	//select
	public $select;

	//from
	public $from;

	//where
	public $where = '';

	//limit
	public $limit = '';

	//like
	public $like = '';

	//order by
	public $orderBy = '';

	//текущее соединение
	public $pdo;

	//constructor
	function __construct($conn) {
		$this->conn = $conn;
		$this->open();
	}

	//соединение с БД
	function open() {

		$dsn = $this->conn['driver'].':host='.$this->conn['host'].';dbname='.$this->conn['dbname'];
		$username = $this->conn['username'];
		$password = $this->conn['password'];
		$charset = $this->conn['charset'];

		try {
			$pdo = new PDO($dsn, $username, $password);
			$pdo->exec("set names ".$charset);
			$this->pdo = $pdo;
			return true;
		}
		catch (PDOException $e) {
			echo 'Не удалось установить соединение с БД'.$e->getMessage();
			return false;
		}
	}

	//закрытие соединения
	function close() {
		if($this->open()) {
			$this->pdo = null;
		}
	}

	/*
	установка SELECT
	Пример:
	$condition = array('id', 'name', 'address'); или $condition = '*';
	$this->db->select($condtition)->from('user')->read();
	*/
	function select($condition = '*') {

		if($condition == '*') {
			$select = "SELECT *";
		}
		else {
			$select = "SELECT ".implode(',', $condition);
		}
		$this->select = $select;
		return $this;
	}

	/*
	установка FROM
	Пример:
	$table = 'user';
	$this->db->select('*')->from($table)->read();
	*/
	function from($table) {
		$from = "FROM ".$table;
		$this->from = $from;
		return $this;
	}

	/*
	установка WHERE
	Пример:
	$where = array('id >= :id', 'name = :name');
	$params = array('id' => 2, 'name' => 'Hello');
	$limit = 10;
	$this->db->select('*')->from('user')->where($where, $params, $limit)->read();
	*/
	function where($where = '', $params = array(), $limit = '') {
		if(!empty($where)) {

			//prepared statements
			$this->params = $params;

			if(is_array($where)) {
				$where = "WHERE ".implode(' AND ', $where);
			}
			else {
				$where = "WHERE ".$where;
			}
		}

		if(!empty($limit)) {
			$limit = "LIMIT ".$limit;
		}
		$this->where = $where;
		$this->limit = $limit;
		return $this;
	}

	/*
	установка LIKE
	Пример:
	$like = array('username' => '%z%', 'surname' => 'Y%');
	$this->db->select('*')->from('user')->like($like)->read();
	*/
	function like($like = '') {
		if(!empty($like) && is_array($like)) {
			foreach ($like as $key => $value) {
				$like_array[] = $key." LIKE '".$value."'";
			}
			$like = "WHERE ".implode(' AND ', $like_array);
		}
		$this->where = $like;
		return $this;
	}

	/*
	установка LIMIT
	Пример:
	$limit = 10;
	$this->db->select('*')->from('user')->limit(10)->read();
	*/
	function limit($limit = '') {
		if(!empty($limit)) {
			$limit = "LIMIT ".$limit;
		}
		$this->limit = $limit;
		return $this;
	}

	/*
	установка ORDER BY
	Пример:
	$order = 'name';
	$type = 'ASC';
	$this->db->select('*')->from('user')->orderBy($order, $type)->read();
	*/
	function orderBy($order = '', $type = 'ASC') {
		if(!empty($order)) {
			$order = "ORDER BY ".$order. " ".$type;
		}
		$this->orderBy = $order;
		return $this;
	}

	/*
	чтение данных
	Пример:
	$table = 'user';
	$condition = array('id', 'name', 'address');
	$like = array('name' => '%z%', 'website' => '%ga%');
	$order = '';
	$data = $this->db->select('*')->from($table)->orderBy($order, 'ASC')->read();
	$data = $this->db->select('*')->from($table)->like($like)->read();
	$data = $this->db->select($condition)->from($table)->where('id > 3')->read();
	*/
	function read() {

		//массив данных
		$data = array();

		//запрос
		$query = trim($this->select." ".$this->from." ".$this->where." ".$this->orderBy." ".$this->limit);

		//выполнение запроса
		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			$this->reset();
			return $data;
		}
		catch (PDOException $e) {
			echo 'Ошибка выборки данных :'.$e->getMessage();
		}
	}

	/*
	вставка данных
	Пример:
	$data = array('name' => 'Hello', 'company' => 'world');
	$table = 'user';
	$this->db->insert($table, $data);
	*/
	function insert($table, $data) {

		//prepared statements
		$this->params = $data;

		//выполнение запроса
		$query = "INSERT INTO ".$table." (".implode(',', array_keys($data)).") VALUES (:".implode(",:",array_keys($data)).")";
		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			$this->reset();
			return true;
		}
		catch (PDOException $e) {
			echo 'Ошибка вставки данных :'.$e->getMessage();
			return false;
		}
	}

	/*
	обновление данных
	Пример:
	$new = array('name' => 'Hello');
	$where = array('name = :name');
	$params = array('name' => 'World');
	$this->db->where($where, $params)->update($table, $new);
	*/
	function update($table, $new) {

		//установка новых значений
		foreach ($new as $key => $value) {
			$set[] = $key." = '".$value."'";
		}

		$query = trim("UPDATE ".$table." SET ".implode(',',$set)." ".$this->where);

		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			$this->reset();
			return true;
		}
		catch (PDOException $e) {
			echo 'Ошибка обновления данных :'.$e->getMessage();
			return false;
		}
	}

	/*
	удаление всех данных с таблицы
	Пример:
	$this->db->deleteAll('user');
	*/
	function deleteAll($table) {

		$query = trim("DELETE FROM ".$table);

		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute();
			$this->reset();
		}
		catch (PDOException $e) {
			echo 'Ошибка удаления данных :'.$e->getMessage();
		}
	}

	/*
	удаление данных с таблицы
	Пример:
	$where = array('id = :id', 'name = :name');
	$params = array('id' => '2', 'name' => 'Hello');
	$table = 'user';
	$this->db->where($where, $params)->delete($table);
	*/
	function delete($table) {

		$query = trim("DELETE FROM ".$table." ".$this->where);

		//выполнение запроса
		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			$this->reset();
		}
		catch (PDOException $e) {
			echo 'Ошибка удаления данных : '.$e->getMessage();
		}
	}

	/*
	кол-во выбранных данных
	Пример:
	$where = array('city_id = :city_id');
	$params = array('city_id' => '5');
	$table = 'company';
	$this->db->where($where, $params)->count($table);
	*/
	function count($table) {

		$query = trim("SELECT COUNT(*) FROM ".$table." ".$this->where);

		//выполнение запроса
		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			$count = $sth->fetchColumn();
			$this->reset();
			return $count;
		}
		catch (PDOException $e) {
			echo 'Ошибка выборки данных : '.$e->getMessage();
		}
	}

	/*
	кол-во всех данных
	Пример:
	$table = 'company';
	$this->db->countAll($table);
	*/
	function countAll($table) {

		$query = trim("SELECT COUNT (*) FROM ".$table);

		//выполнение запроса
		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute();
			$count = $sth->fetchColumn();
			$this->reset();
			return $count;
		}
		catch (PDOException $e) {
			echo 'Ошибка выборки данных : '.$e->getMessage();
		}
	}

	/*
	выборка одного элемента
	Пример:
	$table = 'user';
	$where = array('city_id = :city_id');
	$params = array('city_id' => 3);
	$this->db->selectOne($table, $where, $params);
	*/
	function selectOne($table, $where, $params) {

		if(is_array($where)) {
			$where = "WHERE ".implode(' AND ', $where);
		}

		$this->where = $where;
		$this->params = $params;

		$query = trim("SELECT * FROM ".$table." ".$this->where." LIMIT 1");

		try {
			$sth = $this->pdo->prepare($query);
			$sth->execute($this->params);
			$data = $sth->fetch();
			$this->reset();
			return $data;
		}
		catch (PDOException $e) {
			echo 'Ошибка выборки данных :'.$e->getMessage();
		}
	}

	/*
	удаление и повторное создание таблицы
	Пример:
	$table = 'user';
	$this->db->truncate($table);
	*/
	function truncate($table) {

		$query = trim("TRUNCATE TABLE ".$table);

		//выполнение запроса
		try {
			$this->pdo->beginTransaction();
			$this->pdo->exec($query);
			$this->pdo->commit();
			$this->reset();
		}
		catch (PDOException $e) {
			$this->pdo->rollBack();
			echo 'Ошибка выборки данных : '.$e->getMessage();
		}
	}

	//обновление значений SELECT, UPDATE,...
	function reset() {
		$this->select = '';
		$this->from = '';
		$this->where = '';
		$this->limit = '';
		$this->like = '';
		$this->orderBy = '';
		$this->params = '';
	}
}