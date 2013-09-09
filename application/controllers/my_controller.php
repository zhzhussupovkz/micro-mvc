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
		$this->view->setLayout('layout');
		$this->view->setTitle('About my site');
		$this->view->render('about');
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

	//базовый пример входа
	public function actionLogin() {
		$this->view->setTitle('Login');
		if (isset($_POST['username'])) {
			$user = new User($_POST['username'], $_POST['password']);
			if (Auth::check($user)) {
				Auth::login($user);
				$data = array('auth' => 'Welcome to our site!', 'type' => 'alert-success');
			} else {
				$data = array('auth' =>'Incorrect username or password!', 'type' => 'alert-error');
			}
		} else {
			$data = array('message' => 'Please enter username and password');
		}
		$this->view->render('login', array('data' => $data));
	}

	//выход
	public function actionLogout() {
		Auth::logout();
		$this->view->setTitle('Hello world!');
		$this->view->render('home');
	}
}