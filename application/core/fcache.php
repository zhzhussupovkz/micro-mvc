<?php

//FCache - синглтон класс реализующий механизм кеширования на файлах
class FCache implements ICache {

	private static $instance = null;

	//префикс
	private $prefix = 'fff_';

	//папка для хранения файлов кэша
	private $path;

	//хэш
	private $hash = null;

	//статчиный метод получения экземпляра FCache
	public static function init() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}

		//возвращаем $instance
		return self::$instance;
	}

	//constructor
	private function __construct() {
		$this->path = Config::getParams('cachepath');
		if(!is_dir($this->path))
			mkdir($this->path, 0777, true);
	}

	//проверка существования данных
	public function exists($key) {
		if($this->getFile($key)) {
			return true;
		} else {
			return false;
		}
	}

	//получение данных по ключу
	public function get($key) {
		$file = $this->getFile($key);
		if(($time = time() - filemtime($file)) < 60) {
			$data = unserialize(file_get_contents($file));
			return $data;
		} else {
			unlink($file);
			return false;
		}
	}

	//помещение данных в кэш
	public function set($key, $data, $interval = 3600) {
		$interval = (isset($interval)) ? $interval : 3600; //1 час
		$file = $this->getFile($key);
		if ($file) {
			chmod($file, 0777);
			file_put_contents($file, serialize($data));
		} else {
			$file = $this->path .'/'. $this->prefix . $key. '.bin';
			$link = fopen($file, 'a');
			fclose($link);
			chmod($file, 0777);
			file_put_contents($file, serialize($data));
		}
	}

	//удаление данных по ключу
	public function delete($key) {
		if($this->getFile($key)) {
			$file = $this->getFile($key);
			return unlink($file);
		} else {
			return false;
		}
	}

	//сброс всех данных из кэша
	public function flush() {
		if(is_dir($this->path)) {
			$files = array_diff(scandir($this->path), array('.', '..'));
			foreach ($files as $file) {
				unlink($this->path. '/'. $file);
			}
			return rmdir($this->path);
		} else {
			return false;
		}
	}

	//обновление
	public function update($key, $data, $interval) {
		$interval = (isset($interval)) ? $interval : 3600;
		if ($this->exists($key)) {
			$this->delete($key);
			return $this->set($key, $data, $interval);
		} else {
			return false;
		}
	}

	//использовать префикс
	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}

	//включить хэш
	public function useHash() {
		$this->hash = Security::useHash(Security::passGenerator(8, 'all'));
	}

	//получения файла по ключу
	private function getFile($key) {
		$file = $this->path.'/'.$this->prefix. $key.'.bin';
		if (file_exists($file)) {
			return $file;
		} else {
			return false;
		}
	}
}