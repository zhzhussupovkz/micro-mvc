<?php

/*//класс для работы с Memcache - самый самый простой
class Cache {

	//объект memcache
	private $memcached;

	//параметры соединения
	private $conn;

	//объект в кэше
	protected $cacheObj;

	//constructor
	public function __construct($conn) {
		$this->memcached = new Memcache();
		$this->conn = $conn;
	}

	//открытие соединения с сервером
	public function connect() {
		try {
			$this->memcached->connect($this->conn['host'], $this->conn['port']);
			return true;
		}
		catch ($e) {
			echo 'Не удалось подключиться к кэширующему серверу';
			return false;
		}
	}

	//закрыть текущее соединение
	public function close() {
		if ($this->connect()) {
			$this->memcached->close();
		}
	}

	//получение значения из кэша
	public function get($key) {
		$this->cacheObj = $this->memcached->get($key);
		return $this->cacheObj;
	}

	//установка значения в кэш
	public function set($key, $value, $flag, $time) {
		$this->memcached->set($key, $value, $flag = false, $time = 3600);
		$this->cacheObj = $value;
	}
}*/


//Cache - синглтон класс для работы с Memcache - самый простой (работает)
class Cache {

	private static $instance = null;

	private $prefix;

	private $currentKey;

	private $currentCache;

	private $memcache;

	//статчиный метод получения экземпляра Cache
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}

		//возвращаем $instance
		return self::$instance;
	}

	//constructor
	public function __construct() {
		if(!function_exists('memcache_connect')) {
			echo 'Memcache не установлен';
			exit();
		} else {

			$this->memcache = new Memcache;
			$config = Config::getParams('memcache');
			if(!$this->memcache->connect($config['host'], $config['port'])) {
				echo 'Не удалось подключиться к кэширующему серверу';
				exit();
			}
			$this->prefix = "mmm_";
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
}