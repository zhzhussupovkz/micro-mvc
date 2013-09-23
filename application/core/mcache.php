<?php

//MCache - синглтон класс для работы с Memcache - самый простой (работает)
class MCache implements ICache {

	private static $instance = null;

	//префикс
	private $prefix = 'memc_';

	//текущий ключ
	private $currentKey;

	//текущий кэш
	private $currentCache;

	//объект memcache
	private $memcache;

	//использовать ли хэш
	private $hash = true;

	//статчиный метод получения экземпляра MCache
	public static function init() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}

		//возвращаем $instance
		return self::$instance;
	}

	//constructor
	private function __construct() {
		if(!class_exists('Memcache')) {
			echo 'Memcache не установлен';
			exit();
		}
		else {
			$this->memcache = new Memcache;
			$config = Config::getParams('memcache');
			$this->interval = $config['expire'];
			if(!$this->memcache->connect($config['host'], $config['port'])) {
				echo 'Не удалось подключиться к кэширующему серверу';
				exit();
			}
		}
	}

	//проверка существования данных
	public function exists($key) {
		if($this->memcache->get($this->prefix . md5($key))) {
			$this->currentCache = $this->memcache->get($this->prefix . md5($key));
			$this->currentKey = $this->prefix . md5($key);
			return true;
		} else {
			return false;
		}
	}

	//получение данных по ключу
	public function get($key) {
		if(($this->prefix . md5($key)) == $this->currentKey) {
			return $this->currentCache;
		} else {
			return $this->memcache->get($this->prefix . md5($key));
		}
	}

	//помещение данных в кэш
	public function set($key, $data, $interval) {
		$interval = (isset($interval)) ? $interval : $this->interval;
		return $this->memcache->set($this->prefix . md5($key), $data, MEMCACHE_COMPRESSED, $interval);
	}

	//удаление данных по ключу
	public function delete($key) {
		if($this->memcache->get($this->prefix . md5($key))) {
			return $this->memcache->delete($this->prefix . md5($key));
		} else {
			return false;
		}
	}

	//сброс всех данных из кэша
	public function flush() {
		$this->memcache->flush();
	}

	//обновление
	public function update($key, $data, $interval) {
		$interval = (isset($interval)) ? $interval : $this->interval;
		
		if($this->prefix . $this->currentKey) {
			if(!empty($this->currentCache)) {
				return	$this->memcache->replace($this->currentKey, $data, MEMCACHE_COMPRESSED, $interval);
			}
		} elseif ($this->memcache->get($this->prefix . md5($key))) {
				return $this->memcache->replace($this->prefix . md5($key), $data, MEMCACHE_COMPRESSED, $interval);
		} else {
			return false;
		}
	}

	//использовать префикс
	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}

	//закрытие соединения
	public function close() {
		$this->memcache->close();
	}
}