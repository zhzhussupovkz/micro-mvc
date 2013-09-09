<?php

//ICache - интерфейс для классов работающих с кешированием
interface ICache {

	//инициализация
	public static function init();

	//проверка существования данных
	public function exists($key);

	//получение данных по ключу
	public function get($key);

	//помещение данных в кэш
	public function set($key, $data, $interval);

	//удаление данных по ключу
	public function delete($key);

	//сброс всех данных из кэша
	public function flush();

	//обновление данных по ключу
	public function update($key, $data, $interval);

	//использовать префикс
	public function setPrefix($prefix);

	//включить хэш
	public function useHash();
}

