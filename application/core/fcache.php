<?php

//FCache - синглтон класс реализующий механизм кеширования на файлах
class FCache implements ICache {

	private static $instance = null;

	//префикс
	private $prefix = 'fff_';

	//папка для хранения файлов кэша
	private $path;

	//интервал по умолчанию
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
		if (file_exists($file)) {
			$file = $this->getFileName($key);
			$data = unserialize(file_get_contents($file));
			if (time() <= ($data['time'] + $data['expire'])) {
				return true;
			} else {
				unlink($file);
				clearstatcache();
				return false;
			}
		}
		return false;
	}

	//получение данных по ключу
	public function get($key) {
		if ($this->exists($key)) {
			$file = $this->getFileName($key);
			$data = unserialize(file_get_contents($file));
			return $data['cache'];
		}
		return false;
	}

	//помещение данных в кэш
	public function set($key, $data, $interval) {
		$interval = isset($interval) ? $interval : $this->interval;
		$file = $this->getFileName($key);
		$write = array(
			'cache' => $data,
			'time' => time(),
			'expire' => $interval,
			);
		if ($file) {
			file_put_contents($file, serialize($write));
		} else {
			$file = $this->getFileName($key);
			$link = fopen($file, 'a');
			fclose($link);
			chmod($file, 0777);
			file_put_contents($file, serialize($write));
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
		$interval = isset($interval) ? $interval : $this->interval;
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

	//получения файла по ключу
	private function getFileName($key) {
		return $this->path .'/'. $this->prefix . md5($key). '.tmp';
	}
}