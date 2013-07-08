<?php

//класс для роутинга
class Route {

	public static function start(Request $request) {

		//префиксы для имен контроллера, модели, экшена
		$controllerName = $request->getController().'_Controller';
		$modelName = $request->getController().'_Model';
		$actionName = 'action'.$request->getAction();
		$params = $request->getParams();

		//подключение файла с классом модели
		$modelFile = strtolower($modelName.'.php');
		$modelPath = dirname(__FILE__).'/../models/'.$modelFile;
		if (file_exists($modelPath)) {
			require_once($modelPath);
		}

		//подключение файлов с классами контроллеров
		$controllerFile = strtolower($controllerName.'.php');
		$controllerPath = dirname(__FILE__).'/../controllers/'.$controllerFile;
		if(file_exists($controllerPath)) {
			require_once($controllerPath);
		}
		else {
			Route::Error404();
		}

		//создаем контроллер
		$controller = new $controllerName;

		//модель
		$controller->setModel(new $modelName());

		//если метод с именем 
		$action = method_exists($controller, $actionName) ? $actionName : 'actionIndex';

		//вызываем экшен
		if (!empty($params)) {
			call_user_func_array(array($controller, $action), $params);
		} else {
			call_user_func(array($controller, $action));
		}
		return;
	}

	//Код ошибки 404
	public static function Error404() {
		require_once(dirname(__FILE__).'/../controllers/error_controller.php');
		$controller = new Error_Controller;
		$controller->action404();
	}
}

//старт роутинга
Route::start(new Request());