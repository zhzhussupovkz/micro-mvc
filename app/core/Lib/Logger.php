<?php

//Logger - класс для логгирования
class Logger {

	//файл для записи
	private static $file;

	//запись в файл
	private static function write($message = '') {
		$date = date('d.m.Y');
		self::$file = LOG_PATH.'/'.$date.'.log';
		if (!file_exists(self::$file)) {
			$fp = fopen(self::$file, 'a');
			fclose($fp);
			chmod(self::$file, 0775);
		}

		//IP
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'x.x.x.x';

		//текущее время
		$time = date('d-m-Y H:i:s');

		//запрос: GET, POST
		$request = $_SERVER['REQUEST_METHOD'];

		//текущий URL
		$url = $_SERVER['REQUEST_URI'];

		//сообщение
		$message = isset($message) ? $message : '';

		//User-Agent
		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		//log
		$log = sprintf("%s\t--\t%s\t%s\t%s\t%s\t%s\n",
			$ip,
			$time,
			$request,
			$url,
			$message,
			$userAgent
		);
		file_put_contents(self::$file, $log, FILE_APPEND);
	}

	//запись ошибок в лог (если включено)
	public static function error($message) {
		$config = Config::getParams('log');
		if (in_array('error', $config)) {
			self::write($message);
		}
	}

	//запись запросов
	public static function access() {
		$config = Config::getParams('log');
		if (in_array('access', $config)) {
			self::write();
		}
	}
}