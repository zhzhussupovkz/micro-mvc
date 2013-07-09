<?php

//контроллер для генерации ошибок
class Error_Controller extends Controller {

	//constructor
	public function __construct() {
		parent::__construct();
		$this->load->helper('html');
	}

	//ошибка 404
	public function action404() {
		$this->view->setLayout('layout');
		$this->view->setTitle('Error 404');
		$this->view->setStyle('style');
		$error = array(
			'code' => 404,
			'message' => 'Запрашиваемая Вами страница не найдена',
			);
		$this->view->render('error/error_404', array('error' => $error));
	}
}


