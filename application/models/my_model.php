<?php

class My_Model extends Model {

	public function getUsers() {
		$table = 'user';
		$data = $this->db->select('*')->from($table)->orderBy('name', 'ASC')->read();
		return $data;
	}
}