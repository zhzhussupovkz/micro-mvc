<?php

class My_Model extends MysqlModel {

	public function getUsers() {
		$table = 'user';
		$where = array('id >= :id');
		$params = array(':id' => '3');
		$data = $this->db->select('*')->from($table)->where($where, $params)->orderBy('name', 'ASC')->read();
		return $data;
	}

	/*public function getUsers() {
		$this->db->selectCollection('things');
		$query = array('age' => array('$gt' => 21));
		$data = $this->db->find($query);
		return $data;
	}*/
}