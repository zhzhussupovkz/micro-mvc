<?php

class My_Model extends Model {

	public function getUsers() {
		$table = 'user';
		$where = array('id >= :id');
		$params = array(':id' => '3');
		$data = $this->db->select('*')->from($table)->where($where, $params)->orderBy('name', 'ASC')->read();
		return $data;
	}
}