<?php

//класс создатель MysqlDB
class MysqlDBFactory extends DBFactory {

	public static function createConnection($conn) {
		return new MysqlDB($conn);
	}
}