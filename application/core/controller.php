<?php

//класс Controller
class Controller {
	public $model;
	public $view;
	public $load;

	//constructor
	public function __construct() {
		$this->view = new View();
		$this->load = new Load();
	}
}