<?php

//Load - загрузка классов помощников
class Load {

	//construct
	public function __construct() {
		include_once(APP_PATH.'/helpers/Helper.php');
	}

	//функция для загрузки помощников
	public function helper($helper) {
		if(is_array($helper)) {
			foreach ($helper as $help) {
				include_once(APP_PATH.'/helpers/'.ucfirst($help).'Helper.php');
			}
		}
		else {
			include_once(APP_PATH.'/helpers/'.ucfirst($helper).'Helper.php');
		}
	}
}