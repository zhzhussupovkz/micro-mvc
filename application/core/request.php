<?php

//Request - класс обработки запросов
class Request {

	private $controller;

	private $action;

	private $params;

	//constructor
	public function __construct() {

		//текущий URL
		$curl = $_SERVER['REQUEST_URI'];
		$uri = explode('/', $curl);
		$uri = array_filter($uri);

		//контроллер
		$this->controller = ($c = array_shift($uri)) ? $c : MyApplication::get()->params('defaultController');

		//экшен
		$this->action = ($c = array_shift($uri)) ? $c : MyApplication::get()->params('defaultAction');

		//параметры в запросе
		$this->params = (isset($uri[0])) ? $uri : array();
	}

	//getters
	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}

	public function getParams() {
		return $this->params;
	}

	public function getURI() {
		return $this->uri;
	}
}