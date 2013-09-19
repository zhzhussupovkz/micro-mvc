<?php

//FCache - синглтон класс реализующий механизм кеширования на файлах
class FCache {

	private static $instance = null;

	//префикс
	private $prefix = 'fff_';

	//папка для хранения файлов кэша
	private $path;

	//хэш
	private $hash = true;

	//время хранения кэша
	private $interval;

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
		$params = Config::getParams('filecache');
		$this->path = $params['path'];
		$this->interval = $params['expire'];
		if(!is_dir($this->path))
			mkdir($this->path, 0777, true);
	}

	//проверка существования данных
	public function exists($key) {
		$file = $this->getFileName($key);
		if (file_exists($file) && (time() - filemtime($file) <= $this->interval)) {
			return true;
		}
		return false;
	}

	//получение данных по ключу
	public function get($key) {
		if ($this->exists($key)) {
			$file = $this->getFileName($key);
			$data = unserialize(file_get_contents($file));
			return $data;
		} else {
			return false;
		}
	}

	//помещение данных в кэш
	public function set($key, $data) {
		$file = $this->getFileName($key);
		if ($file) {
			file_put_contents($file, serialize($data));
		} else {
			$file = $this->getFileName($key);
			$link = fopen($file, 'a');
			fclose($link);
			chmod($file, 0777);
			file_put_contents($file, serialize($data));
		}
	}

	//удаление данных по ключу
	public function delete($key) {
		if($this->getFileName($key)) {
			$file = $this->getFileName($key);
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
	public function update($key, $data) {
		if ($this->exists($key)) {
			$this->delete($key);
			return $this->set($key, $data);
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
		$this->hash = true;
	}

	//получения файла по ключу
	private function getFileName($key) {
		if ($this->hash) {
			$name = md5($key);
		} else {
			$name = $key;
		}
		return $this->path .'/'. $this->prefix . $name. '.tmp';
	}
}