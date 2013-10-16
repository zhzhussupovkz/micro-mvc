<?php

//класс Controller
class Controller {

	protected $model;
	protected $view;
	public $load;

	//constructor
	public function __construct() {
		$this->view = new View();
		$this->load = new Load();
	}

	//создание модели
	public function setModel($model) {
		$this->model = $model;
	}

}