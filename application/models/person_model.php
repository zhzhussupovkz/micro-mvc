<?php

//модель Person
class Person_Model extends MysqlModel {

	//имя
	private $name;

	//сайт
	private $website;

	//...

	//таблица в бд
	private $table;

	//construct
	public function __construct() {
		$this->table = 'user';
		parent::__construct();
	}

	//чтение
	public function read() {
		return $this->db->select('*')->from($this->table)->read();
	}

	//сохранение
	public function save() {
		$data = array('name' => $this->name, 'age' => $this->age);
		$this->db->insert($this->table, $data);
	}

	//обновление
	public function update($where, $params, $new) {
		$this->db->where($where, $params)->update($this->table, $this->new);
	}

	//выборка по id
	public function findByPk($id) {
		return $this->db->selectOne($this->table, array('id = :id'), array('id' => $id));
	}

	//выборка по параметрам
	public function finByParams($where, $params) {
		return $this->db->select('*')->from($this->table)->where($where, $params)->read();
	}

	//удаление
	public function delete($where, $params) {
		$this->db->where($where, $params)->delete($this->table);
	}
}