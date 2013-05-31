<?php

//класс пользователя
class User {

	public $name;

	public $password;

	public function __construct($name, $password) {
		$this->name = $name;
		$this->password = $password;
	}
}