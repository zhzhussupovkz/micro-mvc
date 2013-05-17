<?php

//Load - загрузка классов помощников
class Load {

	//construct
	public function __construct() {
		include_once(dirname(__FILE__).'/../helpers/helper.php');
	}

	//функция для загрузки помощников
	public function helper($helper) {
		if(is_array($helper)) {
			foreach ($helper as $help) {
				include_once(dirname(__FILE__).'/../helpers/'.$help.'Helper.php');
			}
		}
		else {
			include_once(dirname(__FILE__).'/../helpers/'.$helper.'Helper.php');
		}
	}
}