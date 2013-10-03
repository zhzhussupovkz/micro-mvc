<?php

//класс автозагрузки
class Autoloader {

	public static function init() {
		require_once(APP_PATH.'/config/Config.php');
		require_once(APP_PATH.'/core/Lib/Load.php');
		require_once(APP_PATH.'/core/Lib/Session.php');
		require_once(APP_PATH.'/core/Lib/Security.php');
		require_once(APP_PATH.'/core/Lib/BaseAuth.php');
		require_once(APP_PATH.'/core/Lib/Logger.php');
		require_once(APP_PATH.'/core/DB/DB.php');
		require_once(APP_PATH.'/core/DB/MysqlDB.php');
		require_once(APP_PATH.'/core/DB/MongoDB.php');
		require_once(APP_PATH.'/core/DB/DBFactory.php');
		require_once(APP_PATH.'/core/DB/MysqlDBFactory.php');
		require_once(APP_PATH.'/core/DB/MongoDBFactory.php');
		require_once(APP_PATH.'/core/MVC/Controller.php');
		require_once(APP_PATH.'/core/MVC/Model.php');
		require_once(APP_PATH.'/core/MVC/MysqlModel.php');
		require_once(APP_PATH.'/core/MVC/MongoModel.php');
		require_once(APP_PATH.'/core/MVC/View.php');
		require_once(APP_PATH.'/core/Caching/ICache.php');
		require_once(APP_PATH.'/core/Caching/MCache.php');
		require_once(APP_PATH.'/core/Caching/FCache.php');
		require_once(APP_PATH.'/core/Exception/MException.php');
		require_once(APP_PATH.'/components/User.php');
		require_once(APP_PATH.'/components/Auth.php');
		require_once(APP_PATH.'/core/Routing/Request.php');
		require_once(APP_PATH.'/core/Routing/Route.php');
	}
}