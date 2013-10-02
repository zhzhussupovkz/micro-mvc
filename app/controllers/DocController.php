<?php

//контроллер для документации по фреймворку
class DocController extends Controller {

	//constructor
	public function __construct() {
		parent::__construct();
		$this->load->helper('Html');
	}

	//действие по умолчанию
	public function actionIndex() {
		$this->view->setLayout('layout');
		$this->view->setTitle('Documentation v1.0');
		$this->view->setStyle('style');
		$this->view->render('docs');
	}
}


