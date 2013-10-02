<?php

//контроллер для работы с моделью Person
class PersonController extends Controller {

	//construct
	public function __construct() {
		parent::__construct();
		$this->setModel(new PersonModel());
		$this->load->helper('Html');
	}

	//все пользователи
	public function actionIndex() {
		$data = $this->model->read();
		$this->view->setLayout('layout');
		$this->view->setTitle('Persons List');
		$this->view->render('person/index', array('data' => $data));
	}

	//пользователь с id = $id
	public function actionView($id) {
		$data = $this->model->findByPk($id);
		$this->view->setTitle('Person - '. $data['name']);
		$this->view->render('person/view', array('data' => $data));
	}
}