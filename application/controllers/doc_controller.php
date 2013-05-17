<?php

//контроллер для документации по фреймворку
class Doc_Controller extends Controller {

	//constructor
	public function __construct() {
		parent::__construct();
		$this->load->helper('html');
	}

	//действие по умолчанию
	public function actionIndex() {
		$this->view->setLayout('layout');
		$this->view->setTitle('Documentation v1.0');
		$this->view->setStyle('style');
		$this->view->render('docs');
	}
}


