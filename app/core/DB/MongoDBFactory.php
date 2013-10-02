<?php

//класс создатель MongoDB
class MongoDBFactory extends DBFactory {

	public static function createConnection($conn) {
		return new MongoDB($conn);
	}
}