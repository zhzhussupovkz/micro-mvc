<?php

//контроллер по умолчанию
class My_Controller extends Controller {

	//constructor
	public function __construct() {
		parent::__construct();
		$this->load->helper('html');
		$this->view->setStyle('style');
	}

	//действие по умолчанию
	public function actionIndex() {
		$this->view->setLayout('layout');
		$this->view->setTitle('Hello world!');
		$this->view->render('home');
	}

	//о сайте
	public function actionAbout() {
		$data = $this->model->getUsers();
		$this->view->setLayout('layout');
		$this->view->setTitle('About my site');
		$this->view->render('about', array('data' => $data));
	}

	//форма обратной связи
	public function actionContact() {
		$this->load->helper('email');
		$this->view->setTitle('Contact');
		if (isset($_POST['name'])) {
			$data = array(
				'thanks' => 'Thank you for contacting us, '.$_POST['name'],
				);
			}
		else {
			$data = array('message' => 'Please fill out the following form to contact us. Thank you.');
		}
		$this->view->render('contact', array('data' => $data));
	}
}