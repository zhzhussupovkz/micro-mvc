<?php

//Cache - синглтон класс для работы с Memcache - самый простой (работает)
class Cache {

	private static $instance = null;

	//префикс
	private $prefix = 'memc_';

	//текущий ключ
	private $currentKey;

	//текущий кэш
	private $currentCache;

	//объект memcache
	private $memcache;

	//хэш
	private $hash;

	//статчиный метод получения экземпляра Cache
	public static function init() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}

		//возвращаем $instance
		return self::$instance;
	}

	//constructor
	public function __construct() {
		if(!class_exists('Memcache')) {
			echo 'Memcache не установлен';
			exit();
		}
		else {
			$this->memcache = new Memcache;
			$config = Config::getParams('memcache');
			if(!$this->memcache->connect($config['host'], $config['port'])) {
				echo 'Не удалось подключиться к кэширующему серверу';
				exit();
				}
			}
		}
	}

	//проверка существования данных
	public function exists($key) {
		if($this->memcache->get($this->prefix . $key)) {
			$this->currentCache = $this->memcache->get($this->prefix . $key);
			$this->currentKey = $this->prefix . $key;
			return true;
		} else {
			return false;
		}
	}

	//удаление данных по ключу
	public function delete($key) {
		if($this->memcache->get($this->prefix . $key)) {
			return $this->memcache->delete($this->prefix . $key);
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
		$interval = (isset($interval)) ? $interval : 60 * 60 * 0.15;
		
		if($this->prefix . $this->currentKey) {
			if(!empty($this->currentCache)) {
				return	$this->memcache->replace($this->currentKey, $data, MEMCACHE_COMPRESSED, $interval);
			}
		} elseif ($this->memcache->get($this->prefix . $key)) {
			return $this->memcache->replace($this->prefix . $key, $data, MEMCACHE_COMPRESSED, $interval);
		} else {
			return false;
		}
	}

	//получение данных по ключу
	public function get($key) {
		if(($this->prefix . $key) == $this->currentKey) {
			return $this->currentCache;
		} else {
			return $this->memcache->get($this->prefix . $key);
		}
	}

	//помещение данных в кэш
	public function set($key, $data, $interval) {
		$interval = (isset($interval)) ? $interval : 60 * 60 * 0.15;
		return $this->memcache->set($this->prefix . $key, $data, MEMCACHE_COMPRESSED, $interval);
	}

	//закрытие соединения
	public function close() {
		$this->memcache->close();
	}

	//включить хэш
	public function useHash() {
		$this->hash = Security::useHash(Security::passGenerator(8, 'all'));
	}

	//использовать префикс
	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}
}