<?php

/*
показ ошибок - включен в режиме development
закомментировать для режима production
*/
ini_set('display_errors', 1);

//входной скрипт
require_once(dirname(__FILE__).'/application/myapp.php');
MyApplication::run();