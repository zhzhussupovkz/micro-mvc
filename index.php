<?php

//директория приложения
define('APP_PATH', dirname(__FILE__).'/app');

/*
показ ошибок - включен в режиме development
закомментировать для режима production
*/
ini_set('display_errors', 1);

//входной скрипт
require_once(APP_PATH.'/MyApp.php');
MyApp::run();