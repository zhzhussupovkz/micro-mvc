<?php

//класс для роутинга
class Route {

	public static function start() {

		//контроллер по умолчанию
		$defaultController = MyApplication::get()->params('defaultController');

		//действие по умолчанию
		$defaultAction = 'Index';

		//текущий URL
		$routes = explode('/', $_SERVER['REQUEST_URI']); 

		//имя контроллера
		if(!empty($routes[2])) {
			$defaultController = $routes[2];
		}
		else {
			Route::Error404();
		}

		//имя экшена
		if(!empty($routes[3])) {
			$defaultAction = $routes[3];
		}
		else {
			Route::Error404();
		}

		//префиксы для имен контроллера и модели
		$controllerName = $defaultController.'_Controller';
		$modelName = $defaultController.'_Model';
		$actionName = 'action'.$defaultAction;

		//подключение файла с классом модели
		$modelFile = strtolower($modelName.'.php');
		$modelPath = dirname(__FILE__).'/../models/'.$modelFile;
		if (file_exists($modelPath)) {
			include $modelPath;
		}

		//подключение файла с классом контроллера
		$controllerFile = strtolower($controllerName.'.php');
		$controllerPath = dirname(__FILE__).'/../controllers/'.$controllerFile;
		if(file_exists($controllerPath)) {
			include $controllerPath;
		}
		else {
			Route::Error404();
		}

		//создаем контроллер
		$controller = new $controllerName;

		//модель
		$controller->model = new $modelName();

		//экшен
		$action = $actionName;

		//если такой метод в контроллере существует, то вызываем его
		if(method_exists($controller, $action)) {
			$controller->$action();
		}
		else {
			Route::Error404();
		}
	}

	//404 Not Found
	public static function Error404() {
		//...
	}
}